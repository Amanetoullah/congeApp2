@extends('adminlte::page')

@section('title')
    Tableau de bord | Laravel Employés App
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">
            <i class="fas fa-tachometer-alt text-primary"></i>
            Tableau de bord
        </h1>
        <div class="d-flex">
            <span class="badge badge-primary badge-pill p-2 mr-2">
                <i class="fas fa-clock mr-1"></i>
                {{ now()->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 shadow-lg">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-2">
                                <i class="fas fa-hand-wave mr-2"></i>
                                Bienvenue, {{ Auth::user()->name }}!
                            </h3>
                            <p class="mb-0 opacity-75">
                                Gérez vos employés et départements depuis ce tableau de bord centralisé.
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="avatar-circle bg-white text-primary">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-primary mb-3">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <h2 class="text-primary mb-1">{{ $stats['total_employees'] }}</h2>
                    <p class="text-muted mb-3">Total Employés</p>
                    <a href="{{ route('admin.employes.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye mr-1"></i>Voir tous
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-success mb-3">
                        <i class="fas fa-building text-white"></i>
                    </div>
                    <h2 class="text-success mb-1">{{ $stats['total_departments'] }}</h2>
                    <p class="text-muted mb-3">Départements</p>
                    <a href="{{ route('admin.departement.index') }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-eye mr-1"></i>Gérer
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-warning mb-3">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                    <h2 class="text-warning mb-1">{{ $stats['total_conges'] ?? 0 }}</h2>
                    <p class="text-muted mb-3">Demandes de Congés</p>
                    <a href="{{ route('admin.conges.index') }}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-eye mr-1"></i>Approuver
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-info mb-3">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <h2 class="text-info mb-1">{{ $stats['total_employees'] > 0 ? round(($stats['total_employees'] / ($stats['total_employees'] + 10)) * 100) : 0 }}%</h2>
                    <p class="text-muted mb-3">Taux d'Occupation</p>
                    <button class="btn btn-outline-info btn-sm" onclick="showAnalytics()">
                        <i class="fas fa-chart-bar mr-1"></i>Analytics
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt text-primary mr-2"></i>
                        Actions Rapides
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.employes.create') }}" class="quick-action-card">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="quick-action-icon bg-primary mb-3">
                                            <i class="fas fa-user-plus text-white"></i>
                                        </div>
                                        <h6 class="mb-2">Nouvel Employé</h6>
                                        <small class="text-muted">Ajouter un employé</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.departement.create') }}" class="quick-action-card">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="quick-action-icon bg-success mb-3">
                                            <i class="fas fa-building text-white"></i>
                                        </div>
                                        <h6 class="mb-2">Nouveau Département</h6>
                                        <small class="text-muted">Créer un département</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('admin.conges.index') }}" class="quick-action-card">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="quick-action-icon bg-warning mb-3">
                                            <i class="fas fa-calendar-alt text-white"></i>
                                        </div>
                                        <h6 class="mb-2">Gérer Congés</h6>
                                        <small class="text-muted">Approuver les demandes</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-primary mr-2"></i>
                        Activité Récente
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="activity-list">
                        <div class="activity-item p-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="activity-icon bg-primary">
                                    <i class="fas fa-user-plus text-white"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="mb-1"><strong>Nouvel employé ajouté</strong></p>
                                    <small class="text-muted">Il y a 2 heures</small>
                                </div>
                            </div>
                        </div>
                        <div class="activity-item p-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="activity-icon bg-success">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="mb-1"><strong>Congé approuvé</strong></p>
                                    <small class="text-muted">Il y a 4 heures</small>
                                </div>
                            </div>
                        </div>
                        <div class="activity-item p-3">
                            <div class="d-flex align-items-center">
                                <div class="activity-icon bg-info">
                                    <i class="fas fa-building text-white"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="mb-1"><strong>Département mis à jour</strong></p>
                                    <small class="text-muted">Il y a 1 jour</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    transform: translateY(-5px);
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

.quick-action-card {
    text-decoration: none;
    color: inherit;
    display: block;
    transition: transform 0.2s ease;
}

.quick-action-card:hover {
    text-decoration: none;
    color: inherit;
    transform: translateY(-3px);
}

.quick-action-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin: 0 auto;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.avatar-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.bg-gradient-success {
    background: linear-gradient(45deg, #28a745, #20c997);
}

.bg-gradient-warning {
    background: linear-gradient(45deg, #ffc107, #fd7e14);
}

.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #6f42c1);
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

.activity-list {
    max-height: 300px;
    overflow-y: auto;
}

.activity-item {
    transition: background-color 0.2s ease;
}

.activity-item:hover {
    background-color: #f8f9fa;
}
</style>
@endsection

@section('js')
<script>
function showAnalytics() {
    Swal.fire({
        title: 'Analytics',
        text: 'Fonctionnalité d\'analytics à venir!',
        icon: 'info',
        confirmButtonText: 'OK'
    });
}
</script>
@endsection

