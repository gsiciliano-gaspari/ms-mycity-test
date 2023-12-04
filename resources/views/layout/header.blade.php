<nav class="navbar navbar-expand-lg navbar navbar-light text-primary border-bottom">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ URL('/') }}">
            <strong>
                <span class="text-primary">
                    {{ $websiteTitle }}</span>
            </strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                            Registrati
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name . ' ' . Auth::user()->surname }}
                        </a>
                        <ul class="dropdown-menu">
                            @canany(['create-user', 'edit-user', 'delete-user'])
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.index') }}">
                                        Amministra Utenti
                                    </a>
                                </li>
                            @endcanany
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-left"></i>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
