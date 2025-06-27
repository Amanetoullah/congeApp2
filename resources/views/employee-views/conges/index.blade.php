@extends('layouts.user')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <div class="w-100">

        <x-toast :message="session('success')" type="success" />
        <x-toast :message="session('error')" type="danger" />
    </div>

    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-calendar-alt text-primary mr-2"></i>
                    Mes Congés
                </h2>
                <a href="{{ route('employes.conge.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i>Nouvelle Demande
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-primary mb-3">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                    <h3 class="text-primary mb-1">{{ $conges->where('statut', 'Approuve')->count() }}</h3>
                    <p class="text-muted mb-0">Approuvés</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-warning mb-3">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <h3 class="text-warning mb-1">{{ $conges->where('statut', 'En attente')->count() }}</h3>
                    <p class="text-muted mb-0">En Attente</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-danger mb-3">
                        <i class="fas fa-times text-white"></i>
                    </div>
                    <h3 class="text-danger mb-1">{{ $conges->where('statut', 'Refuser')->count() }}</h3>
                    <p class="text-muted mb-0">Refusés</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-info mb-3">
                        <i class="fas fa-list text-white"></i>
                    </div>
                    <h3 class="text-info mb-1">{{ $conges->count() }}</h3>
                    <p class="text-muted mb-0">Total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list mr-2"></i>
                    Historique des Demandes
                </h5>
                <div class="d-flex">
                    <span class="badge badge-primary badge-pill p-2">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $conges->count() }} demande(s)
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($conges->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-gradient-primary text-white">
                            <tr>
                                <th class="border-0 py-3">
                                    <i class="fas fa-calendar mr-1"></i>Type
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-calendar-day mr-1"></i>Date Début
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-calendar-day mr-1"></i>Date Fin
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-info-circle mr-1"></i>Statut
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-comment mr-1"></i>Motif
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-clock mr-1"></i>Durée
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($conges as $conge)
                            <tr class="border-bottom">
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="leave-type-icon mr-3">
                                            @if($conge->type == 'Congé annuel')
                                                <i class="fas fa-umbrella-beach text-primary"></i>
                                            @elseif($conge->type == 'Congé maladie')
                                                <i class="fas fa-heartbeat text-danger"></i>
                                            @elseif($conge->type == 'Congé maternité')
                                                <i class="fas fa-baby text-pink"></i>
                                            @elseif($conge->type == 'Congé paternité')
                                                <i class="fas fa-male text-info"></i>
                                            @else
                                                <i class="fas fa-calendar-alt text-secondary"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold">{{ $conge->type }}</h6>
                                            <small class="text-muted">{{ $conge->created_at->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">
                                        <i class="fas fa-play text-success mr-1"></i>
                                        {{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">
                                        <i class="fas fa-stop text-danger mr-1"></i>
                                        {{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    @if($conge->statut == 'Approuve')
                                        <span class="badge badge-success badge-pill">
                                            <i class="fas fa-check mr-1"></i>Approuvé
                                        </span>
                                    @elseif($conge->statut == 'Refuser')
                                        <span class="badge badge-danger badge-pill">
                                            <i class="fas fa-times mr-1"></i>Refusé
                                        </span>
                                    @else
                                        <span class="badge badge-warning badge-pill">
                                            <i class="fas fa-clock mr-1"></i>En attente
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ $conge->motif ?? '-' }}</span>
                                </td>
                                <td class="align-middle">
                                    @php
                                        $start = \Carbon\Carbon::parse($conge->date_debut);
                                        $end = \Carbon\Carbon::parse($conge->date_fin);
                                        $duration = $start->diffInDays($end) + 1;
                                    @endphp
                                    <span class="badge badge-light badge-pill">
                                        <i class="fas fa-calendar-day mr-1"></i>
                                        {{ $duration }} jour(s)
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 4rem;"></i>
                        <h4 class="text-muted mb-2">Aucune demande de congé</h4>
                        <p class="text-muted mb-4">Vous n'avez pas encore soumis de demande de congé.</p>
                        <a href="{{ route('employes.conge.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>Créer ma première demande
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection


@section('css')
<style>
.card {
    border-radius: 15px;
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto;
}

.leave-type-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(0, 123, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.btn {
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.15);
}

.badge {
    border-radius: 20px;
    padding: 0.5em 1em;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
}

.empty-state {
    padding: 2rem;
}

.text-pink {
    color: #e91e63;
}
</style>
@endsection

