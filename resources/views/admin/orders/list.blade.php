@extends('admin.master')
@section('title', 'Módulo Ordenes')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url ('/admin/orders/all/all')}}"><i class="fa-solid fa-clipboard-list"></i> Órdenes</a>
</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-filter"></i><strong> Filtrar por estado:</strong></h2>
                </div>                
                <div class="list-group ms-2 me-auto">
                    <a href="{{ url('admin/orders/all/'.$type)}}" class="list-group-item list-group-item-action @if($status == "all") active @endif" aria-current="true"><i class="fa-solid fa-caret-right"></i> Todas <span class="float-end badge bg-primary rounded-pill">{{$all_orders->count()}}</span></a>
                    @foreach(Arr::except(getOrderStatus(), ['0']) as $key => $value)
                    <a href="{{ url('admin/orders/'.$key.'/'.$type)}}" class="list-group-item list-group-item-action @if($status == $key) active @endif" aria-current="true"><i class="fa-solid fa-caret-right"></i> {{ $value}} <span class="float-end badge bg-primary rounded-pill">{{$all_orders->where('status', $key)->count()}}</span></a>
                    @endforeach                 
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-clipboard-list"></i><strong> Órdenes:</strong></h2>
                </div>     
                <div class="inside">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link @if($type == "all") active @endif"  aria-current="page" href="{{ url('/admin/orders/'.$status.'/all')}}"> Todas</a>
                        </li>
                        @foreach(getOrderType() as $key => $value)
                        <li class="nav-item">
                            <a class="nav-link @if($type == $key) active @endif"  aria-current="page" href="{{ url('/admin/orders/'.$status.'/'.$key)}}">{{ $value}}</a>
                        </li>
                        @endforeach
                    </ul>
                    <table class="table align-middle table-hover mtop16">
                        <thead>
                            <tr>
                                <td><strong><i class="fa-solid fa-arrow-down-9-1"></i></strong></td>
                                <td><strong>Usuario</strong></td>
                                <td><strong>Tipo</strong></td>
                                <td><strong>Fecha</strong></td>
                                <td><strong>Total</strong></td>
                                <td><strong></strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td><strong>{{$order->o_number}}</strong></td>
                                <td>{{$order->getUser->name}} @if($order->getUser->lastname) {{$order->getUser->lastname}} @endif</td>
                                <td>{{getOrderType($order->o_type)}}</td>
                                <td>{{$order->request_at}}</td>
                                <td><strong>{{number($order->total)}}</strong></td>                                
                                <td><div class="opts">                                    
                                        <a href="{{ url('/admin/order/'.$order->id.'/view')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver orden" class="btn-sm permissions" ><i class="fa-solid fa-eye"></i></a>
                                    </div>
                                </td>   
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6">{!! $orders->render() !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>           
            </div>
        </div>
    </div>
</div>
@endsection