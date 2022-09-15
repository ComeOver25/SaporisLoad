<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="/static/imagenes/logo2.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{Config::get('cms.name')}} - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('/static/css/connect.css?v='.time())}}" >
    <script src="https://kit.fontawesome.com/de954fc05b.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head> 
<body>
    
    @section('content')
    @show
</body>
</html>