@extends('layouts.app')

@section('title', 'Catalogue')

@section('content')
<div class="container">
    <div class="row">

        {{-- Sidebar Filtres --}}
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-filter me-2"></i>Filtres
                </div>
                <div class="card-body">
                    <form action="{{ route('catalog.index') }}" method="GET">

                        {{-- Catégories --}}
                        <h6 class="fw-bold">Catégories</h6>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category"
                                       value="" {{ !request('category') ? 'checked' : '' }}>
                                <label class="form-check-label">Toutes</label>
                            </div>
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="category" value="{{ $category->id }}"
                                           {{ request('category') == $category->id ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $category->name }}
                                        <span class="badge bg-secondary">{{ $category->products_count }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        {{-- Prix --}}
                        <h6 class="fw-bold">Prix</h6>
                        <div class="mb-2">
                            <input type="number" class="form-control form-control-sm"
                                   name="min_price" placeholder="Min" value="{{ request('min_price') }}">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control form-control-sm"
                                   name="max_price" placeholder="Max" value="{{ request('max_price') }}">
                        </div>

                        {{-- Tri --}}
                        <h6 class="fw-bold">Trier par</h6>
                        <select name="sort" class="form-select form-select-sm mb-3">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récent</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                        </select>

                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-search me-2"></i>Filtrer
                        </button>
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            Réinitialiser
                        </a>
                    </form>
                </div>
            </div>
        </div>

        {{-- Produits --}}
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Nos Produits <span class="badge bg-secondary">{{ $products->total() }}</span></h4>
            </div>

            @if($products->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Aucun produit trouvé.
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($products as $product)
                        <div class="col">
                            <div class="card h-100 product-card">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="card-img-top" style="height: 200px; object-fit: cover;"
                                         alt="{{ $product->title }}">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                         style="height: 200px;">
                                        <i class="fas fa-image fa-3x"></i>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <span class="badge bg-primary mb-1">{{ $product->category->name }}</span>
                                    <h6 class="card-title">{{ $product->title }}</h6>
                                    <p class="text-danger fw-bold">{{ number_format($product->price, 2) }} DT</p>

                                    {{-- Étoiles --}}
                                    <div class="mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $product->average_rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                        <small class="text-muted">({{ $product->reviews->count() }})</small>
                                    </div>
                                </div>

                                <div class="card-footer d-flex gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}"
                                       class="btn btn-outline-dark btn-sm flex-fill">
                                        <i class="fas fa-eye me-1"></i>Voir
                                    </a>
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-dark btn-sm"
                                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection