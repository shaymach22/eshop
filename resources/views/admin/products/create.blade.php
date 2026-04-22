@extends('layouts.app')

@section('title', 'Nouveau Produit')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-plus me-2"></i>Nouveau Produit
        </h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Titre</label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Prix (DT)</label>
                                    <input type="number" name="price" class="form-control"
                                           value="{{ old('price') }}" step="0.01" min="0" required>
                                    @error('price')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Stock</label>
                                    <input type="number" name="stock" class="form-control"
                                           value="{{ old('stock', 0) }}" min="0" required>
                                    @error('stock')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Catégorie</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Choisir...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @error('image')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="is_active" value="1"
                                       {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold">Produit actif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-save me-2"></i>Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection