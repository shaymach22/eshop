@extends('layouts.app')

@section('title', 'Gestion Commandes')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">
        <i class="fas fa-shopping-bag me-2"></i>Gestion des Commandes
    </h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Paiement</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td class="text-danger fw-bold">
                                {{ number_format($order->total, 2) }} DT
                            </td>
                            <td>{{ ucfirst($order->payment_method) }}</td>
                            <td>
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
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="btn btn-sm btn-outline-dark">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection