@extends('master')
@section('title', 'Carrito de compra')
@section('content')
    <div class="cart mtop32">
        <div class="container">
            @if(count(collect($items))=="0")
            <div class="no_items shadow">
                <div class="inside">
                    <p><img src="{{ url('/static/imagenes/empty-cart.png')}}" alt=""></p>
                    <p><strong>{{Auth::user()->name}}</strong></p>
                    <p> Aun no tienes ningun pedido realizado, anímate a pedir algunos de nuestros exquisitos bocaditos</p>
                    <p>
                        <a href="{{url('/store')}}">Ir a la tienda</a>
                    </p>
                </div>
            </div>
            @else            
            <div class="items mtop32">                
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="header">
                                <h2 class="title"><i class="fa-solid fa-cart-flatbed"></i> Carrito de compras:</h2>
                            </div>
                            <div class="inside">
                                <table class="table align-middle table-hover">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td width="80"></td>
                                            <td><strong>Producto</strong></td>
                                            <td width="160"><strong>Cantidad</strong></td>
                                            <td width="120"><strong>Subtotal</strong></td>
                                        </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($items as $item)
                                            <tr>
                                                <td><a href="#" class="btn-delete btn-deleted"  data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" data-object="{{$item->id}}" data-action="delete" data-path="cart/item"><i class="fa-solid fa-trash-can"></i></a></td>                                                
                                                <td>
                                                    <a href="{{ getUrlFileFromUploads($item->getProduct->image)}}" data-fancybox="gallery" data-caption="{{ $item->getProduct->name}}">
                                                    <img src="{{ getUrlFileFromUploads($item->getProduct->image)}}" class="img-fluid rounded">                            
                                                    </a>
                                                </td>                                                                                      
                                                <td>
                                                    <a href="{{url('/product/'.$item->getProduct->id.'/'.$item->getProduct->slug)}}">{{$item->label_item}}                                                        
                                                        <div class="price_discount">
                                                            Precio: 
                                                        @if($item->discount_status == "1")
                                                            <strong><span class="price_initial">{{ number($item->price_initial)}}</span></strong> <i class="fa-solid fa-right-long"></i> 
                                                        @endif
                                                        <strong>
                                                            <span class="price_unit">{{ number($item->price_unit)}} 
                                                                @if($item->discount_status == "1")
                                                                    ({{$item->discount}}% de descuento)
                                                                @endif
                                                            </span>
                                                        </strong>
                                                        </div>                                                        
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="form_quantity">
                                                        {!! Form::open(['url' => 'cart/item/'.$item->id.'/update']) !!}
                                                        {!! Form::number('quantity', $item->quantity, ['min' => '1', 'class' => 'form-control'] ) !!}
                                                        <button type="submit"><i class="fa-regular fa-floppy-disk"></i></button>
                                                        {!! Form::close()!!}  
                                                    </div>                                                  
                                                </td>
                                                <td><strong>{{ number($item->total)}}</strong></td>
                                            </tr>
                                         @endforeach
                                    </tbody>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><strong>Subtotal:</strong></td>
                                        <td><strong>{{ number($order->getSubtotal())}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><strong>Precio de envió:</strong></td>
                                        <td><strong>{{ number($shipping)}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><strong>Total de la orden:</strong></td>
                                        <td><strong>{{ number($order->total)}}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mtop16">
                            <div class="col-md-6">
                                <div class="panel">
                                    <div class="header">
                                        <h2 class="title"><i class="fa-solid fa-building-columns"></i> Transferencia / Depósito:</h2>
                                    </div>
                                    <div class="inside">
                                        Para depósitos o trasferencias bancarias o electrónicas, puede enviar el pago correspondiente a las siguientes cuentas:
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-md-3">
                        {!! Form::open(['url' => '/cart']) !!}
                        {!! Form::hidden('payment_method', null, ['id' => 'field_payment_method_id']) !!}
                            <div class="panel">
                                <div class="header">
                                    <h2 class="title"><i class="fa-solid fa-map-location-dot"></i> Tipo de orden:</h2>
                                </div>
                                <div class="inside">
                                    @if($order->o_type == "0")
                                        @if(!is_null(Auth::user()->getAddressDefault))
                                            <p style="margin-bottom: 2px";><strong>Departamento:</strong> {{Auth::user()->getAddressDefault->getState->name}}</p>
                                            <p style="margin-bottom: 2px";><strong>Ciudad:</strong> {{Auth::user()->getAddressDefault->getCity->name}}</p>
                                            <p style="margin-bottom: 2px";><strong>Dirección:</strong> {{kvfj(Auth::user()->getAddressDefault->addr_info, 'add1')}}. {{kvfj(Auth::user()->getAddressDefault->addr_info, 'add2')}}, #{{kvfj(Auth::user()->getAddressDefault->addr_info, 'add3')}} </p>
                                            <p style="margin-bottom: 2px";><strong>Referencia:</strong> {{kvfj(Auth::user()->getAddressDefault->addr_info, 'add4')}}</p>
                                            <p><a href="{{url('/account/address')}}" class="btn btn-dark mtop16">Cambiar dirección</a></p>
                                        @else
                                            <p>El usuario no tiene direcciones registradas.</p>
                                            <p><a href="{{url('/account/address')}}" class="btn btn-dark mtop16">Agregar dirección</a></p>
                                        @endif 
                                    @endif
                                    @if(Config('cms.to_go') == "1")
                                        <div class="mcswitch">
                                            <a href="{{ url('/cart/'.$order->id.'/type/0')}}" class="sl @if($order->o_type =="0") active @endif"><i class="fa-solid fa-motorcycle"></i> Enviar</a>                                        
                                            <a href="{{ url('/cart/'.$order->id.'/type/1')}}" class="sl @if($order->o_type =="1") active @endif"><i class="fa-solid fa-people-carry-box"></i> Recoger</a>
                                        </div> 
                                    @endif                              
                                </div>
                            </div>
                            <div class="panel mtop16">
                                <div class="header">
                                    <h2 class="title"><i class="fa-solid fa-credit-card"></i> Métodos de pago:</h2>
                                </div>
                                <div class="inside">
                                    <div class="payment_methods">
                                        @if(Config('cms.payment_method_cash') == "1")                                    
                                            <a href="#" class="btn-payment-method w-100" id="payment_method_cash" data-payment-method-id="0"><i class="fa-solid fa-sack-dollar"></i> Pago en efectivo</a>
                                        @endif
                                        @if(Config('cms.payment_method_creditcard') == "1")
                                            <a href="#" class="btn-payment-method w-100" id="payment_method_creditcard" data-payment-method-id="1"><i class="fa-brands fa-cc-visa"></i> Tarjeta débito / crédito</a>
                                        @endif
                                        @if(Config('cms.payment_method_transfer') == "1")
                                            <a href="#" class="btn-payment-method w-100" id="payment_method_transfer" data-payment-method-id="2"><i class="fa-solid fa-building-columns"></i> Trasferencia bancaria</a>
                                        @endif
                                        @if(Config('cms.payment_method_paypal') == "1")
                                            <a href="#" class="btn-payment-method w-100" id="payment_method_paypal" data-payment-method-id="3"><i class="fa-brands fa-paypal"></i> Paypal</a>
                                        @endif
                                        @if(Config('cms.payment_method_yape') == "1")
                                            <a href="#" class="btn-payment-method w-100" id="payment_method_yape" data-payment-method-id="4"><i class="fa-brands fa-yahoo"></i> Yape</a>                                    
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="panel mtop16">
                                <div class="header">
                                    <h2 class="title"><i class="fa-solid fa-envelopes-bulk"></i> Más:</h2>
                                </div>
                                <div class="inside">
                                    <label for="order_msg">Enviar comentario:</label>
                                    {!! Form::textarea('order_msg', null, ['class' => 'form-control mtop16', 'rows' => 3]) !!}
                                </div>
                            </div>
                            @if(!is_null(Auth::user()->getAddressDefault))
                                <div class="panel mtop16">                            
                                    <div class="inside">
                                        {!! Form::submit('Completar orden', ['class' => 'btn btn-success w-100 disabled', 'id' => 'pay_btn_complete']) !!}
                                    </div>
                                </div>
                            @endif
                        {!! Form::close() !!}
                    </div>                    
                </div>                
            </div>            
            @endif
        </div>
    </div>
@stop
