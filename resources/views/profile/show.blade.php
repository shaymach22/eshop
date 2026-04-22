@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">
        <i class="fas fa-user-circle me-2"></i>Mon Profil
    </h2>

    <div class="row">
        {{-- Infos personnelles --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-user me-2"></i>Informations personnelles
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Avatar --}}
                        <div class="text-center mb-4">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}"
                                     class="rounded-circle mb-2"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center
                                            justify-content-center mx-auto mb-2"
                                     style="width: 100px; height: 100px;">
                                    <i class="fas fa-user fa-3x text-white"></i>
                                </div>
                            @endif
                            <div>
                                <input type="file" name="avatar" class="form-control form-control-sm"
                                       accept="image/*">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control"
                                   value="{{ $user->email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Téléphone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="+216 XX XXX XXX">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Adresse</label>
                            <textarea name="address" class="form-control" rows="3"
                                      placeholder="Votre adresse...">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-save me-2"></i>Enregistrer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Changer mot de passe --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-lock me-2"></i>Changer le mot de passe
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="form-control" required>
                            @error('current_password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-key me-2"></i>Modifier le mot de passe
                        </button>
                    </form>
                </div>
            </div>

            {{-- Statistiques --}}
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-chart-bar me-2"></i>Mes statistiques
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h3 class="text-danger fw-bold">{{ $user->orders->count() }}</h3>
                            <p class="text-muted mb-0">Commandes</p>
                        </div>
                        <div class="col-6">
                            <h3 class="text-danger fw-bold">{{ $user->reviews->count() }}</h3>
                            <p class="text-muted mb-0">Avis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection