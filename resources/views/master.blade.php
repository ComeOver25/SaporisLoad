<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{Config::get('cms.name')}} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <meta name="routeName" content="{{ Route::currentRouteName()}}">
    <meta name="currency" content="{{ Config::get('cms.currency')}}">
    <meta name="auth" content="{{Auth::check()}}">
    @yield('custom_meta')
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">
    <!-- google fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="/static/imagenes/britania.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="{{url('/static/css/style.css?v='.time())}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ url('/static/js/mdslider.js?v='.time())}}"></script>
    <script src="{{ url('/static/js/site.js?v='.time())}}"></script>    
    <script src="https://kit.fontawesome.com/de954fc05b.js" crossorigin="anonymous"></script>
    <!-- google fonts  roboto
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    -->    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
        })
            });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>    
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
</head>
<body>
    <div class="loader" id="loader">
        <div class="box">
            <div class="cart">
                <img src="{{ url('/static/imagenes/shopping-cart.png')}}" alt="Carrito de compras">
            </div>
            <div class="load">
                <img src="{{ url('/static/imagenes/eclipse2.svg')}}" alt="">
            </div>
            
        </div>
    </div>   
    <nav class="navbar navbar-expand-lg shadow">        
            <div class="container">
                <a class="navbar-brand" href="{{ url('/')}}"><img src="{{ url('/static/imagenes/britania.png')}}" alt="cms"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigationMain" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                
                <div class="collapse navbar-collapse" id="navigationMain">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="{{ url('/')}}" class="nav-link lk-home"><i class="fa-solid fa-house-chimney-window"></i><span> Inicio</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/store')}}" class="nav-link lk-store lk-store_category lk-search lk-product_single"><i class="fa-solid fa-shop"></i><span> Tienda</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/')}}" class="nav-link"><i class="fa-solid fa-people-group"></i><span> Nosotros</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/')}}" class="nav-link"><i class="fa-solid fa-address-book"></i><span> Contactos</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/cart')}}" class="nav-link lk-cart"><i class="fa-solid fa-cart-arrow-down"></i> <span class="carnumber"> 0</span> </a>
                        </li>
                        @if(Auth::guest())
                        <li class="nav-item link-acc">
                            <a href="{{ url('/login')}}" class="nav-link btn"><i class="fa-solid fa-person-through-window"></i> Ingresar</a>
                            <a href="{{ url('/register')}}" class="nav-link btn"><i class="fa-solid fa-circle-user"></i> Registrarse</a>
                        </li>                        
                        @else
                        <li class="nav-item link-acc link-user dropdown">
                            <a href="{{ url('/login')}}" class="nav-link btn dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(is_null(Auth::user()->avatar)) <img src="{{ url('/static/imagenes/avatar.jpg')}}">
                                @else
                                <img src="{{ getUrlFileFromUploads(Auth::user()->avatar,'64x64')}}">
                                @endif Hola: {{Auth::user()->name}}</a>
                            <ul class="dropdown-menu shadow" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->role =="1")
                                <li><a class="dropdown-item" href="{{ url('/admin')}}"><i class="fa-solid fa-computer"></i> Administrar</a></li>
                               
                                @endif
                                <li><a class="dropdown-item" href="{{ url('/account/history/orders')}}"><i class="fa-solid fa-clock-rotate-left"></i> Historial de compras</a></li>
                                <li><a class="dropdown-item" href="{{ url('/account/address')}}"><i class="fa-solid fa-location-dot"></i> Mis direcciones</a></li>
                                <li><a class="dropdown-item" href="{{ url('/account/favorites')}}"><i class="fa-solid fa-heart"></i> Favoritos</a></li>
                                <li><a class="dropdown-item" href="{{ url('/account/edit')}}"><i class="fa-solid fa-user-pen"></i> Editar</a></li>
                                <li><a class="dropdown-item" href="{{ url('/logout')}}"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>                       
                            </ul>
                        </li> 
                        @endif
                    </ul>
                </div>
            </div>
        
    </nav>

               @if(Session::has('message'))
               <div class="container">
                   <div class="alert alert-{{ Session::get('typealert') }} mtop16" role="alert" style="display:none;">
                       {{Session::get('message')}}
                       @if($errors->any())
                       <ul>
                           @foreach($errors->all() as $error)
                           <li>{{$error}}</li>
                           @endforeach
                       </ul>
                       @endif
                       <script>
                           $('.alert').slideDown();
                           setTimeout(function(){$('.alert').slideUp();}, 5000);
                       </script>
                   </div>
               </div>
               @endif
               
               <div class="wrapper">
                   <div class="container">
                       @yield('content')
                   </div>
               </div>
              


</body>
</html>