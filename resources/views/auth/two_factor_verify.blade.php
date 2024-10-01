@extends('layouts.authentification')

@section('content')
    <form method="POST" action="{{ route('two_fa.verify.post') }}">
        @csrf

        <div class="mb-3">
            <label for="two_fa_code" class="form-label">Code de vérification</label>
            <input type="text" name="two_fa_code" class="form-control" required>

            @if ($errors->has('two_fa_code'))
                <span class="text-danger">{{ $errors->first('two_fa_code') }}</span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Vérifier</button>
    </form>
@endsection
