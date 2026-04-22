@extends('layouts.app')

@section('title', 'Commande #' . $order->id)

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-shopping-bag me-2"></i>Commande #{{ $order->id }}
        </h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-shopping-bag me-2"></i>Articles
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->title }}</td>
                                    <td>{{ number_format($item->unit_price, 2) }} DT</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-danger fw-bold">
                                        {{ number_format($item->subtotal, 2) }} DT
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total</td>
                                <td class="text-danger fw-bold fs-5">
                                    {{ number_format($order->total, 2) }} DT
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-info-circle me-2"></i>Informations
                </div>
                <div class="card-body">
                    <p><strong>Client :</strong> {{ $order->user->name }}</p>
                    <p><strong>Email :</strong> {{ $order->user->email }}</p>
                    <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Paiement :</strong> {{ ucfirst($order->payment_method) }}</p>
                    <p><strong>Adresse :</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>

            {{-- Changer statut --}}
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-edit me-2"></i>Changer le statut
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-select mb-3">
                            <option value="pending"   {{ $order->status == 'pending'   ? 'selected' : '' }}>En attente</option>
                            <option value="validated" {{ $order->status == 'validated' ? 'selected' : '' }}>Validée</option>
                            <option value="shipped"   {{ $order->status == 'shipped'   ? 'selected' : '' }}>Expédiée</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        </select>
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-save me-2"></i>Mettre à jour
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection