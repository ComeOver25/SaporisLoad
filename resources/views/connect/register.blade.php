@extends('connect.master')

@section('title', 'Registro')

@section('content')

<div class="box box_login shadow">
  <div class="header">
    <a href="{{ url('/')}}">
    <img src="{{url('/static/imagenes/logo.png')}}" >
  </a>
  </div>
  <div class="inside">
{!! Form::open(['url' => '/register'])!!}
<label for="name" class="form-label">Nombres:</label>
<div class="input-group">
    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-address-card"></i></span>
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese su nombre'])!!} 
  </div>
  <label for="lastname" class="form-label mtop16">Apellidos:</label>
<div class="input-group">
    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-id-card-clip"></i></span>
    {!! Form::text('lastname', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese sus apellidos'])!!} 
  </div>
<label for="email" class="form-label  mtop16">Usuario o correo electrónico:</label>
<div class="input-group">
    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-envelope-open-text"></i></span>
    {!! Form::email('email', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese email'])!!} 
  </div>
  <label for="password" class="form-label mtop16">Contraseña:</label>
  <div class="input-group">
    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-key"></i></span>
    {!! Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese contraseña'])!!} 
  </div>
  <label for="cpassword" class="form-label mtop16">Confirmar contraseña:</label>
  <div class="input-group">
    <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-lock"></i></span>
    {!! Form::password('cpassword', ['class' => 'form-control', 'required', 'placeholder' => 'Vuelva a ingresar contraseña'])!!} 
  </div>
  {!! Form::submit('Registrarse',['class'=> 'btn btn-success mtop16']) !!}
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
  <a href="{{ url('/login')}}">Ya tengo cuenta, ingresar</a>
  
  
</div>
</div>


</div>

@stop