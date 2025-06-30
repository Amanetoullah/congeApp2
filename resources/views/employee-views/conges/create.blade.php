@extends('layouts.user')

@section('title', 'Nouvelle Demande de Congé')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-plus text-primary mr-1"></i>
                        Nouvelle Demande
                    </h4>
                    <p class="text-muted mb-0 small">Soumettez votre demande de congé</p>
                </div>
                <a href="{{ route('employes.conge.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-2">
                    <h5 class="mb-0"><i class="fas fa-calendar-plus mr-1"></i> Formulaire de Demande</h5>
                </div>
                
                <div class="card-body p-3">
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show py-2 mb-2" role="alert">
                            <i class="fas fa-check-circle mr-1"></i>
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show py-2 mb-2" role="alert">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            <strong>Erreurs :</strong>
                            <ul class="mb-0 pl-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('employes.conge.store') }}" method="POST" enctype="multipart/form-data" id="leaveForm">
                        @csrf

                        <!-- Leave Type Section -->
                        <div class="mb-3">
                            <h6 class="font-weight-bold mb-2"><i class="fas fa-tag mr-1"></i> Type de Congé</h6>
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold mb-1">Type <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-control form-control-sm" required>
                                    <option value="">Sélectionnez un type</option>
                                    <option value="Congé annuel" {{ old('type') == 'Congé annuel' ? 'selected' : '' }}>
                                        Congé annuel
                                    </option>
                                    <option value="Congé maladie" {{ old('type') == 'Congé maladie' ? 'selected' : '' }}>
                                        Congé maladie
                                    </option>
                                    <option value="Congé maternité" {{ old('type') == 'Congé maternité' ? 'selected' : '' }}>
                                        Congé maternité
                                    </option>
                                    <option value="Congé paternité" {{ old('type') == 'Congé paternité' ? 'selected' : '' }}>
                                        Congé paternité
                                    </option>
                                    <option value="Congé exceptionnel" {{ old('type') == 'Congé exceptionnel' ? 'selected' : '' }}>
                                        Congé exceptionnel
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Date Range Section -->
                        <div class="mb-3">
                            <h6 class="font-weight-bold mb-2"><i class="fas fa-calendar-day mr-1"></i> Période</h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="small font-weight-bold mb-1">Début <span class="text-danger">*</span></label>
                                        <input type="date" name="date_debut" id="date_debut" 
                                               class="form-control form-control-sm" 
                                               value="{{ old('date_debut') }}" 
                                               min="{{ date('Y-m-d') }}" required>
                                        @error('date_debut')
                                            <div class="invalid-feedback d-block small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="small font-weight-bold mb-1">Fin <span class="text-danger">*</span></label>
                                        <input type="date" name="date_fin" id="date_fin" 
                                               class="form-control form-control-sm" 
                                               value="{{ old('date_fin') }}" 
                                               min="{{ date('Y-m-d') }}" required>
                                        @error('date_fin')
                                            <div class="invalid-feedback d-block small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="small text-muted mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                <span id="durationText">Sélectionnez les dates</span>
                            </div>
                        </div>

                        <!-- Document Upload Section -->
                        <div class="mb-3">
                            <h6 class="font-weight-bold mb-2"><i class="fas fa-file-upload mr-1"></i> Justificatif</h6>
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold mb-1">Document</label>
                                <div class="custom-file">
                                    <input type="file" name="justificatif" id="justificatif" 
                                           class="custom-file-input custom-file-input-sm" 
                                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                    <label class="custom-file-label" for="justificatif">Choisir fichier</label>
                                </div>
                                <small class="text-muted">PDF, JPG, PNG, DOC (Max: 5MB)</small>
                                @error('justificatif')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Reason Section -->
                        <div class="mb-3">
                            <h6 class="font-weight-bold mb-2"><i class="fas fa-comment mr-1"></i> Motif</h6>
                            <div class="form-group mb-2">
                                <label class="small font-weight-bold mb-1">Explication</label>
                                <textarea name="motif" id="motif" 
                                          class="form-control form-control-sm" 
                                          rows="3" 
                                          maxlength="500">{{ old('motif') }}</textarea>
                                <small class="text-muted"><span id="charCount">0</span>/500 caractères</small>
                                @error('motif')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Section -->

                        <div class="form-section">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="confirmCheck" name="confirmation">
                                            <label class="form-check-label" for="confirmCheck">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Je confirme que les informations fournies sont exactes
                                            </label>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" >
                                            <i class="fas fa-paper-plane mr-2"></i>
                                            <span id="submitText">Envoyer la demande</span>
                                            <span id="submitSpinner" class="spinner-border spinner-border-sm ml-2 d-none"></span>
                                        </button>
                                    </div>
                                    <div class="mt-3">
                                        <small class="text-muted" id="validationMessage">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Pour activer le bouton, veuillez remplir les champs obligatoires et cocher la case de confirmation.
                                        </small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
.card {
    border-radius: 10px;
}
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #eee;
}
.form-control-sm, .btn-sm {
    font-size: 0.875rem;
    padding: 0.25rem 0.5rem;
}
.custom-file-input-sm {
    height: calc(1.5em + 0.5rem + 2px);
}
.custom-file-label {
    padding: 0.25rem 0.5rem;
    height: calc(1.5em + 0.5rem + 2px);
    font-size: 0.875rem;
}
.small {
    font-size: 0.8rem;
}
.invalid-feedback {
    font-size: 0.75rem;
}
.alert {
    font-size: 0.875rem;
}
</style>
@endsection

