@extends('admin.master')
@section('title', 'Módulo cobertura')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/coverage')}}"><i class="fa-solid fa-truck-fast"></i> Cobertura de envió</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/coverage/'.$coverage->state_id.'/cities')}}"><i class="fa-solid fa-arrow-right-to-city"></i> Cuidades de: {{$coverage->getState->name}}</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/coverage/city/'.$coverage->id.'/edit')}}"><i class="fa-solid fa-pen-to-square"></i> Editar {{ getCoverageType($coverage->ctype)}} de: {{$coverage->name}} </a>
</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        @if(kvfj(Auth::user()->permissions, 'coverage_edit'))  
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-pen-clip"></i> Editar cuidad de envió</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url'=> '/admin/coverage/city/'.$coverage->id.'/edit']) !!}
                                     
                        <label for="name" class="space">Nombre de la cobertura:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                            {!! Form::text('name', $coverage->name, ['class' => 'form-control', 'placeholder' => 'Nombre de la cobertura', 'required']) !!}
                        </div>
                        <label for="shipping_value" class="space">Valor de envió:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><strong>{{Config('cms.currency')}}</strong></span>
                            {!! Form::number('shipping_value', $coverage->price, ['class' => 'form-control', 'min' => '0', 'step' => 'any', 'required']) !!}
                        </div>                                         
                        <label for="days" class="space">Días estimados de entrega:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-calendar-days"></i></span>
                            {!! Form::number('days', $coverage->days,['class'=>'form-control', 'min'=> 0, 'step'=>'any']) !!}                            
                        </div>
                        <label for="status" class="space">Estado de cobertura:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-power-off"></i></span>
                            {!! Form::select('status', getCoverageStatus(), $coverage->status, ['class' => 'form-select']) !!}                            
                        </div>                            
                        {!! Form::submit('Actualizar', ['class' => 'btn btn-success mtop16']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>     
        @endif
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-info"></i> Informacion general:</h2>
                </div>
                <div class="inside">
                    @if ($coverage->ctype == "1")
                    <p><strong>Tipo: </strong>{{getCoverageType($coverage->ctype)}}</p>
                    <p><strong>Nombre:</strong> {{$coverage->name}}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection