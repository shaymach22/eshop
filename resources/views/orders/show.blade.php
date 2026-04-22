@extends('layouts.app')

@section('title', 'Commande #' . $order->id)

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="fas fa-box me-2"></i>Commande #{{ $order->id }}
        </h2>
        <a href="{{ route('orders.history') }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row">
        {{-- Détails commande --}}
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-shopping-bag me-2"></i>Articles commandés
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
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                     style="width: 50px; height: 50px; object-fit: cover;"
                                                     class="rounded">
                                            @endif
                                            {{ $item->product->title }}
                                        </div>
                                    </td>
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

        {{-- Infos commande --}}
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-info-circle me-2"></i>Informations
                </div>
                <div class="card-body">
                    <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Paiement :</strong> {{ ucfirst($order->payment_method) }}</p>
                    <p><strong>Adresse :</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Statut :</strong>
                        @switch($order->status)
                            @case('pending')
                                <span class="badge bg-warning text-dark">En attente</span>
                                @break
                            @case('validated')
                                <span class="badge bg-success">Validée</span>
                                @break
                            @case('shipped')
                                <span class="badge bg-info">Expédiée</span>
                                @break
                            @case('cancelled')
                                <span class="badge bg-danger">Annulée</span>
                                @break
                        @endswitch
                    </p>

                    @if($order->status === 'pending')
                        <form action="{{ route('orders.cancel', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Annuler cette commande ?')">
                                <i class="fas fa-times me-2"></i>Annuler la commande
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection