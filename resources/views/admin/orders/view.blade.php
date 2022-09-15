@extends('admin.master')
@section('title', 'Ordene # '.$order->o_number)

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url ('/admin/orders/all/all')}}"><i class="fa-solid fa-clipboard-list"></i> Órdenes</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/order/'.$order->id.'/view')}}"><i class="fa-solid fa-bag-shopping"></i> Orden # <strong>{{$order->o_number}}</strong></a>
</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="order">
        <div class="row">
            <!-- Columna 1 -->
            <div class="col-md-3">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-user-group"></i><strong> Usuario/Cliente:</strong></h2>
                    </div>                
                    <div class="inside">
                        <div class="profile">
                            <div class="photo">
                                @if(is_null($order->getUser->avatar))
                                    <img src="{{ url('/static/imagenes/avatar.jpg')}}" class="img-fluid rounded-circle" alt="">
                                @else
                                    <img src="{{ url('/uploads_users/'.$order->getUser->id.'/av_'.$order->getUser->avatar)}}" class="img-fluid rounded-circle" alt="">
                                @endif
                            </div>
                            <div class="info mtop16">
                                <ul>
                                    <li class="mtop16"><i class="fa-regular fa-user"></i><strong> Nombre: </strong>{{$order->getUser->name. ' '.$order->getUser->lastname}}</li>
                                    <li class="mtop16"><i class="fa-regular fa-envelope"></i><strong> Email: </strong>{{$order->getUser->email}}</li>
                                    @if($order->getUser->phone)
                                    <li class="mtop16"><i class="fa-solid fa-phone-flip"></i><strong> Telefóno/Celular: </strong>{{$order->getUser->phone}}</li>
                                    @endif
                                </ul>
                                <a href="{{url('/admin/user/'.$order->user_id.'/view')}}" class="btn btn-success btn-sm mtop16"><i class="fa-solid fa-user-gear"></i> Ver usuario</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel shadow mtop16">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-bell-concierge"></i><strong> 
                            Tipo de Orden:</strong></h2>
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
            </div>
            <!-- Columna 2 -->
            <div class="col-md-6">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-clipboard-list"></i><strong> Detalle de la Orden:</strong></h2>
                    </div>     
                    <div class="inside">                                                                     
                        <table class="table table-striped align-middle table-hover">
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
                        @if(kvfj(Auth::user()->permissions, 'order_change_status'))                        
                            <div class="order_status mtop16">
                                {!! Form::Open(['url' => '/admin/order/'.$order->id.'/view']) !!}                                
                                    <div class="row mtop16">
                                        <div class="col-md-12">
                                            <strong><i class="fa-solid fa-spinner"></i>  Estado actual de la orden:</strong>
                                        </div>
                                    </div>
                                    <div class="row mtop16">
                                        <div class="col-md-8">
                                            @if($order->o_type == "0")
                                                @if($order->status == '6' || $order->status == '100')
                                                    {!! Form::select('status', Arr::except(getOrderStatus(), ['0', '5']), $order->status, ['class' => 'form-select', 'disabled']) !!}
                                                @else
                                                    {!! Form::select('status', Arr::except(getOrderStatus(), ['0', '5']), $order->status, ['class' => 'form-select']) !!}
                                                @endif                                                 
                                            @else
                                                @if($order->status == '6' || $order->status == '100')
                                                    {!! Form::select('status', Arr::except(getOrderStatus(), ['0', '4']), $order->status, ['class' => 'form-select', 'disabled']) !!}
                                                @else
                                                    {!! Form::select('status', Arr::except(getOrderStatus(), ['0', '4']), $order->status, ['class' => 'form-select']) !!}
                                                @endif                                            
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            @if($order->status == '6' || $order->status == '100')
                                                {!! Form::submit('Actualizar', ['class' => 'btn btn-success w-100', 'disabled']) !!}
                                            @else
                                                {!! Form::submit('Actualizar', ['class' => 'btn btn-success w-100']) !!}
                                            @endif                                                
                                        </div>
                                    </div>
                                {!! Form::Close() !!}   
                            </div>
                        @endif
                    </div>           
                </div>
            </div>
            <!-- Columna 3 -->
            <div class="col-md-3">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-credit-card"></i><strong> Métodos de pago: </strong></h2>
                    </div>
                    <div class="inside">
                        <div class="payment_methods">                                                                            
                            <a href="#" class="w-100 active" id="payment_method_cash" data-payment-method-id="0"><i class="fa-solid fa-sack-dollar"></i> {{getPaymentMethod($order->payment_method) }}</a>
                        </div>
                    </div>
                </div>
                <div class="panel shadow mtop16">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-calendar-check"></i><strong> Actividad de pago: </strong></h2>
                    </div>
                    <div class="inside">
                        <div class="profile">
                            <div class="info">
                                <ul>
                                    <li><i class="fa-regular fa-clock"></i><strong> Pedido: </strong> {{$order->request_at}}</li>
                                    <li><i class="fa-regular fa-credit-card"></i><strong> Pagada: </strong> {{$order->pait_at}}</li>
                                    <li><i class="fa-solid fa-arrows-rotate"></i><strong> Procesando: </strong> {{$order->process_at}}</li>
                                    @if($order->o_type == "0")                                    
                                        <li><i class="fa-solid fa-truck"></i><strong> Enviada: </strong> {{$order->send_at}}</li>
                                    @else
                                        <li><i class="fa-solid fa-check-to-slot"></i><strong> Lista: </strong> {{$order->send_at}}</li>
                                    @endif
                                    <li><i class="fa-solid fa-box-open"></i><strong> Entregada: </strong> {{$order->delivery_at}}</li>
                                    @if($order->reject_at)    
                                        <li style="color:red"><i class="fa-solid fa-triangle-exclamation"></i><strong> Rechazada: </strong> {{$order->reject_at}}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @if($order->user_comment)
                    <div class="panel shadow mtop16">
                        <div class="header">
                            <h2 class="title"><i class="fa-solid fa-envelopes-bulk"></i><strong>  Más: </strong></h2>
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
@endsection