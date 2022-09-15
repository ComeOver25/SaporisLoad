@extends('admin.master')

@section('title', 'Administración')

@section('content')
<div class="container-fluid">
    @if(kvfj(Auth::user()->permissions, 'dashboard_small_stats'))
    <div class="panel shadow">
        <div class="header">
            <h2 class="title"><i class="fa-solid fa-chart-column"></i> Estadísticas básicas</h2>
        </div>
        
    </div>
    <div class="row mtop16">
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-user-group"></i> Usuarios registrado</h2>
                </div>
                <div class="inside">
                    <div class="big_count">{{ $users}}</div>
                </div>                
            </div>
        </div>
    
    
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-utensils"></i> Bocaditos en venta</h2>
                </div>
                <div class="inside">
                    <div class="big_count">{{ $products}}</div>
                </div>                
            </div>
        </div>

        @if(kvfj(Auth::user()->permissions, 'dashboard_orders_stats'))
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-basket-shopping"></i> Pedidos hoy: {{date('d-M-Y')}}</h2>
                </div>
                <div class="inside">
                    <div class="big_count">0</div>
                </div>                
            </div>
        </div>
        @endif
        
        @if(kvfj(Auth::user()->permissions, 'dashboard_sales_stats'))
        <div class="col-md-3">
            <div class="panel shadow">
                <div class="header">
                    <h2 class="title"><i class="fa-solid fa-coins"></i> Vendido hoy: {{date('d-M-Y')}}</h2>
                </div>
                <div class="inside">
                    <div class="big_count">0</div>
                </div>                
            </div>
        </div>
        @endif

    </div>
    @endif
</div>
@endsection