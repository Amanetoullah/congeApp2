@extends('adminlte::page')

@section('title', 'Gestion des Congés | Laravel Employés App')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
@endpush

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">
            <i class="fas fa-calendar-alt text-primary"></i>
            Gestion des Congés
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
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-warning mb-3">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <h2 class="text-warning mb-1">{{ $conges->where('statut', 'En attente')->count() }}</h2>
                    <p class="text-muted mb-3">En Attente</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-success mb-3">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <h2 class="text-success mb-1">{{ $conges->where('statut', 'Approuve')->count() }}</h2>
                    <p class="text-muted mb-3">Approuvés</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-danger mb-3">
                        <i class="fas fa-times text-white"></i>
                    </div>
                    <h2 class="text-danger mb-1">{{ $conges->where('statut', 'Refuser')->count() }}</h2>
                    <p class="text-muted mb-3">Refusés</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center p-4">
                    <div class="stats-icon bg-gradient-info mb-3">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                    <h2 class="text-info mb-1">{{ $conges->count() }}</h2>
                    <p class="text-muted mb-3">Total Demandes</p>
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
                    Liste des Demandes de Congé
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
                                    <i class="fas fa-hashtag mr-1"></i>ID
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-user mr-1"></i>Employé
                                </th>
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
                                    <i class="fas fa-file-alt mr-1"></i>Justificatif
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-info-circle mr-1"></i>Statut
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-comment mr-1"></i>Motif
                                </th>
                                <th class="border-0 py-3 text-center">
                                    <i class="fas fa-cogs mr-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($conges as $index => $conge)
                            <tr class="border-bottom">
                                <td class="align-middle">
                                    <span class="badge badge-secondary badge-pill">{{ $index + 1 }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            @if ($conge->user->image && $conge->user->image !== 'images/default-avatar.png')
                                                <img src="{{ asset('storage/' . $conge->user->image) }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold">{{ $conge->user->name }}</h6>
                                            <small class="text-muted">{{ $conge->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-info badge-pill text-capitalize">{{ $conge->type }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}</span>
                                </td>
                                <td class="align-middle">
                                    @if($conge->justificatif)
                                        <a href="/storage{{ $conge->justificatif }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-file-alt mr-1"></i>Voir
                                        </a>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-times mr-1"></i>Aucun
                                        </span>
                                    @endif
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
                                <td class="align-middle text-center">
                                    @if($conge->statut == 'En attente')
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-sm mr-1" 
                                                    onclick="approveConge({{ $conge->id }}, '{{ $conge->user->name }}')" 
                                                    title="Approuver">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm mr-1" 
                                                    onclick="rejectConge({{ $conge->id }}, '{{ $conge->user->name }}')" 
                                                    title="Refuser">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" 
                                                    onclick="viewCongeDetails({{ $conge->id }})" 
                                                    title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="badge badge-{{ $conge->statut == 'Approuve' ? 'success' : 'danger' }} badge-pill mb-1">
                                                {{ $conge->statut == 'Approuve' ? 'Approuvé' : 'Refusé' }}
                                            </span>
                                            <small class="text-muted">{{ $conge->updated_at->format('d/m/Y') }}</small>
                                        </div>
                                    @endif
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
                        <p class="text-muted mb-4">Aucune demande de congé n'a été soumise pour le moment.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Conge Modal -->
<div class="modal fade" id="approveCongeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check mr-2"></i>Approuver la Demande
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="approveCongeForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Vous êtes sur le point d'approuver la demande de congé de <strong id="approveEmployeeName"></strong>.
                    </div>
                    <div class="form-group">
                        <label for="approve_remarque" class="form-label">
                            <i class="fas fa-comment mr-1"></i>Remarque (optionnel)
                        </label>
                        <textarea class="form-control" name="remarque" id="approve_remarque" rows="3" 
                                  placeholder="Ajoutez une remarque pour l'employé..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check mr-1"></i>Approuver
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Conge Modal -->
<div class="modal fade" id="rejectCongeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times mr-2"></i>Refuser la Demande
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="rejectCongeForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Vous êtes sur le point de refuser la demande de congé de <strong id="rejectEmployeeName"></strong>.
                    </div>
                    <div class="form-group">
                        <label for="reject_remarque" class="form-label">
                            <i class="fas fa-comment mr-1"></i>Motif du refus <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" name="remarque" id="reject_remarque" rows="3" required
                                  placeholder="Expliquez le motif du refus..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times mr-1"></i>Refuser
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Conge Details Modal -->
<div class="modal fade" id="viewCongeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye mr-2"></i>Détails de la Demande
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="congeDetailsContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>

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

.bg-gradient-danger {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
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

.avatar-sm {
    flex-shrink: 0;
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
function approveConge(congeId, employeeName) {
    document.getElementById('approveEmployeeName').textContent = employeeName;
    document.getElementById('approveCongeForm').action = `/admin/conges/${congeId}/accept`;
    $('#approveCongeModal').modal('show');
}

function rejectConge(congeId, employeeName) {
    document.getElementById('rejectEmployeeName').textContent = employeeName;
    document.getElementById('rejectCongeForm').action = `/admin/conges/${congeId}/refuse`;
    $('#rejectCongeModal').modal('show');
}

function viewCongeDetails(congeId) {
    // Load conge details via AJAX
    fetch(`/admin/conges/${congeId}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('congeDetailsContent').innerHTML = html;
            $('#viewCongeModal').modal('show');
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Impossible de charger les détails du congé'
            });
        });
}

// Form validation
document.getElementById('rejectCongeForm').addEventListener('submit', function(e) {
    const remarque = document.getElementById('reject_remarque').value.trim();
    if (!remarque) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Champ requis',
            text: 'Veuillez saisir un motif de refus.',
            confirmButtonColor: '#ffc107'
        });
        return;
    }
});

// Success/Error messages
@if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: "{{ session('success') }}",
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
@endif

@if (session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: "{{ session('error') }}",
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
@endif
</script>
@endsection
    

