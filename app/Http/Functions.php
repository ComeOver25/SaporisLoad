<?php
// key value from Json = Extraer valores de una variable json
function kvfj($json, $key){
    if($json == null):
        return null;
    else:
        $json = $json;
        $json = json_decode($json, true);
        if(array_key_exists($key, $json)):
            return $json[$key];
        else:
            return null;
        endif;
    endif;
}

function getModulesArray(){
    $a = [
        '0' => 'Productos',
        '1' => 'Arreglos'
    ];

    return $a;
}

function getUrlFileFromUploads($file, $size = null){
    if(!is_null($file)):
        $file = json_decode($file, true); 
        if($size):
            return url('/uploads/'.$file['path'].'/'.$size.'_'.$file['final_name']);
        else:
            return url('/uploads/'.$file['path'].'/'.$file['final_name']);
        endif; 
    endif;
}

function getRoleUserArray($mode, $id){
    $roles = ['0' => 'Usuario normal', '1' => 'Usuario administrador'];
    if (!is_null($mode)):
        return $roles;
    else:

    return $roles[$id];
    endif;
}

function getUserStatusArray($mode, $id){
    $status = ['0' => 'Registrado', '1' => 'Verificado', '100' => 'Baneado' ];
    if (!is_null($mode)):
        return $status;
    else:

        return $status[$id];
    endif;
    
}

function getGenderArray(){
    $a = [
        '0' => 'Sin especificar',
        '1' => 'Masculino',
        '2' => 'Femenino',
        '3' => 'Prefiero no contestar'
    ];

    return $a;
}

function user_permissions(){
    $p = [
        'dashboard' => [
            'icon' =>'<i class="fa-solid fa-house"></i>',
            'title' => 'Módulo Inicio',
            'keys' =>[
                'dashboard' => 'Acceso al inicio',
                'dashboard_small_stats' => 'Acceso a las estadísticas',
                'dashboard_orders_stats' => 'Acceso a ver los pedidos',
                'dashboard_sales_stats' => 'Acceso a ver la venta diaria',
            ],
        ],

        'users' => [
            'icon' =>'<i class="fa-solid fa-user"></i>',
            'title' => 'Módulo Usuarios',
            'keys' =>[
                'user_list' => 'Acceso a la lista de usuarios',
                'user_view' => 'Acceso a ver usuarios',
                'user_edit' => 'Acceso a editar usuarios',
                'user_banned' => 'Acceso a bloquear usuarios', 
                'user_permissions' => 'Acceso a los permisos usuarios',
            ],
        ], 

        'products' => [
            'icon' =>'<i class="fa-solid fa-plate-wheat"></i>',
            'title' => 'Módulo Productos',
            'keys' =>[
                'products' => 'Acceso a los productos',
                'product_add' => 'Acceso a agregar productos',
                'product_edit' => 'Acceso a editar productos', 
                'product_delete' => 'Acceso a eliminar productos',
                'product_search' => 'Acceso a buscar productos',
                'product_gallery_add' => 'Acceso a ingresar imagenes a galeria',
                'product_gallery_delete' => 'Acceso a eliminar imagenes de galeria',
                'product_inventory' => 'Acceso a administrar el inventario de un producto',
            ],
        ], 

        'categories' => [
            'icon' =>'<i class="fa-solid fa-folder-open"></i>',
            'title' => 'Módulo Categorias',
            'keys' =>[
                'categories' => 'Acceso a las categorias',
                'category_add' => 'Acceso a agregar categorias',
                'category_edit' => 'Acceso a editar categorias', 
                'category_delete' => 'Acceso a eliminar categorias',                
            ],
        ],
        
        'orders' => [
            'icon' =>'<i class="fa-solid fa-clipboard-list"></i>',
            'title' => 'Módulo Pedidos',
            'keys' =>[
                'orders_list' => 'Acceso al listado de ordenes',
                'order_view' => 'Acceso al detalle de una orden',
                'order_change_status' => 'Acceso a cambiar el estado de una orden',
            ],
        ],

        'sliders' => [
            'icon' =>'<i class="fa-solid fa-images"></i>',
            'title' => 'Módulo Paneles',
            'keys' =>[
                'sliders_list' => 'Acceso al administrar paneles',
                'slider_add' => 'Acceso a agregar paneles',
                'slider_edit' => 'Acceso a editar los paneles',
                'slider_delete' => 'Acceso a eliminar paneles',
            ],
        ],       

        'settings' => [
            'icon' =>'<i class="fa-solid fa-gears"></i>',
            'title' => 'Módulo Configuración',
            'keys' =>[
                'settings' => 'Acceso a la configuración',
            ],
        ],

        'coverage' => [
            'icon' =>'<i class="fa-solid fa-truck-fast"></i>',
            'title' => 'Cobertura de envios',
            'keys' =>[
                'coverage_list' => 'Acceso a la lista de cobertura de envios',
                'coverage_add' => 'Acceso a agregar cobertura de envios',
                'coverage_edit' => 'Acceso a editar zonas de envios',
                'coverage_delete' => 'Acceso a eliminar zonas de envios',
            ],
        ],

                
    ];

    return $p;
}

