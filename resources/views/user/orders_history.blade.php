@extends('master')
@section('title', 'Historial de compras')

@section('content')
<div class="row mtop32">
    <div class="col-md-12">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fa-solid fa-clock-rotate-left"></i> Historial de Compras</h2>
            </div>
            <div class="inside">
                <div class="edit_avatar">
                    <table class="table align-middle table-hover">
                        <thead>
                            <tr>
                                <td><strong><i class="fa-solid fa-arrow-down-1-9"></i></strong></td>
                                <td><strong>Estado</strong></td>
                                <td><strong>Tipo</strong></td>
                                <td><strong>Método de pago</strong></td>
                                <td><strong>Total pagado</strong></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->getOrders as $order)
                            <tr>
                                <td><strong>{{$order->o_number}}</strong></td>
                                <td>{{getOrderStatus($order->status)}}</td>
                                <td>{{getOrderType($order->o_type)}}</td>
                                <td>{{getPaymentMethod($order->payment_method)}}</td>
                                <td><strong>{{number($order->total)}}</strong></td>
                                <td width="240">
                                    <a href="{{ url('account/history/order/'.$order->id)}}" class="btn btn-primary btn-sm w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Detalles" class="inventory"><i class="fa-solid fa-clipboard-list"></i> Ver Compra</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>           
            </div>
        </div>
    </div>
</div>
@endsection