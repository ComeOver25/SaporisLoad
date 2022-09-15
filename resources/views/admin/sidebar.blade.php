<div class="sidebar shadow">
    <div class="section-top">
        <div class="logo">
            <img src="{{url('/static/imagenes/britania.png')}}" class="img-fluid" alt="Sapori's">
        </div>
        <div class="user">
            <span class="subtitle">Hola:</span>
            <div class="name">
               {{Auth::user()-> name}}{{ Auth::user()->lastname}}
               <a href="{{url('/logout')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Salir"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
            <div class="email">
                {{ Auth::user()->email}}
            </div>
        </div>
    </div>

    <div class="main">
        <ul>
            @if(kvfj(Auth::user()->permissions, 'dashboard'))
            <li>
                <a href="{{url ('/admin')}}" class="lk-dashboard"><i class="fa-solid fa-house"></i> Inicio</a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions, 'user_list'))
            <li>
                <a href="{{url ('/admin/users/all')}}" class="lk-user_list lk-user_view lk-user_banned lk-user_permissions"><i class="fa-solid fa-user"></i> Usuarios</a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions, 'products'))
            <li>
                <a href="{{url ('/admin/products/all')}}" class="lk-products lk-product_add lk-product_edit lk-product_delete lk-product_gallery_add lk-product_gallery_delete lk-product_search lk-product_inventory"><i class="fa-solid fa-plate-wheat"></i> Productos</a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions, 'orders_list'))
            <li>
                <a href="{{url ('/admin/orders/all/all')}}" class="lk-orders_list lk-account_user_order_details lk-order_view" ><i class="fa-solid fa-clipboard-list"></i> Órdenes</a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions, 'coverage_list'))
            <li>
                <a href="{{url ('/admin/coverage')}}" class="lk-coverage_list lk-coverage_add lk-coverage_edit lk-coverage_delete" ><i class="fa-solid fa-truck-fast"></i></i> Cobertura de envios</a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions, 'categories'))
            <li>
                <a href="{{url ('/admin/categories/0')}}" class="lk-categories lk-category_add lk-category_edit lk-category_delete" ><i class="fa-solid fa-folder-open"></i> Categorias</a>
            </li>
            @endif
            @if(kvfj(Auth::user()->permissions, 'sliders_list'))
            <li>
                <a href="{{url ('/admin/sliders')}}" class="lk-sliders_list lk-slider_add lk-slider_edit lk-slider_delete" ><i class="fa-solid fa-images"></i> Paneles</a>
            </li>
            @endif 
            @if(kvfj(Auth::user()->permissions, 'settings'))
            <li>
                <a href="{{url ('/admin/settings')}}" class="lk-settings" ><i class="fa-solid fa-gears"></i> Configuración</a>
            </li>
            @endif            
        </ul>
    </div>
</div>

