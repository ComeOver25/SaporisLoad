@extends('emails.master')
@section('title', 'Detalles de la Orden')

@section('content')
<p>Hola: <strong>{{$name}} </strong> </p>
<p>Su Orden N°: <strong> {{$o_number}} </strong></p>
<p>Fue marcada como: # <strong>{{getOrderStatus($status)}}</strong></p>
@if($status == '6')
<p>Muchas gracias con confiar en nuestros productos.</p>
<p>Atte: <strong>{{Config::get('cms.name')}}</strong></p>
@endif
<p>Atte: <strong>{{Config::get('cms.name')}}</strong></p>

@stop