<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Coche;
use App\Models\Reparacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AppointmentController extends Controller
{
    public function makeAppointment()
    {
        // CARGO TODOS LOS COCHES DEL CLIENTE PARA LA VISTA DE PEDIR CITA

        $_data['cars'] = Coche::where('id_cliente', session('userLogged')['id'])->get()->toArray();
        return view('appointments.makeAppointment', $_data);
    }

    public function getAvailableAppointments(Request $request)
    {
        // CARGO UN SELECT CON LAS HORAS DISPONIBLES SEGÚN LA FECHA SELECCIONADA

        $request['fecha'] = str_replace('/', '-', $request['fecha']);
        $request['fecha'] = date('Y-m-d', substr(strtotime($request['fecha']), 0, 10));

        $hours = ['07:00:00', '07:30:00', '08:00:00', '08:30:00', '09:00:00', '09:30:00', '10:00:00', '10:30:00', '11:00:00', '11:30:00', '12:00:00', '12:30:00', '13:00:00', '13:30:00', '14:00:00', '14:30:00', '15:00:00'];

        $appointDate = Cita::where('fecha', 'LIKE', '%' . $request['fecha'] . '%')->pluck('fecha')->toArray();

        foreach ($appointDate as $aD) {
            foreach ($hours as $hour) {
                if (str_contains($aD, $hour)) {
                    $key = array_search($hour, $hours);
                    unset($hours[$key]);
                }
            }
        }

        if (empty($hours)) {
            return array(trans('messages.noAvailableAppointments'));
        } else {
            return $hours;
        }

    }

    public function storeAppointment(Request $request)

    {
        // GUARDO LA NUEVA CITA EN LA BASE DE DATOS

        $request['fecha'] = str_replace('/', '-', $request['fecha']);
        $request['fecha'] = date('Y-m-d', substr(strtotime($request['fecha']), 0, 10));
        session()->flash('selectedDate', $request['fecha']);
        session()->flash('selectedHour', $request['hora']);

        $validatedData = $request->validate([
            'fecha' => 'required',
            'hora' => 'required',
            'coche' => 'required',
            'motivo' => 'required',
        ], [
            'fecha.required' => trans('messages.dateRequired'),
            'hora.required' => trans('messages.hourRequired'),
            'coche.required' => trans('messages.carRequired'),
            'motivo.required' => trans('messages.reasonRequired'),
        ]);

        if ($request['hora'] == trans('messages.noAvailableAppointments') || $request['hora'] == trans('messages.selectDate')) {
            $request->session()->flash('error-hora', trans('messages.neededHour'));
            return redirect()->back()->withInput($request->all());
        }

        $data = ['id_cliente' => session('userLogged')['id'], 'id_coche' => $request['coche'], 'fecha' => str_replace('/', '-', $request['fecha']) . ' ' . $request['hora'], 'motivo' => $request['motivo'], 'confirmada' => false];

        Cita::insert($data);

        // Mensaje de cuenta creada
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.appointmentAdded');
        $msg['text'] = trans('messages.appointmentSuccessfullyAdded');
        $request->session()->flash('response-form', $msg);
        return redirect()->route('listClientAppointments');

    }

    public function listClientAppointments()
    {
        // CARGO TODAS LAS CITAS DEL CLIENTE QUE HA INICIADO SESIÓN

        $_data['appointments'] = Cita::select('citas.id_cliente as idCliente', 'citas.id as idCita', 'citas.fecha', 'citas.motivo', 'coches.id as idCoche', 'coches.matricula')
            ->join('coches', 'citas.id_coche', '=', 'coches.id')
            ->where('citas.id_cliente', session('userLogged')['id'])
            ->where('citas.fecha', '>=', date('Y-m-d'))
            ->orderBy('fecha', 'ASC')
            ->get()->toArray();

        return view('appointments.clientAppointments', $_data);
    }

    public function listAppointments()
    {
        // CARGO TODAS LAS CITAS A PARTIR DEL DIA ACTUAL QUE HAY EN LA BASE DE DATOS

        $_data['appointments'] = Cita::select('citas.id as idCita', 'citas.id_cliente as idCliente', 'citas.fecha', 'citas.motivo', 'citas.confirmada', 'coches.id as idCoche', 'coches.matricula', 'usuarios.id', 'usuarios.nombre', 'usuarios.apellidos')
            ->join('coches', 'citas.id_coche', '=', 'coches.id')
            ->join('usuarios', 'citas.id_cliente', '=', 'usuarios.id')
            ->where('citas.fecha', '>=', date('Y-m-d'))
            ->orderBy('fecha', 'ASC')
            ->get()->toArray();

        return view('appointments.allAppointments', $_data);
    }

    public function cancelAppointment(Request $request)
    {
        // CANCELO UNA CITA PRO SU ID

        $id = Crypt::decryptString($request['id']);
        Cita::where('id', $id)->delete();
    }

    public function confirmAppointment(Request $request)
    {
        // CONFIRMO UNA CITA POR SU ID Y GENERO LA REPARACIÓN QUE LE CORRESPONDE

        $id = Crypt::decryptString($request['id']);
        $appointment = Cita::where('id', $id)->first()->toArray();
        Cita::where('id', $id)->update(array('confirmada' => 1));
        Reparacion::insert(array('id_coche' => $appointment['id_coche'], 'id_cita' => $appointment['id'], 'estado' => 'En Proceso', 'fecha_fin' => null, 'pagada' => false));
    }
}
