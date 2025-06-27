@extends('adminlte::page')

@section('title')
    Détails du Département | Laravel Employés App
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">
            <i class="fas fa-building text-primary"></i>
            Détails du Département
        </h1>
        <div>
            <a href="{{ route('admin.departement.edit', $departement->id) }}" class="btn btn-warning">
                <i class="fas fa-edit mr-1"></i>Modifier
            </a>
            <a href="{{ route('admin.departement.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i>Retour
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Department Info Card -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations du Département
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-4">
                                <label class="text-muted font-weight-bold">
                                    <i class="fas fa-hashtag mr-1"></i>ID du Département
                                </label>
                                <p class="h5 text-primary">{{ $departement->id }}</p>
                            </div>
                            <div class="info-item mb-4">
                                <label class="text-muted font-weight-bold">
                                    <i class="fas fa-building mr-1"></i>Nom du Département
                                </label>
                                <p class="h4 font-weight-bold">{{ $departement->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-4">
                                <label class="text-muted font-weight-bold">
                                    <i class="fas fa-calendar mr-1"></i>Date de Création
                                </label>
                                <p class="h6">{{ $departement->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div class="info-item mb-4">
                                <label class="text-muted font-weight-bold">
                                    <i class="fas fa-clock mr-1"></i>Dernière Mise à Jour
                                </label>
                                <p class="h6">{{ $departement->updated_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    @if($departement->description)
                        <div class="info-item">
                            <label class="text-muted font-weight-bold">
                                <i class="fas fa-comment mr-1"></i>Description
                            </label>
                            <p class="lead">{{ $departement->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Statistiques
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="stats-item text-center mb-4">
                        <div class="stats-icon bg-gradient-primary mb-3">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <h2 class="text-primary mb-1">{{ $departement->users->count() }}</h2>
                        <p class="text-muted mb-0">Employés</p>
                    </div>
                    
                    @if($departement->users->count() > 0)
                        <div class="stats-item text-center mb-4">
                            <div class="stats-icon bg-gradient-info mb-3">
                                <i class="fas fa-calendar-check text-white"></i>
                            </div>
                            <h2 class="text-info mb-1">{{ $departement->conges->count() }}</h2>
                            <p class="text-muted mb-0">Congés Demandés</p>
                        </div>
                    @endif
                    
                    <div class="stats-item text-center">
                        <div class="stats-icon bg-gradient-warning mb-3">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <h2 class="text-warning mb-1">{{ $departement->users->where('created_at', '>=', now()->subDays(30))->count() }}</h2>
                        <p class="text-muted mb-0">Nouveaux (30j)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees List -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users mr-2"></i>
                    Employés du Département
                </h5>
                <span class="badge badge-primary badge-pill p-2">
                    <i class="fas fa-user mr-1"></i>
                    {{ $departement->users->count() }} employé(s)
                </span>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($departement->users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-gradient-info text-white">
                            <tr>
                                <th class="border-0 py-3">
                                    <i class="fas fa-user mr-1"></i>Employé
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-envelope mr-1"></i>Email
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-calendar mr-1"></i>Date d'Embauche
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-calendar-check mr-1"></i>Congés
                                </th>
                                <th class="border-0 py-3 text-center">
                                    <i class="fas fa-cogs mr-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departement->users as $user)
                            <tr class="border-bottom">
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar mr-3">
                                            @if($user->profile_photo_path)
                                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                                                     alt="{{ $user->name }}" class="rounded-circle" width="40" height="40">
                                            @else
                                                <div class="avatar-placeholder">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ $user->email }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ $user->created_at->format('d/m/Y') }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-info badge-pill">
                                        {{ $user->conges->count() }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('admin.employes.show', $user->id) }}" 
                                       class="btn btn-outline-info btn-sm" title="Voir le profil">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-users text-muted mb-3" style="font-size: 4rem;"></i>
                        <h4 class="text-muted mb-2">Aucun employé</h4>
                        <p class="text-muted mb-4">Ce département ne contient aucun employé pour le moment.</p>
                        <a href="{{ route('admin.employes.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>Ajouter un employé
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

.user-avatar {
    position: relative;
}

.avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
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

.info-item label {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.info-item p {
    margin-bottom: 0;
}
</style>
@endsection 