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
        @if(kvfj(Auth::user()->permissions, 'slider_edit'))
            <div class="col-md-6">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-pen-to-square"></i> Editar paneles:</h2>
                    </div>
                    <div class="inside">
                        {!! Form::open(['url'=> '/admin/slider/'.$slider->id.'/edit']) !!}
                        
                            
                                <label for="name" class="space">Nombre:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                                {!! Form::text('name', $slider->name, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
                            </div>

                            <label for="visible" class="space">Estado:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                @if($slider->status=="1")
                                <i class="fa-solid fa-eye"></i>
                                @else
                                <i class="fa-solid fa-eye-low-vision"></i>
                                @endif
                            </span>
                            {!! Form::select('visible', getVisible(), $slider->status , ['class'=>'form-select']) !!}
                        
                    </div>

                    <label for="img" class="space">Imagen destacada:</label>
                    <a href="{{getUrlFileFromUploads($slider->file_name)}}" data-fancybox="gallery">
                        <img src="{{getUrlFileFromUploads($slider->file_name)}}" class="img-fluid">                            
                    </a>      

                                <label for="content" class="space">Contenido:</label>
                                
                                {!! Form::textarea('content', html_entity_decode($slider->content), ['class' => 'form-control', 'rows' => '2', 'placeholder' => 'Descripción']) !!}
                                <script>CKEDITOR.replace( 'content' );</script>
                                <label for="sorden" class="space">Orden de aparición:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-1-9"></i></span>
                                {!! Form::number('sorder', $slider->sorder, ['class' => 'form-control', 'min'=> 0]) !!}
                            </div>
                            {!! Form::submit('Guardar', ['class' => 'btn btn-success mtop16']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endif
        
    </div>
</div>
@endsection