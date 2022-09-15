@extends('master')
@section('title', 'Orden #'.$order->o_number)

@section('content')
    <div class="cart mtop32">
        <div class="container">
            <div class="items mtop32">                
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="header">
                                <h2 class="title"><i class="fa-solid fa-paste"></i> Detalles de la orden #{{$order->o_number}}</h2>
                            </div>
                            <div class="inside">
                                <table class="table align-middle table-hover">
                                    <thead>
                                        <tr>
                                            <td width="80"></td>
                                            <td><strong>Producto</strong></td>
                                            <td width="160"><strong>Cantidad</strong></td>
                                            <td width="120"><strong>Subtotal</strong></td>
                                        </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($order->getItems as $item)
                                            <tr>
                                                <td>
                                                    <a href="{{ url ('uploads/'.$item->getProduct->file_path.'/'.$item->getProduct->image)}}" data-fancybox="gallery" data-caption="{{ $item->getProduct->name}}">
                                                    <img src="{{url ('uploads/'.$item->getProduct->file_path.'/t_'.$item->getProduct->image)}}" class="img-fluid rounded">                            
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
                                                <td><strong>{{$item->quantity}}</strong></td>
                                                <td><strong>{{ number($item->total)}}</strong></td>
                                            </tr>
                                         @endforeach
                                    </tbody>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><strong>Subtotal:</strong></td>
                                        <td><strong>{{ number($order->getSubtotal())}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><strong>Precio de envió:</strong></td>
                                        <td><strong>{{ number($order->delivery)}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><strong>Total de la orden:</strong></td>
                                        <td><strong>{{ number($order->total)}}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-md-3">
                            <div class="panel">
                                <div class="header">
                                    <h2 class="title"><i class="fa-solid fa-map-location-dot"></i> Tipo de orden:</h2>
                                </div>
                                <div class="inside">
                                    @if($order->o_type == "0")                                        
                                        <p style="margin-bottom: 2px";><strong>Departamento:</strong> {{$order->getUserAddress->getState->name}}</p>
                                        <p style="margin-bottom: 2px";><strong>Ciudad:</strong> {{$order->getUserAddress->getCity->name}}</p>
                                        <p style="margin-bottom: 2px";><strong>Dirección:</strong> {{kvfj($order->getUserAddress->addr_info, 'add1')}}. {{kvfj($order->getUserAddress->addr_info, 'add2')}}, #{{kvfj($order->getUserAddress->addr_info, 'add3')}} </p>
                                        <p style="margin-bottom: 2px";><strong>Referencia:</strong> {{kvfj($order->getUserAddress->addr_info, 'add4')}}</p>                                           
                                    @endif                                    
                                        <div class="mcswitch">
                                            <a href="#" class="sl @if($order->o_type =="0") active @endif"><i class="fa-solid fa-motorcycle"></i> Enviar</a>                                        
                                            <a href="#" class="sl @if($order->o_type =="1") active @endif"><i class="fa-solid fa-people-carry-box"></i> Recoger</a>
                                        </div>                                                                  
                                </div>
                            </div>
                            <div class="panel mtop16">
                                <div class="header">
                                    <h2 class="title"><i class="fa-solid fa-credit-card"></i> Métodos de pago:</h2>
                                </div>
                                <div class="inside">
                                    <div class="payment_methods">                                                                            
                                        <a href="#" class="w-100 active" id="payment_method_cash" data-payment-method-id="0"><i class="fa-solid fa-sack-dollar"></i> {{getPaymentMethod($order->payment_method) }}</a>
                                    </div>
                                </div>
                            </div>
                            @if($order->user_comment)
                                <div class="panel mtop16">
                                    <div class="header">
                                        <h2 class="title"><i class="fa-solid fa-envelopes-bulk"></i> Más:</h2>
                                    </div>
                                    <div class="inside">
                                        <label for="order_msg"><strong>Comentario:</strong></label>
                                        
                                        <p class="mtop16">{!! $order->user_comment !!}</p>
                                    </div>
                                </div>
                            @endif
                    </div>                    
                </div>                
            </div> 
        </div>
    </div>
@endsection