@extends('admin.master')

@section('title', 'Módulo de Configuración')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{url ('/admin/settings')}}"><i class="fa-solid fa-gears"></i> Configuración</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
    {!! Form::open(['url' => '/admin/settings']) !!}
        <!-- Row #1 -->
        <div class="row">
            <div class="col-md-4 d-flex">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-gear"></i> General:</h2>            
                    </div>
                    <div class="inside">
                        <label for="name" class="space">Nombre de la Empresa:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-signature"></i></span>
                        {!! Form::text('name', Config::get('cms.name'), ['class' => 'form-control', 'placeholder' => 'Nombre de la tienda']) !!}                        
                        </div>

                        <label for="map" class="space mtop16">Ubicación:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-map-location-dot"></i></span>
                        {!! Form::text('map', Config::get('cms.map'), ['class' => 'form-control', 'placeholder' => 'Dirección de la tienda']) !!}
                        </div>

                        <label for="website" class="space mtop16">Sitio web:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-blog"></i></span>
                        {!! Form::text('website', Config::get('cms.website') , ['class' => 'form-control', 'placeholder' => 'Sitio web']) !!}
                        </div>                       

                        <label for="company_phone" class="space mtop16">Telefóno/Celular:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone-volume"></i></span>
                            {!! Form::number('company_phone', Config::get('cms.company_phone'), ['class' => 'form-control', 'placeholder' => 'Celular/Telefóno', 'min'=>'1', 'max'=>'999999999']) !!}                        
                        </div>

                        <label for="email_from" class="space mtop16">Correo electrónico:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-at"></i></span>
                        {!! Form::email('email_from', Config::get('cms.email_from') , ['class' => 'form-control', 'placeholder' => 'Correo electrónico']) !!}
                        </div>

                        <label for="maintenance_mode" class="space mtop16">Modo mantenimiento:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                            {!! Form::select('maintenance_mode', getModeConfig(), Config::get('cms.maintenance_mode') , ['class'=>'form-select']) !!}                        
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-cash-register"></i> Moneda y Precios:</h2>            
                    </div>
                    <div class="inside">
                        <label for="currency" class="space" >Símbolo de moneda:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-coins"></i></span>
                        {!! Form::text('currency', Config::get('cms.currency') , ['class' => 'form-control', 'placeholder' => 'Prefijo de la moneda']) !!}
                        </div>

                        <label for="shop_min_amount" class="space mtop16">Monto mínimo de compra:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-down-long"></i><strong>{{Config('cms.currency')}}</strong></span>
                        {!! Form::number('shop_min_amount', Config::get('cms.shop_min_amount'), ['class' => 'form-control', 'min' => 1, 'required']) !!}
                        </div>

                        <label for="shipping_method" class="space mtop16">Configuración de precio de envió:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-car-side"></i></span>
                            {!! Form::select('shipping_method',getShippingMethod(), Config::get('cms.shipping_method'), ['class' => 'form-control']) !!}
                        </div>

                        <label for="shipping_default_value" class="space mtop16">Valor del envió:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><strong>{{Config('cms.currency')}}</strong></span>
                            {!! Form::number('shipping_default_value', Config::get('cms.shipping_default_value'), ['class' => 'form-control', 'min' => 1 , 'required']) !!}
                        </div>

                        <label for="shipping_amount_min" class="space mtop16">Monto mínimo para envió gratis:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-down-long"></i><strong>{{Config('cms.currency')}}</strong></span>
                            {!! Form::number('shipping_amount_min', Config::get('cms.shipping_amount_min'), ['class' => 'form-control', 'min' => 0 , 'required']) !!}
                        </div>

                        <label for="to_go" class="space">Recojo en tienda:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-truck-pickup"></i></span>
                            {!! Form::select('to_go', getEnableorNot(), Config::get('cms.to_go') , ['class'=>'form-select']) !!}
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-wifi"></i> Redes sociales:</h2>            
                    </div>
                    <div class="inside">
                        <label for="facebook" class="space">Facebook:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-facebook"></i></span>
                        {!! Form::text('facebook', Config::get('cms.facebook'), ['class' => 'form-control', 'placeholder' => 'Facebook']) !!}                        
                        </div>

                        <label for="instagram" class="space mtop16">Instagram:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-instagram"></i></span>
                        {!! Form::text('instagram', Config::get('cms.instagram'), ['class' => 'form-control', 'placeholder' => 'Instagram']) !!}
                        </div>

                        <label for="twitter" class="space mtop16">Twitter:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-twitter"></i></span>
                        {!! Form::text('twitter', Config::get('cms.twitter') , ['class' => 'form-control', 'placeholder' => 'Twitter']) !!}
                        </div>
                        
                        <label for="youtube" class="space mtop16">Youtube:</label>
                        <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-youtube"></i></span>
                        {!! Form::text('youtube', Config::get('cms.youtube') , ['class' => 'form-control', 'placeholder' => 'Youtube']) !!}
                        </div> 

                        <label for="whatsapp" class="space mtop16">Whatsapp:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-whatsapp"></i></span>
                            {!! Form::text('whatsapp', Config::get('cms.whatsapp'), ['class' => 'form-control', 'placeholder' => 'Whatsapp']) !!}                        
                        </div>                        

                    </div>
                </div>
            </div>            
        </div>
        <!-- Row #2 -->
        <div class="row mtop16">
            <div class="col-md-4 d-flex">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-money-check-dollar"></i> Pagos / Integraciones</h2>            
                    </div>
                    <div class="inside">
                        <label for="payment_method_cash" class="space">Pagos en efectivo:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-sack-dollar"></i></span>
                            {!! Form::select('payment_method_cash', getEnableorNot(), Config::get('cms.payment_method_cash') , ['class'=>'form-select']) !!}
                        </div>

                        <label for="payment_method_creditcard" class="space">Pagos en tarjeta:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-cc-visa"></i></span>
                            {!! Form::select('payment_method_creditcard', getEnableorNot(), Config::get('cms.payment_method_creditcard') , ['class'=>'form-select']) !!}
                        </div>

                        <label for="payment_method_transfer" class="space">Pagos por trasferencia:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-building-columns"></i></span>
                            {!! Form::select('payment_method_transfer', getEnableorNot(), Config::get('cms.payment_method_transfer') , ['class'=>'form-select']) !!}
                        </div> 
                        
                        @if (Config::get('cms.payment_method_transfer') == 1)
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="panel">
                                        <label for="payment_method_transfer" class="space"><strong>BCP :</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1" style="padding: 0px"><img src="{{ url('/static/imagenes/bcp.png')}}" alt="" style="width: 42px; height:38px;"></span>
                                            {!! Form::text('payment_method_transfer_accounts_bank_BCP', Config::get('cms.payment_method_transfer_accounts_bank_BCP'), ['class' => 'form-control', 'placeholder' => 'Cuenta BCP']) !!}
                                        </div> 
                                        <label for="payment_method_transfer" class="space"><strong>BCP CCI :</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1" style="padding: 0px"><img src="{{ url('/static/imagenes/bcp1.png')}}" alt="" style="width: 42px; height:38px;"></span>
                                            {!! Form::text('payment_method_transfer_accounts_bank_BCPCCI', Config::get('cms.payment_method_transfer_accounts_bank_BCPCCI'), ['class' => 'form-control', 'placeholder' => 'Cuenta CCI - BCP']) !!}
                                        </div> 
                                        <label for="payment_method_transfer" class="space"><strong>BBVA :</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1" style="padding: 0px"><img src="{{ url('/static/imagenes/bbva.png')}}" alt="" style="width: 42px; height:38px;"></span>
                                            {!! Form::text('payment_method_transfer_accounts_bank_BBVA', Config::get('cms.payment_method_transfer_accounts_bank_BBVA'), ['class' => 'form-control', 'placeholder' => 'Cuenta BBVA']) !!}
                                        </div> 
                                        <label for="payment_method_transfer" class="space"><strong>BBVA CCI :</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1" style="padding: 0px"><img src="{{ url('/static/imagenes/bbva.png')}}" alt="" style="width: 42px; height:38px;"></span>
                                            {!! Form::text('payment_method_transfer_accounts_bank_BBVACCI', Config::get('cms.payment_method_transfer_accounts_bank_BBVACCI'), ['class' => 'form-control', 'placeholder' => 'Cuenta CCI - BBVA']) !!}
                                        </div> 
                                        <label for="payment_method_transfer" class="space"><strong>Interbank :</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1" style="padding: 0px"><img src="{{ url('/static/imagenes/interbank.png')}}" alt="" style="width: 42px; height:38px;"></span>
                                            {!! Form::text('payment_method_transfer_accounts_bank_BBVA', Config::get('cms.payment_method_transfer_accounts_bank_BBVA'), ['class' => 'form-control', 'placeholder' => 'Cuenta Interbank']) !!}
                                        </div> 
                                        <label for="payment_method_transfer" class="space"><strong>Interbank CCI :</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1" style="padding: 0px"><img src="{{ url('/static/imagenes/interbank.png')}}" alt="" style="width: 42px; height:38px;"></span>
                                            {!! Form::text('payment_method_transfer_accounts_bank_BBVACCI', Config::get('cms.payment_method_transfer_accounts_bank_BBVACCI'), ['class' => 'form-control', 'placeholder' => 'Cuenta CCI - Interbank']) !!}
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        @endif
                        <label for="payment_method_paypal" class="space">Pagos en Paypal:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-paypal"></i></span>
                            {!! Form::select('payment_method_paypal', getEnableorNot(), Config::get('cms.payment_method_paypal') , ['class'=>'form-select']) !!}
                        </div>

                        <label for="payment_method_yape" class="space">Pagos en Yape:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-brands fa-yahoo"></i></span>
                            {!! Form::select('payment_method_yape', getEnableorNot(), Config::get('cms.payment_method_yape') , ['class'=>'form-select']) !!}
                        </div>  
                        @if (Config::get('cms.payment_method_yape') == 1)
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="panel">
                                    <label for="payment_method_transfer" class="space"><strong>Celular :</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1" style="padding: 0px"><img src="{{ url('/static/imagenes/yape.png')}}" alt="" style="width: 42px; height:38px;"></span>
                                        {!! Form::text('payment_method_yape_number', Config::get('cms.payment_method_yape_number'), ['class' => 'form-control', 'placeholder' => 'Números de Cuenta']) !!}
                                    </div> 
                                    <label for="payment_method_transfer" class="space"><strong>Nombre/Titular :</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1" style="padding: 0px"><img src="{{ url('/static/imagenes/yape.png')}}" alt="" style="width: 42px; height:38px;"></span>
                                        {!! Form::text('payment_method_yape_name', Config::get('cms.payment_method_yape_name'), ['class' => 'form-control', 'placeholder' => 'Números de Cuenta']) !!}
                                    </div>                                     
                                </div>
                            </div>
                        </div>
                        @endif                      
                    </div>        
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-brands fa-windows"></i> Servidor</h2>            
                    </div>
                    <div class="inside">
                        <label for="server_uploads_paths" class="space">Uploads Server Path:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-server"></i></span>
                            {!! Form::text('server_uploads_paths', Config::get('cms.server_uploads_paths'), ['class' => 'form-control', 'placeholder' => 'Upload Server Path', 'required']) !!} 
                        </div>
                        
                        <label for="server_uploads_user_paths" class="space">Uploads Server Users Path:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-warehouse"></i></span>
                            {!! Form::text('server_uploads_user_paths', Config::get('cms.server_uploads_user_paths'), ['class' => 'form-control', 'placeholder' => 'Upload Server User Path', 'required']) !!} 
                        </div>

                        <label for="server_webapp_path" class="space">Path webapp:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-warehouse"></i></span>
                            {!! Form::text('server_webapp_path', Config::get('cms.server_webapp_path'), ['class' => 'form-control', 'placeholder' => 'Path webapp']) !!} 
                        </div>
                    </div>        
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="panel shadow">
                    <div class="header">
                        <h2 class="title"><i class="fa-solid fa-paste"></i> Paginación</h2>            
                    </div>
                    <div class="inside">
                        <label for="products_per_page" class="space">Productos a mostrar por página:</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                            {!! Form::number('products_per_page', Config::get('cms.products_per_page'), ['class' => 'form-control', 'placeholder' => 'Productos por página', 'min'=>'1', 'max'=>'25', 'required']) !!}
                        </div>
                        <label for="products_per_page_random" class="space">Productos a mostrar por página (Random):</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                            {!! Form::number('products_per_page_random', Config::get('cms.products_per_page_random'), ['class' => 'form-control', 'placeholder' => 'Productos por random', 'min'=>'1', 'max'=>'25', 'required']) !!}
                        </div>
                    </div>        
                </div>
            </div>
        </div>
        <div class="row mtop16">
            <div class="col-md-12">
                <div class="panel shadow">
                    <div class="inside">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}      
                    </div>
                </div>                        
            </div>
        </div>
    {!! Form::close() !!}    
</div>
@endsection