function getUserYears(){
   
    $ym = '2004-01-01';
    $yo = '1950-12-31';
    return [$ym, $yo];
}

function getModeConfig(){
    $modefing = [
        '0' => 'Desactivado',
        '1' => 'Activado'
    ];

    return $modefing;
}

function getVisible(){
    $visible = [
        '0' => 'No visible',
        '1' => 'Visible'
    ];

    return $visible;
}

function getLimited(){
    $limited = [
        '0' => 'Limitado',
        '1' => 'Ilimitado'
    ];

    return $limited;
}

function getEye(){
    $eye = [
        '0' => 'No mostrar',
        '1' => 'Mostrar'
    ];

    return $eye;
}

function getShippingMethod($method = null){
    $status = ['0' => 'Gratis', '1' => 'Precio fijo', '2' => 'Precio variable por ubicación', '3' => 'Envió gratis / Monto mínimo' ];
    if (is_null($method)):
        return $status;
    else:

        return $status[$method];
    endif;
    
}

function getCoverageType($type = null){
    $status = ['0' => 'Departamento', '1' => 'Ciudad'];
    if (is_null($type)):
        return $status;
    else:

        return $status[$type];
    endif;    
}

function getCoverageStatus($status = null){
    $list = ['0' => 'No habilitado', '1' => 'Habilitado'];
    if (is_null($status)):
        return $list;
    else:
        return $list[$status];
    endif;    
}

function getAddress(){
    $a = [
        'Jiron' => 'Jiron',
        'Avenida' => 'Avenida',
        'Sector' => 'Sector',
        'Urbanización' => 'Urbanización',
        'Pasaje' => 'Pasaje',
    ];

    return $a;
}

function getEnableorNot(){
    $decision = [
        '0' => 'Desactivado',
        '1' => 'Activado'
    ];

    return $decision;
}

function getConfig($key){
    $var = config('cms.'.$key);
    return json_encode($var);
}

function getPaymentMethod($method = null){
    $list = ['0' => 'Pago en Efectivo', '1' => 'Tarjeta de crédito/débito', '2' => 'Transferencia / deposito', '3' => 'Paypal', '4' => 'Pago por Yape'];
    if (is_null($method)):
        return $list;
    else:
        return $list[$method];
    endif;  
}

function getOrderStatus($status = null){
    $list = [
        '0' => 'En proceso',
        '1' => 'Pago pendiente de confirmación.', 
        '2' => 'Pago recibido', 
        '3' => 'Procesando orden', 
        '4' => 'Orden enviada',
        '5' => 'Orden Lista para recoger',
        '6' => 'Orden entregada',
        '100' => 'Orden cancelada'
    ];
    if (is_null($status)):
        return $list;
    else:
        return $list[$status];
    endif;  
}

function getOrderType($type = null){
    $list = [
        '0' => 'Entrega a Domicilio',
        '1' => 'Recojo en Tienda', 
    ];
    if (is_null($type)):
        return $list;
    else:
        return $list[$type];
    endif;  
}

function number($number){
    return Config('cms.currency').' '.number_format($number, 2, '.',',');
}


