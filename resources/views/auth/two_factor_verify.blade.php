@extends('layouts.authentification')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Vérification du Code</h2>
        <form method="POST" action="{{ route('two_fa.verify.post') }}">
            @csrf

            <div class="mb-3">
                <label for="two_fa_code" class="form-label">Code de vérification</label>
                <div class="d-flex justify-content-center gap-2">
                    @for ($i = 0; $i < 6; $i++)
                        <input type="text" name="two_fa_code[]" class="form-control text-center" required maxlength="1"
                               placeholder="0"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                               style="width: 50px; height: 50px; font-size: 24px; border-radius: 8px; border: 2px solid #007bff;">
                    @endfor
                </div>

                @if ($errors->has('two_fa_code'))
                    <span class="text-danger">{{ $errors->first('two_fa_code') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100">Vérifier</button>
        </form>
    </div>

    <script>
        // Fonction pour gérer le focus sur les champs de code
        document.querySelectorAll('input[name^="two_fa_code"]').forEach((input, index) => {
            input.addEventListener('input', function () {
                if (this.value.length > 1) {
                    this.value = this.value.slice(-1); // Permet uniquement un chiffre
                }
                if (this.value && index < 5) {
                    document.querySelector(`input[name="two_fa_code[${index + 1}]"]`).focus();
                }
            });
        });

        // Gestion du collage dans les cases
        document.addEventListener('paste', (event) => {
            const clipboardData = event.clipboardData || window.clipboardData;
            const pastedData = clipboardData.getData('Text').trim();
            const inputs = document.querySelectorAll('input[name^="two_fa_code"]');
            inputs.forEach((input, index) => {
                if (pastedData[index]) {
                    input.value = pastedData[index];
                }
            });
            event.preventDefault(); // Évite le collage direct
        });
    </script>
@endsection
