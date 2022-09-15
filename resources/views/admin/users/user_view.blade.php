@extends('admin.master')

@section('title', 'Usuarios')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/users/all')}}"><i class="fa-solid fa-user"></i> Usuarios</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/user/'.$u->id.'/edit')}}"><i class="fa-solid fa-user-pen"></i> Editar Usuario: {{ $u->name}} {{ $u->lastname}}</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page_user">
        <div class="row">
        <div class="col-md-4">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-circle-info"></i> Información</h2>
                </div>
                <div class="inside">
                    <div class="mini_profile">
                    @if(is_null($u->avatar))
                    <img src="{{ url('/static/imagenes/avatar.jpg')}}" class="avatar" alt="">
                    @else
                    <img src="{{ getUrlFileFromUploads($u->avatar,'256x256')}}" class="avatar" alt="">
                    @endif
                    <div class="info">
                        <span class="title"><i class="fa-solid fa-id-card"></i> Nombre:</span>
                        <span class="text">{{ $u->name }} {{ $u->lastname }}</span>
                        <span class="title"><i class="fa-solid fa-user-lock"></i> Estado del usuario:</span>
                        <span class="text">{{ getUserStatusArray(null,$u->status) }}</span>
                        <span class="title"><i class="fa-solid fa-envelope-circle-check"></i> Correo electrónico:</span>
                        <span class="text">{{ $u->email }}</span>
                        <span class="title"><i class="fa-solid fa-calendar-check"></i> Fecha de registro:</span>
                        <span class="text">{{ $u->created_at }}</span>
                        <span class="title"><i class="fa-solid fa-arrows-down-to-people"></i> Rol de usuario:</span>
                        <span class="text">{{ getRoleUserArray(null,$u->role) }}</span>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
                    </div>
                    @if(kvfj(Auth::user()->permissions, 'user_banned'))
                    @if($u->status == "100")
                    <a href="{{ url('admin/user/'.$u->id.'/banned') }}" class="btn btn-success">Activar Usuario</a>
                    @else
                    <a href="{{ url('admin/user/'.$u->id.'/banned') }}" class="btn btn-danger">Suspender Usuario</a>
                    @endif 
                    @endif                   
                </div>
                </div>
            </div>
        </div>
            <div class="col-md-8">
                @if(kvfj(Auth::user()->permissions, 'order_view'))
                    <div class="panel shadow">
                        <div class="header">
                            <h2 class="title"><i class="fa-solid fa-clipboard-list"></i> <strong> Historial de Compras</strong></h2>
                        </div>
                        <div class="inside">
                            <table class="table align-middle table-hover mtop16">
                                <thead>
                                    <tr>
                                        <td><strong><i class="fa-solid fa-arrow-down-9-1"></i></strong></td>
                                        <td><strong>Estado</strong></td>
                                        <td><strong>Tipo</strong></td>
                                        <td><strong>Fecha</strong></td>
                                        <td><strong>Total</strong></td>
                                        <td><strong></strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($u->getOrders as $order)
                                    <tr>
                                        <td><strong>{{$order->o_number}}</strong></td>
                                        <td>{{ getOrderStatus($order->status)}}</td>
                                        <td>{{getOrderType($order->o_type)}}</td>
                                        <td>{{$order->request_at}}</td>
                                        <td><strong>{{number($order->total)}}</strong></td>
                                        <td><div class="opts">                                    
                                                <a href="{{ url('/admin/order/'.$order->id.'/view')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver orden" class="btn-sm permissions" ><i class="fa-solid fa-eye"></i></a>
                                            </div>
                                        </td>                                         
                                    </tr>
                                    @endforeach                                
                                </tbody>
                            </table>
                        </div>                    
                    </div>
                @endif
                @if(kvfj(Auth::user()->permissions, 'user_edit'))
                    <div class="panel shadow mtop16">
                        <div class="header">
                            <h2 class="title"><i class="fa-solid fa-user-pen"></i> <strong> Información del usuario</strong></h2>
                        </div>
                        <div class="inside">                       
                            {!! Form::open(['url' => '/admin/user/'.$u->id.'/edit']) !!}
                            <div class="row">
                                <div class="col-md-6">                                 
                                        <label for="module" class="space">Rol de Usuario:</label>
                                        <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            @if($u->role=="1")
                                            <i class="fa-solid fa-user-graduate"></i>
                                            @else
                                            <i class="fa-solid fa-user-tag"></i>
                                            @endif
                                            </span>
                                        {!! Form::select('user_type', getRoleUserArray('list', null), $u->role , ['class'=>'form-select']) !!}
                                    </div>          
                                        
                                </div>
                            </div>
                            <div class="row mtop16">
                                <div class="col-md-12">
                                    {!! Form::submit('Guardar',['class' => 'btn btn-success']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}                        
                        </div>                    
                    </div> 
                @endif               
            </div>
        </div>
    </div>
</div>
@endsection