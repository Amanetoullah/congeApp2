@extends('adminlte::page')

@section('title', 'Demandes de Congé | Laravel Employés App')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
@endpush

@section('content_header')
    <h1 class="text-center text-primary fw-bold">📅 Gestion des Congés</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table id="congesTable" class="table table-striped table-hover table-bordered align-middle">
                    <thead class="bg-primary text-dark">
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">Employé</th>
        <th class="text-center">Type</th>
        <th class="text-center">Date Début</th>
        <th class="text-center">Date Fin</th>
        <th class="text-center">Justificatif</th>
        <th class="text-center">Statut</th>
        <th class="text-center">Motif</th>
        <th class="text-center">Action</th>
    </tr>
</thead>

                    <tbody class="bg-white text-dark text-center">
                        @foreach($conges as $index => $conge)
                        <tr>
                            <td class="fw-bold">{{ $index + 1}}</td>
                            <td>{{ $conge->user->name}}</td>
                            <td class="text-capitalize">{{ $conge->type}}</td>
                            <td>{{ \Carbon\Carbon::parse($conge->date_debut)->format('d M Y')}}</td>
                            <td>{{ \Carbon\Carbon::parse($conge->date_fin)->format('d M Y')}}</td>
                            <td>
                                @if($conge->justificatif)
                                    <a href="/storage{{ $conge->justificatif}}" target="_blank" class="btn btn-sm btn-info">📄 Voir</a>
                                @else
                                    <span class="text-muted">Aucun</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{
                                    $conge->statut == 'Approuve'? 'success':
                                    ($conge->statut == 'Refuser'? 'danger': 'warning')
}}">
                                    {{ ucfirst($conge->statut)}}
                                </span>
                            </td>
                            <td>{{ $conge->motif?? '-'}}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <form action="{{ route('admin.conges.destroy', $conge->id)}}" method="POST" class="me-1">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-outline-danger btn-sm fw-bold" title="Refuser">❌</button>
                                    </form>
                                    <form action="{{ route('admin.conges.accept', $conge->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-outline-success btn-sm fw-bold" title="Approuver">✅</button>
                                    </form>
                                </div>
                            </td>
                        </tr>@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables + Bootstrap 5 -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Extensions de boutons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- Librairies PDF et Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    $(document).ready(function () {
        $('#congesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
},
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copyHtml5', text: '📋 Copier'},
                { extend: 'excelHtml5', text: '📊 Excel'},
                { extend: 'pdfHtml5', text: '📄 PDF'},
                { extend: 'print', text: '🖨 Imprimer'},
                { extend: 'colvis', text: '👁 Colonnes visibles'}
            ]
});
});
</script>
@endpush
