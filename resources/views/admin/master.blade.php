<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{Config::get('cms.name')}} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <meta name="routeName" content="{{ Route::currentRouteName()}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="/static/imagenes/britania.png" type="image/png">
    <link rel="stylesheet" href="{{url('/static/css/admin.css?v='.time())}}">    
    <link rel="stylesheet" href="{{url('/static/css/mdalert.css')}}"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ url('/static/js/mdalert.js?v='.time())}}"></script>
    <script src="{{ url('/static/js/admin.js?v='.time())}}"></script>
    <script src="https://kit.fontawesome.com/de954fc05b.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script> 

</head>
<body>
    <div class="mdalert" id="md_alert_dom">
        <div class="md_alert_inside" id="md_alert_inside">
            <div class="md_alert_content" id="md_alert_content">                
            </div>
            <div class="md_alert_footer" id="md_alert_footer">
                <div class="md_alert_footer_other_btns" id="md_alert_footer_other_btns">                    
                </div>
                <a href="#" class="md_alert_btn_close" id="md_alert_btn_close">CERRAR</a>
            </div>
        </div>
    </div>
    <div class="wrapper">
        
        <div class="col1">@include('admin.sidebar')</div>
        <div class="col2">
            
            <nav class="navbar navbar-expand-lg shadow">
                <div class="collapse navbar-collapse">
                    <ul class="navbar">
                        <li class="nav-item">
                            <a href="{{ url('/')}}" class="nav-link"><i class="fa-solid fa-house"></i> Inicio</a>
                        </li>
                    </ul>
                </div>
            </nav>
           <div class="page">

               <div class="container-fluid">
                   <nav aria-label="breadcrumb shadow">
                       <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/admin')}}"><i class="fa-solid fa-house"></i> Inicio</a>
                            </li>
                            @section('breadcrumb')
                            @show
                       </ol>

                   </nav>
                   
               </div>
               @if(Session::has('message'))
               <div class="container-fluid">
                   <div class=" mtop16 alert alert-{{ Session::get('typealert') }}" role="alert" style="display:none;">
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
              
@section('content')

@show

           </div>
           
        </div>
    </div>    
</body>
</html>