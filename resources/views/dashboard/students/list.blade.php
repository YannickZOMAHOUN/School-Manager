@extends('layouts.template')

@section("another_CSS")
<link rel="stylesheet" href="{{asset('css/datatable/bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('css/datatable/dataTables.bootstrap4.min.css')}}">
@endsection

@section("content")

<div class="d-flex justify-content-between my-2 flex-wrap">
    <div class="text-color-avt fs-22 font-medium">Liste des élèves</div>
</div>

<!-- Formulaire de sélection de la classe et de l'année scolaire -->
<form method="GET" action="{{ route('student.index') }}" class="mb-4">
    <div class="row">
        <div class="col-md-6">
            <label for="classroom" class="form-label">Classe</label>
            <select name="classroom_id" id="classroom" class="form-select">
                @foreach($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                        {{ $classroom->classroom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="year" class="form-label">Année Scolaire</label>
            <select name="year_id" id="year" class="form-select">
                @foreach($years as $year)
                    <option value="{{ $year->id }}" {{ request('year_id') == $year->id ? 'selected' : '' }}>
                        {{ $year->year }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Afficher les élèves</button>
    </div>
</form>

<div class="card p-3">
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom(s)</th>
                    <th>Date de Naissance</th>
                    <th>Lieu de Naissance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->matricule }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->surname }}</td>
                    <td>{{ \Carbon\Carbon::parse($student->birthday)->format('d/m/Y') }}</td> <!-- Format jour-mois-année -->
                    <td>{{ $student->birthplace }}</td>
                    <td class="text-center" style="cursor: pointer">
                        <a class="text-decoration-none text-secondary" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Note de l'élève" href=> <i class="bi bi-printer"></i> </a>
                        &nbsp;
                        <a class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Editer l'élève" href="{{route('student.edit', $student)}}"> <i
                                class="fas fa-pen"></i> </a>
                        &nbsp;
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer cet élève" class="">
                            <i data-bs-toggle="modal" data-bs-target="#delete_student{{$student->id }}"
                                class="fas fa-trash-alt text-danger"></i>
                        </a>
                    </td>
                </tr>
                <!-- Modal de confirmation de suppression -->
                <div class="modal fade" id="delete_student{{$student->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-color-avt">Confirmer suppression de l'élève</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('student.destroy',$student) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-danger ms-2">Confirmer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

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
        });
    </script>
@endsection
