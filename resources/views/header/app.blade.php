@php
    $home = route('default');
    $logo_desktop = '/assets/images/logos/lesprixbas_small.png';
    $logo_mobile = '/assets/images/logos/lesprixbas_smaller.png';
@endphp

<header>
    <nav id="navbar0" class='navbar navbar-expand-md fixed-top navbar-dark bg-white shadow-sm'>
        <a class='navbar-brand mr-auto mr-lg-0' href='{{ $home }}'>
            <picture>
                <source 
                srcset="{{ $logo_mobile }}" media="(max-width: 1200px)" 
                srcset="{{ $logo_desktop }}" media="(min-width: 1200px)" 
                />
                <img id="logo" src='{{ $logo_desktop }}' alt='Les Prix Bas' />

            </picture>
        </a>

        <div id="subnavbar0" class='navbar-collapse offcanvas-collapse'>
            <ul class="navbar-nav navbar-dark mr-auto">
            </ul>
            @include('search.search_nav_bar')
            @include('cart.cart_nav_button')
            @include('user.user_nav_button')
        </div>
        
 
    </nav>

    <div id="placeholder" aria-label="placeholder">
    
    </div>
    
    <div id="subnavbar1" class='nav-scroller bg-light shadow-sm'>
        <nav class='nav nav-underline'>
            <div class='nav-item active'>
                <a class='nav-link  bg-light align-text-bottom' href='{{ $home }}'>Tous nos rayons <span class='sr-only'>(current)</span></a>
            </div>
        </nav>
    </div>
</header>
