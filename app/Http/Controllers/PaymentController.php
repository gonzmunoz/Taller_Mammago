<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\ArticulosPedidos;
use App\Models\Coche;
use App\Models\Pedidos;
use App\Models\PedidosCliente;
use App\Models\Reparacion;
use App\Models\Trabajo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\PaymentExecution;
use PDF;

class PaymentController extends Controller
{

    private $apiContext;

    public function __construct()
    {
        // CONSTRUCTOR PARA LOS PAGOS CON PAYPAL

        $payPalConfig = Config::get('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $payPalConfig['client_id'],
                $payPalConfig['secret']
            )
        );

        $this->apiContext->setConfig($payPalConfig['settings']);
    }

    public function payOrderWithPayPal(Request $request)
    {
        // PAGO UN PEDIDO MEDIANTE PAYPAL ASIGNÁNDOLE LA CANTIDAD

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal(\Cart::getTotal());
        $amount->setCurrency('EUR');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('payPalStatusOrder'))->setCancelUrl(route('cartCheckout'));

        $payment = new Payment();
        $payment->setIntent('sale')->setPayer($payer)->setTransactions(array($transaction))->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $ex) {
            echo $ex->getData();
        }
    }

    public function payPalStatusOrder(Request $request)
    {
        // COMPRUEBO QUE EL PEDIDO DE PAYPAL SE HA COMPLETADO CORRECTAMENTE

        $data = $request->all();
        $paymentId = $data['paymentId'];
        $payerId = $data['PayerID'];
        $token = $data['token'];

        if (!$paymentId || !$payerId || !$token) {
            $msg['icon'] = 'error';
            $msg['title'] = trans('messages.paymentError');
            $msg['text'] = trans('messages.paymentErrorMessage');
            $request->session()->flash('response-form', $msg);
            return redirect()->route('cartCheckout');
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') {

            $items = \Cart::getContent();

            $idPedido = count(Pedidos::all()) + 1;
            Pedidos::insert(array('id' => $idPedido, 'id_usuario' => session('userLogged')['id'], 'fecha' => Carbon::now()));
            foreach ($items as $row) {
                $stockArticulo = Articulo::where('id', $row['id'])->pluck('stock')->toArray();
                ArticulosPedidos::insert(array('id_articulo' => $row['id'], 'id_pedido' => $idPedido, 'cantidad' => $row['quantity'], 'precio' => $row['price']));
                Articulo::where('id', $row['id'])->update(array('stock' => ($stockArticulo[0] - $row['quantity'])));
            }

            $data['order'] = Pedidos::select('pedidos.id as idPedido', 'pedidos.fecha', 'usuarios.nombre', 'usuarios.apellidos', 'usuarios.direccion', DB::raw('SUM(articulos_pedidos.precio * articulos_pedidos.cantidad) as precioTotal'))
                ->join('articulos_pedidos', 'pedidos.id', '=', 'articulos_pedidos.id_pedido')
                ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
                ->where('pedidos.id', $idPedido)
                ->groupBy('pedidos.id', 'pedidos.fecha', 'usuarios.nombre', 'usuarios.apellidos', 'usuarios.direccion')
                ->get()->toArray();
            $data['articles'] = ArticulosPedidos::select('articulos_pedidos.cantidad', 'articulos_pedidos.precio', 'articulos.nombre', 'articulos.imagen')
                ->join('articulos', 'articulos_pedidos.id_articulo', '=', 'articulos.id')
                ->where('articulos_pedidos.id_pedido', $idPedido)
                ->get()->toArray();
            $pdf = PDF::loadView('pdfs.myOrderPDF', $data);

            Mail::send('emails.orderEmail', $data, function ($message) use ($data, $pdf) {
                $message->to(session('userLogged')['email'])
                    ->subject(trans('messages.orderNumberEmail') . ' ' . $data['order'][0]['idPedido'])
                    ->attachData($pdf->output(), trans('messages.orderPdf'));
            });

            \Cart::clear();

            $msg['icon'] = 'success';
            $msg['title'] = trans('messages.paymentCompleted');
            $msg['text'] = trans('messages.paymentCompletedMessage');
            $request->session()->flash('response-form', $msg);
            return redirect()->route('myOrders');
        }

    }

    public function payRepairWithPayPal($id)
    {
        // PAGO UNA REPARACIÓN MEDIANTE PAYPAL ASIGNÁNDOLE LA CANTIDAD

        $id = Crypt::decryptString($id);
        $repair = Reparacion::where('id', $id)->first()->toArray();
        $works = Trabajo::select('trabajos.id', 'trabajos.descripcion', 'trabajos.tiempo_empleado')
            ->join('trabajos_reparaciones', 'trabajos.id', '=', 'trabajos_reparaciones.id_trabajo')
            ->join('reparaciones', 'trabajos_reparaciones.id_reparacion', '=', 'reparaciones.id')
            ->where('reparaciones.id', '=', $id)
            ->get()->toArray();
        $spentTime = 0;
        $replacementsTotal = 0;

        foreach ($works as $work) {
            $spentTime += floatval($work['tiempo_empleado']);
        }

        $repair = array_merge($repair, array('tiempo_empleado' => $spentTime));

        $replacements = Articulo::select('articulos.id', 'articulos.nombre', 'articulos.precio', 'articulos.imagen', 'articulos_reparaciones.cantidad', 'reparaciones.estado')
            ->join('articulos_reparaciones', 'articulos.id', '=', 'articulos_reparaciones.id_articulo')
            ->join('reparaciones', 'articulos_reparaciones.id_reparacion', '=', 'reparaciones.id')
            ->where('reparaciones.id', '=', $id)
            ->get()->toArray();

        foreach ($replacements as $replacement) {
            $replacementsTotal = $replacement['precio'] * $replacement['cantidad'];
        }

        $engine = Coche::where('id', $repair['id_coche'])->first()->toArray();

        $repair = array_merge($repair, array('id_motor' => $engine['id_motor'], 'totalTrabajos' => ($spentTime * 30), 'totalRepuestos' => $replacementsTotal, 'total' => ($spentTime * 30) + $replacementsTotal));


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($repair['total']);
        $amount->setCurrency('EUR');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('payPalStatusRepair', $id))->setCancelUrl(route('viewClientRepair', $id));

        $payment = new Payment();
        $payment->setIntent('sale')->setPayer($payer)->setTransactions(array($transaction))->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $ex) {
            echo $ex->getData();
        }
    }

    public function payPalStatusRepair(Request $request)
    {
        // COMPRUEBO QUE EL APGO DE LA REPARACIÓN MEDIANTE PAYPAL SE HA HECHO CORRECTAMENTE

        $data = $request->all();
        $paymentId = $data['paymentId'];
        $payerId = $data['PayerID'];
        $token = $data['token'];

        if (!$paymentId || !$payerId || !$token) {
            $msg['icon'] = 'error';
            $msg['title'] = trans('messages.paymentError');
            $msg['text'] = trans('messages.paymentErrorMessage');
            $request->session()->flash('response-form', $msg);
            return redirect()->route('listClientRepairs');
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') {

            $repair = Reparacion::select('reparaciones.id', 'reparaciones.id_coche', 'reparaciones.id_cita', 'reparaciones.estado', 'reparaciones.fecha_fin', 'reparaciones.pagada', 'usuarios.nombre', 'usuarios.apellidos', 'usuarios.direccion')
                ->join('coches', 'reparaciones.id_coche', '=', 'coches.id')
                ->join('usuarios', 'coches.id_cliente', '=', 'usuarios.id')
                ->where('reparaciones.id', $request['id'])
                ->first()->toArray();

            $works = Trabajo::select('trabajos.id', 'trabajos.descripcion', 'trabajos.tiempo_empleado')
                ->join('trabajos_reparaciones', 'trabajos.id', '=', 'trabajos_reparaciones.id_trabajo')
                ->join('reparaciones', 'trabajos_reparaciones.id_reparacion', '=', 'reparaciones.id')
                ->where('reparaciones.id', '=', $request['id'])
                ->get()->toArray();
            $spentTime = 0;
            $replacementsTotal = 0;

            foreach ($works as $work) {
                $spentTime += floatval($work['tiempo_empleado']);
            }

            $repair = array_merge($repair, array('tiempo_empleado' => $spentTime));

            $replacements = Articulo::select('articulos.id', 'articulos.nombre', 'articulos.precio', 'articulos.imagen', 'articulos_reparaciones.cantidad', 'reparaciones.estado')
                ->join('articulos_reparaciones', 'articulos.id', '=', 'articulos_reparaciones.id_articulo')
                ->join('reparaciones', 'articulos_reparaciones.id_reparacion', '=', 'reparaciones.id')
                ->where('reparaciones.id', '=', $request['id'])
                ->get()->toArray();

            foreach ($replacements as $replacement) {
                $replacementsTotal = $replacement['precio'] * $replacement['cantidad'];
            }

            $engine = Coche::where('id', $repair['id_coche'])->first()->toArray();

            $repair = array_merge($repair, array('id_motor' => $engine['id_motor'], 'totalTrabajos' => ($spentTime * 30), 'totalRepuestos' => $replacementsTotal, 'total' => ($spentTime * 30) + $replacementsTotal));

            $data['repair'] = $repair;
            $data['works'] = $works;
            $data['replacements'] = $replacements;
            
            Reparacion::where('id', $request['id'])->update(array('pagada' => 1));

            $pdf = PDF::loadView('pdfs.myRepairPDF', $data);

            Mail::send('emails.repairEmail', $data, function ($message) use ($data, $pdf) {
                $message->to(session('userLogged')['email'])
                    ->subject(trans('messages.repairReceipt') . ' ' . $data['repair']['id'])
                    ->attachData($pdf->output(), trans('messages.repairPdf'));
            });

            $msg['icon'] = 'success';
            $msg['title'] = trans('messages.paymentCompleted');
            $msg['text'] = trans('messages.repairPaymentCompletedMessage');
            $request->session()->flash('response-form', $msg);
            return redirect()->route('listClientRepairs');
        }
    }

}
