@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title')
    Liste des Employés | Laravel Employés App
@endsection

@section('content_header')
    <h1>Liste des Employés</h1>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="mt-5">
            <div class="col-md-12 mx-auto">
                <div class="card my-5 shadow-lg">
                    <div class="card-header d-flex align-items-center">
                        {{--<h4 class="font-weight-bold text-uppercase m-0">Employés</h4>--}}
                        
                        
                        
                        
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom Complet</th>
                                        <th>Département</th>
                                        <th>Date d'Embauche</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Adresse</th>
                                        <th>Ville</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employes as $index => $employe)
                                    <tr>
                                        <td>{{ $index +1}}</td>
                                        <td>{{ $employe->name}}</td>
                                        <td>{{ $employe->departement->name}}</td>
                                        <td>{{ $employe->hire_date}}</td>
                                        <td>{{ $employe->email}}</td>
                                        <td>{{ $employe->phone}}</td>
                                        <td>{{ $employe->address}}</td>
                                        <td>{{ $employe->city}}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <a href="{{ route('admin.employe.show', $employe->id)}}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.employe.edit', $employe->id)}}" class="btn btn-sm btn-warning mx-2">
                                                    <i class="fas fa-edit"></i>
                                                </a><form id="{{ $employe->id}}" action="{{ route('admin.employe.destroy', $employe->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    <button class="btn btn-sm btn-danger" onclick="deleteEmp('{{ $employe->id}}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- End of.table-responsive -->
        </div>
    </div>
</div>
</div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
$('#myTable').DataTable({
    dom: 'Bfrtip',
    buttons: ['copy', 'excel', 'csv', 'pdf', 'print', 'colvis'],
    initComplete: function() {
        $('.dataTables_info').css('text-align', 'right');
}
});

// Filtrer les employés dynamiquement
$("#searchBox").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value)> -1);
});
});
});

function deleteEmp(id) {
Swal.fire({
    title: "Êtes-vous sûr?",
    text: "Voulez-vous vraiment supprimer cet employé?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Oui, supprimer!"
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
    title: "{{ session()->get('success')}}",
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
    title: "{{ session()->get('error')}}",
    showConfirmButton: false,
    timer: 3000,
    toast: true
});
</script>
@endif
@endsection
