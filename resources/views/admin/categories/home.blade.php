@extends('admin.master')
@section('title', 'Módulo Categorias')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/categories/0')}}"><i class="fa-solid fa-folder-open"></i> Categorias</a>
</li>

@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        @if(kvfj(Auth::user()->permissions, 'category_add'))
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-plus"></i> Agregar categorías</h2>
                </div>
                <div class="inside">
                    
                    {!! Form::open(['url'=> '/admin/category/add/'.$module, 'files'=> true]) !!}
                                            
                            <label for="name" class="space">Nombre de la categoria:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-arrow-down-a-z"></i></span>
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre de la categoria']) !!}
                        </div>

                        <label for="module" class="space">Categorías padre:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-hat-cowboy"></i></span>
                        <select name="parent" id="" class="form-select">
                            <option value="0">Sin categoría padre</option>
                            @foreach($cats as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    
                </div>

                        <label for="module" class="space">Categorías:</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-box-open"></i></span>
                        {!! Form::select('module', getModulesArray(), $module , ['class'=>'form-select', 'disabled']) !!}
                    
                </div>

                <label for="icon" class="space">Icono:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-icons"></i></span>                                                                    
                                {!! Form::file('icon', ['class' => 'form-control', 'id' =>'formFile', 'accept'=>'image/*', 'required']) !!}
                            </div>
                        {!! Form::submit('Guardar', ['class' => 'btn btn-success mtop16']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-9">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-folder-open"></i> Categorias</h2>
                </div>
                <div class="inside">
                    <nav class="nav nav-pills ">
                        @foreach(getModulesArray() as $m => $k)
                        <a href="{{ url('/admin/categories/'.$m) }}" class="nav-link"><i class="fa-solid fa-list"></i>  {{ $k }}</a>
                        @endforeach
                    
                    </nav>
                    <table class="table table-striped mtop16 align-middle">
                        <thead>
                            <tr>
                                <td width="64px"></td>
                                <td>Nombre:</td>
                                <td width="160px">Opciones:</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cats as $cat)
                                <tr>
                                    <td width="48">
                                        @if(!is_null($cat->icon))
                                            <a href="{{getUrlFileFromUploads($cat->icon)}}" data-fancybox="gallery">
                                                <img src="{{getUrlFileFromUploads($cat->icon)}}" alt="" class="img-fluid" width="48">                            
                                            </a>
                                        @endif
                                    </td>                                          
                                    <td>{{ $cat->name}}</td>
                                    <td><div class="opts">
                                        @if(kvfj(Auth::user()->permissions, 'category_edit'))
                                        <a href="{{'/admin/category/'.$cat->id.'/edit'}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="{{'/admin/category/'.$cat->id.'/subs'}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Sub Categorias" class="list"><i class="fa-solid fa-list-ul"></i></a>
                                        @endif
                                        @if(kvfj(Auth::user()->permissions, 'category_delete'))
                                        
                                        <a href="#" data-path="admin/category" data-action="delete" data-object="{{ $cat->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" class="btn-deleted delete"><i class="fa-solid fa-trash-can" ></i></a>
                                        @endif
                                    </div>
                                    </td>
                                </tr>
                                
                            @endforeach
                            <tr>
                                <td colspan="4">{!! $cats->render() !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
