@extends('layouts.user')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4>📝 Modifier un employé</h4>
                </div>
                <div class="card-body p-4">
                    @if(session()->has('message'))
                        <div class="alert alert-success text-center">{{ session('message')}}</div>
                    @endif

                    @if(isset($employe))
                        <form action="{{ route('admin.employes.update', $employe->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-primary">N° d’enregistrement:</label>
                                    <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $employe->registration_number)}}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-primary">Nom complet:</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $employe->name)}}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-primary">Département:</label>
                                    <select name="departement_id" class="form-select">
                                        @foreach ($departements as $departement)
                                            <option value="{{ $departement->id}}" @if($employe->departement->id == $departement->id) selected @endif>
                                                {{ $departement->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-primary">Date d’embauche:</label>
                                    <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', $employe->hire_date)}}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-primary">Téléphone:</label>
                                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', $employe->phone)}}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-primary">Adresse:</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address', $employe->address)}}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-primary">Ville:</label>
                                    <input type="text" name="city" class="form-control" value="{{ old('city', $employe->city)}}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3 rounded-pill">
                                <i class="fas fa-save"></i> Enregistrer les modifications
                            </button>
                        </form>
                    @else
                        <div class="alert alert-danger text-center">❌ Employé introuvable!</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
