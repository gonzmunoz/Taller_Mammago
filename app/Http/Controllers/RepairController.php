<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\ArticulosReparaciones;
use App\Models\Coche;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Motorizacion;
use App\Models\Reparacion;
use App\Models\Repuesto;
use App\Models\RepuestosReparaciones;
use App\Models\Trabajo;
use App\Models\TrabajosReparaciones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;

class RepairController extends Controller
{
    public function listClientRepairs()
    {
        // MUESTRO TODAS LAS REPARACIONES DE UN CLIENTE CONCRETO

        $repairs = Reparacion::select('reparaciones.id as idReparacion', 'reparaciones.estado', 'reparaciones.pagada', 'coches.matricula', 'citas.motivo')
            ->join('coches', 'reparaciones.id_coche', '=', 'coches.id')
            ->join('usuarios', 'coches.id_cliente', '=', 'usuarios.id')
            ->join('citas', 'citas.id', '=', 'reparaciones.id_cita')
            ->where('usuarios.id', session('userLogged')['id'])
            ->get()->toArray();
        $repairsWithTime = [];
        // Recorro los trabajos de cada reparación para sumar el tiempo de cada trabajo y obtener el tiempo total
        foreach ($repairs as $repair) {
            $works = Trabajo::select('trabajos.id as idTrabajo', 'trabajos.tiempo_empleado')
                ->join('trabajos_reparaciones', 'trabajos.id', 'trabajos_reparaciones.id_trabajo')
                ->where('trabajos_reparaciones.id_reparacion', '=', $repair['idReparacion'])
                ->get()->toArray();
            $timeSpent = 0;
            foreach ($works as $work) {
                $timeSpent += floatval($work['tiempo_empleado']);
            }
            $repair = array_merge($repair, array('tiempo_empleado' => $timeSpent));
            $repairsWithTime[] = $repair;
        }

        $_data['repairs'] = $repairsWithTime;
        return view('repairs.clientRepairs', $_data);
    }

    public function listRepairs()
    {
        // MUESTRO TODAS LAS REPARACIONES QUE HAY EN LA BASE DE DATOS

        $repairs = Reparacion::select('reparaciones.id as idReparacion', 'reparaciones.estado', 'reparaciones.pagada', 'coches.matricula', 'citas.motivo')
            ->join('coches', 'reparaciones.id_coche', '=', 'coches.id')
            ->join('citas', 'citas.id', '=', 'reparaciones.id_cita')
            ->get()->toArray();
        $repairsWithTime = [];
        // Recorro los trabajos de cada reparación para sumar el tiempo de cada trabajo y obtener el tiempo total
        foreach ($repairs as $repair) {
            $works = Trabajo::select('trabajos.id as idTrabajo', 'trabajos.tiempo_empleado')
                ->join('trabajos_reparaciones', 'trabajos.id', 'trabajos_reparaciones.id_trabajo')
                ->where('trabajos_reparaciones.id_reparacion', '=', $repair['idReparacion'])
                ->get()->toArray();
            $timeSpent = 0;
            foreach ($works as $work) {
                $timeSpent += floatval($work['tiempo_empleado']);
            }
            $repair = array_merge($repair, array('tiempo_empleado' => $timeSpent));
            $repairsWithTime[] = $repair;
        }

        $_data['repairs'] = $repairsWithTime;

        return view('repairs.allRepairs', $_data);
    }

    public function viewRepair($id)
    {
        // MUESTRO TODOS LOS DATOS DE UNA REPARACIÓN CONCRETA

        $id = Crypt::decryptString($id);
        $repair = Reparacion::where('id', $id)->first()->toArray();
        $works = Trabajo::select('trabajos.id', 'trabajos.descripcion', 'trabajos.tiempo_empleado')
            ->join('trabajos_reparaciones', 'trabajos.id', '=', 'trabajos_reparaciones.id_trabajo')
            ->join('reparaciones', 'trabajos_reparaciones.id_reparacion', '=', 'reparaciones.id')
            ->where('reparaciones.id', '=', $id)
            ->get()->toArray();
        $spentTime = 0;
        foreach ($works as $work) {
            $spentTime += floatval($work['tiempo_empleado']);
        }

        $repair = array_merge($repair, array('tiempo_empleado' => $spentTime));

        $_data['replacements'] = Articulo::select('articulos.id', 'articulos.nombre', 'articulos.precio', 'articulos_reparaciones.cantidad', 'reparaciones.estado')
            ->join('articulos_reparaciones', 'articulos.id', '=', 'articulos_reparaciones.id_articulo')
            ->join('reparaciones', 'articulos_reparaciones.id_reparacion', '=', 'reparaciones.id')
            ->where('reparaciones.id', '=', $id)
            ->get()->toArray();

        $engine = Coche::where('id', $repair['id_coche'])->first()->toArray();

        $repair = array_merge($repair, array('id_motor' => $engine['id_motor']));

        $_data['repair'] = $repair;
        $_data['works'] = $works;

        return view('repairs.repairDetails', $_data);
    }

    public function viewClientRepair($id)
    {
        // MUESTRO TODOS LOS DATOS DE UNA REPARACIÓN CONCRETA COMO CLIENTE

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

        $_data['repair'] = $repair;
        $_data['works'] = $works;
        $_data['replacements'] = $replacements;

        return view('repairs.clientRepairDetails', $_data);
    }

    public function checkWorks(Request $request)
    {
        // COMPRUEBA SI LA REPARACIÓN YA TIENE ALGÚN TRABAJO PARA VER SI SE PUEDE BORRAR

        return $works = count(TrabajosReparaciones::where('id_reparacion', Crypt::decryptString($request['repairId']))->get());
    }

    public function updateRepair(Request $request)
    {
        // ACTUALIZO LA REPARACIÓN

        $id = Crypt::decryptString($request['repairId']);
        Reparacion::where('id', $id)->update(array('estado' => $request['estado']));

        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.stateUpdated');
        $msg['text'] = trans('messages.stateSuccessfullyUpdated');
        $request->session()->flash('response-form', $msg);
        return redirect()->back();
    }

    public function addWork(Request $request)
    {
        // AÑADO UN NUEVO TRABAJO A LA REPARACIÓN

        $id = Crypt::decryptString($request['id']);
        $request['timeSpent'] = str_replace(',', '.', $request['timeSpent']);
        Trabajo::insert(array('descripcion' => $request['description'], 'tiempo_empleado' => $request['timeSpent']));

        $lastWork = (DB::table('trabajos')->latest('id')->first())->id;

        TrabajosReparaciones::insert(array('id_trabajo' => $lastWork, 'id_reparacion' => $id));

        $works = Trabajo::select('trabajos.id', 'trabajos.descripcion', 'trabajos.tiempo_empleado')
            ->join('trabajos_reparaciones', 'trabajos.id', '=', 'trabajos_reparaciones.id_trabajo')
            ->join('reparaciones', 'trabajos_reparaciones.id_reparacion', '=', 'reparaciones.id')
            ->where('reparaciones.id', '=', $id)
            ->get()->toArray();
        $spentTime = 0;
        foreach ($works as $work) {
            $spentTime += floatval($work['tiempo_empleado']);
        }

        return array('numero_trabajos' => count(TrabajosReparaciones::where('id_reparacion', $id)->get()), 'id_trabajo' => $lastWork, 'descripcion' => $request['description'], 'tiempo_empleado' => $request['timeSpent'], 'tiempo_total' => $spentTime . ' ' . trans('messages.hours'));

    }

    public function getWorkData(Request $request)
    {
        // DEVUELVO TODOS LOS DATOS RELACIONADOS DEL TRABAJO

        $work = Trabajo::where('id', $request['id'])->first()->toArray();
        return array('descripcion' => $work['descripcion'], 'tiempo_empleado' => $work['tiempo_empleado']);
    }

    public function updateWork(Request $request)
    {
        // ACTUALIZO UN TRABAJO QUE YA EXISTE EN LA REPARACIÓN

        Trabajo::where('id', $request['id'])->update(array('descripcion' => $request['description'], 'tiempo_empleado' => $request['timeSpent']));

        return array('id_trabajo' => $request['id'], 'descripcion' => $request['description'], 'tiempo_empleado' => $request['timeSpent']);
    }

