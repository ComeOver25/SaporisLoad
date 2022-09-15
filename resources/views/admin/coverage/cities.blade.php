@extends('admin.master')
@section('title', 'Módulo cobertura')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/coverage')}}"><i class="fa-solid fa-truck-fast"></i> Cobertura de envió</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/coverage/'.$state->id.'/cities')}}"><i class="fa-solid fa-arrow-right-to-city"></i> Cuidades de: {{$state->name}}</a>
</li>

@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        @if(kvfj(Auth::user()->permissions, 'coverage_add'))  
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-arrow-right-to-city"></i> Agregar cuidad de envió</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url'=> '/admin/coverage/city/add/']) !!}
                    {!! Form::hidden('state_id', $id)!!}                   
                        <label for="name" class="space">Nombre de la cobertura:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la cobertura', 'required']) !!}
                        </div>
                        <label for="shipping_value" class="space">Valor de envió:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><strong>{{Config('cms.currency')}}</strong></span>
                            {!! Form::number('shipping_value', Config::get('cms.shipping_default_value'), ['class' => 'form-control', 'min' => '0', 'step' => 'any', 'required']) !!}
                        </div>                                         
                        <label for="days" class="space">Días estimados de entrega:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-calendar-days"></i></span>
                            {!! Form::number('days', 0,['class'=>'form-control', 'min'=> 0, 'step'=>'any']) !!}                            
                        </div>                           
                        {!! Form::submit('Agregar', ['class' => 'btn btn-success mtop16']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>     
        @endif        
        <div class="col-md-9">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-list-check"></i> Listado de ciudades de envios</h2>
                </div>
                <div class="inside">
                    <table class="table table-striped mtop16 align-middle">
                        <thead>
                            <tr>
                                <td ><strong>Estado:</strong></td>
                                <td ><strong>Ciudades:</strong></td>
                                <td><strong>Precio de envió:</strong></td>
                                <td><strong>Entrega estimada:</strong></td>
                                <td>Opciones:</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cities as $city)
                                <tr>
                                    <td><strong>{{ getCoverageStatus($city->status)}}</strong></td>
                                    <td>{{ $city->name}}</td>                                                                                
                                    <td>{{Config('cms.currency')}} {{ $city->price}}</td>
                                    <td>{{ $city->days}} días</td>
                                    <td><div class="opts">
                                        @if(kvfj(Auth::user()->permissions, 'coverage_edit'))
                                        <a href="{{'/admin/coverage/city/'.$city->id.'/edit'}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>                                       
                                        @endif
                                        @if(kvfj(Auth::user()->permissions, 'coverage_delete'))                                        
                                        <a href="#" data-path="admin/coverage" data-action="delete" data-object="{{ $city->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" class="btn-deleted delete"><i class="fa-solid fa-trash-can" ></i></a>
                                        @endif
                                    </div>
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