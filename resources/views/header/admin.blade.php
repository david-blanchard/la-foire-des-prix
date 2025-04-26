@php
    $home = route('admin');
    $logo = '/assets/images/logos/lesprixbas_smaller.png';
@endphp

<header>
    <nav id="navbar0" class='navbar navbar-expand-md fixed-top navbar-dark bg-white shadow-sm'>
        <a class='navbar-brand mr-auto mr-lg-0' href='{{ $home }}'>
            <picture>
                <source 
                srcset="{{ $logo }}" media="(max-width: 1200px)" 
                srcset="{{ $logo }}" media="(min-width: 1200px)" 
                />
                <img id="logo" src='{{ $logo }}' alt='Les Prix Bas' />

            </picture>
        </a>

        <div id="subnavbar0" class='navbar-collapse offcanvas-collapse'>
            <ul class="navbar-nav navbar-dark mr-auto">
            </ul>
            @include('search.search_nav_bar')
            @include('user.user_nav_button')
        </div>
    </nav>

    <div id="placeholder" aria-label="placeholder">
    
    </div>
    
    <div id="subnavbar1" class='nav-scroller bg-light shadow-sm'>
        <nav class='nav nav-underline'>
            <div class='nav-item active'>
                <a class='nav-link  bg-light align-text-bottom' href='{{ $home }}'>
                    Accueil
                </a>
            </div>
            <div class='nav-item active'>
                <a class="nav-link  bg-light " href="{{ route('products.index') }}">
                    Gérer les produits
                </a>
            </div>
            <div class='nav-item active'>
                <a class="nav-link  bg-light " href="{{ route('product_images.index') }}">
                    Gérer les images par produit
                </a>
            </div>
            <div class='nav-item active'>
                <a class="nav-link  bg-light " href="{{ route('images.index') }}">
                    Gérer la bibliothèque d'images
                </a>
            </div>
            <div class='nav-item active'>
                <a class="nav-link  bg-light " href="{{ route('brands.index') }}">
                    Gérer les marques
                </a>
            </div>
        </nav>
    </div>
</header>
@include('admin.includes.alerts')
