<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Image, Auth, Config, Str, Hash;
use App\Models\User;
use App\Http\Models\Coverage;
use App\Http\Models\UserAddress;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAccountEdit(){
        return view('user.account_edit');
    }
    public function postAccountAvatar(Request $request){
        $rules =[
            'avatar' => 'required|image',
            
            
        ];

        $messages =[
            'avatar.required' => 'Seleccione una imagen',            
            'avatar.image' => 'Seleccione un archivo PNG,JPG',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:            
            if($request->hasFile('avatar')):
                $u = User::find(Auth::id());
                $actual_user = $u->avatar;
                if(!is_null($u->avatar)):
                    $this->getFileDelete('uploads', $actual_user,['256x256', '64x64']);              
                endif;           
                $u->avatar = $this->postFileUpload('avatar', $request, [[64,64,'64x64'],[256,256,'256x256']]);                              
                if($u->save()):                                        
                    return back()->with('message', 'Avatar actualizado éxitosamente')->with('typealert', 'success');                   
                endif;
                
            endif;
        endif;
        
    }

    public function postAccountPassword(Request $request){
        $rules =[
            'apassword' => 'required|min:8',
            'password' => 'required|min:8',
            'cpassword' => 'required|min:8|same:password',
                       
            
        ];

        $messages =[
            'apassword.required' => 'Se necesita la contraseña actual',
            'apassword.min' => 'Se necesita min 8 caracteres de la contraseña actual',
            'password.required' => 'Ingrese una nueva contraseña',
            'password.min' => 'Se necesita min 8 caracteres de la contraseña nueva',
            'cpassword.required' => 'Confirme la nueva contraseña',
            'cpassword.min' => 'Se necesita min 8 caracteres de confirmación',  
            'cpassword.same' => 'Las contraseñas no coinciden',  
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:
            $u=User::find(Auth::id());
            if(Hash::check($request->input('apassword'), $u->password)):
                $u->password = Hash::make($request->input('password'));
                if($u->save()):
                    return back()->with('message', 'Contraseña actualizada correctamente')->with('typealert',"success"); 
                endif;
            else:
                return back()->with('message', 'Su contraseña actual es errónea')->with('typealert',"danger"); 
            endif;
        endif;
    }

    public function postAccountInfo(Request $request){

        $rules =[
            'name' => 'required',
            'lastname' => 'required',
            'phone' => 'required|min:9',
            'birthday' => 'required',

            
            
        ];

        $messages =[
            'name.required' => 'Se necesita un nombre',            
            'lastname.required' => 'Se necesita un apellido', 
            'phone.required' => 'Porfavor ingrese un celular de contacto',
            'phone.min' => 'El celular debe tener 9 números', 
            'birthday.required' => 'La fecha de nacimiento es requerida',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:
            $u=User::find(Auth::id());
            $u->name = e($request->input('name'));
            $u->lastname = e($request->input('lastname'));
            $u->birthday = $request->input('birthday');
            $u->phone = e($request->input('phone'));
            $u->gender = e($request->input('gender'));
            if($u->save()):
                return back()->with('message', 'Su información se actualizo correctamente')->with('typealert',"success"); 
            endif;
        endif;

    }

    public function getAccountAddress(){
        $states = Coverage::where('ctype', '0')->pluck('name', 'id');
        $data = ['states' => $states];
        return view('user.account_address', $data);
    }

    public function postAccountAddressAdd(Request $request){        
        $rules =[
            'name' => 'required',
            'state' => 'required',
            'city' => 'required',
            'add1' => 'required',
            'add2' => 'required',
            'add3' => 'required',
        ];

        $messages =[
            'name.required' => 'Se necesita un nombre',            
            'state.required' => 'Se debe seleccionar un departamento', 
            'city.required' => 'Se debe seleccionar una cuidad',
            'add1.required' => 'Se necesita el tipo de via',
            'add2.required' => 'Se necesita el tipo de vivienda',
            'add3.required' => 'Se necesita la direccion',            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:            
            $address = new UserAddress;
            $address->user_id = Auth::id();
            $address->state_id = $request->input('state');
            $address->city_id = $request->input('city');
            $address->name = e($request->input('name'));
            $info = ['add1' => e($request->input('add1')) , 'add2' => e($request->input('add2')), 'add3' => e($request->input('add3')), 'add4' => e($request->input('add4'))];
            $address->addr_info = json_encode($info);
            if(count(collect(Auth::user()->getAddress)) ==""):
                $address->default = "1";
            endif;
            if($address->save()):
                return back()->with('message', 'La direccion se guardo correctamente')->with('typealert',"success"); 
            endif;
        endif;

    }

    public function getAccountAddressSetDefault(UserAddress $address){
        if(Auth::id() != $address->user_id):
            return back()->with('message', 'No puede editar esta dirección de entrega')->with('typealert',"danger"); 
        else:
            // Retiramos el valor default de la anterior dirección            
            $default = UserAddress::find(Auth::user()->getAddressDefault->id);
            $default->default ="0";
            $default->save();
            // Asignamos el valor a la nueva
            $address->default = "1";
            if($address->save()):
                return back()->with('message', 'La direccion se actualizo con éxito')->with('typealert',"success"); 
            endif;
        endif;
    }

    public function getAccountAddressDelete(UserAddress $address){
        if(Auth::id() != $address->user_id):
            return back()->with('message', 'No tienes permiso para eliminar esta dirección de entrega.')->with('typealert',"danger"); 
        else:
            if ($address->default =="0"):
                if($address->delete()):
                    return back()->with('message', 'La dirección se elimino con éxito.')->with('typealert',"success"); 
                endif;
            else: 
                return back()->with('message', 'No se puede eliminar una dirección principal de entrega.')->with('typealert',"danger"); 
            endif; 
        endif;
    }

}
