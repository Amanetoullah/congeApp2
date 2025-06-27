@extends('adminlte::page')

@section('title')
    Gestion des Départements | Laravel Employés App
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">
            <i class="fas fa-building text-primary"></i>
            Gestion des Départements
        </h1>
        <a href="{{ route('admin.departement.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i>Nouveau Département
        </a>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-primary mb-3">
                        <i class="fas fa-building text-white"></i>
                    </div>
                    <h2 class="text-primary mb-1">{{ $departements->count() }}</h2>
                    <p class="text-muted mb-0">Total Départements</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-success mb-3">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <h2 class="text-success mb-1">{{ $departements->sum(function($dept) { return $dept->users->count(); }) }}</h2>
                    <p class="text-muted mb-0">Total Employés</p>
                </div>
            </div>
        </div>
      
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-warning mb-3">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <h2 class="text-warning mb-1">{{ $departements->filter(function($dept) { return $dept->users->count() == 0; })->count() }}</h2>
                    <p class="text-muted mb-0">Départements Vides</p>
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
                    Liste des Départements
                </h5>
                <div class="d-flex">
                    <span class="badge badge-primary badge-pill p-2">
                        <i class="fas fa-building mr-1"></i>
                        {{ $departements->count() }} département(s)
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($departements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-gradient-primary text-white">
                            <tr>
                                <th class="border-0 py-3">
                                    <i class="fas fa-hashtag mr-1"></i>ID
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-building mr-1"></i>Nom
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-comment mr-1"></i>Description
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-users mr-1"></i>Employés
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-calendar mr-1"></i>Créé le
                                </th>
                                <th class="border-0 py-3 text-center">
                                    <i class="fas fa-cogs mr-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departements as $index => $departement)
                            <tr class="border-bottom">
                                <td class="align-middle">
                                    <span class="badge badge-secondary badge-pill">{{ $index + 1 }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="department-icon mr-3">
                                            <i class="fas fa-building text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold">{{ $departement->name }}</h6>
                                            <small class="text-muted">ID: {{ $departement->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">
                                        {{ $departement->description ? Str::limit($departement->description, 50) : 'Aucune description' }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-info badge-pill mr-2">
                                            {{ $departement->users->count() }}
                                        </span>
                                        <small class="text-muted">employé(s)</small>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ $departement->created_at->format('d/m/Y') }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-info btn-sm mr-1" 
                                                onclick="viewDepartment({{ $departement->id }})" 
                                                title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm mr-1" 
                                                onclick="editDepartment({{ $departement->id }}, '{{ addslashes($departement->name) }}', '{{ addslashes($departement->description ?? '') }}')" 
                                                title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($departement->users->count() == 0)
                                            <button type="button" class="btn btn-outline-danger btn-sm" 
                                                    onclick="deleteDepartment({{ $departement->id }}, '{{ addslashes($departement->name) }}')" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-outline-secondary btn-sm" disabled 
                                                    title="Impossible de supprimer - contient des employés">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-building text-muted mb-3" style="font-size: 4rem;"></i>
                        <h4 class="text-muted mb-2">Aucun département</h4>
                        <p class="text-muted mb-4">Vous n'avez pas encore créé de département.</p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createDepartmentModal">
                            <i class="fas fa-plus mr-1"></i>Créer le premier département
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Department Modal -->
<div class="modal fade" id="createDepartmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus mr-2"></i>Nouveau Département
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.departement.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-building mr-1"></i>Nom du département <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="name" required 
                               placeholder="Ex: Ressources Humaines">
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">
                            <i class="fas fa-comment mr-1"></i>Description
                        </label>
                        <textarea class="form-control" name="description" rows="3" 
                                  placeholder="Description du département (optionnel)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Department Modal -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit mr-2"></i>Modifier le Département
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editDepartmentForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name" class="form-label">
                            <i class="fas fa-building mr-1"></i>Nom du département <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_description" class="form-label">
                            <i class="fas fa-comment mr-1"></i>Description
                        </label>
                        <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i>Mettre à jour
                    </button>
                </div>
            </form>
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

.department-icon {
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

.modal-content {
    border-radius: 15px;
    border: none;
}

.modal-header {
    border-radius: 15px 15px 0 0;
}

.form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
</style>
@endsection

@section('js')
<script>
function editDepartment(id, name, description) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description || '';
    document.getElementById('editDepartmentForm').action = `/admin/departement/${id}`;
    $('#editDepartmentModal').modal('show');
}

function deleteDepartment(id, name) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: `Voulez-vous vraiment supprimer le département "${name}" ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/departement/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function viewDepartment(id) {
    window.location.href = `/admin/departement/${id}`;
}

@if (session()->has('message'))
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "{{ session()->get('message') }}",
        showConfirmButton: false,
        timer: 3000,
        toast: true
    });
@endif
</script>
@endsection
