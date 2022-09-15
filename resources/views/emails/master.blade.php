<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{Config::get('cms.name')}} - @yield('title')</title>
    <link rel="icon" href="/static/imagenes/logo2.png" type="image/png">
    <link rel="stylesheet" href="">
</head>
<body style="margen: 0px; padding: 0px; background-color: #f3f3f3">
    <div style="max-width:728px; width: 60% ; margin: 0px auto; display: block" >
        <img src="https://imgur.com/gDmFLWh.jpg" alt="" style="width: 100%; display: block">
        <div style=" background-color: #ffff; padding: 24px ">
            @yield('content')  
            <hr>
            <div style="margin-top: 16px;">
                <p><strong>Encuéntranos por nuestras redes sociales.</strong></p>
                @if(Config('cms.facebook') != "")
                    <a href="{{ Config('cms.facebook')}}" target="_blank" style="display: inline-block; margin-right: 6px;"><img src="{{ url('/static/imagenes/facebook_circle.png')}}" alt="" style="width: 36px;"></a>
                @endif
                @if(Config('cms.instagram') != "")
                    <a href="{{ Config('cms.instagram')}}" target="_blank" style="display: inline-block; margin-right: 6px;"><img src="{{ url('/static/imagenes/instagram_circle.png')}}" alt="" style="width: 36px;"></a>
                @endif
                @if(Config('cms.twitter') != "")
                    <a href="{{ Config('cms.twitter')}}" target="_blank" style="display: inline-block; margin-right: 6px;"><img src="{{ url('/static/imagenes/twitter_circle.png')}}" alt="" style="width: 36px;"></a>
                @endif
                @if(Config('cms.youtube') != "")
                    <a href="{{ Config('cms.youtube')}}" target="_blank" style="display: inline-block; margin-right: 6px;"><img src="{{ url('/static/imagenes/youtube_circle.png')}}" alt="" style="width: 36px;"></a>
                @endif
                @if(Config('cms.whatsapp') != "")
                    <a href="{{ Config('cms.whatsapp')}}" target="_blank" style="display: inline-block; margin-right: 6px;"><img src="{{ url('/static/imagenes/whatsapp_circle.png')}}" alt="" style="width: 36px;"></a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>