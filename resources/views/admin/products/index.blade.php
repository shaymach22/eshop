@extends('layouts.app')

@section('title', 'Gestion Produits')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-box me-2"></i>Gestion des Produits
        </h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-dark">
            <i class="fas fa-plus me-2"></i>Nouveau produit
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         class="rounded">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center
                                                justify-content-center"
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $product->title }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                            </td>
                            <td class="text-danger fw-bold">
                                {{ number_format($product->price, 2) }} DT
                            </td>
                            <td>
                                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-sm btn-outline-dark">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Supprimer ce produit ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection