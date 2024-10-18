@extends('layouts.template')

@section('another_CSS')
<link rel="stylesheet" href="{{asset('css/datatable/dataTables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.min.css')}}">
@endsection

@section('content')
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Enregistrement des groupes pédagogiques</h4>
    </div>

    <div class="card py-5">
        <form action="{{route('classroom.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="col-12 col-md-12 mb-3">
                    <label for="year" class="font-medium form-label fs-16 text-label">Année Scolaire</label>
                    <select class="form-select bg-form" name="year" id="year" required aria-label="Sélectionnez l'année scolaire">
                        <option selected disabled class="text-secondary">Choisissez l'année scolaire</option>
                        @foreach ($years as $year)
                            <option value="{{ $year->id }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>
                <table class="table mt-3" id="classrooms-table">
                    <thead>
                        <tr>
                            <th>Promotion</th>
                            <th>Groupe(s) Pédagogique(s)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('#year').change(function () {
        let yearId = $('#year').val();
        if (yearId) {
            $.ajax({
                url: '{{ route("get.promotions") }}',
                type: 'GET',
                data: {year_id: yearId},
                success: function (data) {
                    $('#classrooms-table tbody').empty();
                    data.forEach(function (promotion) {
                        let row = `<tr>
                            <td>${promotion.promotion}</td>
                            <td>
                                <input type="text" name="classrooms[${promotion.id}]"
                                class="form-control bg-form"
                                placeholder="Entrez les groupes séparés par des virgules"
                                required>
                            </td>
                        </tr>`;
                        $('#classrooms-table tbody').append(row);
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: xhr.responseJSON?.message || 'Une erreur est survenue lors du chargement.'
                    });
                }
            });
        }
    });
});
</script>
@endsection
