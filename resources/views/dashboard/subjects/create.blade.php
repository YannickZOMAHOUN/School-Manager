@extends('layouts.template')

@section('another_CSS')
<link rel="stylesheet" href="{{asset('css/datatable/dataTables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.min.css')}}">
@endsection

@section('content')
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Enregistrement d'une nouvelle matière</h4>
    </div>

    <div class="card py-5">
        <form action="{{ route('subject.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 mb-3">
                        <label for="subject" class="font-medium fs-16 text-black form-label">Matière</label>
                        <input type="text" name="subject" id="subject" class="form-control bg-form @error('subject') is-invalid @enderror" value="{{ old('subject') }}">
                        @error('subject')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row d-flex justify-content-center mt-2">
                        <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                        <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="d-flex justify-content-between my-2 flex-wrap">
    <div class="text-color-avt fs-22">Matières de l'école {{ auth()->user()->school->school }}</div>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>Matière</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $subject)
                @if($subject->school_id == auth()->user()->school->id)  {{-- Vérification que la matière appartient à l'école de l'utilisateur connecté --}}
                <tr>
                    <td>{{ $subject->subject }}</td>
                    <td class="text-center">
                        <a class="text-decoration-none text-secondary" data-bs-toggle="tooltip" title="Détails" href="{{ route('subject.show', $subject) }}">
                            <i class="bi bi-printer"></i>
                        </a>
                        &nbsp;
                        <a class="text-decoration-none" data-bs-toggle="tooltip" title="Éditer" href="{{ route('subject.edit', $subject) }}">
                            <i class="fas fa-pen"></i>
                        </a>
                        &nbsp;
                        <i data-subject-id="{{ $subject->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal" class="fas fa-trash-alt text-danger delete-subject"></i>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('modals.delete')  {{-- Inclusion du modal réutilisable pour la suppression --}}
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

        // Définir l'URL de suppression dynamique pour le modal
        $(document).on('click', '.delete-subject', function() {
            let subjectId = $(this).data('subject-id');
            let url = "{{ route('subject.destroy', ':id') }}";
            url = url.replace(':id', subjectId);
            $('#deleteForm').attr('action', url);
        });
    });
</script>
@endsection
