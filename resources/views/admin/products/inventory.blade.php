@extends('admin.master')

@section('title', 'Inventario de Producto')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url ('/admin/products/all')}}"><i class="fa-solid fa-plate-wheat"></i> Productos</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/'.$product->id.'/edit')}}"><i class="fa-solid fa-pen"></i> {{ $product->name}}</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/'.$product->id.'/inventory')}}"><i class="fa-solid fa-boxes-stacked"></i> Inventario:</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- columna N.1 -->
        <div class="col-md-3">        
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-folder-plus"></i> Crear inventario:</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url' => '/admin/product/'.$product->id.'/inventory', 'files' => true]) !!}         
                        <label for="name" class="space">Nombre del inventario:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre del inventario', 'required']) !!}
                        </div>
                        <label for="inventory" class="space mtop16">Inventario:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-up-9-1"></i></span>
                        {!! Form::number('inventory', 1, ['class'=>'form-control', 'min'=>'1']) !!}                    
                        </div>
                        <label for="price" class="space">Precio:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            {{ Config('cms.currency')}}
                        </span>
                        {!! Form::number('price', 1.00, ['class'=>'form-control', 'min'=>'1.00', 'step'=>'any', 'required']) !!}                    
                        </div>
                        <label for="limited" class="space">Limite de inventario:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-boxes-packing"></i></span>
                        {!! Form::select('limited', getLimited(), 0,['class'=>'form-select']) !!}                    
                        </div>
                        <label for="minimum" class="space">Inventario mínimo:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-land-mine-on"></i></span>
                        {!! Form::number('minimum', 1, ['class'=>'form-control', 'min'=>'1']) !!}                    
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
                <h2 class="title"><i class="fa-solid fa-boxes-stacked"></i> Inventarios de: <b>{{$product->name}}</b></h2>
            </div>
            <div class="inside">
                <table class="table">
                    <thead>
                        <tr>
                            <td>ID:</td>
                            <td>Nombre:</td>
                            <td>Existencias:</td>
                            <td>Mínimo</td>
                            <td>Precio:</td>
                            <td>Opciones:</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->getInventory as $inventory)
                        <tr>
                            <td>{{ $inventory->id}}</td>
                            <td>{{ $inventory->name}}</td>
                            <td>
                                @if($inventory->limited =="1")
                                <i class="fa-solid fa-infinity"></i>
                                @else
                                {{ $inventory->quantity}}
                                @endif
                            </td>
                            <td>
                                @if($inventory->limited =="1")
                                <i class="fa-solid fa-infinity"></i>
                                @else
                                {{ $inventory->minimum}}
                                @endif
                            </td>
                            <td>{{Config('cms.currency')}} {{ $inventory->price}}</td>
                            <td width="150">
                                <div class="opts">                                   
                                    <a href="{{ url('/admin/product/inventory/'.$inventory->id.'/edit') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" class="edit"><i class="fa-solid fa-marker"></i></a>                                        
                                    <a href="#" data-path="admin/product/inventory" data-action="delete" data-object="{{ $inventory->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" class="btn-deleted delete"><i class="fa-solid fa-trash-can" ></i></a>                                
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