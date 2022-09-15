<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str,Config ,Image, Auth;
use App\Http\Models\Slider;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getHome(){
        $sliders = Slider::orderBy('sorder', 'Asc')->get();
        $data = ['sliders' => $sliders];
        return view('admin.slider.home', $data);
    }

    public function postSliderAdd(Request $request){
        $rules =[
            'name' => 'required',
            'img' => 'required|image|dimensions:min_width=500,min_height=500',
            'content' => 'required',
            'sorder' => 'required'
            
        ];

        $messages =[
            'name.required' => 'El nombre es requerido',
            'img.required' => 'La imagen es requerida',           
            'img.image' => 'Seleccione un archivo PNG,JPG',
            'img.dimenions' => 'La imagen debe ser mayor a 500x500',
            'content.required' => 'Es necesaria una pequeña descripción',
            'sorder.required' => 'Se necesita un número de orden'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:
                        
            $slider = new Slider;
            $slider->user_id = Auth::id();
            $slider->status=$request->input('visible');
            $slider->name=e($request->input('name'));
            $slider->file_name = $this->postFileUpload('img', $request, [[1000,1000,'1000x1000']]);
            $slider->content=e($request->input('content'));
            $slider->sorder=e($request->input('sorder'));

            if($slider->save()):
                    return back()->with('message', 'Agregado correctamente')->with('typealert',"success"); 
            endif;
        endif;
    }

    public function getSliderEdit($id){
        $slider = Slider::findOrFail($id);
        $data = ['slider' => $slider];
        return view('admin.slider.edit', $data);
    }

    public function postSliderEdit($id, Request $request){
        $rules =[
            'name' => 'required',            
            'content' => 'required',
            'sorder' => 'required',
            'img' => 'dimensions',
            
        ];

        $messages =[
            'name.required' => 'El nombre es requerido',            
            'content.required' => 'Es necesaria una pequeña descripción',
            'sorder.required' => 'Se necesita un número de orden',
            'img.dimenions' => 'La imagen debe ser mayor a 500x500',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else: 
            $slider = Slider::findOrFail($id);
            $slider-> user_id = Auth::id();
            $slider->status=$request->input('visible');
            $slider->name=e($request->input('name'));
            $slider->content=e($request->input('content'));
            $slider->sorder=e($request->input('sorder'));
            /*if($request->hasFile('img')):
                $actual_file_name = $slider->file_name;
                if(!is_null($slider->file_name)):
                    $this->getFileDelete('uploads', $actual_file_name,['1000x1000']);              
                endif;
                $slider->file_name = $this->postFileUpload('img', $request);       
            endif;*/
            if($slider->save()):
                return redirect('/admin/sliders')->with('message', 'Agregado correctamente')->with('typealert',"success"); 
            endif;
        endif;
    }

    public function getSliderDelete(Request $request,$id){

        $slider = Slider::findOrFail($id);       
        
        $path = $slider->file_path;
        $file = $slider->file_name;
        $upload_path = Config::get('filesystems.disks.uploads.root');
                
        if($slider->delete()):
            $actual_file_name = $slider->file_name;
            $this->getFileDelete('uploads', $actual_file_name,['1000x1000']);  
            return back()->with('message', 'Panel eliminado correctamente')->with('typealert',"success"); 
        endif;

    }
}
