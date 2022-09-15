@extends('admin.master')

@section('title', 'Agregar Producto')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url ('/admin/products/all')}}"><i class="fa-solid fa-plate-wheat"></i> Productos</a>
</li>
<li class="breadcrumb-item">
    <a href="{{url ('/admin/product/add')}}"><i class="fa-solid fa-plus"></i> Agregar producto</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fa-solid fa-plus"></i> Agregar producto</h2>
        </div>
        <div class="inside">
            {!! Form::open(['url' => 'admin/product/add', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12">
                    <label for="name" class="space">Nombre del producto:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre del producto']) !!}
                </div>
                </div>
            </div>
            <div class="row mtop16">
                <div class="col-md-4">
                    <label for="category" class="space">Categoria:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-shrimp"></i></span>
                        {!! Form::select('category', $cats, 0, ['class'=>'form-select', 'id' => 'category']) !!}
                        {{ Form::hidden('subcategory_actual', 0, ['id' => 'subcategory_actual'])}}
                    
                </div>
                </div>
                <div class="col-md-4">
                    <label for="subcategory" class="space">Sub-Categoría:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-diagram-predecessor"></i></span>
                        {!! Form::select('subcategory', [], null , ['class'=>'form-select', 'id' => 'subcategory', 'required']) !!}
                    
                </div>
                </div>
                <div class="col-md-4">
                    <label for="image" class="space">Imagen:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-photo-film"></i></i></span>
                    {!! Form::file('image', ['class' => 'form-control', 'id' =>'formFile', 'accept'=>'image/*']) !!}
                                       
                </div>
                </div>
            </div>
            <div class="row mtop16">
                
                <div class="col-md-4">
                    <label for="indiscount" class="space">¿En oferta?:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-bomb"></i></span>
                        {!! Form::select('indiscount', ['0'=>'No', '1'=>'Si'], 0 , ['class'=>'form-select']) !!}
                    
                </div>
                </div>
                <div class="col-md-4">
                    <label for="discount" class="space">Descuento:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-brazilian-real-sign"></i></span>
                        {!! Form::number('discount', 0.00, ['class'=>'form-control', 'min'=>'0.00', 'step'=>'any']) !!}
                    
                </div>
                </div>
                
                <div class="col-md-4">
                    <label for="code" class="space">Código de producto:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-barcode"></i></span>
                        {!! Form::text('code', null, ['class'=>'form-control', 'placeholder' => 'Ingrese código de producto']) !!}
                    
                </div>
                </div>
                
            </div>
            
            <div class="row mtop16">
                <div class="col-md-12">
                    <label for="content" class="space">Descripción</label>
                    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
                    <script>CKEDITOR.replace( 'content' );</script>
                </div>
            </div>
            <div class="row mtop16">
                <div class="col-md-12">
                    
                    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                    
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection