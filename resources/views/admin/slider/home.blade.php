@extends('admin.master')
@section('title', 'Módulo de Paneles')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/sliders')}}"><i class="fa-solid fa-images"></i> Sliders</a>
</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        @if(kvfj(Auth::user()->permissions, 'slider_add'))
            <div class="col-md-4">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-plus"></i> Agregar paneles:</h2>
                    </div>
                    <div class="inside">
                        {!! Form::open(['url'=> '/admin/slider/add', 'files'=> true]) !!}
                        
                            
                                <label for="name" class="space">Nombre:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
                            </div>

                            <label for="visible" class="space">Estado:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-eye"></i></span>
                            {!! Form::select('visible', getVisible(), 1 , ['class'=>'form-select']) !!}
                        
                    </div>

                    <label for="img" class="space">Imagen destacada:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-panorama"></i></span>                                                                    
                                    {!! Form::file('img', ['class' => 'form-control', 'id' =>'formFile', 'accept'=>'image/*']) !!}
                                </div>

                                <label for="content" class="space">Contenido:</label>
                                
                                    
                                {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '2', 'placeholder' => 'Descripción']) !!}
                                <script>CKEDITOR.replace( 'content' );</script>
                            
                            <label for="sorden" class="space">Orden de aparición:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-1-9"></i></span>
                                {!! Form::number('sorder', null, ['class' => 'form-control', 'min'=> 0]) !!}
                            </div>
                            {!! Form::submit('Guardar', ['class' => 'btn btn-success mtop16']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-8">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-image"></i> Paneles:</h2>
                </div>
                <div class="inside">
                    <table class="table align-middle table-hover">
                        <thead>
                            <tr>
                                <td>ID:</td>
                                <td>Imagen:</td>
                                <td>Nombre:</td>                                
                                <td width="130">Acciones:</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sliders as $slider)
                            <tr>
                                <td>{{$slider->id}}</td>
                                <td width="180px">
                                    <a href="{{getUrlFileFromUploads($slider->file_name)}}" data-fancybox="gallery">
                                        <img src="{{getUrlFileFromUploads($slider->file_name)}}" class="img-fluid">                            
                                    </a>                           
                                </td>
                                
                                <td>
                                    <div class="slider_content">
                                        <h1>{{$slider->name}}</h1>
                                        {!! html_entity_decode($slider->content) !!}
                                    </div>
                                </td>
                                <td width="100px">
                                    <div class="opts">
                                    @if(kvfj(Auth::user()->permissions, 'slider_edit'))                                    
                                    <a href="{{ url('/admin/slider/'.$slider->id.'/edit') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>                                    
                                    @endif
                                    @if(kvfj(Auth::user()->permissions, 'slider_delete'))                                    
                                    <a href="#" data-path="admin/slider" data-action="delete" data-object="{{ $slider->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" class="btn-deleted delete"><i class="fa-solid fa-trash-can" ></i></a>                                                                                                            
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
