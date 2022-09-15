@extends('master')
@section('title', 'Editar Perfil')

@section('content')
<div class="row mtop32">    
    <div class="col-md-4">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fa-solid fa-location-dot"></i> Agregar dirección de entrega:</h2>
            </div>
            <div class="inside">
                {!! Form::open(['url' => '/account/address/add']) !!}
                <label for="name" class="space">Nombre:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-id-card-clip"></i></span>
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de dirección', 'required']) !!}
                </div>
                <label for="state" class="space mtop16">Departamento:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-map-location-dot"></i></span>
                    {!! Form::select('state', $states , null, ['class'=>'form-select', 'id' => 'state']) !!}  
                </div>
                <label for="city" class="space mtop16">Ciudad:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-building-flag"></i></span>
                    {!! Form::select('city', [] , null, ['class'=>'form-select', 'id' => 'address_city', 'required' ]) !!}  
                </div> 
                <label for="add1" class="space mtop16">Tipo:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-text-height"></i></span>
                {!! Form::select('add1', getAddress(), 0, ['class' => 'form-select']) !!}
                </div>
                <label for="add2" class="space mtop16">Dirección:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-bed"></i></span>
                {!! Form::text('add2', null, ['class' => 'form-control', 'placeholder' => 'Dirección']) !!}
                </div>
                <label for="add3" class="space mtop16">Número / Lote:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-house-crack"></i></span>
                {!! Form::text('add3', null,['class' => 'form-control', 'placeholder' => 'Número / Lote']) !!}
                </div>
                
                <label for="add4" class="space mtop16">Referencia:</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-car-rear"></i></span>
                {!! Form::text('add4', null, ['class' => 'form-control', 'placeholder' => 'Referencia']) !!}
                </div>
                <div class="row mtop16">
                    <div class="col-md-12">
                        {!! Form::submit('Guardar',['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}               
            </div>                
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fa-solid fa-map-location-dot"></i> Mis direcciones de entrega:</h2>
            </div>
            <div class="inside">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <td><strong>Nombre:</strong></td>
                            <td><strong>Departamento/ciudad:</strong></td>
                            <td><strong>Dirección:</strong></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(Auth::user()->getAddress as $address)
                        <tr>
                            <td>{{$address->name}} 
                                @if($address->default == "0")
                                <p><small><a href="{{ url('account/address/'.$address->id.'/setdefault')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Convertir en principal">Convertir en principal</a></small></p>
                                @else
                                <p><small><strong>Dirección de entrega principal</strong></small></p>
                                @endif
                            </td>
                            <td>{{$address->getState->name}} <i class="fa-solid fa-right-long"></i> {{$address->getCity->name}}</td>
                            <td>{{kvfj($address->addr_info, 'add1')}}. {{kvfj($address->addr_info, 'add2')}}, #{{kvfj($address->addr_info, 'add3')}}</td>
                            <td>
                                @if($address->default == "0")
                                <a href="#" class="btn-delete btn-deleted" data-object="{{$address->id}}" data-action="delete" data-path="account/address" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"><i class="fa-solid fa-trash-can"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

