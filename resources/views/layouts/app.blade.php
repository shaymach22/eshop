<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-size: 1.5rem; }
        .product-card { transition: transform 0.2s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .badge-cart { font-size: 0.6rem; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="fas fa-store me-2"></i>E-Shop
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <form class="d-flex mx-auto w-50" action="{{ route('catalog.index') }}" method="GET">
                <input class="form-control me-2" type="search" name="search"
                       placeholder="Rechercher un produit..."
                       value="{{ request('search') }}">
                <button class="btn btn-outline-warning" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('catalog.index') }}">Catalogue</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger badge-cart">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="fas fa-user me-2"></i>Mon profil
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.history') }}">
                                <i class="fas fa-box me-2"></i>Mes commandes
                            </a></li>
                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-cog me-2"></i>Administration
                                </a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-3">
    @foreach (['success' => 'success', 'error' => 'danger', 'warning' => 'warning'] as $type => $class)
        @if(session($type))
            <div class="alert alert-{{ $class }} alert-dismissible fade show">
                {{ session($type) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach
</div>

<main class="py-4">
    @yield('content')
</main>

<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p class="mb-0">&copy; {{ date('Y') }} E-Shop. Tous droits réservés.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>