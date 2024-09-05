@li
<div>
    <h4 class="font-medium text-color-avt">Ajouter les notes</h4>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveNote">
        <div class="row">
            <div class="col-12 col-md-4 mb-3">
                <label for="year" class="font-medium form-label fs-16 text-label">Année Scolaire</label>
                <select wire:model="year_id" class="form-select bg-form">
                    <option selected disabled>Choisissez l'année scolaire</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="classroom" class="font-medium form-label fs-16 text-label">Classe</label>
                <select wire:model="classroom_id" class="form-select bg-form">
                    <option selected disabled>Choisissez la classe</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->classroom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="student" class="font-medium form-label fs-16 text-label">Élève</label>
                <select wire:model="student_id" class="form-select bg-form">
                    <option selected disabled>Sélectionnez l'élève</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }} {{ $student->surname }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-4 mb-3">
                <label for="subject" class="font-medium form-label fs-16 text-label">Matière</label>
                <select wire:model="subject_id" class="form-select bg-form">
                    <option selected disabled>Sélectionnez la matière</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="ratio" class="font-medium form-label fs-16 text-label">Coefficient</label>
                <input wire:model="ratio_id" type="number" class="form-control bg-form" readonly>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="semester" class="font-medium form-label fs-16 text-label">Semestre</label>
                <select class="form-select bg-form" wire:model="semester" id="semester">
                    <option selected disabled class="text-secondary">Choisissez le semestre</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
        </div>

        <div class="col-12 col-md-12 mb-3">
            <label for="note" class="font-medium fs-16 text-black form-label">Moyenne non coefficiée</label>
            <input wire:model="note" type="number" step="0.1" class="form-control bg-form" placeholder="Entrez la note">
        </div>

        <div class="row d-flex justify-content-center mt-2">
            <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
        </div>
    </form>
</div>