    public function deleteWork(Request $request)
    {

        // BORRO UN TRABAJO

        TrabajosReparaciones::where('id_trabajo', $request['id'])->delete();
        Trabajo::where('id', $request['id'])->delete();

        return array('numero_trabajos' => count(TrabajosReparaciones::where('id_reparacion', Crypt::decryptString($request['repairId']))->get()));
    }

    public function getReplacements(Request $request)
    {
        // DEVUELVO TODOS LOS REPUESTOS DE UNA REPARACIÓN

        $articles = Articulo::where('id_motor', $request['engineId'])->where('id_categoria', $request['categoryId'])->where('visible', 1)->get()->toArray();

        if (empty($articles)) {
            return "noReplacements";
        } else {
            return $articles;
        }
    }

    public function checkStock(Request $request)
    {
        // COMPRUEBO EL STOCK DE UN ARTÍCULO PARA VER SI SE PUEDE AÑADIR A LA REPARACIÓN

        if ($request['toUpdate'] == "true") {
            $article = Articulo::where('id', $request['id'])->first()->toArray();
            $replacementRepair = ArticulosReparaciones::where('id_articulo', $request['idReplacement'])->first()->toArray();
            $article['stock'] = (int)$article['stock'] + (int)$replacementRepair['cantidad'];
        } else {
            $article = Articulo::where('id', $request['id'])->first()->toArray();
        }
        return $article['stock'];
    }

    public function checkArticleInRepair(Request $request)
    {
        // COMPRUEBO SI UN ARTÍCULO YA ESTÁ EN LA REPARACIÓN

        if ((ArticulosReparaciones::where('id_articulo', $request['replacementId'])->where('id_reparacion', Crypt::decryptString($request['repairId']))->count()) != 0) {
            return "true";
        } else {
            return "false";
        }
    }

    public function addReplacement(Request $request)
    {

        // AÑADO UN ARTÍCULO A LA REPARACIÓN

        $id = Crypt::decryptString($request['repairId']);

        $article = Articulo::where('id', $request['replacementId'])->first()->toArray();

        Articulo::where('id', $request['replacementId'])->update(array('stock' => ((int)$article['stock'] - (int)$request['quantity'])));

        ArticulosReparaciones::insert(array('id_reparacion' => $id, 'id_articulo' => $request['replacementId'], 'cantidad' => $request['quantity'], 'precio' => $article['precio']));

        return array('numero_repuestos' => count(ArticulosReparaciones::where('id_reparacion', $id)->get()), 'id_repuesto' => $request['replacementId'], 'nombre' => $article['nombre'], 'precio' => $article['precio'], 'cantidad' => $request['quantity']);
    }

    public function getReplacementData(Request $request)
    {
        // DEVUELVO TODOS LOS DATOS DE UN ARTÍCULO

        $replacementData = Articulo::where('id', $request['id'])->first()->toArray();
        $replacementRepairData = ArticulosReparaciones::where('id_articulo', $request['id'])->first()->toArray();
        return array('nombre' => $replacementData['nombre'], 'precio' => $replacementRepairData['precio'], 'cantidad' => $replacementRepairData['cantidad'], 'categoria' => $replacementData['id_categoria'], 'repuesto' => $replacementData['id']);
    }

    public function updateReplacement(Request $request)
    {
        // ACTUALIZO LOS DATOS DE UN REPUESTO QUE YA ESTÁ EN LA REPARACIÓN

        $replacement = Articulo::where('id', $request['replacementId'])->first()->toArray();

        ArticulosReparaciones::where('id_articulo', $request['replacementId'])->update(array('cantidad' => $request['quantity']));

        $replacementRepair = ArticulosReparaciones::where('id_articulo', $request['replacementId'])->first()->toArray();

        return array('id_repuesto' => $request['replacementId'], 'nombre' => $replacement['nombre'], 'precio' => $replacementRepair['precio'], 'cantidad' => $request['quantity']);
    }

