<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;
use App\Models\Recording;
use App\Models\Ratio;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Year;
class ManageStudentNotes extends Component
{
    public $years;
    public $classrooms;
    public $subjects;
    public $students = [];
    public $ratios = [];

    public $year_id;
    public $classroom_id;
    public $student_id;
    public $subject_id;
    public $ratio_id;
    public $note;

    public function mount()
    {
        $this->years = Year::all();
        $this->classrooms = Classroom::all();
        $this->subjects = Subject::all();
    }

    public function updatedYearId()
    {
        $this->loadStudents();
    }

    public function updatedClassroomId()
    {
        $this->loadStudents();
        $this->loadRatios();
    }

    public function updatedSubjectId()
    {
        $this->loadRatios();
    }

    public function loadStudents()
    {
        if ($this->year_id && $this->classroom_id) {
            $this->students = Recording::where('year_id', $this->year_id)
                                        ->where('classroom_id', $this->classroom_id)
                                        ->with('student')
                                        ->get()
                                        ->pluck('student');
        }
    }

    public function loadRatios()
{
    // Vérifier que les attributs sont définis
    if (!isset($this->classroom_id) || !isset($this->subject_id)) {
        // Vous pouvez gérer les cas où les ID ne sont pas définis
        $this->ratios = null;
        $this->ratio_id = null;
        return;
    }

    // Rechercher les ratios correspondant à la classe et à la matière
    $this->ratios = Ratio::where('classroom_id', $this->classroom_id)
                         ->where('subject_id', $this->subject_id)
                         ->first();

    // Définir l'ID du ratio ou le mettre à null si aucun ratio n'est trouvé
    $this->ratio_id = $this->ratios ? $this->ratios->id : null;
}


    public function saveNote()
    {
        $this->validate([
            'student_id' => 'required',
            'subject_id' => 'required',
            'ratio_id' => 'required',
            'note' => 'required|numeric|min:0|max:20'
        ]);

        Note::create([
            'note' => $this->note,
            'recording_id' => $this->student_id,
            'subject_id' => $this->subject_id,
            'ratio_id' => $this->ratio_id,
        ]);

        session()->flash('message', 'Note ajoutée avec succès !');
        $this->reset(['student_id', 'subject_id', 'ratio_id', 'note']);
    }

    public function render()
    {
        return view('livewire.manage-student-notes');
    }
}
