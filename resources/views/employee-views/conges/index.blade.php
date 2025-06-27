@extends('layouts.user')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')

<div class="container-fluid">
    <div class="w-100">
        <x-toast:message="session('success')" type="success" />
        <x-toast:message="session('error')" type="danger" />
    </div>
    <h2 class="my-4">Liste des Congés</h2>
    @extends('layouts.alert')

    <div class="table-responsive shadow-lg">
        <table id="congesTable" class="table table-striped table-hover">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th>Type</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Statut</th>
                    <th>Motif</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conges as $conge)
                <tr class="align-middle text-center">
                    <td><i class="fas fa-calendar-alt text-primary"></i> {{ $conge->type}}</td>
                    <td><i class="fas fa-clock text-success"></i> {{ $conge->date_debut}}</td>
                    <td><i class="fas fa-clock text-danger"></i> {{ $conge->date_fin}}</td>
                    <td>
                        <span class="badge bg-{{
                            $conge->statut == 'Approuve'? 'success':
                            ($conge->statut == 'Refuser'? 'danger': 'warning')
}}">
                            <i class="fas fa-{{
                                $conge->statut == 'Approuve'? 'check-circle':
                                ($conge->statut == 'Refuser'? 'times-circle': 'hourglass-half')
}}"></i>
                            {{ $conge->statut}}
                        </span>
                    </td>
                    <td class="fw-bold text-secondary">{{ $conge->motif?? '-'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#congesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
},
            pageLength: 10,
            lengthMenu: [5, 10, 20, 50]
});
});
</script>
@endpush

