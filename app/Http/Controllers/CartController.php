<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Order;
use App\Http\Models\OrderItem;
use App\Http\Models\Product;
use App\Http\Models\Inventory;
use App\Http\Models\Variant;
use App\Http\Models\Coverage;
use Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCart(){
        $order = $this->getUserOrder();
        $items = $order->getItems;
        $shipping = $this->getShippingValue($order->id);        
        $order = Order::find($order->id);       
        $data = ['order' => $order, 'items' => $items, 'shipping' => $shipping];
        return view('cart', $data);
    }

    public function getOrderChangeType(Order $order, $type ){
        if($order->user_id != Auth::id()):
            return redirect('/');
        endif; 
        if($order->status == "0"):            
            $order->o_type = $type;
            if($type == "1"):
                $order->user_address_id = null;
                $order->delivery == '0.00';
            endif;
            if($order->save()):
                return back();
            endif;
        else:
            return redirect('/');
        endif;
    }

    public function postCart(Request $request){
        $order = $this->getUserOrder();
        $order = Order::find($order->id);
        if($request->input('payment_method') == "0"):
            $this->getProcessOrder($order->id);                   
        endif;
        $order->payment_method = $request->input('payment_method');
        $order->user_comment = $request->input('order_msg');
        if($order->save()):
            $order = Order::find($order->id);
            if($order->payment_method == "0" && $order->status == "1"):              
                $this->getOrderEmailDetails($order->id);
                return redirect('account/history/order/'.$order->id);
            else:
                return redirect('/cart/payment');
            endif;
        endif;
    }   

    public function getUserOrder(){
        $order = Order::where('status', '0')->where('user_id', Auth::id())->count();
        if($order == "0"):
            $order = new Order;
            $order->user_id = Auth::id();
            $order->save();
        else:
            $order = Order::where('status', '0')->where('user_id', Auth::id())->first();
        endif;
        return $order;
    }

    public function getShippingValue($order_id){
        $order = Order::find($order_id);
        if($order->o_type == "0" ||  Config('cms.to_go') == "0"):
            $shipping_method = Config('cms.shipping_method');
            if($shipping_method == "0"):
                $price = '0.00';
            endif;
            if($shipping_method == "1"):
                $price = Config('cms.shipping_default_value');
            endif;
            if($shipping_method == "2"):
                $user_address_count = Auth::user()->getAddress()->count();
                if($user_address_count == "0"):
                    $price = Config('cms.shipping_default_value');
                else:
                    $user_address = Auth::user()->getAddressDefault->city_id;
                    $coverage = Coverage::find($user_address);
                    $price = $coverage->price;
                endif;
            endif;
            if($shipping_method == "3"):
                if($order->getSubTotal() >= Config('cms.shipping_amount_min')):
                    $price = '0.00';
                else:
                    $price = Config('cms.shipping_default_value');
                endif;
            endif;
            if(!is_null(Auth::user()->getAddressDefault)):
                $order->user_address_id = Auth::user()->getAddressDefault->id;
            endif;
            $order->o_type = '0';
            $order->subtotal = $order->getSubTotal();
            $order->delivery = $price;
            $order->total = $order->getSubTotal()+$price;            
            $order->save();
        else:
            $price = '0.00';
            $order->total = $order->getSubTotal();
            $order->save();
        endif;
        return $price;
    }

    public function postCartAdd(Request $request, $id){        
        if(is_null($request->input('inventory'))):
            return back()->with('message', 'Selecione una opción del producto a comprar')->with('typealert', 'danger');
        else:
            $inventory = Inventory::where('id', $request->input('inventory'))->count();
            if($inventory == "0"):
                return back()->with('message', 'El producto ingresado no se encontró')->with('typealert', 'danger');
            else:
                $inventory = Inventory::find($request->input('inventory'));            
                if($inventory->product_id != $id):
                    return back()->with('message', 'El producto seleccionado no se puede añadir al carrito')->with('typealert', 'danger');
                else:            
                    $order = $this->getUserOrder();
                    $product = Product::find($id);                                       
                    if($request->input('quantity') < 1):
                        return back()->with('message', 'Ingrese una cantidad valida')->with('typealert', 'danger');
                    else:
                        if($inventory->limited== "0"):
                            if($request->input('quantity') > $inventory->quantity):
                                return back()->with('message', 'La cantidad seleccionada supera el stock actual del producto')->with('typealert', 'danger');
                            endif;
                        endif;
                        if(count(collect($inventory->getVariants)) > "0"):
                            if(is_null($request->input('variant'))):                                
                                return back()->with('message', 'Seleccione todas las opciones del producto')->with('typealert', 'danger');
                            endif; 
                        endif;      
                        if(!is_null($request->input('variant'))):
                            $variant = Variant::where('id', $request->input('variant'))->count();
                            if($variant == "0"):
                                return back()->with('message', 'Selección no encontrada')->with('typealert', 'danger');
                            else:
                                $variant = Variant::find($request->input('variant'));
                                if($variant->inventory_id != $inventory->id):
                                    return back()->with('message', 'Selección no valida')->with('typealert', 'danger');
                                endif;
                            endif;
                        endif; 
                        $query = OrderItem::where('order_id', $order->id)->where('product_id', $product->id)->count();
                        if($query==0):                                   
                            $oitem = new OrderItem;
                            $price = $this->getCalculatePrice($product->in_discount, $product->discount, $inventory->price);
                            $total = $price * $request->input('quantity');
                            if($request->input('variant')):
                                $variant = Variant::find($request->input('variant'));
                                $variant_label = ' / '.$variant->name;
                            else:
                                $variant_label = '';
                            endif;
                            $label = $product->name.' / '.$inventory->name.$variant_label;
                            $oitem->user_id = Auth::id();
                            $oitem->order_id = $order->id;
                            $oitem->product_id = $id;
                            $oitem->inventory_id = $request->input('inventory');
                            $oitem->variant_id = $request->input('variant');
                            $oitem->label_item = $label;
                            $oitem->quantity = $request->input('quantity');
                            $oitem->discount_status = $product->in_discount;
                            $oitem->discount = $product->discount;
                            $oitem->discount_until_date = $product->discount_until_date;
                            $oitem->price_initial = $inventory->price;
                            $oitem->price_unit = $price;
                            $oitem->total = $total;
                            if($oitem->save()):                
                                return back()->with('message', 'Producto agregado al carrito')->with('typealert', 'success');                
                            endif;
                        else:
                            return back()->with('message', 'Este producto, ya esta en su carrito de compra')->with('typealert', 'danger');
                        endif;
                    endif;
                endif;
            endif;
        endif;         
    }

    public function postCartItemQuantityUpdate($id, Request $request){
        $order = $this->getUserOrder();
        $oitem = OrderItem::find($id);
        $inventory = Inventory::find($oitem->inventory_id);
        //$product = Product::find($oitem->product_id);
        if($order->id != $oitem->order_id):
            return back()->with('message', 'No se puede actualizar la cantidad de este producto')->with('typealert',"danger"); 
        else:
            if($inventory->limited == "0"):
                if($request->input('quantity') > $inventory->quantity):
                    return back()->with('message', 'La cantidad ingresada supera al stock actual del producto')->with('typealert',"danger");
                endif;
            endif;
            $total = $oitem->price_unit * $request->input('quantity');
            $oitem->quantity = $request->input('quantity');
            $oitem->total = $total;
            if($oitem->save()):
                $this->getShippingValue($order->id);            
                return back()->with('message', 'Cantidad actualizada con éxito.')->with('typealert', 'success');                
            endif;
        endif;        
    }

    public function getCartItemDelete($id){
        $oitem = OrderItem::findOrFail($id);
        if($oitem->delete()):           
            return back()->with('message', 'Producto eliminado del carrito correctamente')->with('typealert',"success"); 
        endif;
    }

    public function getCalculatePrice($in_discount, $discount, $price){         
        $final_price = $price;
        if ($in_discount == "1"):
            $discount_value = $discount/100;
            $discount_calc = $price * $discount_value;
            $final_price = $price - $discount_calc;
        endif;
        return $final_price;
    }   
}
