@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title')
    Liste des Employés | Laravel Employés App
@endsection

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">
            <i class="fas fa-users text-primary"></i>
            Gestion des Employés
        </h1>
        <a href="{{ route('admin.employes.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Nouvel Employé
        </a>
    </div>
@endsection

@section('content')
    <div class="container-fluid">

        @include('layouts.alert')
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-primary">
                    <div class="inner">
                        <h3>{{ $employes->count() }}</h3>
                        <p>Total Employés</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>{{ $departments->count() }}</h3>
                        <p>Départements</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>{{ $employes->where('hire_date', '>=', now()->subDays(30))->count() }}</h3>
                        <p>Nouveaux (30j)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>{{ $employes->where('departement_id', '!=', null)->count() }}</h3>
                        <p>Assignés</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="card shadow-lg border-0">
            <div class="card-header bg-white border-0 py-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary border-0 text-white">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                            <input type="text" id="searchInput" class="form-control border-0" placeholder="Rechercher un employé..." style="background-color: #f8f9fa;">
                        </div>

                    </div>
                    <div class="col-md-2">
                        <select id="departmentFilter" class="form-control border-0" style="background-color: #f8f9fa;">
                            <option value="">Tous les départements</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="sortField" class="form-control border-0" style="background-color: #f8f9fa;">
                            <option value="name">Trier par nom</option>
                            <option value="email">Trier par email</option>
                            <option value="registration_number">Trier par numéro</option>
                            <option value="hire_date">Trier par date d'embauche</option>
                            <option value="department">Trier par département</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="sortDirection" class="btn btn-outline-primary btn-block rounded-pill" data-direction="asc">
                            <i class="fas fa-sort-up"></i> Asc
                        </button>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex justify-content-end">
                            <span class="badge badge-primary badge-pill p-2">
                                <i class="fas fa-users mr-1"></i>
                                <span id="totalCount">{{ $employes->count() }}</span> employé(s)
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="employeesTable" class="table table-hover mb-0">
                        <thead class="bg-gradient-primary text-white">
                            <tr>
                                <th class="border-0 py-3">
                                    <i class="fas fa-hashtag mr-1"></i>ID
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-user mr-1"></i>Nom Complet
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-building mr-1"></i>Département
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-calendar-alt mr-1"></i>Date d'Embauche
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-envelope mr-1"></i>Email
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-phone mr-1"></i>Téléphone
                                </th>
                                <th class="border-0 py-3">
                                    <i class="fas fa-map-marker-alt mr-1"></i>Ville
                                </th>
                                <th class="border-0 py-3 text-center">
                                    <i class="fas fa-cogs mr-1"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody id="employeesTableBody">
                            @foreach ($employes as $index => $employe)
                            <tr class="border-bottom">
                                <td class="align-middle">
                                    <span class="badge badge-secondary badge-pill">{{ $index + 1 }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm mr-3">
                                            @if ($employe->image)
                                                <img src="{{ asset('storage/' . $employe->image) }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold">{{ $employe->name }}</h6>
                                            <small class="text-muted">{{ $employe->registration_number }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @if($employe->departement)
                                        <span class="badge badge-info badge-pill">{{ $employe->departement->name }}</span>
                                    @else
                                        <span class="badge badge-light badge-pill">Non assigné</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($employe->hire_date)
                                        <span class="text-muted">{{ \Carbon\Carbon::parse($employe->hire_date)->format('d/m/Y') }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <a href="mailto:{{ $employe->email }}" class="text-primary">
                                        <i class="fas fa-envelope mr-1"></i>{{ $employe->email }}
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <a href="tel:{{ $employe->phone }}" class="text-success">
                                        <i class="fas fa-phone mr-1"></i>{{ $employe->phone }}
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">{{ $employe->city }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.employes.show', $employe->id) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.employes.edit', $employe->id) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteEmp('{{ $employe->id }}')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <form id="{{ $employe->id }}" action="{{ route('admin.employes.destroy', $employe->id) }}" method="post" class="d-none">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
.card {
    border-radius: 15px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.small-box {
    border-radius: 15px;
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.small-box:hover {
    transform: translateY(-5px);
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    vertical-align: middle;
    border-top: 1px solid #f8f9fa;
}

.btn-group .btn {
    border-radius: 20px;
    margin: 0 2px;
}

.badge-pill {
    border-radius: 50rem;
}

.avatar-sm img {
    border: 2px solid #e9ecef;
}

.form-control {
    border-radius: 25px;
    transition: all 0.3s ease;
}

.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    border-color: #80bdff;
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

.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.bg-gradient-success {
    background: linear-gradient(45deg, #28a745, #1e7e34);
}

.bg-gradient-warning {
    background: linear-gradient(45deg, #ffc107, #e0a800);
}

.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #138496);
}
</style>
@endsection

@section('js')
<script>
$(document).ready(function(){
    let searchTimeout;
    let currentSortField = 'name';
    let currentSortDirection = 'asc';

    // Search functionality with debounce
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            loadEmployees();
        }, 500);
    });

    // Department filter
    $('#departmentFilter').on('change', function() {
        loadEmployees();
    });

    // Sort field change
    $('#sortField').on('change', function() {
        currentSortField = $(this).val();
        loadEmployees();
    });

    // Sort direction toggle
    $('#sortDirection').on('click', function() {
        currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
        $(this).data('direction', currentSortDirection);
        $(this).html(currentSortDirection === 'asc' ? '<i class="fas fa-sort-up"></i> Asc' : '<i class="fas fa-sort-down"></i> Desc');
        loadEmployees();
    });

    function loadEmployees() {
        const search = $('#searchInput').val();
        const department = $('#departmentFilter').val();

        $.ajax({
            url: '{{ route("admin.employes.index") }}',
            method: 'GET',
            data: {
                search: search,
                department: department,
                sort: currentSortField,
                direction: currentSortDirection,
                ajax: true
            },
            success: function(response) {
                updateTable(response.employes);
                $('#totalCount').text(response.total);
            },
            error: function(xhr, status, error) {
                console.error('Error loading employees:', error);
            }
        });
    }

    function updateTable(employes) {
        const tbody = $('#employeesTableBody');
        tbody.empty();

        employes.forEach(function(employe, index) {
            const avatar = employe.image ? 
                `<img src="/storage/${employe.image}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">` :
                `<div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fas fa-user text-white"></i></div>`;
            
            const department = employe.departement ? 
                `<span class="badge badge-info badge-pill">${employe.departement.name}</span>` :
                `<span class="badge badge-light badge-pill">Non assigné</span>`;
            
            const hireDate = employe.hire_date ? formatDate(employe.hire_date) : 'N/A';

            const row = `
                <tr class="border-bottom">
                    <td class="align-middle">
                        <span class="badge badge-secondary badge-pill">${index + 1}</span>
                    </td>
                    <td class="align-middle">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm mr-3">
                                ${avatar}
                            </div>
                            <div>
                                <h6 class="mb-0 font-weight-bold">${employe.name}</h6>
                                <small class="text-muted">${employe.registration_number}</small>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle">
                        ${department}
                    </td>
                    <td class="align-middle">
                        <span class="text-muted">${hireDate}</span>
                    </td>
                    <td class="align-middle">
                        <a href="mailto:${employe.email}" class="text-primary">
                            <i class="fas fa-envelope mr-1"></i>${employe.email}
                        </a>
                    </td>
                    <td class="align-middle">
                        <a href="tel:${employe.phone}" class="text-success">
                            <i class="fas fa-phone mr-1"></i>${employe.phone}
                        </a>
                    </td>
                    <td class="align-middle">
                        <span class="text-muted">${employe.city}</span>
                    </td>
                    <td class="align-middle text-center">
                        <div class="btn-group" role="group">
                            <a href="/admin/employes/${employe.id}" class="btn btn-sm btn-outline-primary" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/admin/employes/${employe.id}/edit" class="btn btn-sm btn-outline-warning" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteEmp('${employe.id}')" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <form id="${employe.id}" action="/admin/employes/${employe.id}" method="post" class="d-none">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('fr-FR');
    }
});

function deleteEmp(id) {
    Swal.fire({
        title: "Êtes-vous sûr?",
        text: "Voulez-vous vraiment supprimer cet employé?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, supprimer!",
        cancelButtonText: "Annuler"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(id).submit();
        }
    });
}
</script>

@if (session()->has('success'))
<script>
Swal.fire({
    position: "top-end",
    icon: "success",
    title: "{{ session()->get('success') }}",
    showConfirmButton: false,
    timer: 3000,
    toast: true
});
</script>
@endif

@if (session()->has('error'))
<script>
Swal.fire({
    position: "top-end",
    icon: "error",
    title: "{{ session()->get('error') }}",
    showConfirmButton: false,
    timer: 3000,
    toast: true
});
</script>
@endif
@endsection
