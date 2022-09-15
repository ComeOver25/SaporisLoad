@extends('master')
@section('title', 'Tienda - '.$category->name)
@section('custom_meta')
<meta name="category_id" content="{{$category->id}}">
@stop
@section('content')
    <div class="store">
        <div class="row mtop32">
            <div class="col-md-3">
                <div class="categories_list shadow">
                    <h2 class="title"><i class="fa-solid fa-bars-staggered"></i> {{$category->name}} <i class="fa-solid fa-caret-down"></i></h2>
                    <ul>
                        @if($category->parent!="0")
                        <li>
                            <a href="{{url ('store/category/'.$category->getParent->id.'/'.$category->getParent->slug)}}"><i class="fa-solid fa-backward"></i> Regresar a {{$category->getParent->name}}</a>
                        </li>
                        @endif
                        @if($category->parent=="0")
                        <li>
                            <a href="{{url ('store/category/'.$category->id.'/'.$category->slug)}}"><i class="fa-solid fa-chevron-down"></i> Subcategorias</a>
                        </li>
                        
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ url('/store/category/'.$cat->id.'/'.$cat->slug) }}">
                                <img src="{{ getUrlFileFromUploads($cat->icon)}}" alt=""> {{$cat->name}}
                            </a>
                        </li>
                        @endforeach
                        
                        <li>
                            <a href="{{ url('/store')}}"><i class="fa-solid fa-backward"></i> Regresar a Tienda</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="store_white">
                    <section>
                        <h2 class="home_title"><i class="fa-solid fa-shop"></i> {{$category->name}}</h2>
                        <div class="products_list" id="products_list">            
                        </div>
                        <div class="load_more_products">
                            <a href="#" id="load_more_products"><i class="fa-regular fa-paper-plane"></i> Cargar más productos</a>
                        </div>
                    </section>
                    
                </div>
            </div>
        </div>
    </div>
@endsection