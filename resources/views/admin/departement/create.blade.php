@extends('adminlte::page')

@section('title')
    Créer un Département | Laravel Employés App
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">
            <i class="fas fa-plus text-success"></i>
            Créer un Nouveau Département
        </h1>
        <a href="{{ route('admin.departement.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Retour à la liste
        </a>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-building mr-2"></i>
                        Informations du Département
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('admin.departement.store') }}" method="POST" id="createDepartmentForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="name" class="form-label font-weight-bold">
                                        <i class="fas fa-building mr-1"></i>Nom du département <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           name="name" 
                                           id="name"
                                           value="{{ old('name') }}" 
                                           required 
                                           placeholder="Ex: Ressources Humaines, Informatique, Marketing..."
                                           maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Le nom doit être unique et descriptif
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-info-circle mr-1"></i>Statut
                                    </label>
                                    <div class="form-control-plaintext">
                                        <span class="badge badge-success badge-pill">
                                            <i class="fas fa-plus mr-1"></i>Nouveau
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
                                      id="description"
                                      rows="4" 
                                      placeholder="Décrivez le rôle et les responsabilités de ce département..."
                                      maxlength="500">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Description optionnelle mais recommandée
                                </small>
                                <small class="text-muted">
                                    <span id="charCount">0</span>/500 caractères
                                </small>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="fas fa-undo mr-1"></i>Réinitialiser
                                </button>
                            </div>
                            <div>
                                <a href="{{ route('admin.departement.index') }}" class="btn btn-secondary mr-2">
                                    <i class="fas fa-times mr-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <i class="fas fa-save mr-1"></i>Créer le Département
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Guidelines Card -->
            <div class="card shadow-lg border-0 mt-4">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Conseils pour la Création
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="guideline-item mb-3">
                                <div class="guideline-icon bg-primary">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                                <div class="guideline-content">
                                    <h6 class="font-weight-bold">Nom Clair</h6>
                                    <p class="text-muted mb-0">Utilisez un nom court et compréhensible</p>
                                </div>
                            </div>
                            <div class="guideline-item mb-3">
                                <div class="guideline-icon bg-success">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <div class="guideline-content">
                                    <h6 class="font-weight-bold">Organisation</h6>
                                    <p class="text-muted mb-0">Pensez à la structure de votre entreprise</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="guideline-item mb-3">
                                <div class="guideline-icon bg-warning">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                                <div class="guideline-content">
                                    <h6 class="font-weight-bold">Évitez les Doublons</h6>
                                    <p class="text-muted mb-0">Chaque nom de département doit être unique</p>
                                </div>
                            </div>
                            <div class="guideline-item mb-3">
                                <div class="guideline-icon bg-info">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                                <div class="guideline-content">
                                    <h6 class="font-weight-bold">Description Utile</h6>
                                    <p class="text-muted mb-0">Ajoutez une description pour clarifier le rôle</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats Card -->
            <div class="card shadow-lg border-0 mt-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Statistiques Actuelles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="stats-item">
                                <div class="stats-icon bg-gradient-primary mb-2">
                                    <i class="fas fa-building text-white"></i>
                                </div>
                                <h4 class="text-primary mb-1">{{ \App\Models\Departement::count() }}</h4>
                                <p class="text-muted mb-0">Départements Existants</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-item">
                                <div class="stats-icon bg-gradient-success mb-2">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <h4 class="text-success mb-1">{{ \App\Models\User::count() }}</h4>
                                <p class="text-muted mb-0">Total Employés</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-item">
                                <div class="stats-icon bg-gradient-info mb-2">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <h4 class="text-info mb-1">+1</h4>
                                <p class="text-muted mb-0">Nouveau Département</p>
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
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin: 0 auto;
}

.guideline-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    margin-right: 1rem;
}

.guideline-item {
    display: flex;
    align-items: center;
}

.guideline-content h6 {
    margin-bottom: 0.25rem;
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
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
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

.form-text {
    font-size: 0.875rem;
}

#charCount {
    font-weight: bold;
    color: #6c757d;
}

.form-control:focus + .form-text {
    color: #28a745;
}
</style>
@endsection

@section('js')
<script>
// Character counter for description
document.getElementById('description').addEventListener('input', function() {
    const maxLength = 500;
    const currentLength = this.value.length;
    const charCount = document.getElementById('charCount');
    
    charCount.textContent = currentLength;
    
    if (currentLength > maxLength * 0.9) {
        charCount.style.color = '#dc3545';
    } else if (currentLength > maxLength * 0.7) {
        charCount.style.color = '#ffc107';
    } else {
        charCount.style.color = '#6c757d';
    }
});

// Form validation
document.getElementById('createDepartmentForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const submitBtn = document.getElementById('submitBtn');
    
    if (!name) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Erreur de validation',
            text: 'Le nom du département est requis.',
            confirmButtonColor: '#dc3545'
        });
        return;
    }
    
    // Disable submit button to prevent double submission
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Création en cours...';
});

// Reset form function
function resetForm() {
    Swal.fire({
        title: 'Réinitialiser le formulaire ?',
        text: 'Toutes les données saisies seront effacées.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, réinitialiser',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('createDepartmentForm').reset();
            document.getElementById('charCount').textContent = '0';
            document.getElementById('charCount').style.color = '#6c757d';
        }
    });
}

// Auto-save draft (optional feature)
let autoSaveTimer;
document.getElementById('name').addEventListener('input', function() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
        const formData = {
            name: document.getElementById('name').value,
            description: document.getElementById('description').value
        };
        localStorage.setItem('departmentDraft', JSON.stringify(formData));
    }, 1000);
});

// Load draft on page load
window.addEventListener('load', function() {
    const draft = localStorage.getItem('departmentDraft');
    if (draft) {
        const formData = JSON.parse(draft);
        if (formData.name || formData.description) {
            Swal.fire({
                title: 'Brouillon trouvé',
                text: 'Voulez-vous charger le brouillon sauvegardé ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, charger',
                cancelButtonText: 'Non, commencer à nouveau'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('name').value = formData.name || '';
                    document.getElementById('description').value = formData.description || '';
                    document.getElementById('charCount').textContent = (formData.description || '').length;
                } else {
                    localStorage.removeItem('departmentDraft');
                }
            });
        }
    }
});

// Clear draft on successful submission
document.getElementById('createDepartmentForm').addEventListener('submit', function() {
    localStorage.removeItem('departmentDraft');
});

@if (session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: "{{ session('error') }}",
        confirmButtonColor: '#dc3545'
    });
@endif
</script>
@endsection 