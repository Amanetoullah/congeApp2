@extends('adminlte::page')

@section('title')
    Modifier le Département | Laravel Employés App
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">
            <i class="fas fa-edit text-warning"></i>
            Modifier le Département
        </h1>
        <a href="{{ route('admin.departement.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Retour
        </a>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-building mr-2"></i>
                        Modifier "{{ $departement->name }}"
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('admin.departement.update', $departement->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label font-weight-bold">
                                        <i class="fas fa-building mr-1"></i>Nom du département <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           name="name" 
                                           value="{{ old('name', $departement->name) }}" 
                                           required 
                                           placeholder="Ex: Ressources Humaines">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-users mr-1"></i>Nombre d'employés
                                    </label>
                                    <div class="form-control-plaintext">
                                        <span class="badge badge-info badge-pill">
                                            {{ $departement->users->count() }} employé(s)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description" class="form-label font-weight-bold">
                                <i class="fas fa-comment mr-1"></i>Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Description du département (optionnel)">{{ old('description', $departement->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-calendar mr-1"></i>Date de création
                                    </label>
                                    <div class="form-control-plaintext">
                                        {{ $departement->created_at->format('d/m/Y à H:i') }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-clock mr-1"></i>Dernière mise à jour
                                    </label>
                                    <div class="form-control-plaintext">
                                        {{ $departement->updated_at->format('d/m/Y à H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('admin.departement.show', $departement->id) }}" class="btn btn-outline-info">
                                    <i class="fas fa-eye mr-1"></i>Voir les détails
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('admin.departement.index') }}" class="btn btn-secondary mr-2">
                                    <i class="fas fa-times mr-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save mr-1"></i>Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Department Stats Card -->
            <div class="card shadow-lg border-0 mt-4">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Statistiques du Département
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="stats-item">
                                <div class="stats-icon bg-gradient-primary mb-3">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <h3 class="text-primary mb-1">{{ $departement->users->count() }}</h3>
                                <p class="text-muted mb-0">Employés</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-item">
                                <div class="stats-icon bg-gradient-success mb-3">
                                    <i class="fas fa-calendar-check text-white"></i>
                                </div>
                                <h3 class="text-success mb-1">{{ $departement->conges->count() }}</h3>
                                <p class="text-muted mb-0">Congés Demandés</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-item">
                                <div class="stats-icon bg-gradient-warning mb-3">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <h3 class="text-warning mb-1">{{ $departement->users->where('created_at', '>=', now()->subDays(30))->count() }}</h3>
                                <p class="text-muted mb-0">Nouveaux (30j)</p>
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

.form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #fa709a;
    box-shadow: 0 0 0 0.2rem rgba(250, 112, 154, 0.25);
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.form-control-plaintext {
    padding: 0.75rem 0;
    color: #6c757d;
    font-weight: 500;
}

.form-label {
    color: #495057;
    margin-bottom: 0.75rem;
}

.stats-item {
    padding: 1rem;
}
</style>
@endsection 