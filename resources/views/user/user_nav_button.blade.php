@php
    $home = route('home');
    $admin_ui = route('admin');
    $login = "Connexion"; // __('Login')
    $register = "Pas encore inscrit ?"; // __('Register')
    $logout = "Déconnexion"; // __('Logout')
    $isAdmin = \App\Repositories\UserRepository::isAdmin();

@endphp

<button type="button" class="btn btn-secondary dropdown-toggle my-2 my-sm-0 ml-3" id="dropdown01" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
    @guest
        <i class="fa fa-user-circle"></i>
    @else
        <i class="fa fa-user-circle-o"></i>
    @endguest
</button>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby='dropdown01'>
    @guest
        @if (Route::has('login'))
            <a class="dropdown-item" href="{{ route('login') }}">{{ $login }}</a>
        @endif

        @if (Route::has('register'))
            <a class="dropdown-item" href="{{ route('register') }}">{{ $register }}</a>
        @endif
    @else
        <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ $logout }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endguest
    @if(!$isAdmin)
        <a class='dropdown-item' href='{{ $home }}'>F.A.Q</a>
        <a class='dropdown-item' href='{{ $home }}'>Mentions légales</a>
    @else
        <a class='dropdown-item' href='{{ $admin_ui }}'>Admin UI</a>
    @endif
</div>
