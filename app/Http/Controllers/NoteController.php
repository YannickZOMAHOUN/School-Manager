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
                             ->with('student') // Assuming 'student' is the relation on 'Recording'
                             ->get()->pluck('student');
        return response()->json($students);
    }

    public function getRatio(Request $request) {
        $ratio = Ratio::where('subject_id', $request->subject_id)
                      ->where('classroom_id', $request->classroom_id)
                      ->first();
        return response()->json(['ratio' => $ratio ? $ratio->ratio : null]);
    }

    public function create(){
        try {
                    $subjects = Subject::all();
                    $classrooms = Classroom::all();
                    $years = Year::all();
                    $students = Student::all();
                    return view('dashboard.notes.create',compact(['subjects','classrooms','students','years']));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'year' => 'required|exists:years,id',
            'classroom' => 'required|exists:classrooms,id',
            'student' => 'required|exists:students,id',
            'subject' => 'required|exists:subjects,id',
            'ratio' => 'required|numeric',
            'semester' => 'required|in:1,2',
            'note' => 'required|numeric',
        ]);

        try {
            // Création ou récupération de l'enregistrement
            $recording = Recording::where([
                ['student_id', $request->student],
                ['year_id', $request->year],
                ['classroom_id', $request->classroom],
            ])->first();

            if (!$recording) {
                Log::warning('Enregistrement non trouvé', [
                    'student_id' => $request->student,
                    'year_id' => $request->year,
                    'classroom_id' => $request->classroom,
                ]);
                return response()->json(['success' => false, 'message' => 'Enregistrement non trouvé.'], 404);
            }

            // Création ou mise à jour de la note
            $note = Note::updateOrCreate(
                [
                    'recording_id' => $recording->id,
                    'subject_id' => $request->subject,
                    'semester' => $request->semester,
                ],
                [
                    'note' => $request->note,
                    'ratio_id' => $request->ratio,
                ]
            );

            Log::info('Note enregistrée avec succès', [
                'note_id' => $note->id,
                'recording_id' => $recording->id,
                'subject_id' => $request->subject,
                'semester' => $request->semester,
                'note' => $request->note,
                'ratio' => $request->ratio,
            ]);

            // Réponse de succès
            return response()->json(['success' => true, 'message' => 'Note enregistrée avec succès.', 'note' => $note], 200);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement de la note', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de l\'enregistrement.'], 500);
        }
    }
    /*public function show(){
        try {
            $years = Year::all();
            $classrooms = Classroom::all();
                    return view('dashboard.notes.show',compact(['classrooms','years']));
        }catch (\Exception $e){
            Log::info($e->getMessage());
            abort(404);
        }
    }*/
    public function getStudentNotes(Request $request)
    {
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
                // Calculer les notes et moyennes pour le semestre courant
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
                        'subject' => $note->subject->subject,
                        'note' => $note->note,
                        'coefficient' => $coefficient,
                        'moyenne_coefficiee' => $moyenneCoefficiee
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
                    $moyenneAnnuelle = (($moyenneGenerale * 2) + $moyenneGeneraleSemester1) / 3;

                    // Calculer le rang pour le semestre 1 et la moyenne annuelle
                    $rankSemester1 = array_search($moyenneGeneraleSemester1, array_values($rankings)) + 1;
                    $rankAnnuel = array_search($moyenneAnnuelle, array_values($rankings)) + 1;

                    return response()->json([
                        'student_name' => $recording->student->name . ' ' . $recording->student->surname,
                        'classroom' => $recording->classroom->classroom,
                        'notes' => $notesData,
                        'total_moyenne_coefficiee' => $totalMoyenneCoefficiee,
                        'moyenne_generale' => $moyenneGenerale,
                        'moyenne_annuelle' => $moyenneAnnuelle,
                        'rank' => $rank,
                        'rank_semester_1' => $rankSemester1,
                        'rank_annuel' => $rankAnnuel
                    ]);
                }

                return response()->json([
                    'student_name' => $recording->student->name . ' ' . $recording->student->surname,
                    'classroom' => $recording->classroom->classroom,
                    'notes' => $notesData,
                    'total_moyenne_coefficiee' => $totalMoyenneCoefficiee,
                    'moyenne_generale' => $moyenneGenerale,
                    'rank' => $rank
                ]);
            }

            return response()->json(['message' => 'Aucun enregistrement trouvé'], 404);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération des notes'], 500);
        }
    }
    public function getClassStudents(Request $request)
    {
        $students = Recording::where('year_id', $request->year_id)
            ->where('classroom_id', $request->classroom_id)
            ->with('student')
            ->get()
            ->pluck('student');

        return response()->json(['students' => $students]);
    }


    public function show($student_id)
{
    // Rechercher l'enregistrement dans le modèle Recording
    $recording = Recording::where('student_id', $student_id)
        ->with('student', 'classroom', 'year', 'notes') // Charger les relations nécessaires
        ->first();

    // Si l'enregistrement n'existe pas, renvoyer une erreur
    if (!$recording) {
        return redirect()->back()->with('error', 'Enregistrement non trouvé.');
    }

    // Récupérer toutes les années et les classes
    $years = Year::all();
    $classrooms = Classroom::all();

    // Passer les données à la vue
    return view('dashboard.notes.show', compact('recording', 'years', 'classrooms'));
}



}
