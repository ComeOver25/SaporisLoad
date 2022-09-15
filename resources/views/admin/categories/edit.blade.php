@extends('admin.master')

@section('title', 'Editar Categoria')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/categories/0')}}"><i class="fa-solid fa-folder-open"></i> Categorías</a>
</li>
@if($cat->parent == "0")
<li class="breadcrumb-item">
    <a href="{{ url('/admin/category/'.$cat->id.'/edit')}}"><i class="fa-solid fa-pen-to-square"></i> Editar categoría:{{ $cat->name}}</a>
</li>
@else
<li class="breadcrumb-item">
    <a href="{{ url('/admin/category/'.$cat->parent.'/subs')}}"><i class="fa-solid fa-pen-to-square"></i> Categoría:{{ $cat->getParent->name}}</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/category/'.$cat->id.'/edit')}}"><i class="fa-solid fa-pen-clip"></i> Editar sub-categoría:{{ $cat->name}}</a>
</li>
@endif

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 ">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-plus"></i> Editar categorias</h2>
                </div>
                <div class="inside">
                    {!! Form::open(['url'=> '/admin/category/'.$cat->id.'/edit', 'files' => true]) !!}                    
                        
                            <label for="name" class="space">Nombre de la categoria:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                            {!! Form::text('name', $cat->name, ['class' => 'form-control', 'placeholder' => 'Nombre de la categoria']) !!}
                        </div>
                        
                        
                <label for="icon" class="space">Icono:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-icons"></i></span>
                                {!! Form::file('icon', ['class' => 'form-control', 'id' =>'formFile', 'accept'=>'image/*']) !!}
                        </div>
                        <label for="order" class="space">Orden:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                            {!! Form::number('order', $cat->order, ['class' => 'form-control', 'min' => '0']) !!}
                        </div>
                        {!! Form::submit('Actualizar', ['class' => 'btn btn-success mtop16']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @if(!is_null($cat->icon))
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-brands fa-contao"></i> Icono Actual</h2>
                </div>
                <div class="inside">
                    <a href="{{getUrlFileFromUploads($cat->icon)}}" data-fancybox="gallery">
                        <img src="{{getUrlFileFromUploads($cat->icon)}}" alt="" class="img-fluid">                            
                    </a>
                </div>
            </div>
        </div>
        @endif
    
    </div>
</div>
@endsection