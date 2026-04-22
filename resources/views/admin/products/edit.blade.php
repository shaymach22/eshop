@extends('layouts.app')

@section('title', 'Modifier Produit')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-edit me-2"></i>Modifier : {{ $product->title }}
        </h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Titre</label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title', $product->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="5" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Prix (DT)</label>
                                    <input type="number" name="price" class="form-control"
                                           value="{{ old('price', $product->price) }}"
                                           step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Stock</label>
                                    <input type="number" name="stock" class="form-control"
                                           value="{{ old('stock', $product->stock) }}"
                                           min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Catégorie</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Image actuelle</label>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="img-fluid rounded mb-2" style="max-height: 150px;">
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="is_active" value="1"
                                       {{ $product->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold">Produit actif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save me-2"></i>Mettre à jour
                </button>
            </form>
        </div>
    </div>
</div>
@endsectionphpp