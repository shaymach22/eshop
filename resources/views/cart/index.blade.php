@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">
        <i class="fas fa-shopping-cart me-2"></i>Mon Panier
    </h2>

    @if(empty($cart))
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
            <h4 class="text-muted">Votre panier est vide</h4>
            <a href="{{ route('catalog.index') }}" class="btn btn-dark mt-3">
                <i class="fas fa-arrow-left me-2"></i>Continuer les achats
            </a>
        </div>
    @else
        <div class="row">
            {{-- Articles --}}
            <div class="col-md-8">
                @foreach($cart as $id => $item)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                {{-- Image --}}
                                <div class="col-md-2">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}"
                                             class="img-fluid rounded" style="height: 70px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                             style="height: 70px;">
                                            <i class="fas fa-image text-white"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- Titre + Prix --}}
                                <div class="col-md-4">
                                    <h6 class="mb-0">{{ $item['title'] }}</h6>
                                    <small class="text-danger fw-bold">
                                        {{ number_format($item['price'], 2) }} DT
                                    </small>
                                </div>

                                {{-- Quantité --}}
                                <div class="col-md-3">
                                    <form action="{{ route('cart.update', $id) }}" method="POST"
                                          class="d-flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity"
                                               value="{{ $item['quantity'] }}"
                                               min="1" class="form-control form-control-sm w-75">
                                        <button type="submit" class="btn btn-sm btn-outline-dark">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    </form>
                                </div>

                                {{-- Sous-total --}}
                                <div class="col-md-2 text-center">
                                    <strong class="text-danger">
                                        {{ number_format($item['price'] * $item['quantity'], 2) }} DT
                                    </strong>
                                </div>

                                {{-- Supprimer --}}
                                <div class="col-md-1 text-end">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Vider le panier --}}
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash me-2"></i>Vider le panier
                    </button>
                </form>
            </div>

            {{-- Résumé --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-receipt me-2"></i>Résumé
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sous-total</span>
                            <strong>{{ number_format($total, 2) }} DT</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Livraison</span>
                            <span class="text-success">Gratuite</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong class="text-danger fs-5">{{ number_format($total, 2) }} DT</strong>
                        </div>

                        @auth
                            <a href="{{ route('orders.checkout') }}" class="btn btn-dark w-100">
                                <i class="fas fa-credit-card me-2"></i>Commander
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-dark w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Connectez-vous pour commander
                            </a>
                        @endauth

                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-dark w-100 mt-2">
                            <i class="fas fa-arrow-left me-2"></i>Continuer les achats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection