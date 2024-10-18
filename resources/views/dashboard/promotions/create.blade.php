@extends('layouts.template')

@section('another_CSS')
<link rel="stylesheet" href="{{asset('css/datatable/dataTables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.min.css')}}">
@endsection

@section('content')
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Les promotions</h4>
    </div>
    <div class="card py-5">
        <form action="{{ route('promotion.store') }}" method="POST">
            @csrf
            <div class="col-12 col-md-12 mb-3">
                <label for="year" class="font-medium form-label fs-16 text-label">Année Scolaire</label>
                <select class="form-select bg-form" name="year" id="year" required aria-label="Sélectionnez l'année scolaire">
                    <option selected disabled class="text-secondary">Choisissez l'année scolaire</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Promotion</th>
                            <th>Présente</th>
                        </tr>
                    </thead>
                   <tbody>
                     @foreach ($promotions as $promotion)
                        <tr>
                            <td>{{ $promotion->promotion }}</td>
                            <td>
                                <input type="checkbox" name="promotion_ids[]" value="{{ $promotion->id }}">
                            </td>
                        </tr>
                     @endforeach
                   </tbody>
                </table>
                <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
