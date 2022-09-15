@extends('admin.master')
@section('title', 'Sub Categorías')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('/admin/categories/0')}}"><i class="fa-solid fa-folder-open"></i> Categorias</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ url('/admin/category/'.$category->id.'/subs')}}"><i class="fa-solid fa-list-ul"></i> Listar categoría: {{ $category->name}}</a>    
</li>


@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
       
        <div class="col-md-12">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-folder-open"></i> Subcategorías de: <strong>{{$category->name}}</strong></h2>
                </div>
                <div class="inside">
                    
                    <table class="table table-striped mtop16 align-middle">
                        <thead>
                            <tr>
                                <td width="64px">Icon:</td>
                                <td>Nombre:</td>
                                <td width="160px">Opciones:</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->getSubCategories as $cat)
                                <tr>
                                    <td>@if(!is_null($cat->icon))
                                        <a href="{{getUrlFileFromUploads($cat->icon)}}" data-fancybox="gallery">
                                            <img src="{{getUrlFileFromUploads($cat->icon)}}" alt="" class="img-fluid">                            
                                        </a>
                                        </td>
                                        @endif                                         
                                    <td>{{ $cat->name}}</td>
                                    <td><div class="opts">
                                        @if(kvfj(Auth::user()->permissions, 'category_edit'))
                                        <a href="{{'/admin/category/'.$cat->id.'/edit'}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>                                        
                                        @endif
                                        @if(kvfj(Auth::user()->permissions, 'category_delete'))
                                        
                                        <a href="#" data-path="admin/category" data-action="delete" data-object="{{ $cat->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" class="btn-deleted delete"><i class="fa-solid fa-trash-can" ></i></a>
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