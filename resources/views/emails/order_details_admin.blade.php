@extends('emails.master')
@section('title', 'Detalles de la Orden')

@section('content')
<p>Hola: <strong>{{$name}} </strong> </p>
<p> Orden N°: <strong> {{$order->o_number}} </strong></p>
<p>Para el Señor(a): <strong>{{ $order->getUser->name}} {{ $order->getUser->lastname}}</strong> </p>
@if(!is_null($order->getUser->phone))
<p>Telefóno de contacto: <strong>{{ $order->getUser->phone}}</strong> </p>
@endif
<p>Hemos recibida una nueva order con éxito, y el detalle de la compra es la siguiente:</p>
<table class="table align-middle table-hover">
    <thead>
        <tr>
            <td width="56"></td>
            <td><strong>Producto</strong></td>
            <td width="160"><strong>Cantidad</strong></td>
            <td width="120"><strong>Subtotal</strong></td>
        </tr>
        </thead>
    <tbody>
        @foreach($order->getItems as $item)
            <tr>
                <td style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 4px 0px;"><img src="{{ getUrlFileFromUploads($item->getProduct->image)}}" style="width: 50px; border-radius: 4px;"></td>                                                                                      
                <td style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 4px 0px;">
                    <a href="{{url('/product/'.$item->getProduct->id.'/'.$item->getProduct->slug)}}" style="color: #333; text-decoration: none;">{{$item->label_item}}                                                        
                        <div class="price_discount">
                            Precio: 
                        @if($item->discount_status == "1")
                            <small><strong><span class="price_initial"><small>{{number($item->price_initial)}}</small></span></strong></small> <i class="fa-solid fa-right-long"></i> 
                        @endif
                        <small>
                            <strong>
                                <span class="price_unit">{{ number($item->price_unit) }} 
                                    @if($item->discount_status == "1")
                                    ({{$item->discount}}% de descuento)
                                    @endif
                                </span>
                            </strong>
                        <small>
                        </div>                                                        
                    </a>
                </td>
                <td style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 4px 0px;">{{ $item->quantity}}</td>
                <td style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 4px 0px;"><strong>{{ number($item->total)}}</strong></td>
            </tr>
         @endforeach
    </tbody>
    <tr>
        <td colspan="2" style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 8px 0px;"></td>
        <td style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 8px 0px;"><strong>Subtotal:</strong></td>
        <td style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 8px 0px;"><strong>{{ number($order->getSubtotal())}}</strong></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 8px 0px;"></td>
        <td style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 8px 0px;"><strong>Precio de envió:</strong></td>
        <td style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 8px 0px;"><strong>{{ number($order->delivery)}}</strong></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 8px 0px;"></td>
        <td style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 8px 0px;"><strong>Total de la orden:</strong></td>
        <td style="vertical-align: top; border-bottom: 1px solid #f0f0f0; padding: 8px 0px;"><strong>{{ number($order->total)}}</strong></td>
    </tr>
</table>
@if(!is_null($order->user_address_id))
<p><strong>La orden deberá ser enviada a la siguiente dirección:</strong></p>
<p style="margin-bottom: 2px";><strong>Departamento:</strong> {{$order->getUserAddress->getState->name}}</p>
<p style="margin-bottom: 2px";><strong>Ciudad:</strong> {{$order->getUserAddress->getCity->name}}</p>
<p style="margin-bottom: 2px";><strong>Dirección:</strong> {{kvfj($order->getUserAddress->addr_info, 'add1')}}. {{kvfj(Auth::user()->getAddressDefault->addr_info, 'add2')}}, #{{kvfj(Auth::user()->getAddressDefault->addr_info, 'add3')}} </p>
<p style="margin-bottom: 2px";><strong>Referencia:</strong> {{kvfj($order->getUserAddress->addr_info, 'add4')}}</p>
@else
<p><strong>El comprador pasará a recoger su pedido, favor de ponerse en contacto con él:</strong></p>
@endif
<p><strong>Más detalles de la compra en: <a href="{{url('/admin/order/'.$order->id.'/view')}}"></a></strong></p>
<hr>

@if($order->payment_method == "0")
    <p>Ha seleccionado pagar en efectivo.</p>
@endif
@stop