@section('js')
<!-- Le même script JavaScript que dans votre version originale -->
<script>
document.addEventListener('DOMContentLoaded', function() {
<<<<<<< HEAD
    // ... (conservez tout le code JavaScript original)
=======
    const dateDebut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');
    const durationText = document.getElementById('durationText');
    const motif = document.getElementById('motif');
    const charCount = document.getElementById('charCount');
    const confirmCheck = document.getElementById('confirmCheck');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    const typeSelect = document.getElementById('type');

    // Calculate duration
    function calculateDuration() {
        if (dateDebut.value && dateFin.value) {
            const start = new Date(dateDebut.value);
            const end = new Date(dateFin.value);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            
            if (end < start) {
                durationText.innerHTML = '<i class="fas fa-exclamation-triangle text-warning mr-1"></i>Date de fin doit être après la date de début';
                durationText.className = 'text-warning';
            } else {
                durationText.innerHTML = `<i class="fas fa-calendar-day text-info mr-1"></i>Durée: ${diffDays} jour(s)`;
                durationText.className = 'text-info';
            }
        } else {
            durationText.innerHTML = '<i class="fas fa-info-circle text-info mr-1"></i>Durée: Sélectionnez les dates';
            durationText.className = 'text-info';
        }
    }

    // Character count for motif
    function updateCharCount() {
        const count = motif.value.length;
        charCount.textContent = count;
        if (count > 450) {
            charCount.className = 'text-warning';
        } else {
            charCount.className = 'text-muted';
        }
    }

    // Enable/disable submit button - Simplified validation
    function updateSubmitButton() {
        const hasDates = dateDebut.value && dateFin.value;
        const hasType = typeSelect.value && typeSelect.value.trim() !== '';
        const isConfirmed = confirmCheck.checked;
        const validationMessage = document.getElementById('validationMessage');
        
        // Check if dates are valid (end date after start date)
        let datesValid = false;
        if (hasDates) {
            const start = new Date(dateDebut.value);
            const end = new Date(dateFin.value);
            datesValid = end >= start;
        }
        
        // Enable button if we have type, valid dates and confirmation
        const shouldEnable = hasType && hasDates && datesValid && isConfirmed;
        
        submitBtn.disabled = !shouldEnable;
        
        // Update button appearance
        if (shouldEnable) {
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-primary');
            validationMessage.innerHTML = '<i class="fas fa-check-circle text-success mr-1"></i>Formulaire complet ! Vous pouvez envoyer votre demande.';
            validationMessage.className = 'text-success';
        } else {
            submitBtn.classList.remove('btn-primary');
            submitBtn.classList.add('btn-secondary');
            
            // Provide specific feedback
            if (!hasType) {
                validationMessage.innerHTML = '<i class="fas fa-info-circle text-info mr-1"></i>Veuillez sélectionner un type de congé.';
                validationMessage.className = 'text-info';
            } else if (!hasDates) {
                validationMessage.innerHTML = '<i class="fas fa-info-circle text-info mr-1"></i>Veuillez sélectionner les dates de début et de fin.';
                validationMessage.className = 'text-info';
            } else if (!datesValid) {
                validationMessage.innerHTML = '<i class="fas fa-exclamation-triangle text-warning mr-1"></i>La date de fin doit être après la date de début.';
                validationMessage.className = 'text-warning';
            } else if (!isConfirmed) {
                validationMessage.innerHTML = '<i class="fas fa-info-circle text-info mr-1"></i>Veuillez confirmer que les informations sont exactes.';
                validationMessage.className = 'text-info';
            } else {
                validationMessage.innerHTML = '<i class="fas fa-info-circle text-info mr-1"></i>Veuillez remplir tous les champs obligatoires.';
                validationMessage.className = 'text-info';
            }
        }
        
        // Debug info (remove in production)
        console.log('Validation:', {
            hasType: hasType,
            hasDates: hasDates,
            datesValid: datesValid,
            isConfirmed: isConfirmed,
            shouldEnable: shouldEnable
        });
    }

    // Event listeners
    dateDebut.addEventListener('change', function() {
        if (this.value) {
            dateFin.min = this.value;
        }
        calculateDuration();
        updateSubmitButton();
    });

    dateFin.addEventListener('change', function() {
        calculateDuration();
        updateSubmitButton();
    });

    typeSelect.addEventListener('change', function() {
        updateSubmitButton();
    });

    confirmCheck.addEventListener('change', function() {
        if (this.checked) {
            this.parentElement.classList.add('text-success');
        } else {
            this.parentElement.classList.remove('text-success');
        }
        updateSubmitButton();
    });

    motif.addEventListener('input', updateCharCount);

    // Form submission
    document.getElementById('leaveForm').addEventListener('submit', function(e) {
        // Final validation before submission
        const hasDates = dateDebut.value && dateFin.value;
        const hasType = typeSelect.value && typeSelect.value.trim() !== '';
        const isConfirmed = confirmCheck.checked;
        
        if (!hasDates || !hasType || !isConfirmed) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires et confirmer les informations.');
            return;
        }
        
        // Check date validity
        const start = new Date(dateDebut.value);
        const end = new Date(dateFin.value);
        if (end < start) {
            e.preventDefault();
            alert('La date de fin doit être après la date de début.');
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitText.textContent = 'Envoi en cours...';
        submitSpinner.classList.remove('d-none');
    });

    // Initialize
    calculateDuration();
    updateCharCount();
    updateSubmitButton();
>>>>>>> 19313525114c9a183f9273da01af7c256d60ee30
});
</script>
@endsection