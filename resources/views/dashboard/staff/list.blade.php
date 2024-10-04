@extends('layouts.template')

@section("another_CSS")
    <link rel="stylesheet" href="{{asset('css/datatable/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/datatable/dataTables.bootstrap4.min.css')}}">
@endsection

@section("content")

    <div class="d-flex justify-content-between my-2 flex-wrap">
        <div class="text-color-avt fs-22 font-medium">Liste des membres {{ auth()->user()->school->school }}</div>
        <div>
            <a class="btn btn-success fs-14" href="{{ route('staff.create') }}">
                <i class="fas fa-plus"></i> Ajouter un membre
            </a>
        </div>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr class="text-center">
                    <th>Fonction</th>
                    <th>Nom</th>
                    <th>Prénom(s)</th>
                    <th>Email</th>
                    <th>Numéro de téléphone</th>
                    <th>Actions </th>
                </tr>
                </thead>
                <tbody>
                @foreach($staff as $key=>$staff)
                    <tr>
                        <td>{{ $staff->role->role_name }}</td>
                        <td>{{ $staff->name}}</td>
                        <td>{{ $staff->surname}}</td>
                        <td>{{ $staff->user->email }}</td>
                        <td>{{ $staff->number }}</td>
                        <td class="text-center" style="cursor: pointer">
                            <a class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Editer des informations" href="{{route('staff.edit', $staff)}}">
                                <i class="fas fa-pen"></i>
                            </a>
                            &nbsp;
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer">
                                <i data-bs-toggle="modal" data-bs-target="#delete_staff{{$staff->id}}" class="fas fa-trash-alt text-danger"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@include('modals.delete')
@endsection

@section("another_Js")

    <script src="{{asset('js/datatable/jquery-3.5.1.js')}}"></script>
    <script src="{{asset('js/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/datatable/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        $(document).ready(function(){
            $('#example').DataTable(
                {
                    "language": {
                        "url": "{{asset('js/datatable/French.json')}}"
                    },
                    responsive: true,
                    "columnDefs": [ {
                        "targets": -1,
                        "orderable": false
                    } ]
                }
            );
            $('.alert').alert('close')


        // Définir l'URL de suppression dynamique pour le modal
        $(document).on('click', '.delete-staff', function() {
            let staffId = $(this).data('staff-id');
            let url = "{{ route('staff.destroy', ':id') }}";
            url = url.replace(':id', staffId);
            $('#deleteForm').attr('action', url);
        });
        });
    </script>
@endsection
