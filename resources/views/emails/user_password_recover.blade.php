@extends('emails.master')
@section('title', 'Recuperar contraseña')

@section('content')
<p>Hola: <strong>{{ $name}}</strong> </p>
<p>Este es un correo electrónico que le servirá para poder reestablecer sus contraseña dentro de nuestra plataforma. Atte: El administrador</p>
<p>Para continuar haga click en el siguiente enlace:</p>
<p><a href="{{ url('/reset') }}" style="display: inline-block; background-color: #D3C8F3; color: #fff; padding: 12px; border-radius: 4px; text-decoration: none"> Resetear mi contraseña </a></p>
<p>Si el botón anterior no funciona copie y peque el siguiente url en su navegador:</p>
<p style="color: blue">{{ url('/reset?email='.$email)}}</p>
<p>Dentro del enlace, ingrese el siguiente código de confirmación:</p>
<p><h1>{{$code}}</h1></p>
@stop