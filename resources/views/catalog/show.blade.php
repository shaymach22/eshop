@extends('layouts.app')

@section('title', $product->title)

@section('content')
<div class="container">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Catalogue</a></li>
            <li class="breadcrumb-item active">{{ $product->title }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Image --}}
        <div class="col-md-5">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="img-fluid rounded shadow" alt="{{ $product->title }}">
            @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded"
                     style="height: 400px;">
                    <i class="fas fa-image fa-5x"></i>
                </div>
            @endif
        </div>

        {{-- Détails --}}
        <div class="col-md-7">
            <span class="badge bg-primary mb-2">{{ $product->category->name }}</span>
            <h2 class="fw-bold">{{ $product->title }}</h2>

            {{-- Étoiles --}}
            <div class="mb-3">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $product->average_rating ? 'text-warning' : 'text-muted' }}"></i>
                @endfor
                <span class="text-muted ms-2">({{ $product->reviews->count() }} avis)</span>
            </div>

            <h3 class="text-danger fw-bold mb-3">{{ number_format($product->price, 2) }} DT</h3>

            <p class="text-muted">{{ $product->description }}</p>

            {{-- Stock --}}
            <div class="mb-3">
                @if($product->stock > 0)
                    <span class="badge bg-success">
                        <i class="fas fa-check me-1"></i>En stock ({{ $product->stock }})
                    </span>
                @else
                    <span class="badge bg-danger">
                        <i class="fas fa-times me-1"></i>Rupture de stock
                    </span>
                @endif
            </div>

            {{-- Ajouter au panier --}}
            @if($product->stock > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1"
                           max="{{ $product->stock }}" class="form-control w-25">
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Avis --}}
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="fw-bold mb-4">
                <i class="fas fa-star text-warning me-2"></i>Avis clients
            </h4>

            {{-- Formulaire avis --}}
            @auth
                <div class="card mb-4">
                    <div class="card-header">Laisser un avis</div>
                    <div class="card-body">
                        <form action="{{ route('reviews.store', $product) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Note</label>
                                <select name="rating" class="form-select w-25" required>
                                    <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                    <option value="4">⭐⭐⭐⭐ Bien</option>
                                    <option value="3">⭐⭐⭐ Moyen</option>
                                    <option value="2">⭐⭐ Mauvais</option>
                                    <option value="1">⭐ Très mauvais</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Commentaire</label>
                                <textarea name="comment" class="form-control" rows="3"
                                          placeholder="Votre avis..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-paper-plane me-2"></i>Envoyer
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}">Connectez-vous</a> pour laisser un avis.
                </div>
            @endauth

            {{-- Liste des avis --}}
            @forelse($product->reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $review->user->name }}</strong>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        @if($review->comment)
                            <p class="mt-2 mb-0">{{ $review->comment }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-muted">Aucun avis pour ce produit.</p>
            @endforelse
        </div>
    </div>

    {{-- Produits similaires --}}
    @if($related->count() > 0)
        <div class="row mt-5">
            <h4 class="fw-bold mb-4">Produits similaires</h4>
            @foreach($related as $item)
                <div class="col-md-3">
                    <div class="card product-card h-100">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}"
                                 class="card-img-top" style="height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                 style="height: 150px;">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h6>{{ $item->title }}</h6>
                            <p class="text-danger fw-bold">{{ number_format($item->price, 2) }} DT</p>
                            <a href="{{ route('products.show', $item->slug) }}"
                               class="btn btn-outline-dark btn-sm w-100">Voir</a>
                        </div>