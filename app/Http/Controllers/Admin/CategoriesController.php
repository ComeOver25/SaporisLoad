<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Str, Config;
use App\Http\Models\Category;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getHome($module){
        $cats = Category::where('module',$module)->where('parent', '0')->orderBy('order', 'Asc')->paginate(10);
        $data = ['cats' => $cats, 'module'=> $module];
        return view('admin.categories.home',$data);
    }

    public function postCategoryAdd(Request $request, $module){

        $rules=[
            'name' => 'required',
            'icon' => 'required|dimensions:min_width=500,min_height=500'
            
        ];
        $messages = [

            'name.required' => 'Se requiere un nombre de la categoria',
            'icon.dimensions' => 'El icono debe ser de 500 x 500',
            'icon.required' => 'Se requiere un icono para la categoria'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger"); 
        else:
            /*
            $upload_icon = $this->postFileUpload('icon', $request);
            $icon = json_decode($upload_icon, true);
            if($icon['upload'] == 'error'):
                return back()->with('message', 'No se pudo subir el archivo')->with('typealert', 'danger');
            endif;
            */
            $c = new Category;
            $c->module = $module;
            $c->parent = $request->input('parent');
            $c->name = e($request->input('name'));
            $c->slug = Str::slug($request->input('name'));
            $c->icon = $this->postFileUpload('icon', $request);
           if($c->save()):            
            return back()->with('message', 'Registrado correctamente')->with('typealert',"success"); 
           endif;
        endif;
    }

    public function getCategoryEdit($id){

        $cat = Category::findOrFail($id);
        $data = ['cat'=> $cat];
        return view('admin.categories.edit',$data);

    }

    public function postCategoryEdit(Request $request, $id){

        $rules=[
            
            'name' => 'required',
            'icon' => 'dimensions:min_width=500,min_height=500', 
            
            
        ];
        $messages = [

            'name.required' => 'Se requiere un nombre de la categoria',
            'icon.dimensions' => 'El icono debe ser de 500 x 500',       

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger"); 
        else:
            
            $c = Category::find($id);
            $c->name = e($request->input('name'));
            $c->slug = Str::slug($request->input('name'));
            if($request->hasFile('icon')):
                $actual_icon = $c->icon;
                if(!is_null($c->icon)):
                    $this->getFileDelete('uploads', $actual_icon);              
                endif;
                $c->icon = $this->postFileUpload('icon', $request);       
            endif;
            $c->order = $request->input('order');
           if($c->save()):     
               
            return redirect('/admin/categories/0')->with('message', 'Actualizado correctamente')->with('typealert',"success");            
           endif;
        endif;
    }

    public function getSubCategories($id){
        $cat = Category::findOrFail($id);
        $data = ['category' => $cat];
        return view('admin.categories.subs_categories',$data);
    }

    public function getCategoryDelete($id){
        $c = Category::find($id);
        //$path = $c->file_path;
        //$file = $c->icon;
        //$upload_path = Config::get('filesystems.disks.uploads.root');
        if($c->delete()):
            //unlink($upload_path.'/'.$path.'/'.$file);
            return back()->with('message', 'Eliminado con éxito')->with('typealert',"success"); 
        endif;

    }
    
}