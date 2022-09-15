@extends('emails.master')
@section('title', 'Nueva contraseña')

@section('content')
<p>Hola: <strong>{{ $name}}</strong> </p>
<p>Este es un correo electrónico que le servirá para poder ingresar al sistema con su nueva contraseña. Atte: El administrador</p>
<p>Su nueva contraseña es:</p>
<p><h1>{{ $password }}</h1></p>
<p>Para iniciar sesión, de click en el siguiente botón:</p>
<p><a href="{{ url('/login') }}" style="display: inline-block; background-color: #D3C8F3; color: #fff; padding: 12px; border-radius: 4px; text-decoration: none"> Iniciar Sesión </a></p>
<p>Si el botón anterior no funciona copie y peque el siguiente url de su navegador:</p>
<p style="color: blue">{{ url('/login')}}</p>

@stop