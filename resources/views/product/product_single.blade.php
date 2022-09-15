@extends('master')
@section('title', $product->name)
@section('custom_meta')
<meta name="product_id" content="{{ $product->id}}">
@stop
@section('content')
<div class="product_single shadow-lg">
    <div class="inside">
        <div class="container">
            <div class="row">
                <!-- imagen y galeria -->
                <div class="col-md-4 pleft0">
                    <div class="slick-slider">
                        <div class="slider-nav">
                            <a href="{{ getUrlFileFromUploads($product->image)}}" data-fancybox="gallery" data-caption="{{ $product->name}}{{ $product->content}}">
                                <img src="{{ getUrlFileFromUploads($product->image,'500x500')}}" alt="{{$product->name}}" class="img-fluid">                            
                            </a>
                        </div>
                        
                    @if(count($product->getGallery)>0)
                    @foreach($product->getGallery as $gallery)
                    <div >                    
                        <a href="{{ getUrlFileFromUploads($gallery->file_name)}}" data-fancybox="gallery">
                            <img src="{{ getUrlFileFromUploads($gallery->file_name)}}" alt="{{$product->name}}" class="img-fluid">                           
                        </a>
                    </div>
                    @endforeach
                    @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <h2 class="title">{{ $product->name }}</h2>
                    <div class="category">
                        <ul>
                            <li><a href="{{ url('/')}}"><i class="fa-solid fa-house-chimney"></i> Inicio</a></li>
                            <li><span class="next"><i class="fa-solid fa-play"></i></span></li>
                            <li><a href="{{ url('/store')}}"><i class="fa-solid fa-store"></i> Tienda</a></li>
                            <li><span class="next"><i class="fa-solid fa-play"></i></span></li>
                            <li><a href="{{ url('/store')}}"><i class="fa-solid fa-folder-open"></i> {{$product->cat->name}}</a></li>
                            @if($product->subcategory_id!= "0")
                            <li><span class="next"><i class="fa-solid fa-play"></i></span></li>
                            <li><a href="{{ url('/store')}}"><i class="fa-solid fa-folder-tree"></i> {{$product->getSubcategory->name}}</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="add_cart">
                        {!! Form::open(['url' => '/cart/product/'.$product->id.'/add']) !!}
                        {!! Form::hidden('inventory', null, ['id' => 'field_inventory'] )!!}
                        {!! Form::hidden('variant', null, ['id' => 'field_variant'] )!!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="variants mtop16">
                                    <p><strong>Opciones del producto:</strong></p>
                                    <ul id="inventory">
                                        @foreach($product->getInventory as $inventory)
                                        <li><a href="#" class="inventory"  id="inventory_{{$inventory->id}}" data-inventory-id="{{$inventory->id}}">{{$inventory->name}} - <span class="price">{{Config::get('cms.currency').' '.number_format($inventory->price, 2,'.',',')}}</span></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="variants hidden btop1 mtop16 ptop16" id="variants_div">
                                    <p><strong>Más opciones del producto:</strong></p>
                                    <ul id="variants"></ul>
                                </div>                              
                            </div>
                        </div>
                        <div class="before_quantity">
                            <h5 class="title">¿Qué cantidad deseas comprar?</h5>
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="quantity">                                    
                                        <a href="#" class="amount_action" data-action="minus"><i class="fa-solid fa-minus"></i></a>
                                        {{ Form::number('quantity',1,['class' => 'form-control', 'min' => '1', 'id' => 'add_to_cart_quantity'])}}
                                        <a href="#" class="amount_action" data-action="plus"><i class="fa-solid fa-plus"></i></a>
                                    </div>
                                </div>                            
                                <div class="col-md-4 col-12">
                                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-cart-plus"></i> Agregar al carrito</button>
                                    
                                </div>
                                <div class="col-md-4 col-12">
                                    <a href="#" class="btn btn-favorite" id="favorite_1_{{$product->id}}" onclick="add_to_favorites({{$product->id}}, '1'); return false;"><i class="fa-solid fa-heart"></i> Agregar a favoritos</a>
                                    
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="content">
                        {!! html_entity_decode($product->content) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
