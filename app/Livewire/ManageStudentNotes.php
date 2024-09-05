<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;
use App\Models\Recording;
use App\Models\Ratio;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Year;

class ManageStudentNotes extends Component
{
    public $years;
    public $classrooms;
    public $students = [];
    public $subjects;
    public $year_id;
    public $classroom_id;
    public $student_id;
    public $subject_id;
    public $ratio_id;
    public $note;
    public $semester;

    public function mount()
    {
        $this->years = Year::all();
        $this->classrooms = Classroom::all();
        $this->subjects = Subject::all();
    }

    // Charger automatiquement les élèves lorsque l'année et la classe sont sélectionnées
    public function updatedYearId()
    {
        if ($this->classroom_id) {
            $this->loadStudents();
        }
    }

    public function updatedClassroomId()
    {
        if ($this->year_id) {
            $this->loadStudents();
        }
    }

    public function loadStudents()
    {
        if ($this->year_id && $this->classroom_id) {
            $this->students = Student::whereHas('recordings', function ($query) {
                $query->where('year_id', $this->year_id)
                      ->where('classroom_id', $this->classroom_id);
            })->get();

            if ($this->students->isEmpty()) {
                session()->flash('message', 'Aucun élève trouvé pour cette classe et année scolaire.');
            }
        } else {
            $this->students = [];
        }
    }


    // Charger automatiquement le coefficient lorsque la matière est sélectionnée
    public function updatedSubjectId()
    {
        $this->loadRatio();
    }

    public function loadRatio()
    {
        if ($this->subject_id) {
            $ratio = Ratio::where('subject_id', $this->subject_id)->first();

            if ($ratio) {
                $this->ratio_id = $ratio->coefficient;
            } else {
                $this->ratio_id = null;
                session()->flash('message', 'Aucun coefficient trouvé pour cette matière.');
            }
        }
    }

    // Sauvegarder les notes
    public function saveNote()
    {
        // Validation des données
        $this->validate([
            'year_id' => 'required',
            'classroom_id' => 'required',
            'student_id' => 'required',
            'subject_id' => 'required',
            'note' => 'required|numeric',
            'semester' => 'required|integer',
        ]);

        // Trouver l'enregistrement (recording) correspondant
        $recording = Recording::where('student_id', $this->student_id)
            ->where('classroom_id', $this->classroom_id)
            ->where('year_id', $this->year_id)
            ->first();

        if (!$recording) {
            session()->flash('message', 'Aucun enregistrement trouvé pour cet élève, cette classe et cette année.');
            return;
        }

        Note::create([
            'note' => $this->note,
            'semester' => $this->semester,
            'recording_id' => $recording->id,
            'subject_id' => $this->subject_id,
            'ratio_id' => $this->ratio_id,
        ]);

        // Réinitialisation des champs du formulaire après enregistrement
        $this->resetForm();

        session()->flash('message', 'Note enregistrée avec succès.');
    }

    public function resetForm()
{
    $this->reset('year_id', 'classroom_id', 'student_id', 'subject_id', 'ratio_id', 'note', 'semester');
}


    public function render()
    {
        return view('livewire.manage-student-notes');
    }
}
