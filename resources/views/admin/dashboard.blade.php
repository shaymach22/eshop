@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">
        <i class="fas fa-cog me-2"></i>Dashboard Admin
    </h2>

    {{-- Statistiques --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card text-white bg-dark">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Produits</h6>
                        <h2 class="fw-bold">{{ $stats['products'] }}</h2>
                    </div>
                    <i class="fas fa-box fa-3x opacity-50"></i>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.products.index') }}" class="text-white">
                        Gérer <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Commandes</h6>
                        <h2 class="fw-bold">{{ $stats['orders'] }}</h2>
                    </div>
                    <i class="fas fa-shopping-bag fa-3x opacity-50"></i>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.orders.index') }}" class="text-white">
                        Gérer <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Utilisateurs</h6>
                        <h2 class="fw-bold">{{ $stats['users'] }}</h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Revenu total</h6>
                        <h2 class="fw-bold">{{ number_format($stats['revenue'], 2) }}</h2>
                    </div>
                    <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Commandes récentes --}}
    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between">
            <span><i class="fas fa-clock me-2"></i>Commandes récentes</span>
            <a href="{{ route('admin.orders.index') }}" class="text-white">Voir tout</a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td class="text-danger fw-bold">
                                {{ number_format($order->total, 2) }} DT
                            </td>
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
        </div>
    </div>
</div>
@endsection