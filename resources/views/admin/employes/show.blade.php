@extends('adminlte::page')

@section('title')
    Détails de l'employé | Laravel Employés App
@endsection

@section('content_header')
    <h1>Détails de l'Employé</h1>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4>👤 Détails de l'Employé</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if ($employe->image)
                                <img src="{{ asset('storage/' . $employe->image) }}" alt="Photo de profil" class="img-fluid rounded-circle" style="max-width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Photo par défaut" class="img-fluid rounded-circle" style="max-width: 200px; height: 200px; object-fit: cover;">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th class="fw-bold text-primary" style="width: 30%;">N° d'enregistrement:</th>
                                    <td>{{ $employe->registration_number }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold text-primary">Nom Complet:</th>
                                    <td>{{ $employe->name }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold text-primary">Email:</th>
                                    <td>{{ $employe->email }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold text-primary">Département:</th>
                                    <td>{{ $employe->departement->name ?? 'Non assigné' }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold text-primary">Date d'embauche:</th>
                                    <td>{{ $employe->hire_date ? \Carbon\Carbon::parse($employe->hire_date)->format('d/m/Y') : 'Non définie' }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold text-primary">Téléphone:</th>
                                    <td>{{ $employe->phone }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold text-primary">Adresse:</th>
                                    <td>{{ $employe->address }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold text-primary">Ville:</th>
                                    <td>{{ $employe->city }}</td>
                                </tr>
                                <tr>
                                    <th class="fw-bold text-primary">Rôle:</th>
                                    <td>
                                        @foreach($employe->roles as $role)
                                            <span class="badge badge-primary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('admin.employes.edit', $employe->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('admin.employes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                        <form action="{{ route('admin.employes.destroy', $employe->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
