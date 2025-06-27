@extends('adminlte::page')

@section('title', 'Ajouter un employé')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="m-0">
            <i class="fas fa-user-plus text-primary mr-1"></i> Nouvel Employé
        </h5>
        <a href="{{ route('admin.employes.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Retour
        </a>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('message'))
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

    <div class="card shadow-sm">
        <div class="card-header bg-light py-2">
            <h6 class="mb-0"><i class="fas fa-user-plus text-primary mr-1"></i>Créer un nouvel employé</h6>
        </div>

        <div class="card-body px-3 py-3">
            <form action="{{ route('admin.employes.store') }}" method="POST" enctype="multipart/form-data" id="employeeForm">
                @csrf

                <!-- Informations personnelles -->
                <h6 class="text-primary mb-2"><i class="fas fa-user mr-1"></i> Informations personnelles</h6>
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="small font-weight-bold mb-1">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small font-weight-bold mb-1">Numéro d'enregistrement <span class="text-danger">*</span></label>
                        <input type="text" name="registration_number" class="form-control form-control-sm" value="{{ old('registration_number') }}" required>
                    </div>
                </div>

                <!-- Contact -->
                <h6 class="text-primary mt-3 mb-2"><i class="fas fa-address-book mr-1"></i> Contact</h6>
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="small font-weight-bold mb-1">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small font-weight-bold mb-1">Téléphone <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control form-control-sm" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <!-- Adresse -->
                <h6 class="text-primary mt-3 mb-2"><i class="fas fa-map-marker-alt mr-1"></i> Adresse</h6>
                <div class="row g-2 mb-3">
                    <div class="col-md-8">
                        <label class="small font-weight-bold mb-1">Adresse <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control form-control-sm" value="{{ old('address') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="small font-weight-bold mb-1">Ville <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control form-control-sm" value="{{ old('city') }}" required>
                    </div>
                </div>

                <!-- Emploi -->
                <h6 class="text-primary mt-3 mb-2"><i class="fas fa-briefcase mr-1"></i> Emploi</h6>
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="small font-weight-bold mb-1">Département <span class="text-danger">*</span></label>
                        <select name="departement" class="form-control form-control-sm" required>
                            <option value="">Sélectionnez...</option>
                            @foreach ($departements as $departement)
                                <option value="{{ $departement->id }}" {{ old('departement') == $departement->id ? 'selected' : '' }}>
                                    {{ $departement->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="small font-weight-bold mb-1">Date d'embauche <span class="text-danger">*</span></label>
                        <input type="date" name="hire_date" class="form-control form-control-sm" value="{{ old('hire_date') }}" required>
                    </div>
                </div>

                <!-- Image -->
                <h6 class="text-primary mt-3 mb-2"><i class="fas fa-camera mr-1"></i> Photo</h6>
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="small font-weight-bold mb-1">Image</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input custom-file-input-sm" id="imageInput" onchange="previewImage(event)">
                            <label class="custom-file-label" for="imageInput">Choisir une image</label>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <img id="imagePreview" src="#" alt="Aperçu" style="display:none; max-width:80px; height:80px; border-radius:50%; object-fit:cover; border:2px solid #ddd;">
                    </div>
                </div>

                <!-- Mot de passe -->
                <h6 class="text-primary mt-3 mb-2"><i class="fas fa-lock mr-1"></i> Sécurité</h6>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="small font-weight-bold mb-1">Mot de passe <span class="text-danger">*</span></label>
                        <div class="input-group input-group-sm">
                            <input type="password" name="password" class="form-control form-control-sm" id="password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="togglePassword()">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="password-strength mt-4">
                            <div class="progress" style="height: 3px;">
                                <div class="progress-bar" id="passwordStrength" style="width: 0%"></div>
                            </div>
                            <small class="text-muted">Force du mot de passe</small>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetForm()">
                        <i class="fas fa-undo mr-1"></i> Réinitialiser
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        <i class="fas fa-save mr-1"></i>Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .form-control-sm, .btn-sm {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
        height: calc(1.5em + 0.5rem + 2px);
    }
    .custom-file-input-sm {
        height: calc(1.5em + 0.5rem + 2px);
    }
    .custom-file-label {
        padding: 0.25rem 0.5rem;
        height: calc(1.5em + 0.5rem + 2px);
        font-size: 0.875rem;
    }
    .card-header h6 {
        font-size: 1rem;
    }
    .small {
        font-size: 0.8rem;
    }
</style>
@endsection

@section('js')
<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.querySelector('#password + .input-group-append i');
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    function resetForm() {
        document.getElementById('employeeForm').reset();
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('imagePreview');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection