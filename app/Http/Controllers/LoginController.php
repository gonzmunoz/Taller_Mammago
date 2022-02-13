<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{

    public function register()
    {
        // DEVUELVO LA VISTA PARA REGISTRARSE EN LA APLICACIÓN

        return view('login.register');
    }

    public function checkRegister(Request $request)
    {
        // VALIDO EL REGISTRO PARA QUE LOS DATOS SEAN CORRECTOS

        $validatedData = $request->validate([
            'rgUserName' => 'required',
            'rgName' => 'required',
            'rgSurName' => 'required',
            'rgEmail' => 'required',
            'rgPassword' => 'required|regex:/^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
            'rgPasswordRepeated' => 'required',
        ], [
            'rgUserName.required' => trans('messages.userNameRequired'),
            'rgName.required' => trans('messages.nameRequired'),
            'rgSurName.required' => trans('messages.surNameRequired'),
            'rgEmail.required' => trans('messages.emailRequired'),
            'rgPassword.required' => trans('messages.passwordRequired'),
            'rgPassword.regex' => trans('messages.validPassword'),
            'rgPasswordRepeated.required' => trans('messages.repeatedPasswordRequired'),
        ]);

        // Comprobar si el nombre de usuario y el email ya están en uso
        $usedUser = $this->usedColumnUser('nombre_usuario', $request['rgUserName']);
        $usedEmail = $this->usedColumnUser('email', $request['rgEmail']);

        if ($usedUser) {
            $request->session()->flash('error-user', trans('messages.usedUserName'));
            return redirect()->back()->withInput($request->all());
        } elseif ($usedEmail) {
            $request->session()->flash('error-email', trans('messages.usedEmail'));
            return redirect()->back()->withInput($request->all());
        }

        // Código que se meterá en el email para poder confirmar la cuenta de usuario
        $codigoConfirmacion = Str::random(25);

        unset($request['_token']);

        $data = ['id_tipo_usuario' => 4, 'nombre_usuario' => $request['rgUserName'], 'nombre' => $request['rgName'], 'apellidos' => $request['rgSurName'],
            'email' => $request['rgEmail'], 'password' => $request['rgPassword'], 'foto' => 'images/users/user.jpg', 'confirmada' => 0, 'codigo_confirmacion' => $codigoConfirmacion];

        // Comprobar si las contraseñas introducidas son iguales
        if ($request['rgPassword'] != $request['rgPasswordRepeated']) {
            $request->session()->flash('error-password', trans('messages.mismatchPassword'));
            return redirect()->back()->withInput($request->all());
        } else {

            $details = [
                'title' => trans('messages.confirmEmail'),
                'body' => url('register/verify/' . $codigoConfirmacion),
            ];

            // Enviar email para confirmar cuenta
            Mail::to($request['rgEmail'])->send(new \App\Mail\ConfirmAccount($details));
            $data['password'] = Hash::make($request['rgPassword']);
            Usuario::insert($data);

            // Mensaje de cuenta creada
            $msg['icon'] = 'success';
            $msg['title'] = trans('messages.accountCreated');
            $msg['text'] = trans('messages.accountSuccessfullyCreated');
            $request->session()->flash('response-form', $msg);
            return redirect()->route('index');
        }


    }

    public function verifyEmail($code)
    {
        // CONFIRMO LA CUENTA DE USUARIO MEDIANTE EL ENLACE QUE SE LE ENVIA AL CORREO ELECTRÓNICO

        $usuario = Usuario::where('codigo_confirmacion', $code)->first();


        if ($usuario == null) {
            return view('layout.index');
        } else {
            Usuario::where('codigo_confirmacion', $code)->update(array('confirmada' => 1));
            $msg['icon'] = 'success';
            $msg['title'] = trans('messages.accountActivated');
            $msg['text'] = trans('messages.accountSuccessfullyActivated');
            session()->flash('response-form', $msg);
        }

        return redirect()->route('index');
    }

    public function login()
    {
        // DEVUELVO LA VISTA PARA INICIAR SESIÓN

        return view('login.login');
    }

    public function checkLogin(Request $request)
    {
        // VALIDO QUE EL INICIO DE SESIÓN SEA CORRECTO

        $validatedData = $request->validate([
            'lgName' => 'required',
            'lgPassword' => 'required',
        ], [
            'lgName.required' => trans('messages.emailRequired'),
            'lgPassword.required' => trans('messages.passwordRequired')
        ]);

        $client = Usuario::where('email', $request['lgName'])->orwhere('nombre_usuario', $request['lgName'])->first();


        if ($client != null) {
            $client = Usuario::where('email', $request['lgName'])->orwhere('nombre_usuario', $request['lgName'])->first()->toArray();
            $correctPassword = Hash::check($request['lgPassword'], $client['password']);
            if (($request['lgName'] == $client['email'] || $request['lgName'] == $client['nombre_usuario']) && $correctPassword) {
                if ($client['confirmada'] == 0) {
                    $msg['icon'] = 'error';
                    $msg['title'] = trans('messages.noActiveAccount');
                    $msg['text'] = trans('messages.pleaseActiveAccount');
                    $request->session()->flash('response-form', $msg);
                    return redirect()->route('login');
                } else {

                    if ($client['habilitada'] == 1) {
                        session()->put('userLogged', $client);
                        $msg['icon'] = 'success';
                        $msg['title'] = trans('messages.logged');
                        $msg['text'] = trans('messages.successfullyLogged');
                        $request->session()->flash('response-form', $msg);
                        return redirect()->route('index');
                    } else {
                        $msg['icon'] = 'error';
                        $msg['title'] = trans('messages.userDisabled');
                        $msg['text'] = trans('messages.accountDisabled');
                        $request->session()->flash('response-form', $msg);
                        return redirect()->route('login');
                    }

                }

            } else {
                $request->session()->flash('error-password', trans('messages.incorrectPassword'));
            }
        } else {
            $request->session()->flash('error-email', trans('messages.unregisteredEmail'));
        }

        return redirect()->back()->withInput($request->all());

    }

    public function forgottenPassword()
    {
        // DEVUELVO LA VISTA DE CONTRASEÑA OLVIDADA

        return view('login.forgottenPassword');
    }

    public function recoverPassword(Request $request)
    {
        // VALIDO QUE EL CORREO ESTÉ REGISTRADO EN LA APLICACIÓN PARA ENVIARLE UN ENLACE PARA CAMBIAR SU CONTRASEÑA

        $validatedData = $request->validate([
            'fpEmail' => 'required',
        ], [
            'fpEmail.required' => trans('messages.emailRequired'),
        ]);

        unset($request['_token']);

        $data = $request->all();

        $client = Usuario::where('email', $request['fpEmail'])->first();

        if ($client != null) {

            $codigoPassword = Str::random(25);

            $details = [
                'title' => trans('messages.pleaseChangePassword'),
                'body' => url('changePassword/' . $codigoPassword),
            ];

            Mail::to($request['fpEmail'])->send(new \App\Mail\RecoverPassword($details));

            Usuario::where('email', $data['fpEmail'])->update(array('codigo_password' => $codigoPassword));

            $msg['icon'] = 'success';
            $msg['title'] = trans('messages.emailSend');
            $msg['text'] = trans('messages.checkEmail');
            $request->session()->flash('response-form', $msg);
            return redirect()->route('index');
        } else {
            $request->session()->flash('error-email', trans('messages.unregisteredEmailForgotten'));
            return redirect()->back()->withInput($request->all());
        }

    }

    public function validateChangePassword($code)
    {
        // VALIDO MEDIANTE EL ENLACE DE CORREO SI EL USUARIO PUEDE CAMBIAR SU CONTRASEÑA

        $usuario = Usuario::where('codigo_password', $code)->first();
        $_data['codigoPassword'] = $code;

        if ($usuario == null) {
            return redirect()->route('index');
        } else {
            return view('login.recoverPassword', $_data);
        }

    }

    public function changePassword(Request $request)
    {
        // CAMBIO LA CONTRASEÑA DEL USUARIO DESPUÉS DE VALIDARLA

        $validatedData = $request->validate([
            'cpPassword' => 'required',
            'cpPassword-repeat' => 'required',
        ], [
            'cpPassword.required' => trans('messages.passwordRequired'),
            'cpPassword-repeat.required' => trans('messages.passwordRepeatRequired'),
        ]);

        unset($request['_token']);

        if ($request['cpPassword'] == $request['cpPassword-repeat']) {
            Usuario::where('codigo_password', $request['passwordCode'])->update(array('password' => Hash::make($request['cpPassword'])));
            $msg['icon'] = 'success';
            $msg['title'] = trans('messages.passwordChanged');
            $msg['text'] = trans('messages.passwordSuccessfullyChanged');
            $request->session()->flash('response-form', $msg);
            return redirect()->route('index');
        } else {
            $request->session()->flash('error-password', trans('messages.mismatchPassword'));
            return redirect()->back()->withInput($request->all());
        }

    }

    public function logout(Request $request)
    {
        // CIERRO LA SESIÓN DEL USUARIO

        \Cart::clear();
        session()->forget('userLogged');
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.loggedOut');
        $msg['text'] = trans('messages.successfullyLoggedOut');
        $request->session()->flash('response-form', $msg);
        return redirect()->route('index');
    }

    public function usedColumnUser($campo, $valor)
    {
        // COMPRUEBO SI HAY UN CAMPO REPETIDO

        $result = Usuario::where($campo, $valor)->first();
        if ($result == null) {
            return false;
        } else {
            return true;
        }
    }

}
