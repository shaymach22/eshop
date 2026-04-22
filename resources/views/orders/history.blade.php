@extends('layouts.app')

@section('title', 'Mes Commandes')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">
        <i class="fas fa-box me-2"></i>Mes Commandes
    </h2>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-5x text-muted mb-4"></i>
            <h4 class="text-muted">Aucune commande pour l'instant</h4>
            <a href="{{ route('catalog.index') }}" class="btn btn-dark mt-3">
                <i class="fas fa-shopping-cart me-2"></i>Commencer mes achats
            </a>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Articles</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>{{ $order->items->count() }} article(s)</td>
                                <td class="text-danger fw-bold">
                                    {{ number_format($order->total, 2) }} DT
                                </td>
                                <td>
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock me-1"></i>En attente
                                            </span>
                                            @break
                                        @case('validated')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Validée
                                            </span>
                                            @break
                                        @case('shipped')
                                            <span class="badge bg-info">
                                                <i class="fas fa-truck me-1"></i>Expédiée
                                            </span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Annulée
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="btn btn-sm btn-outline-dark">
                                        <i class="fas fa-eye me-1"></i>Détails
                                    </a>
                                    @if($order->status === 'pending')
                                        <form action="{{ route('orders.cancel', $order) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Annuler cette commande ?')">
                                                <i class="fas fa-times me-1"></i>Annuler
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $orders->links() }}
            </div>
        </div>
    @endif
</div>
@endsection