@extends('connect.master')

@section('title', 'Reset contraseña')

@section('content')

<div class="box box_login shadow">
  <div class="header">
    <a href="{{ url('/')}}">
    <img src="{{url('/static/imagenes/logo.png')}}" >
  </a>
  </div>
  <div class="inside">
{!! Form::open(['url' => '/reset'])!!}
<label for="email" class="form-label">Correo electrónico</label>
<div class="input-group">
    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-envelope-open-text"></i></span>
    {!! Form::email('email', $email, ['class' => 'form-control', 'placeholder' => 'Ingrese email','required'])!!} 
  </div>
  <label for="code" class="form-label mtop16">Código de recuperación:</label>
<div class="input-group">
    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-user-secret"></i></span>
    {!! Form::number('code', $email, ['class' => 'form-control', 'placeholder' => 'Ingrese el código','required' ])!!} 
  </div>
  
  {!! Form::submit('Recuperar mi contraseña',['class'=> 'btn btn-success mtop16']) !!}
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
  <a href="{{ url('/login')}}">Ingresar a mi cuenta</a>
  
</div>
</div>


</div>

@stop