@extends('connect.master')

@section('title', 'Iniciar Sesión')

@section('content')

<div class="box box_login shadow">
  <div class="header">
    <a href="{{ url('/')}}">
    <img src="{{url('/static/imagenes/logo.png')}}" >
  </a>
  </div>
  <div class="inside">
{!! Form::open(['url' => '/login'])!!}
<label for="email" class="form-label">Correo electrónico</label>
<div class="input-group">
    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-envelope-open-text"></i></span>
    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese email'])!!} 
  </div>
  <label for="password" class="form-label mtop16">Contraseña</label>
  <div class="input-group">
    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-key"></i></span>
    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese contraseña'])!!} 
  </div>
  {!! Form::submit('Ingresar',['class'=> 'btn btn-success mtop16']) !!}
{!! Form::close()!!}
@if(Session::has('message'))
<div class="container">
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
<div class="footer mtop16">
  <a href="{{ url('/register')}}">¿No tienes cuenta?, Registrate</a>
  <a href="{{ url('/recover')}}">Olvide mi contraseña</a>
  
</div>
</div>


</div>

@stop