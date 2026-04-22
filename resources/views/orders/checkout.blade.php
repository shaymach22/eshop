@extends('layouts.app')

@section('title', 'Commander')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">
        <i class="fas fa-credit-card me-2"></i>Finaliser la commande
    </h2>

    <div class="row">
        {{-- Formulaire --}}
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-map-marker-alt me-2"></i>Informations de livraison
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Adresse de livraison</label>
                            <textarea name="shipping_address" class="form-control" rows="3"
                                      placeholder="Votre adresse complète..." required>{{ auth()->user()->address }}</textarea>
                            @error('shipping_address')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Mode de paiement</label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio"
                                               name="payment_method" value="cash" checked>
                                        <label class="form-check-label">
                                            <i class="fas fa-money-bill text-success me-2"></i>Cash
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio"
                                               name="payment_method" value="card">
                                        <label class="form-check-label">
                                            <i class="fas fa-credit-card text-primary me-2"></i>Carte
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio"
                                               name="payment_method" value="paypal">
                                        <label class="form-check-label">
                                            <i class="fab fa-paypal text-info me-2"></i>PayPal
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2">
                            <i class="fas fa-check me-2"></i>Confirmer la commande
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Résumé commande --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-receipt me-2"></i>Résumé de la commande
                </div>
                <div class="card-body">
                    @foreach($cart as $id => $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item['title'] }}
                                <span class="badge bg-secondary">x{{ $item['quantity'] }}</span>
                            </span>
                            <strong>{{ number_format($item['price'] * $item['quantity'], 2) }} DT</strong>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong class="text-danger fs-5">{{ number_format($total, 2) }} DT</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection