@extends('admin.master')

@section('title', 'Inventario de Producto')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url ('/admin/products/all')}}"><i class="fa-solid fa-plate-wheat"></i> Productos</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/'.$inventory->getProduct->id.'/edit')}}"><i class="fa-solid fa-pen"></i> {{ $inventory->getProduct->name}}</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/'.$inventory->getProduct->id.'/inventory')}}"><i class="fa-solid fa-boxes-stacked"></i> Inventario:</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/inventory/'.$inventory->id.'/edit')}}"><i class="fa-solid fa-box-open"></i> {{ $inventory->name}}</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- columna N.1 -->
        <div class="col-md-3">        
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-pen"></i> Editar inventario: {{$inventory->name}}</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url' => '/admin/product/inventory/'.$inventory->id.'/edit']) !!}         
                        <label for="name" class="space">Nombre del inventario:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                            {!! Form::text('name', $inventory->name, ['class' => 'form-control', 'placeholder' => 'Nombre del inventario', 'required']) !!}
                        </div>
                        <label for="inventory" class="space mtop16">Inventario:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-up-9-1"></i></span>
                        {!! Form::number('inventory', $inventory->quantity, ['class'=>'form-control', 'min'=>'1']) !!}                    
                        </div>
                        <label for="price" class="space">Precio:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            {{ Config('cms.currency')}}
                        </span>
                        {!! Form::number('price', $inventory->price, ['class'=>'form-control', 'min'=>'1.00', 'step'=>'any', 'required']) !!}                    
                        </div>
                        <label for="limited" class="space">Limite de inventario:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-boxes-packing"></i></span>
                        {!! Form::select('limited', getLimited(), $inventory->limited,['class'=>'form-select']) !!}                    
                        </div>
                        <label for="minimum" class="space">Inventario mínimo:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-land-mine-on"></i></span>
                        {!! Form::number('minimum', $inventory->minimum, ['class'=>'form-control', 'min'=>'1']) !!}                    
                        </div>
                        {!! Form::submit('Guardar', ['class' => 'btn btn-success mtop16']) !!}
                    {!! Form::close() !!}
                </div>
            </div> 
        </div>
    <!-- columna N.2 -->
    <div class="col-md-9">        
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fa-solid fa-boxes-stacked"></i> Variantes de: <b>{{$inventory->name}}</b></h2>
            </div>
            <div class="inside">
                
                {!! Form::open(['url' => '/admin/product/inventory/'.$inventory->id.'/variant']) !!}
                    <div class="row">
                        <div class="col-md-6">                            
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la variante', 'required']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <td >ID:</td>
                            <td>Nombre: </td>
                            <td>Opciones:</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventory->getVariants as $variant)
                        <tr>
                            <td>{{ $variant->id}}</td>
                            <td>{{ $variant->name}}</td>
                            <td>
                                <div class="opts">
                                    <a href="#" data-path="admin/product/variant" data-action="delete" data-object="{{ $variant->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" class="btn-deleted delete"><i class="fa-solid fa-trash-can" ></i></a>
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
@endsection