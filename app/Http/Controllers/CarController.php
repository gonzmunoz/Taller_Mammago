<?php

namespace App\Http\Controllers;

use App\Models\Coche;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Motorizacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CarController extends Controller
{
    public function addCar($id)
    {
        // CARGO LA VISTA PARA AÑADIR UN COCHE A UN CLIENTE

        $id = Crypt::decryptString($id);
        $_data['user'] = Usuario::where('id', $id)->first()->toArray();
        $_data['brands'] = Marca::all();
        return view('cars.addCar', $_data);
    }

    public function getBrands()
    {
        // CARGO UN SELECT CON LAS MARCAS DE COCHE

        $brands = Marca::select('marcas_coche.id', 'marcas_coche.nombre')->get()->toArray();
        return $brands;
    }

    public function getModels(Request $request)
    {
        // CARGO UN SELECT CON LOS MODELOS DE COCHE SEGÚN SU MARCA

        $models = Modelo::where('id_marca', $request['id'])->get()->toArray();
        return $models;
    }

    public function getEngines(Request $request)
    {
        // CARGO UN SELECT CON LOS MOTORES DE COCHE SEGÚN SU MODELO

        $engines = Motorizacion::where('id_modelo', $request['id'])->get()->toArray();
        return $engines;
    }

    public function storeCar(Request $request)
    {
        // ASIGNO EL COCHE AL CLIENTE VALIDANDO QUE LOS DATOS SEAN CORRECTOS

        $validatedData = $request->validate([
            'marca' => 'required|not_in:selectBrand',
            'modelo' => 'required|not_in:selectModel',
            'motor' => 'required|not_in:selectEngine',
            'anio' => 'required|numeric|between:1900,' . now()->year,
            'matricula' => 'required',
            'bastidor' => 'required|min:17|max:17',
        ], [
            'marca.required' => trans('messages.brandRequired'),
            'marca.not_in' => trans('messages.brandNotIn'),
            'modelo.required' => trans('messages.modelRequired'),
            'modelo.not_in' => trans('messages.modelNotIn'),
            'motor.required' => trans('messages.engineRequired'),
            'motor.not_in' => trans('messages.engineNotIn'),
            'anio.required' => trans('messages.manufactureYearRequired'),
            'anio.numeric' => trans('messages.manufactureYearNumeric'),
            'anio.between' => trans('messages.manufactureYearBetween'),
            'matricula.required' => trans('messages.licensePlateRequired'),
            'bastidor.required' => trans('messages.chassisNumberRequired'),
            'bastidor.min' => trans('messages.chassisNumberMin'),
            'bastidor.max' => trans('messages.chassisNumberMax'),
        ]);

        unset($request['_token']);
        $data = array('id_cliente' => Crypt::decryptString($request['id_cliente']),
            'id_motor' => $request['motor'], 'anio' => $request['anio'], 'matricula' => $request['matricula'], 'bastidor' => $request['bastidor']);

        if (!preg_match('/^[0-9]{4}[A-Z]{3}$/', $request['matricula'])) {
            $request->session()->flash('error-matricula', trans('messages.invalidLicensePlate'));
            return redirect()->back()->withInput($request->all());
        }

        // Comprobar si la matrícula ya está en uso
        $usedLicensePlate = Coche::where('matricula', $request['matricula'])->first();

        // Comprobar si el número de bastidor ya está en uso
        $usedChassisNumber = Coche::where('bastidor', $request['bastidor'])->first();

        if ($usedLicensePlate) {
            $request->session()->flash('error-matricula', trans('messages.usedLicensePlate'));
            return redirect()->back()->withInput($request->all());
        } elseif ($usedChassisNumber) {
            $request->session()->flash('error-bastidor', trans('messages.usedChassisNumber'));
            return redirect()->back()->withInput($request->all());
        }

        Coche::insert($data);

        // Mensaje de coche añadido
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.carAdded');
        $msg['text'] = trans('messages.carSuccessfullyAdded');
        $request->session()->flash('response-form', $msg);
        return redirect()->route('listClients');

    }

    public function listCars()
    {
        // MUESTRO TODOS LOS COCHES QUE HAY EN LA BASE DE DATOS

        $carsData = Coche::select('coches.id', 'coches.id_cliente', 'coches.anio', 'coches.matricula', 'coches.bastidor', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor', 'usuarios.nombre', 'usuarios.apellidos')
            ->join('usuarios', 'coches.id_cliente', '=', 'usuarios.id')
            ->join('motorizaciones_coche', 'coches.id_motor', '=', 'motorizaciones_coche.id')
            ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
            ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
            ->get()->toArray();
        $cars = [];
        //Recorro los coches para añadir al array el nombre de usuario de su dueño
        foreach ($carsData as $car) {
            $owner = Usuario::where('id', $car['id_cliente'])->first()->toArray()['nombre_usuario'];
            $cars[] = array_merge($car, array('dueno' => $owner));
        }
        $_data['cars'] = $cars;

        return view('cars.listCars', $_data);
    }

    public function myCars()
    {
        // MUESTRO TODOS LOS COCHES QUE PERTENECEN AL CLIENTE

        $_data['cars'] = Coche::select('coches.id', 'coches.id_cliente', 'coches.anio', 'coches.matricula', 'coches.bastidor', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
            ->join('motorizaciones_coche', 'coches.id_motor', '=', 'motorizaciones_coche.id')
            ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
            ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
            ->where('id_cliente', session('userLogged')['id'])
            ->get()->toArray();
        return view('cars.myCars', $_data);
    }

    public function viewCar($id)
    {
        // CARGO LOS DATOS DEL COCHE PARA MOSTRAR LA VISTA DE ACTUALIZACIÓN DE COCHE

        $id = Crypt::decryptString($id);
        $_data['car'] = Coche::select('coches.id', 'coches.id_cliente', 'marcas_coche.id as id_marca', 'modelos_coche.id as id_modelo', 'coches.id_motor', 'coches.anio', 'coches.matricula', 'coches.bastidor', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
            ->join('motorizaciones_coche', 'coches.id_motor', '=', 'motorizaciones_coche.id')
            ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
            ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
            ->where('coches.id', $id)
            ->first()->toArray();
        $_data['brands'] = Marca::all();

        return view('cars.updateCar', $_data);
    }

    public function updateCar(Request $request)
    {
        // ACTUALIZO LOS DATOS DE UN COCHE CONCRETO

        unset($request['_token']);

        $validatedData = $request->validate([
            'marca' => 'required|not_in:selectBrand',
            'modelo' => 'required|not_in:selectModel',
            'motor' => 'required|not_in:selectEngine',
            'anio' => 'required|numeric|between:1900,' . now()->year,
            'matricula' => 'required',
            'bastidor' => 'required|min:17|max:17',
        ], [
            'marca.required' => trans('messages.brandRequired'),
            'marca.not_in' => trans('messages.brandNotIn'),
            'modelo.required' => trans('messages.modelRequired'),
            'modelo.not_in' => trans('messages.modelNotIn'),
            'motor.required' => trans('messages.engineRequired'),
            'motor.not_in' => trans('messages.engineNotIn'),
            'anio.required' => trans('messages.manufactureYearRequired'),
            'anio.numeric' => trans('messages.manufactureYearNumeric'),
            'anio.between' => trans('messages.manufactureYearBetween'),
            'matricula.required' => trans('messages.licensePlateRequired'),
            'bastidor.required' => trans('messages.chassisNumberRequired'),
            'bastidor.min' => trans('messages.chassisNumberMin'),
            'bastidor.max' => trans('messages.chassisNumberMax'),
        ]);

        unset($request['_token']);
        $data = $request->all();
        $data = array('id' => Crypt::decryptString($request['id']), 'id_cliente' => Crypt::decryptString($request['id_cliente']),
            'id_motor' => $request['motor'], 'anio' => $request['anio'], 'matricula' => $request['matricula'], 'bastidor' => $request['bastidor']);

        if (!preg_match('/^[0-9]{4}[A-Z]{3}$/', $request['matricula'])) {
            $request->session()->flash('error-matricula', trans('messages.invalidLicensePlate'));
            return redirect()->back()->withInput($request->all());
        }

        // Comprobar si la matrícula ya está en uso
        $usedLicensePlate = Coche::where('matricula', $request['matricula'])->where('id_cliente', '!=', $data['id_cliente'])->first();

        // Comprobar si el número de bastidor ya está en uso
        $usedChassisNumber = Coche::where('bastidor', $request['bastidor'])->where('id_cliente', '!=', $data['id_cliente'])->first();

        if ($usedLicensePlate) {
            $request->session()->flash('error-matricula', trans('messages.usedLicensePlate'));
            return redirect()->back()->withInput($request->all());
        } elseif ($usedChassisNumber) {
            $request->session()->flash('error-bastidor', trans('messages.usedChassisNumber'));
            return redirect()->back()->withInput($request->all());
        }

        Coche::where('id', $data['id'])->update($data);

        // Mensaje de cuenta creada
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.carUpdated');
        $msg['text'] = trans('messages.carSuccessfullyUpdated');
        $request->session()->flash('response-form', $msg);
        return redirect()->route('listCars');
    }

}
