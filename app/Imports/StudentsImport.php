<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Recording;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    protected $classroom_id;
    protected $year_id;
    protected $school_id;

    public function __construct($classroom_id, $year_id)
    {
        $this->classroom_id = $classroom_id;
        $this->year_id = $year_id;
        $this->school_id = auth()->user()->school->id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $birthday = Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d');
        $student = Student::create([
            'matricule' => $row[0],
            'name' => $row[1],
            'surname' => $row[2],
            'sex' => $row[3],
            'birthday' => $birthday,
            'birthplace' => $row[5],
            'school_id' => $this->school_id,
        ]);

        Recording::query()->create([
            'student_id' => $student->id,
            'classroom_id' => $this->classroom_id,
            'year_id' => $this->year_id,
            'school_id' => auth()->user()->school_id,
        ]);

        return $student;
    }
}
