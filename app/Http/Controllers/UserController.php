<?php

namespace App\Http\Controllers;

use App\Models\Coche;
use App\Models\TipoUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        // DEVUELVO LA VISTA PARA QUE EL USUARIO VEA SUS DATOS

        return view('users.myAccount');
    }

    public function updateAccount(Request $request)
    {
        // ACTUALIZO LOS DATOS DE UN USUARIO

        unset($request['_token']);

        $validatedData = $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'pais' => 'required',
            'provincia' => 'required',
            'ciudad' => 'required',
            'email' => 'required',
            'telefono' => 'required|numeric|digits:9',
            'foto' => 'sometimes|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nombre.required' => trans('messages.nameRequired'),
            'apellidos.required' => trans('messages.surNameRequired'),
            'direccion.required' => trans('messages.addressRequired'),
            'pais.required' => trans('messages.countryRequired'),
            'provincia.required' => trans('messages.stateRequired'),
            'ciudad.required' => trans('messages.cityRequired'),
            'email.required' => trans('messages.emailRequired'),
            'telefono.required' => trans('messages.phoneRequired'),
            'telefono.numeric' => trans('messages.phoneNumeric'),
            'telefono.digits' => trans('messages.phoneDigits'),
            'foto.mimes' => trans('messages.errorMimes'),
        ]);

        // Comprobar si el email ya está en uso
        $usedEmail = $this->usedColumnUser('email', $request['email'], $request['nombre_usuario']);

        // Comprobar si el usuario ya está en uso
        $usedPhone = $this->usedColumnUser('telefono', $request['telefono'], $request['nombre_usuario']);

        if ($usedEmail) {
            $request->session()->flash('error-email', trans('messages.usedEmail'));
            return redirect()->back()->withInput($request->all());
        } elseif ($usedPhone) {
            $request->session()->flash('error-phone', trans('messages.usedPhone'));
            return redirect()->back()->withInput($request->all());
        }

        $data = ['nombre_usuario' => $request['nombre_usuario'], 'nombre' => $request['nombre'], 'apellidos' => $request['apellidos'], 'direccion' => $request['direccion'],
            'pais' => $request['pais'], 'provincia' => $request['provincia'], 'ciudad' => $request['ciudad'],
            'email' => $request['email'], 'telefono' => $request['telefono'], 'password' => $request['password']];

        $user = Usuario::where('id', session('userLogged')['id'])->first()->toArray();
        $updatePassword = false;

        if ($data['password'] != null) {
            if (!Hash::check($data['password'], $user['password'])) {
                $request->session()->flash('error-old-password', trans('messages.wrongOldPassword'));
                return redirect()->back()->withInput($request->all());
            }

            if ($request['new-password'] == $request['repeat-new-password']) {
                if (preg_match('/^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $request['new-password'])) {
                    $updatePassword = true;
                } else {
                    $request->session()->flash('error-password', trans('messages.validPassword'));
                    return redirect()->back()->withInput($request->all());
                }
            } else {
                $request->session()->flash('error-password', trans('messages.wrongNewPassword'));
                return redirect()->back()->withInput($request->all());
            }
        }

        // Al cambiar la contraseña, comprobar si las dos coinciden
        if ($updatePassword) {
            $data['password'] = Hash::make($request['new-password']);
        } else {
            $data['password'] = $user['password'];
        }

        // Si el usuario quire cambiar la foto se sube la imagen cuyo nombre será el del usuario,
        // así si alguna vez la cambia se sustituye la anterior para no almacenar imágenes innecesariamente
        if ($request['foto'] != null) {
            $imageExtension = $request->file('foto')->extension();
            $data['foto'] = 'images/users/' . $data['nombre_usuario'] . '.' . $imageExtension;
            $path = $request->file('foto')->storeAs('', $data['foto'], 'public');
        }

        Usuario::where('id', session('userLogged')['id'])->update($data);
        $user = Usuario::where('id', session('userLogged')['id'])->first()->toArray();
        session()->put('userLogged', $user);
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.updatedAccount');
        $msg['text'] = trans('messages.accountSuccessfullyUpdated');
        $request->session()->flash('response-form', $msg);
        return redirect()->route('myAccount');

    }

    public function addWorker()
    {
        // DEVUELVO LA VISTA PARA AÑADIR UN TRABAJADOR

        $_data['workers'] = TipoUsuario::where('tipo_usuario', 'administrativo')->orWhere('tipo_usuario', 'mecanico')->get()->toArray();
        return view('users.addWorker', $_data);
    }

    public function storeWorker(Request $request)
    {
        // VALIDO LOS DATOS DEL TRABAJADOR Y LO GUARDO EN LA BASE DE DATOS

        $validatedData = $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'pais' => 'required',
            'provincia' => 'required',
            'ciudad' => 'required',
            'email' => 'required',
            'telefono' => 'required',
        ], [
            'nombre.required' => trans('messages.nameRequired'),
            'apellidos.required' => trans('messages.surNameRequired'),
            'direccion.required' => trans('messages.addressRequired'),
            'pais.required' => trans('messages.countryRequired'),
            'provincia.required' => trans('messages.stateRequired'),
            'ciudad.required' => trans('messages.cityRequired'),
            'email.required' => trans('messages.emailRequired'),
            'telefono.required' => trans('messages.phoneRequired'),
        ]);

        // Comprobar si el email y el email ya está en uso
        $usedEmail = $this->usedColumnUser('email', $request['email'], null);
        // Comprobar si el teléfono ya está en uso
        $usedPhone = $this->usedColumnUser('telefono', $request['telefono'], null);

        if ($usedEmail) {
            $request->session()->flash('error-email', trans('messages.usedEmail'));
            return redirect()->back()->withInput($request->all());
        } elseif ($usedPhone) {
            $request->session()->flash('error-phone', trans('messages.usedPhone'));
            return redirect()->back()->withInput($request->all());
        }

        // Código que se meterá en el email para poder confirmar la cuenta
        $codigoConfirmacion = Str::random(25);

        unset($request['_token']);

        $lastWorker = ""; // Para contar el último trabajador y asignarle nombre de usuario
        $username = "";
        $password = "";

        if ($request['puesto'] == 2) {
            $lastWorker = count(Usuario::where('id_tipo_usuario', 2)->get());
            $username = "administrativo" . ($lastWorker + 1);
            $password = Hash::make('adMMin56');
        } elseif ($request['puesto'] == 3) {
            $lastWorker = count(Usuario::where('id_tipo_usuario', 3)->get());
            $username = "mecanico" . ($lastWorker + 1);
            $password = Hash::make('MMeca81');
        }

        $data = ['id_tipo_usuario' => $request['puesto'], 'nombre_usuario' => $username, 'nombre' => $request['nombre'], 'apellidos' => $request['apellidos'],
            'email' => $request['email'], 'password' => $password, 'foto' => 'images/users/user.jpg', 'confirmada' => 0, 'codigo_confirmacion' => $codigoConfirmacion];

        $details = [
            'title' => trans('messages.confirmEmail') . ' ' . $username,
            'user_name' => trans('messages.yourUserName') . ' ' . $username,
            'body' => url('register/verify/' . $codigoConfirmacion),
        ];

        // Enviar email para confirmar cuenta
        Mail::to($request['email'])->send(new \App\Mail\ConfirmWorkerAccount($details));
        Usuario::insert($data);

        // Mensaje de cuenta creada
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.accountCreated');
        $msg['text'] = trans('messages.accountSuccessfullyCreated2');
        $request->session()->flash('response-form', $msg);
        return redirect()->route('index');

    }

    public function listWorkers()
    {
        // LISTO TODOS LOS TRABAJORES QUE HAY EN LA BASE DE DATOS

        $_data['users'] = Usuario::where('id_tipo_usuario', '!=', 4)->where('id_tipo_usuario', '!=', 1)->get()->toArray();

        return view('users.listWorkers', $_data);
    }

    public function listClients()
    {
        // LISTO TODOS LOS CLIENTES QUE HAY EN LA BASE DE DATOS

        $_data['users'] = Usuario::where('id_tipo_usuario', 4)->get()->toArray();
        return view('users.listClients', $_data);
    }

    public function viewClient($id)
    {
        // DEVUELVO LA VISTA PARA VER TODOS LOS DATOS DE UN CLIENTE

        $id = Crypt::decryptString($id);
        $_data['user'] = Usuario::where('id', $id)->first()->toArray();
        return view('users.updateUser', $_data);
    }

    public function viewWorker($id)
    {
        // DEVUELVO LA VISTA PARA VER TODOS LOS DATOS DE UN TRABAJADOR

        $id = Crypt::decryptString($id);
        $_data['user'] = Usuario::where('id', $id)->first()->toArray();
        return view('users.updateWorker', $_data);
    }

    public function updateClient(Request $request)
    {
        // VALIDO LOS DATOS DEL TRABAJADOR Y LO ACTUALIZO

        unset($request['_token']);

        $validatedData = $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'pais' => 'required',
            'provincia' => 'required',
            'ciudad' => 'required',
            'email' => 'required',
            'telefono' => 'required|numeric|digits:9',
        ], [
            'nombre.required' => trans('messages.nameRequired'),
            'apellidos.required' => trans('messages.surNameRequired'),
            'direccion.required' => trans('messages.addressRequired'),
            'pais.required' => trans('messages.countryRequired'),
            'provincia.required' => trans('messages.stateRequired'),
            'ciudad.required' => trans('messages.cityRequired'),
            'email.required' => trans('messages.emailRequired'),
            'telefono.required' => trans('messages.phoneRequired'),
            'telefono.numeric' => trans('messages.phoneNumeric'),
            'telefono.digits' => trans('messages.phoneDigits'),
        ]);

        // Comprobar si el email ya está en uso
        $usedEmail = $this->usedColumnUser('email', $request['email'], $request['nombre_usuario']);

        // Comprobar si el teléfono ya está en uso
        $usedPhone = $this->usedColumnUser('telefono', $request['telefono'], $request['nombre_usuario']);

        if ($usedEmail) {
            $request->session()->flash('error-email', trans('messages.usedEmail'));
            return redirect()->back()->withInput($request->all());
        } elseif ($usedPhone) {
            $request->session()->flash('error-phone', trans('messages.usedPhone'));
            return redirect()->back()->withInput($request->all());
        }

        $data = ['nombre_usuario' => $request['nombre_usuario'], 'nombre' => $request['nombre'], 'apellidos' => $request['apellidos'], 'direccion' => $request['direccion'],
            'pais' => $request['pais'], 'provincia' => $request['provincia'], 'ciudad' => $request['ciudad'],
            'email' => $request['email'], 'telefono' => $request['telefono']];

        $user = Usuario::where('id', $request['id'])->update($data);

        if (str_contains(url()->previous(), 'viewClient')) {
            $msg['icon'] = 'success';
            $msg['title'] = trans('messages.userUpdate');
            $msg['text'] = trans('messages.messageUserUpdated');
            $request->session()->flash('response-form', $msg);
            return redirect()->route('listClients');
        } else {
            $msg['icon'] = 'success';
            $msg['title'] = trans('messages.workerUpdate');
            $msg['text'] = trans('messages.messageWorkerUpdated');
            $request->session()->flash('response-form', $msg);
            return redirect()->route('listWorkers');
        }

    }

    public function disableUser(Request $request)
    {
        // INHABILITO A UN USUARIO PARA ACCEDER A LA APLICACIÓN

        $id = Crypt::decryptString($request['id']);
        $user = Usuario::where('id', $id)->first()->toArray();
        Usuario::where('id', $id)->update(array('habilitada' => 0));
    }

    public function ableUser(Request $request)
    {
        // HABILITO A UN USUARIO PARA QUE PUEDA VOLVER A ACCEDER A LA APLICACIÓN

        $id = Crypt::decryptString($request['id']);
        Usuario::where('id', $id)->update(array('habilitada' => 1));
    }


    public function usedColumnUser($campo, $valor, $username)
    {
        // COMPRUBA SI EL CAMPO QUE INTRODUZCO YA ESTÁ REGISTRADO

        if ($username == null) {
            $result = Usuario::where($campo, $valor)->first();
        } else {
            $result = Usuario::where($campo, $valor)->where('nombre_usuario', '!=', $username)->first();
        }

        if ($result == null) {
            return false;
        } else {
            return true;
        }
    }
}
