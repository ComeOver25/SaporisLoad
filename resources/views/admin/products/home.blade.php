@extends('admin.master')

@section('title', 'Módulo de Productos')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url ('/admin/products/all')}}"><i class="fa-solid fa-plate-wheat"></i> Productos</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fa-solid fa-plate-wheat"></i> Productos</h2>
            <ul>
                @if(kvfj(Auth::user()->permissions, 'product_add'))
                <li>
                    <a href="{{url ('/admin/product/add')}}" ><i class="fa-solid fa-plus"></i> Agregar producto</a>
                </li>
            @endif
            <li>
                <a href="#">Filtrar <i class="fa-solid fa-filter"></i></a>
                <ul class="shadow">
                    <li><a href="{{ url('admin/products/1')}}"><i class="fa-solid fa-earth-americas"></i> Públicos</a></li>
                    <li><a href="{{ url('admin/products/0')}}"><i class="fa-solid fa-eye-slash"></i> No visibles</a></li>
                    <li><a href="{{ url('admin/products/trash')}}"><i class="fa-solid fa-trash-can"></i> Papelera</a></li>
                    <li><a href="{{ url('admin/products/all')}}"><i class="fa-solid fa-list"></i> Todos</a></li>
                </ul>
            </li>
            <li>
                <a href="#" id="btn_search" ><i class="fa-solid fa-magnifying-glass"></i> Buscar</a>
                
            </li>
            </ul>
        </div>
        <div class="inside">
            <div class="form_search" id="form_search">
                {!! Form::Open(['url' => '/admin/product/search']) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Buscar', 'required']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::select('filter', ['0' => 'Nombre del producto', '1' => 'Código'], 0, ['class' => 'form-select']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::select('status', ['0' => 'Producto no Visible', '1' => 'Producto Visible'], 1, ['class' => 'form-select']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            
            <table class="table align-middle table-hover">
                <thead>
                    <tr>
                        <th ><strong>ID</strong></th>
                        <th >Código</th>                     
                        <th ><strong>Imagen</strong></th>
                        <th ><strong>Nombre</strong></th>
                        <th ><strong>Precio Min.</strong></th>
                        <th ><strong>Opciones</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                    <tr >
                        <th width="50">{{ $p->id }}</th>
                        <td width="50">{{ $p->code }}</td>
                        <td width="48"><a href="{{getUrlFileFromUploads($p->image)}}" data-fancybox="gallery" data-caption="{{ $p->name}}{{ $p->content}}">
                            <img src="{{getUrlFileFromUploads($p->image)}}" width="48" alt="" >                            
                        </a></td>
                        <td>
                            <p style="margin-bottom: 0px;">{{ $p->name }} @if($p->status == "0") <i class="fa-solid fa-eye-slash" data-bs-toggle="tooltip" data-bs-placement="top" title="Estado: No visible"></i>  @endif </p>
                            <p style="margin-bottom: 0px;"><small><i class="fa-solid fa-folder-open"></i> {{ $p->cat->name }}                             
                                @if($p->subcategory_id != "0") 
                                <i class="fa-solid fa-angles-right"> </i>
                                {{$p->getSubcategory->name}}                            
                                @endif</small>
                            </p>
                        </td>
                        <td>{{Config::get('cms.currency')}} {{ $p->price }}</td>
                        <td width="150">
                            <div class="opts">
                            @if(kvfj(Auth::user()->permissions, 'product_edit'))
                            @if(is_null($p->deleted_at))
                            <a href="{{ url('/admin/product/'.$p->id.'/edit') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            @endif
                            @endif
                            @if(kvfj(Auth::user()->permissions, 'product_inventory'))
                            <a href="{{ url('/admin/product/'.$p->id.'/inventory') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Inventario" class="inventory"><i class="fa-solid fa-box"></i></a>
                            @endif
                            @if(kvfj(Auth::user()->permissions, 'product_delete'))
                            @if(is_null($p->deleted_at))
                            <a href="#" data-path="admin/product" data-action="delete" data-object="{{ $p->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" class="btn-deleted delete"><i class="fa-solid fa-trash-can" ></i></a>
                            @else
                            <a href="#" data-action="restore" data-path="admin/product" data-object="{{ $p->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Recuperar producto" class="btn-deleted restore"><i class="fa-solid fa-trash-can-arrow-up"></i></a>
                            @endif
                            @endif
                        </div>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6">{!! $products->render() !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection