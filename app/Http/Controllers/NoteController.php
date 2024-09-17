<?php

namespace App\Http\Controllers;

use App\Models\Recording;
use App\Models\Ratio;
use App\Models\Classroom;
use App\Models\Year;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    public function getStudents(Request $request) {
        $students = Recording::where('year_id', $request->year_id)
                             ->where('classroom_id', $request->classroom_id)
                             ->where('school_id', auth()->user()->school_id) // Ajouter un filtre pour l'école
                             ->with('student') // Relation avec le modèle 'Student'
                             ->get()->pluck('student');
        return response()->json($students);
    }

    public function getRatio(Request $request) {
        $ratio = Ratio::where('subject_id', $request->subject_id)
                      ->where('classroom_id', $request->classroom_id)
                      ->first();

        if ($ratio) {
            return response()->json([
                'ratio' => $ratio->ratio,
                'ratio_id' => $ratio->id // Assurez-vous que 'id' est bien la clé primaire du ratio
            ]);
        } else {
            return response()->json([
                'ratio' => null,
                'ratio_id' => null
            ]);
        }
    }

    public function create() {
        try {
            $subjects = Subject::all();
            $classrooms = Classroom::all();
            $years = Year::all();
            $students = Student::all();
            return view('dashboard.notes.create', compact(['subjects', 'classrooms', 'students', 'years']));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function store(Request $request) {
        // Validation des données
        $validated = $request->validate([
            'year' => 'required|exists:years,id',
            'classroom' => 'required|exists:classrooms,id',
            'subject' => 'required|exists:subjects,id',
            'ratio_id' => 'required|exists:ratios,id',
            'semester' => 'required|in:1,2',
            'averages' => 'required|array',
            'averages.*' => 'nullable|numeric|min:0|max:20', // Permet des champs vides avec valeur 0
        ]);

        try {
            // Parcourir chaque note soumise
            foreach ($request->averages as $studentId => $noteValue) {
                $noteValue = $noteValue ?: 0; // Remplace les valeurs nulles par 0

                // Vérifier si une note existe déjà pour cet élève, matière, semestre, et école
                $existingNote = Note::whereHas('recording', function ($query) use ($request, $studentId) {
                    $query->where('student_id', $studentId)
                          ->where('year_id', $request->year)
                          ->where('classroom_id', $request->classroom)
                          ->where('school_id', auth()->user()->school->id);
                })
                ->where('subject_id', $request->subject)
                ->where('semester', $request->semester)
                ->first();

                if ($existingNote) {
                    // Si une note existe déjà, vous pouvez ignorer ou gérer comme vous le souhaitez
                    continue; // Ignorer cet élève et passer au suivant
                }

                // Récupérer ou créer un enregistrement (recording)
                $recording = Recording::firstOrCreate(
                    [
                        'student_id' => $studentId,
                        'year_id' => $request->year,
                        'classroom_id' => $request->classroom,
                        'school_id' => auth()->user()->school->id
                    ]
                );

                // Création de la nouvelle note
                Note::create([
                    'recording_id' => $recording->id,
                    'subject_id' => $request->subject,
                    'school_id' => auth()->user()->school->id,
                    'semester' => $request->semester,
                    'note' => $noteValue,
                    'ratio_id' => $request->ratio_id,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Les notes ont été enregistrées avec succès.'
            ], 200);

        } catch (\Exception $e) {
            // Gestion des erreurs
            Log::error('Erreur lors de l\'enregistrement des notes', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de l\'enregistrement des notes.'], 500);
        }
    }

    public function getStudentNotes(Request $request) {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'year_id' => 'required|exists:years,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'semester' => 'required|in:1,2'
        ]);

        try {
            $recording = Recording::where('student_id', $request->student_id)
                ->where('year_id', $request->year_id)
                ->where('classroom_id', $request->classroom_id)
                ->first();

            if ($recording) {
                // Récupérer les notes pour l'élève et le semestre spécifiés
                $notes = Note::where('recording_id', $recording->id)
                    ->where('semester', $request->semester)
                    ->with('subject', 'ratio')
                    ->get();

                $totalCoefficient = 0;
                $totalMoyenneCoefficiee = 0;

                $notesData = $notes->map(function ($note) use (&$totalCoefficient, &$totalMoyenneCoefficiee) {
                    $coefficient = $note->ratio->ratio;
                    $moyenneCoefficiee = $note->note * $coefficient;

                    $totalCoefficient += $coefficient;
                    $totalMoyenneCoefficiee += $moyenneCoefficiee;

                    return [
                        'id' => $note->id,
                        'subject' => $note->subject->subject,
                        'note' => $note->note,
                        'coefficient' => $coefficient,
                        'moyenne_coefficiee' => $moyenneCoefficiee,
                        'readonly' => true // Les champs seront en lecture seule
                    ];
                });

                $moyenneGenerale = $totalCoefficient ? $totalMoyenneCoefficiee / $totalCoefficient : 0;

                // Calculer le rang pour le semestre courant
                $students = Recording::where('year_id', $request->year_id)
                    ->where('classroom_id', $request->classroom_id)
                    ->get();

                $rankings = [];
                foreach ($students as $student) {
                    $studentNotes = Note::where('recording_id', $student->id)
                        ->where('semester', $request->semester)
                        ->with('ratio')
                        ->get();

                    $studentTotalCoefficient = 0;
                    $studentTotalMoyenneCoefficiee = 0;

                    foreach ($studentNotes as $note) {
                        $coefficient = $note->ratio->ratio;
                        $moyenneCoefficiee = $note->note * $coefficient;

                        $studentTotalCoefficient += $coefficient;
                        $studentTotalMoyenneCoefficiee += $moyenneCoefficiee;
                    }

                    $studentMoyenneGenerale = $studentTotalCoefficient ? $studentTotalMoyenneCoefficiee / $studentTotalCoefficient : 0;

                    $rankings[$student->id] = $studentMoyenneGenerale;
                }

                arsort($rankings);
                $rank = array_search($moyenneGenerale, array_values($rankings)) + 1;

                if ($request->semester == 2) {
                    // Calculer la moyenne annuelle
                    $notesSemester1 = Note::where('recording_id', $recording->id)
                        ->where('semester', 1)
                        ->with('subject', 'ratio')
                        ->get();

                    $totalCoefficientSemester1 = 0;
                    $totalMoyenneCoefficieeSemester1 = 0;

                    $notesSemester1->each(function ($note) use (&$totalCoefficientSemester1, &$totalMoyenneCoefficieeSemester1) {
                        $coefficient = $note->ratio->ratio;
                        $moyenneCoefficiee = $note->note * $coefficient;

                        $totalCoefficientSemester1 += $coefficient;
                        $totalMoyenneCoefficieeSemester1 += $moyenneCoefficiee;
                    });

                    $moyenneGeneraleSemester1 = $totalCoefficientSemester1 ? $totalMoyenneCoefficieeSemester1 / $totalCoefficientSemester1 : 0;
                    $moyenneAnnuelle = (($moyenneGenerale * 2) + $moyenneGeneraleSemester1) / 3; }
                    else
                    {
                         $moyenneAnnuelle = $moyenneGenerale;
                         }
                         return response()->json([
                            'notes' => $notesData,
                            'total_coefficient' => $totalCoefficient,
                            'total_moyenne_coefficiee' => $totalMoyenneCoefficiee,
                            'moyenne_generale' => $moyenneGenerale,
                            'rank' => $rank,
                            'moyenne_annuelle' => $moyenneAnnuelle ?? $moyenneGenerale
                        ]);
                    } else {
                        return response()->json(['message' => 'Enregistrement non trouvé.'], 404);
                    }
                } catch (\Exception $e) {
                    Log::error('Erreur lors de la récupération des notes de l\'élève', [
                        'error' => $e->getMessage(),
                        'request_data' => $request->all(),
                    ]);
                    return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de la récupération des notes.'], 500);
                }
            }

            public function getNotes(Request $request)
            {
                // Validation des données
                $validatedData = $request->validate([
                    'year_id' => 'required|integer',
                    'classroom_id' => 'required|integer',
                    'subject_id' => 'required|integer',
                    'semester' => 'required|integer'
                ]);

                $yearId = $validatedData['year_id'];
                $classroomId = $validatedData['classroom_id'];
                $subjectId = $validatedData['subject_id'];
                $semester = $validatedData['semester'];

                // Récupérer les notes en fonction des paramètres
                $notes = Note::whereHas('recording', function ($query) use ($yearId, $classroomId) {
                        $query->where('year_id', $yearId)
                              ->where('classroom_id', $classroomId);
                    })
                    ->where('subject_id', $subjectId)
                    ->where('semester', $semester)
                    ->get();

                // Formater les données avant de les retourner
                $formattedNotes = $notes->map(function ($note) {
                    return [
                        'student_id' => $note->recording->student->id,
                        'note' => $note->note,
                        'student_name' => $note->recording->student->name, // Relation avec Student
                        'student_surname' => $note->recording->student->surname
                    ];
                });

                return response()->json($formattedNotes);
            }

    }