    public function deleteReplacement(Request $request)
    {
        // BORRO UN REPUESTO DE LA REPARACIÓN

        $replacementRepairData = ArticulosReparaciones::where('id_articulo', $request['id'])->first()->toArray(); // Datos de la repuestos_reparaciones para saber la cantidad del artículo para actualizar la base de datos
        $replacement = Articulo::where('id', $request['id'])->first()->toArray(); // Datos del repuesto para saber la cantidad que hay que aumentar en la base de datos

        ArticulosReparaciones::where('id_articulo', $request['id'])->delete();

        Articulo::where('id', $request['id'])->update(array('stock' => $replacement['stock'] + $replacementRepairData['cantidad']));

        return array('numero_repuestos' => count(ArticulosReparaciones::where('id_reparacion', $request['id'])->get()));
    }

    public function completeRepair(Request $request)
    {
        // MARCO LA REPARACIÓN COMO COMPLETADA

        Reparacion::where('id', Crypt::decryptString($request['repairId']))->update(array('estado' => 'Completada', 'fecha_fin' => Carbon::now()));

        $repairData = Reparacion::select('coches.matricula', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor', 'usuarios.nombre', 'usuarios.apellidos', 'usuarios.email')
            ->join('coches', 'reparaciones.id_coche', '=', 'coches.id')
            ->join('usuarios', 'coches.id_cliente', '=', 'usuarios.id')
            ->join('motorizaciones_coche', 'coches.id_motor', '=', 'motorizaciones_coche.id')
            ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
            ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
            ->first()->toArray();

        $details = [
            'title' => trans('messages.repairCompleted'),
            'body' => trans('messages.emailOrderCompleted') . ' ' . $repairData['marca'] . ' ' . $repairData['modelo'] . ' ' . $repairData['motor'] . ' ' . trans('messages.withLicensePlate') . ' ' . $repairData['matricula'] . ' ' . trans('messages.emailOrderCompleted2'),
        ];

        // Enviar email para avisar el cliente de que la reparación está completada
        Mail::to($repairData['email'])->send(new \App\Mail\RepairNotification($details));
    }

    public function printRepair($id)
    {
        // SACO EL PDF DE UNA REPARACIÓN

        $id = Crypt::decryptString($id);

        $repair = Reparacion::select('reparaciones.id', 'reparaciones.id_coche', 'reparaciones.id_cita', 'reparaciones.estado', 'reparaciones.fecha_fin', 'reparaciones.pagada', 'usuarios.nombre', 'usuarios.apellidos', 'usuarios.direccion')
            ->join('coches', 'reparaciones.id_coche', '=', 'coches.id')
            ->join('usuarios', 'coches.id_cliente', '=', 'usuarios.id')
            ->where('reparaciones.id', $id)
            ->first()->toArray();

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

        $_data['repair'] = $repair;
        $_data['works'] = $works;
        $_data['replacements'] = $replacements;

        $pdf = PDF::loadView('pdfs.myRepairPDF', $_data);

        return $pdf->download(trans('messages.orderPdf'));

    }

    public function payRepair(Request $request)
    {
        // MARCO UNA REPARACIÓN COMO PAGADA (SI EL CLIENTE QUIERE PAGAR EN EL TALLER DIRECTAMENTE)

        Reparacion::where('id', $request['id'])->update(array('pagada' => 1));
    }

    public function checkDeleteRepair(Request $request)
    {
        // COMPRUEBO SI UNA REPARACIÓN YA TIENE ARTICULOS O REPUESTOS PARA VER SI SE PUEDE BORRAR

        $id = Crypt::decryptString($request['id']);

        if ((ArticulosReparaciones::where('id_reparacion', $id)->count()) != 0 || (TrabajosReparaciones::where('id_reparacion', $id))->count() != 0) {
            return "false";
        } else {
            return "true";
        }

    }

    public function cancelRepair(Request $request)
    {
        // CANCELO LA REPARACIÓN

        $id = Crypt::decryptString($request['id']);

        Reparacion::where('id', $id)->delete();
    }

}
