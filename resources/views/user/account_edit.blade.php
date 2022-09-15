@extends('master')
@section('title', 'Editar Perfil')

@section('content')
<div class="row mtop32">
    <div class="col-md-4">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fa-solid fa-camera"></i> Editar imagen</h2>
            </div>
            <div class="inside">
                <div class="edit_avatar">
                    {!! Form::open(['url' => 'account/edit/avatar', 'id'=>'form_avatar_change' ,'files' => true]) !!} 
                    <a href="#" id="btn_avatar_edit">
                        <div class="overlay" id="avatar_change_overlay">
                            <i class="fa-solid fa-camera-retro"></i>
                        </div>
                    @if(is_null(Auth::user()->avatar))                    
                        <img src="{{ url('/static/imagenes/avatar.jpg')}}">                    
                    @else
                    <img src="{{getUrlFileFromUploads(Auth::user()->avatar,'256x256')}}">
                    @endif
                    </a>
                   
                    {!! Form::file('avatar', ['class' => 'form-control', 'id' =>'input_file_avatar', 'accept'=>'image/*']) !!}
                                   
                   
                
                    {!! Form::close() !!}    
                </div>           
            </div>
        </div>

        <div class="panel shadow mtop32">
            <div class="header">
                <h2 class="title"><i class="fa-solid fa-spell-check"></i> Cambiar contraseña</h2>
            </div>
            <div class="inside">
                {!! Form::open(['url' => '/account/edit/password']) !!}
                <div class="row">
                    <div class="col-md-12">
                        <label for="apassword" class="form-label">Contraseña Actual:</label>
                        <div class="input-group">
                          <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-key"></i></span>
                          {!! Form::password('apassword', ['class' => 'form-control', 'placeholder' => 'Ingrese contraseña actual'])!!} 
                        </div>
                    </div>
                </div>
                <div class="row mtop16">
                    <div class="col-md-12">
                        <label for="password" class="form-label">Contraseña nueva:</label>
                        <div class="input-group">
                          <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-unlock-keyhole"></i></span>
                          {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Ingrese nueva contraseña'])!!} 
                        </div>
                    </div>
                </div>
                <div class="row mtop16">
                    <div class="col-md-12">
                        <label for="cpassword" class="form-label ">Confirmar contraseña:</label>
                        <div class="input-group">
                          <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-lock"></i></span>
                          {!! Form::password('cpassword', ['class' => 'form-control', 'placeholder' => 'Confirme nueva contraseña'])!!} 
                        </div>
                    </div>
                </div>
                <div class="row mtop16">
                    <div class="col-md-12">
                        {!! Form::submit('Actualizar contraseña',['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel shadow">
            <div class="header">
                <h2 class="title"><i class="fa-solid fa-user-pen"></i> Editar información de usuario</h2>
            </div>
            <div class="inside">
                {!! Form::open(['url' => '/account/edit/info']) !!}
                <div class="row">
                    <div class="col-md-4">
                        <label for="name" class="space">Nombre:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-id-card-clip"></i></span>
                            {!! Form::text('name', Auth::user()->name, ['class' => 'form-control', 'placeholder' => 'Nombre de usuario']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="lastname" class="space">Apellidos:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-id-card"></i></span>
                            {!! Form::text('lastname', Auth::user()->lastname, ['class' => 'form-control', 'placeholder' => 'Apellidos']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="space">Correo Electrónico:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-at"></i></span>
                            {!! Form::text('email', Auth::user()->email, ['class' => 'form-control', 'placeholder' => 'Correo electrónico', 'disabled']) !!}
                        </div>
                    </div>
                </div>
                <div class="row mtop16">
                    <div class="col-md-4">
                        <label for="birthday" class="space">Fecha de nacimiento:</label>
                                    <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-calendar-check"></i></span>
                                    {!! Form::date('birthday',  Auth::user()->birthday , ['class'=>'form-control', 'min' => getUserYears()[1], 'max' => getUserYears()[0]], 'required') !!}
                                </div>
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="space">Número de telefóno:</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-mobile-screen-button"></i></span>
                            {!! Form::number('phone', Auth::user()->phone, ['class' => 'form-control', 'placeholder' => 'Celular/Telefóno', 'min'=>'1', 'max'=>'999999999', 'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="gender" class="space">Género:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            @if(Auth::user()->gender=='1')
                            <i class="fa-solid fa-mars"></i>
                            @else 
                            @if(Auth::user()->gender=='2')
                            <i class="fa-solid fa-venus"></i>
                            @else
                            <i class="fa-solid fa-venus-mars"></i>
                            @endif
                            @endif
                        </span>
                        {!! Form::select('gender', getGenderArray('list', null), Auth::user()->gender, ['class'=>'form-select']) !!}  
                    </div>
                </div>
                <div class="row mtop16">
                    <div class="col-md-12">
                        {!! Form::submit('Actualizar datos',['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
