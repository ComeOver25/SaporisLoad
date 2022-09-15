<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Product;
use App\Http\Models\PGallery;
use App\Http\Models\Inventory;
use App\Http\Models\Variant;
use Validator, Str,Config ,Image;
use Illuminate\Pagination\Paginator;


class ProductController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getHome($status){
        switch($status){
            case '0':
                $products = Product::with(['cat', 'getSubcategory'])->where('status','0')->orderBy('id', 'asc')->paginate(10);
                break;
            case '1':
                $products = Product::with(['cat', 'getSubcategory'])->where('status','1')->orderBy('id', 'asc')->paginate(10);
                break;
            case 'all':
                $products = Product::with(['cat', 'getSubcategory'])->orderBy('id', 'asc')->paginate(10);
                break;
            case 'trash':
                $products = Product::with(['cat', 'getSubcategory'])->onlyTrashed()->orderBy('id', 'asc')->paginate(10);
                break;
        }
       
        $data = ['products' => $products];
        return view('admin.products.home', $data);
    }

    public function getProductAdd(){
        $cats = Category::where('module', '0')->where('parent', '0')->pluck('name','id');
        $data =['cats'=> $cats];
        return view('admin.products.add',$data);
    }

    public function postProductAdd(Request $request){
        $rules =[
            'name' => 'required',
            'image' => 'required|image|dimensions:min_width=500,min_height=500',            
            'content' => 'required'
            
        ];

        $messages =[
            'name.required' => 'El nombre es requerido',
            'image.required' => 'Seleccione una imagen o foto',
            'image.image' => 'Seleccione un archivo PNG,JPG',
            'image.dimensions' => 'La imagen tiene que ser mayor a 500x500',            
            'content.required' => 'Se necesita una descripción'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:            
            $product = new Product;
            $product->status = '0';
            $product->code = e($request->input('code'));
            $product->name= e($request->input('name'));
            $product->slug = Str::slug($request->input('name'));
            $product->category_id=$request->input('category');
            $product->subcategory_id=$request->input('subcategory');
            $product->image = $this->postFileUpload('image', $request, [[500,500,'500x500']]);          
            $product->in_discount = $request->input('indiscount');
            $product->discount = $request->input('discount');
            $product->content= $request->input('content');
            if($product->save()):                
                return redirect('/admin/product/'.$product->id.'/edit')->with('message', 'Producto registrado correctamente')->with('typealert',"success"); 
               endif;
        endif;
        
    }

    public function getProductEdit($id){
        $p = Product::findOrFail($id);
        $cats = Category::where('module', '0')->where('parent', '0')->pluck('name','id');
        $data =['cats'=> $cats, 'p' => $p];
        return view('admin.products.edit',$data);

    }

    public function postProductEdit($id, Request $request){

        $rules =[
            'name' => 'required',
            'image' => 'image|dimensions:min_width=500,min_height=500',            
            'content' => 'required'
            
        ];

        $messages =[
            'name.required' => 'El nombre es requerido',            
            'image.image' => 'Seleccione un archivo PNG,JPG',
            'image.dimensions' => 'La imagen tiene que ser mayor a 500x500',           
            'content.required' => 'Se necesita una descripción'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:
                        
            $product = Product::findOrFail($id);
            $ipp = $product->file_path; //imagen path previa
            $ip = $product->image; //imagen previa 
            $product->status = $request->input('status');
            $product->code = e($request->input('code'));
            $product->name= e($request->input('name'));
            $product->category_id=$request->input('category');
            $product->subcategory_id=$request->input('subcategory');
            $product->slug = Str::slug($request->input('name'));
            if($request->hasFile('image')):
                $actual_image = $product->image;
                if(!is_null($product->image)):
                    $this->getFileDelete('uploads', $actual_image,['500x500'/*, '328x328'*/]);              
                endif;
                $product->image = $this->postFileUpload('image', $request, [[500,500,'500x500'] /*, [328,328,'328x328']*/]);       
            endif;
                      
            $product->in_discount = $request->input('indiscount');
            $product->discount = $request->input('discount');
            $product->discount_until_date = $request->input('discount_until_date');
            $product->content= $request->input('content');
            if($product->save()):
                $this->getUpdateMinPrice($product->id);                
                return back()->with('message', 'Producto actualizado correctamente')->with('typealert',"success"); 
               endif;
        endif;

    }

    public function postProductGalleryAdd($id, Request $request){

        $rules =[
            'file_image' => 'required|image|dimensions:min_width=500,min_height=500',
            
            
        ];

        $messages =[
            'file_image.required' => 'Seleccione una imagen',            
            'file_image.image' => 'Seleccione un archivo PNG,JPG',
            'file_image.dimensions' => 'La imagen tiene que ser mayor a 500x500',
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:
            
            if($request->hasFile('file_image')):                
                $g = new PGallery;
                $g -> product_id = $id;
                $g->file_name = $this->postFileUpload('file_image', $request, [[500,500,'500x500']]);
                if($g->save()):                    
                    return back()->with('message', 'Imagen añadida correctamente')->with('typealert',"success"); 
                   endif;
                
            endif;
        endif;

    }

    function getProductGalleryDelete($id, $gid){
        $g = PGallery::findOrFail($gid);
        $upload_path = Config::get('filesystems.disks.uploads.root');
        if($g->product_id != $id){
            return back()->with('message', 'Imagen no eliminada')->with('typealert',"danger"); 
        } else {
            if($g->delete()):
                return back()->with('message', 'Imagen eliminada correctamente')->with('typealert',"success"); 
            endif;
        }
    }

    public function postProductSearch(Request $request) {
        $rules =[
            'search' => 'required',
        ];

        $messages =[
            'search.required' => 'Campo de búsqueda vacío', 
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return redirect('admin/products/all')->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:
            switch($request->input('filter')){
                case '0':
                    $products = Product::with(['cat'])->where('name', 'LIKE', '%'.$request->input('search').'%')->where('status',$request->input('status'))->orderBy('id', 'asc')->paginate(10);
                    break;
                case '1':
                    $products = Product::with(['cat'])->where('code', $request->input('search'))->orderBy('id', 'asc')->paginate(10);
                    break;
            }

            $data = ['products' => $products];
            return view('admin.products.search', $data);
        endif;
    }

    public function getProductDelete($id){
        $p = Product::findOrFail($id);

        if($p->delete()):
           
            return back()->with('message', 'Producto eliminado correctamente')->with('typealert',"success"); 
        endif;
    }

    public function getProductRestore($id){
        $p = Product::onlyTrashed()->where('id',$id)->first();
        
        if($p->restore()):
           
            return back()->with('message', 'Producto se restauro correctamente')->with('typealert',"success"); 
        endif;
    }

    public function getProductInventory($id){
        $product = Product::findOrFail($id);
        $data = ['product' => $product];
        return view('admin.products.inventory', $data);
    }

    public function postProductInventory($id, Request $request){
        $rules =[
            'name' => 'required',
            'price' => 'required',
        ];

        $messages =[
            'name.required' => 'El nombre es requerido', 
            'price.required' => 'El precio es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:
            $inventory = new Inventory;
            $inventory->product_id = $id; 
            $inventory->name=e($request->input('name'));
            $inventory->quantity =$request->input('inventory');
            $inventory->price =$request->input('price');
            $inventory->limited =$request->input('limited');
            $inventory->minimum =$request->input('minimum');
            if($inventory->save()):
                $this->getUpdateMinPrice($inventory->product_id);
                return back()->with('message', 'Guardado con éxito')->with('typealert', 'success');
            endif;
        endif;        
    }

    public function getProductInventoryEdit($id){
        $inventory = Inventory::findOrFail($id);
        $data = ['inventory' => $inventory];
        return view('admin.products.inventory_edit', $data);
    }

    public function postProductInventoryEdit($id, Request $request){
        $rules =[
            'name' => 'required',
            'price' => 'required',
        ];

        $messages =[
            'name.required' => 'El nombre es requerido', 
            'price.required' => 'El precio es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:
            $inventory = Inventory::findOrFail($id);
            $inventory->name=e($request->input('name'));
            $inventory->quantity =$request->input('inventory');
            $inventory->price =$request->input('price');
            $inventory->limited =$request->input('limited');
            $inventory->minimum =$request->input('minimum');
            if($inventory->save()):
                $this->getUpdateMinPrice($inventory->product_id);
                return back()->with('message', 'Actualizado con éxito')->with('typealert', 'success');
            endif;
        endif;  
    }

    public function getProductInventoryDelete($id){
        $inventory=Inventory::findOrFail($id);
        if($inventory->delete()):
            $this->getUpdateMinPrice($inventory->product_id);
            return back()->with('message', 'Inventario Eliminado Correctamente')->with('typealert', 'success');
        endif;
    }

    public function postProductInventoryVariantAdd($id, Request $request){
        $rules =[
            'name' => 'required',
        ];

        $messages =[
            'name.required' => 'El nombre de la variante es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert',"danger")->withInput(); 
        else:
        $inventory = Inventory::findOrFail($id); 

        $variant = new Variant;
        $variant->product_id = $inventory->product_id;
        $variant->inventory_id = $id;
        $variant->name = e($request->input('name'));

        if($variant->save()):
            return back()->with('message', 'Guardado con éxito')->with('typealert', 'success');
        endif;
    endif;
    }

    public function getProductInventoryVariantDelete($id){
        $variant=Variant::findOrFail($id);
        if($variant->delete()):
            return back()->with('message', 'Variante eliminada correctamente')->with('typealert', 'success');
        endif;
    }

    public function getUpdateMinPrice($id){
        $product=Product::find($id);
        $price = $product->getPrice->min('price');
        $product->price =$price;
        $product->save();
    }

}
