@extends('layouts.template')

@section('another_CSS')
<link rel="stylesheet" href="{{asset('css/datatable/dataTables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.min.css')}}">
@endsection

@section('content')
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Ajout des coefficients</h4>
    </div>

    <div class="card py-5">
        <form action="{{ route('ratio.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="classroom" class="font-medium form-label fs-16 text-label">
                            Classe
                        </label>
                        <select class="form-select bg-form" name="classroom" id="classroom" multiple aria-label="Sélectionnez les classes">
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{$classroom->classroom}}</option>
                            @endforeach
                        </select>
                        <div class="form-check mt-2">
                            <label class="form-check-label">
                                Appliquer à toutes les classes d'un niveau :
                            </label>
                            <select class="form-select bg-form mt-1" name="apply_to_level" id="applyToLevel">
                                <option value="" selected>Aucun</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level }}">{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="subject" class="font-medium form-label fs-16 text-label">
                            Matière
                        </label>
                        <select class="form-select bg-form" name="subject" id="subject" aria-label="Sélectionnez une matière">
                            <option selected disabled class="text-secondary">Choisissez la matière</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{$subject->subject}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-12 mb-3">
                        <label for="ratio" class="font-medium fs-16 text-black form-label">
                            Coefficient
                        </label>
                        <input type="number" step="0.1" name="ratio" id="ratio" class="form-control bg-form"
                            placeholder="Entrez le coefficient" aria-describedby="ratioHelp">
                    </div>

                    <div class="row d-flex justify-content-center mt-2">
                        <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                        <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="d-flex justify-content-between my-2 flex-wrap">
        <div class="text-color-avt fs-22">Coefficient</div>
    </div>
    <div class="d-flex justify-content-between my-3">
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAllRatiosModal">
            Supprimer tous les coefficients
        </button>
    </div>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="deleteAllRatiosModal" tabindex="-1" aria-labelledby="deleteAllRatiosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAllRatiosModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer tous les coefficients de votre école ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('ratios.destroy.all') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card p-3">
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th>Classe</th>
                        <th>Matière</th>
                        <th>Coefficient</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ratios as $key => $ratio)
                    @if($ratio->school_id == auth()->user()->school->id)
                        <tr>
                            <td>{{ $ratio->classroom->classroom }}</td>
                            <td>{{ $ratio->subject->subject }}</td>
                            <td>{{ $ratio->ratio }}</td>
                            <td class="text-center" style="cursor: pointer">
                                <a class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Changer le coefficient" href="{{route('ratio.edit', $ratio)}}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                &nbsp;
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer">
                                    <i data-bs-toggle="modal" data-bs-target="#delete_ratio{{$ratio->id}}" class="fas fa-trash-alt text-danger"></i>
                                </a>
                            </td>
                        </tr>
                        @endif

                        <div class="modal fade" id="delete_ratio{{$ratio->id}}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-color-avt">Confirmer la suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('ratio.destroy', $ratio)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <div class="d-flex justify-content-center">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
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

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection

@section("another_Js")
<script src="{{asset('js/datatable/jquery-3.5.1.js')}}"></script>
<script src="{{asset('js/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/datatable/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $(document).ready(function(){
        $('#example').DataTable({
            "language": {
                "url": "{{asset('js/datatable/French.json')}}"
            },
            responsive: true,
            "columnDefs": [{
                "targets": -1,
                "orderable": false
            }]
        });
        $('.alert').alert('close');
    });
</script>
@endsection
