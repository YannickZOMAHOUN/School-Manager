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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
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

    public function index() {
        try {
            $classrooms = Classroom::all();
            $years = Year::all();
            return view('dashboard.notes.list', compact([ 'classrooms', 'years']));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            abort(404);
        }
    }
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
                        'id' => $note->id,
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


    public function generateRankingPDF(Request $request)
    {
        // Validation des données
        $request->validate([
            'year_id' => 'required|exists:years,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'semester_hidden' => 'required|in:1,2',
        ]);

        try {
            // Récupérer l'année scolaire et la classe
            $year = Year::findOrFail($request->year_id);
            $classroom = Classroom::findOrFail($request->classroom_id);

            // Récupérer les enregistrements pour l'année scolaire, la classe et le semestre spécifiés
            $recordings = Recording::where('year_id', $request->year_id)
                ->where('classroom_id', $request->classroom_id)
                ->with(['student', 'notes' => function ($query) use ($request) {
                    $query->where('semester', $request->semester_hidden)->with('ratio');
                }])
                ->get();

            // Vérification si les enregistrements existent
            if ($recordings->isEmpty()) {
                return redirect()->back()->with('error', 'Aucun enregistrement trouvé pour les critères sélectionnés.');
            }

            // Calcul des classements
            $rankings = $recordings->map(function ($recording) {
                $totalCoefficient = 0;
                $totalMoyenneCoefficiee = 0;

                foreach ($recording->notes as $note) {
                    $coefficient = $note->ratio->ratio;
                    $moyenneCoefficiee = $note->note * $coefficient;
                    $totalCoefficient += $coefficient;
                    $totalMoyenneCoefficiee += $moyenneCoefficiee;
                }

                $moyenneGenerale = $totalCoefficient ? $totalMoyenneCoefficiee / $totalCoefficient : 0;

                return [
                    'student' => $recording->student,
                    'moyenne_generale' => $moyenneGenerale,
                ];
            });

            // Trier par moyenne générale
            $rankings = $rankings->sortByDesc('moyenne_generale')->values();

            // Ajouter les rangs
            $rankings->transform(function ($ranking, $index) {
                $ranking['rank'] = $index + 1;
                return $ranking;
            });

            // Générer le PDF
            $pdf = Pdf::loadView('dashboard.notes.printed.print-classement', [
                'rankings' => $rankings,
                'year' => $year->year,
                'classroom' => $classroom->classroom,
                'semester_hidden' => $request->semester_hidden,
            ]);

            return $pdf->stream('classement.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la génération du classement.');
        }
    }

    public function generateBulletinsPDF(Request $request)
    {
        // Validation des données
        $request->validate([
            'year_id' => 'required|exists:years,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'semester_hidden' => 'required|in:1,2',
        ]);

        // Récupérer l'année scolaire et la classe
        $year = Year::findOrFail($request->year_id);
        $classroom = Classroom::findOrFail($request->classroom_id);

        // Récupérer les enregistrements pour l'année scolaire, la classe et le semestre spécifiés
        $recordings = Recording::where('year_id', $request->year_id)
            ->where('classroom_id', $request->classroom_id)
            ->with(['student', 'notes' => function ($query) use ($request) {
                $query->where('semester', $request->semester_hidden)->with('ratio', 'subject');
            }])
            ->get();

        // Vérification si les enregistrements existent
        if ($recordings->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun bulletin trouvé pour les critères sélectionnés.');
        }

        // Fonction pour déterminer l'appréciation
        function getAppreciation($note) {
            if ($note < 5) {
                return 'Médiocre';
            } elseif ($note >= 5 && $note < 10) {
                return 'Insuffisant';
            } elseif ($note >= 10 && $note < 12) {
                return 'Passable';
            } elseif ($note >= 12 && $note < 14) {
                return 'Assez Bien';
            } elseif ($note >= 14 && $note < 16) {
                return 'Bien';
            } elseif ($note >= 16 && $note < 19) {
                return 'Très Bien';
            } else {
                return 'Honorable';
            }
        }

        // Préparation des données pour chaque bulletin
        $bulletins = $recordings->map(function ($recording) use ($request) {
            $totalCoefficient = 0;
            $totalMoyenneCoefficiee = 0;

            $notes = $recording->notes->map(function ($note) use (&$totalCoefficient, &$totalMoyenneCoefficiee) {
                $coefficient = $note->ratio ? $note->ratio->ratio : 1;
                $moyenneCoefficiee = $note->note * $coefficient;

                $totalCoefficient += $coefficient;
                $totalMoyenneCoefficiee += $moyenneCoefficiee;

                return [
                    'subject' => $note->subject->subject,
                    'coefficient' => $coefficient,
                    'note' => $note->note,
                    'moyenne_coefficiee' => $moyenneCoefficiee,
                    'appreciation' => getAppreciation($note->note) // Ajouter l'appréciation
                ];
            });

            $moyenneGenerale = $totalCoefficient ? $totalMoyenneCoefficiee / $totalCoefficient : 0;

            return [
                'student' => $recording->student,
                'notes' => $notes,
                'total_moyenne_coefficiee' => $totalMoyenneCoefficiee,
                'moyenne_generale' => number_format($moyenneGenerale, 2)  // Formatage à 2 décimales
            ];
        });

        // Générer le PDF pour tous les bulletins
        $pdf = Pdf::loadView('dashboard.notes.printed.print', [
            'bulletins' => $bulletins,
            'year' => $year->year,
            'classroom' => $classroom->classroom,
            'semester' => $request->semester_hidden,
        ]);

        return $pdf->stream('bulletins.pdf');
    }




     }

