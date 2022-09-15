@extends('admin.master')

@section('title', 'Módulo de Usuarios')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/users/all')}}"><i class="fa-solid fa-user"></i> Usuarios</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fa-solid fa-user"></i> Usuarios</h2>
        </div>
        <div class="inside">
            <div class="row">
                <div class="col-md-2 offset-md-10">
                    <div class="dropdown">
                        <button  style="width: 100%" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-filter"></i> Filtrar
                          </button> 
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{ url('/admin/users/all') }}"><i class="fa-solid fa-list"></i> Todos</a></li>                            
                            <li><a class="dropdown-item" href="{{ url('/admin/users/0') }}"><i class="fa-solid fa-user-xmark"></i> No verificados</a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin/users/1') }}"><i class="fa-solid fa-list-check"></i> Verificados</a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin/users/100') }}"><i class="fa-solid fa-user-slash"></i> Suspendidos</a></li>
                          </ul> 
                    </div>
                    
                        
                </div>
            </div>
            <table class="table align-middle table-hover">
                <thead>
                    <tr>
                        <th>ID:</th>
                        <th>Avatar:</th>
                        <th>Nombre:</th>
                        <th>Apellido:</th>
                        <th>Correo electrónico:</th>
                        <th>Rol:</th>
                        <th>Estado:</th>                        
                        <th>Acciones</th>
                    </tr>
                </thead>
            
            <tbody>
                @foreach($users as $user)
                @if($user->status=='100')
                    <tr class="table-warning">
                @else
                <tr>
                    @endif                    
                    <th>{{$user->id}}</th>
                    <td width="40">
                        @if(is_null($user->avatar))
                        <img src="{{ url('/static/imagenes/avatar.jpg')}}" class="img-fluid rounded-circle" alt="">
                        @else
                        <img src="{{ getUrlFileFromUploads($user->avatar,'256x256')}}" class="img-fluid rounded-circle" alt="">
                        @endif</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->lastname}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{getRoleUserArray(null, $user->role)}}</td>  
                    <td>{{getUserStatusArray(null, $user->status)}}</td>                    
                    <td><div class="opts">
                        @if(kvfj(Auth::user()->permissions, 'user_view'))
                        <a href="{{'/admin/user/'.$user->id.'/view'}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver perfil" class="edit"><i class="fa-solid fa-id-card-clip"></i></a>
                        @endif
                        @if(kvfj(Auth::user()->permissions, 'user_permissions'))
                        <a href="{{'/admin/user/'.$user->id.'/permissions'}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Permisos de usuario" class="permissions"><i class="fa-solid fa-person-chalkboard"></i></a>
                        @endif
                    </div>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="8">{!! $users->render() !!}</td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection