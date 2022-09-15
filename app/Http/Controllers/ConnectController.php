<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Hash, Auth, Mail, Str;
use App\Mail\UserSendRecover;
use App\Mail\UserSendNewPassword;
use App\Models\User;

class ConnectController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except(['getLogout']);
    }
    // creamos la funcion
    public function getLogin(){

        return view('connect.login');

    }

    public function postLogin(Request $request){
        $rules = [
            
            // unique dice requiere de la APP del metodo user, de la columna en la base de datos email
            'email' => 'required|email',
            'password' => 'required|min:8',
            
        ];
        $messages = [
           
            'email.required' => 'Email no ingresado',
            'email.email' => 'Correo inválido',           
            'password.required' => 'Contraseña no ingresada',
            'password.min' => 'Ingrese más de 8 carácteres',
            
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger"); 
        else:
           if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)):
            if(Auth::user()->status == "100"):
                return redirect('/logout');
            else:
                return redirect('/');
            endif;
            
           else:  
            return back()->withErrors($validator)->with('message', 'Error de usuario y/o contraseña')->with('typealert',"warning");
           endif;
        endif;

    }

    public function getRegister(){

        return view('connect.register');

    }

    public function postRegister(Request $request){
        $rules = [
            //reglas para validar campos
            'name' => 'required',
            'lastname' => 'required',
            // unique dice requiere de la APP del metodo user, de la columna en la base de datos email
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'cpassword' => 'required|min:8|same:password'
        ];

        $messages = [
            'name.required' => 'Nombre no ingresado',
            'lastname.required' => 'Apellido no puede estar vacio',
            'email.required' => 'Email no ingresado',
            'email.email' => 'Correo inválido',
            'email.unique' => 'El correo ya existe',
            'password.required' => 'Contraseña no ingresada',
            'password.min' => 'Ingrese más de 8 carácteres',
            'cpassword.required' => 'Ingrese confirmación de contraseña',
            'cpassword.min' => 'Ingrese más de 8 carácteres de confirmación',
            'cpassword.same' => 'Las contraseñas no coinciden'
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger"); 
        else:
            $user = new User;
            $user->name= e($request->input('name'));
            $user->lastname= e($request->input('lastname'));
            $user->email= e($request->input('email'));
            $user->password=Hash::make($request->input('password'));

            if($user->save()):
                return redirect('/login')->with('message', 'Usuario creado exitosamente')->with('typealert',"success");
            endif;
        endif;
    }

    public function getLogout(){
        $status = Auth::user()->status;
        Auth::logout();
        if($status == "100"):
            return redirect('/login')->with('message', 'Su usuario fue suspendido, contacte con el administrador')->with('typealert', 'danger');
        else:
        return redirect('/');
        endif;
    }

    public function getRecover(){
        return view('connect.recover');

    }

    public function postRecover(Request $request){
        $rules = [
            
            'email' => 'required|email'            
        ];

        $messages = [
            
            'email.required' => 'Email no ingresado',
            'email.email' => 'Correo inválido'            
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger"); 
        else:
            $user=User::where('email', $request->input('email'))->count();
            if ($user== "1"):
                $user=User::where('email', $request->input('email'))->first();
                $code = rand(100000, 999999);
                $data = ['name' => $user->name, 'email' => $user->email, 'code' => $code];
                $u = User::find($user->id);
                $u->password_code = $code;
                if($u->save()):
                Mail::to($user->email)->send(new UserSendRecover($data));
                return redirect('/reset?email='.$user->email)->with('message', 'Hemos enviado un correo electrónico a su usuario perfil')->with('typealert',"warning"); 
                endif;
            else:
                return back()->with('message', 'Email no encontrado')->with('typealert',"danger");
            endif;

            
        endif;
    }

    public function getReset(Request $request){
        $data = ['email' => $request->get('email')];
        return view('connect.reset',$data);
    }

    public function postReset(Request $request){
        $rules = [
            
            'email' => 'required|email',
            'code' => 'required'           
        ];

        $messages = [
            
            'email.required' => 'Email no ingresado',
            'email.email' => 'Correo inválido',
            'code.required' => 'Ingrese el código de su correo'           
        ];

        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger"); 
        else:
            $user=User::where('email', $request->input('email'))->where('password_code', $request->input('code'))->count();
            if($user =="1"):
                $user=User::where('email', $request->input('email'))->where('password_code', $request->input('code'))->first();
                $new_password = Str::random(8);
                $user->password = Hash::make($new_password);
                $user->password_code = null;
                if($user->save()):
                    $data = ['name' => $user->name, 'password' =>  $new_password];
                    Mail::to($user->email)->send(new UserSendNewPassword($data));
                    return redirect('/login')->with('message', 'Se le envio un correo con su contraseña')->with('typealert',"success"); 
                endif;
            else:
                return back()->with('message', 'Correo o código de verificación no encontrado')->with('typealert',"danger");
            endif;
        endif;
    }
}
