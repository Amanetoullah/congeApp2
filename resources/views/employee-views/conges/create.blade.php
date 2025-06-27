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
                        <div class="mt-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="confirmCheck">
                                <label class="form-check-label small" for="confirmCheck">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Je confirme que les informations sont exactes
                                </label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted" id="validationMessage">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Remplissez les champs obligatoires
                                </small>
                                <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                                    <i class="fas fa-paper-plane mr-1"></i>
                                    <span id="submitText">Envoyer</span>
                                    <span id="submitSpinner" class="spinner-border spinner-border-sm ml-1 d-none"></span>
                                </button>
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
    // ... (conservez tout le code JavaScript original)
});
</script>
@endsection