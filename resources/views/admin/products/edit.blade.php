@extends('admin.master')

@section('title', 'Editar Producto')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url ('/admin/products/all')}}"><i class="fa-solid fa-plate-wheat"></i> Productos</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/product/'.$p->id.'/edit')}}"><i class="fa-solid fa-pen-to-square"></i> Editar producto: {{ $p->name}}</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">        
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-pen-to-square"></i> Editar producto</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url' => '/admin/product/'.$p->id.'/edit', 'files' => true]) !!}
                    <div class="row">
                        <div class="col-md-8">
                        <label for="name" class="space">Nombre del producto:</label>
                            <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                            {!! Form::text('name', $p->name, ['class' => 'form-control', 'placeholder' => 'Nombre del producto']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="image" class="space">Imagen:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-photo-film"></i></i></span>
                            {!! Form::file('image',  ['class' => 'form-control', 'id' =>'formFile', 'accept'=>'image/*']) !!}
                                            
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="category" class="space">Categoría:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-shrimp"></i></span>
                                {!! Form::select('category', $cats, $p->category_id, ['class'=>'form-select', 'id' => 'category']) !!}
                            {{ Form::hidden('subcategory_actual', $p->subcategory_id, ['id' => 'subcategory_actual'])}}
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
                            <label for="code" class="space">Código de producto:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-barcode"></i></span>
                                {!! Form::text('code', $p->code, ['class'=>'form-control', 'placeholder' => 'Ingrese código de producto']) !!}
                            
                        </div>
                        </div>
                    </div>
                <div class="row mtop16">
                
                <div class="col-md-3">
                    <label for="indiscount" class="space">¿En oferta?:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-bomb"></i></span>
                        {!! Form::select('indiscount',  ['0'=>'No', '1'=>'Si'], $p->in_discount, ['class'=>'form-select']) !!}
                    
                </div>
                </div>
                <div class="col-md-3">
                    <label for="discount" class="space">Descuento:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-brazilian-real-sign"></i></span>
                        {!! Form::number('discount', $p->discount, ['class'=>'form-control', 'min'=>'0.00', 'step'=>'any']) !!}
                    
                </div>
                </div>
                <div class="col-md-3">
                    <label for="discount_until_date" class="space">Fecha Limite:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-calendar-xmark"></i></span>
                        {!! Form::date('discount_until_date', $p->discount_until_date, ['class'=>'form-control', 'Y-m-d']) !!}
                    
                </div>
                </div>
                
                <div class="col-md-3">
                    <label for="status" class="space">Mostrar:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            @if($p->status=='0')
                            <i class="fa-solid fa-eye-slash"></i>
                            @else
                            <i class="fa-solid fa-eye"></i>
                            @endif
                        </span>
                        {!! Form::select('status',  getEye(), $p->status, ['class'=>'form-select']) !!}
                    
                </div>
                </div>                
                
                </div>
                
                <div class="row mtop16">
                <div class="col-md-12">
                    <label for="content" class="space">Descripción</label>
                    {!! Form::textarea('content', $p->content, ['class' => 'form-control']) !!}
                    <script>CKEDITOR.replace( 'content' );</script>
                </div>
                </div>
                <div class="row mtop16">
                <div class="col-md-12">
                    
                    {!! Form::submit('Actualizar datos', ['class' => 'btn btn-success']) !!}
                    
                </div>
                </div>
                {!! Form::close() !!}
                </div>
        </div>

        </div>
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-image"></i> Imagen</h2>
                </div>
                <div class="inside">
                    <a href="{{getUrlFileFromUploads($p->image)}}" data-fancybox="gallery">
                        <img src="{{getUrlFileFromUploads($p->image)}}" width="100%" alt="" >
                    </a> 
                </div>
            </div>
            <div class="panel shadow mtop16">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-images"></i> Galeria</h2>
                </div>
                <div class="inside product_gallery">
                    @if(kvfj(Auth::user()->permissions, 'product_gallery_add'))
                    {!! Form::open(['url' => '/admin/product/'.$p->id.'/gallery/add', 'files' => true , 'id' => 'form_product_gallery']) !!}        
                      
                    {!! Form::file('file_image',  ['class' => 'form-control', 'id' =>'product_file_image', 'accept'=>'image/*', 'style' => 'display: none', 'required']) !!}
                                      
                    {!! Form::close()!!}
                    
                    <div class="btn-submit">
                        
                        <a href="#" id="btn_product_file_image"><i class="fa-solid fa-folder-plus"></i></a>
                       
                    </div>
                    @endif
                    <div class="tumbs">
                        @foreach($p->getGallery as $img)
                        <div class="tumb">
                            @if(kvfj(Auth::user()->permissions, 'product_gallery_delete'))
                            <a href="{{getUrlFileFromUploads($img->file_name)}}"><i class="fa-solid fa-trash-can" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"></i></a>                        
                            @endif                            
                            <img src="{{getUrlFileFromUploads($img->file_name)}}" data-fancybox="gallery">
                        </div>
                        @endforeach
                    </div>
                 </div>
            </div>
        </div>
        
    </div>
</div>
@endsection