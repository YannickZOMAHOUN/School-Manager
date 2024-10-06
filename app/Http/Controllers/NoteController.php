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
        $schoolId = auth()->user()->school->id;
        $recording = Recording::where('student_id', $student_id)
            ->where('school_id',$schoolId)
            ->with('student', 'classroom', 'year', 'notes') // Charger les relations nécessaires
            ->first();
        if (!$recording) {
            return redirect()->back()->with('error', 'Enregistrement non trouvé.');
        }
        $years = Year::where('school_id', $schoolId)->where('status',true)->get();
        $classrooms = Classroom::where('school_id', $schoolId)->get();
        return view('dashboard.notes.show', compact('recording', 'years', 'classrooms'));
    }

    public function getcards() {
        try {
            $schoolId = auth()->user()->school->id;
            $classrooms = Classroom::where('school_id', $schoolId)->get();
            $years = Year::where('school_id', $schoolId)->get();

            return view('dashboard.notes.card', compact([ 'classrooms', 'years']));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function index() {
        try {
            $schoolId = auth()->user()->school->id;
            $classrooms = Classroom::where('school_id', $schoolId)->get();
                        $years = Year::where('school_id', $schoolId)->where('status',true)->get();

            $subjects = Subject::where('school_id', $schoolId)->get();
            return view('dashboard.notes.list', compact([ 'classrooms', 'years','subjects']));
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
                      ->where('school_id', auth()->user()->school_id)
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
            $subjects = Subject::where('school_id', auth()->user()->school_id)->get();
            $classrooms = Classroom::where('school_id', auth()->user()->school_id)->get();
            $years = Year::where('school_id', auth()->user()->school_id)->where('status',true)->get();
            $students = Student::where('school_id', auth()->user()->school_id)->get();
            return view('dashboard.notes.create', compact(['subjects', 'classrooms', 'students', 'years']));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            abort(404);
        }
    }

    public function edit(Note $note) {
        try {
            $subjects = Subject::where('school_id', auth()->user()->school_id)->get();
            $classrooms = Classroom::where('school_id', auth()->user()->school_id)->get();
            $years = Year::where('school_id', auth()->user()->school_id)->where('status',true)->get();
            $students = Student::where('school_id', auth()->user()->school_id)->get();
            return view('dashboard.notes.edit', compact(['subjects', 'classrooms', 'students', 'years','note']));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            abort(404);
        }
    }
    public function update(Request $request,Note $note){
        try {
            $note->update([
                'note'=>$request->note,
                'classroom_id'=>$request->classroom,
                'subject_id'=>$request->subject,
                'school_id'=>auth()->user()->school->id,
            ]);
            return  redirect()->route('note.show');
            }catch (\Exception $e){
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
                ->where('school_id', auth()->user()->school_id)
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
                    ->where('school_id', auth()->user()->school_id)
                    ->get();

                $rankings = [];
                foreach ($students as $student) {
                    $studentNotes = Note::where('recording_id', $student->id)
                        ->where('semester', $request->semester)
                        ->with('ratio')
                        ->where('school_id', auth()->user()->school_id)
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
                        ->where('school_id', auth()->user()->school_id)
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


            public function getClassStudents(Request $request)
            {
                $students = Recording::where('year_id', $request->year_id)
                    ->where('classroom_id', $request->classroom_id)
                    ->where('school_id', auth()->user()->school_id)
                    ->with('student')
                    ->get()
                    ->pluck('student');

                return response()->json(['students' => $students]);
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
                ->where('school_id', auth()->user()->school_id)
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

            return $pdf->stream('classement-' . $classroom->classroom . '-semestre' . $request->semester_hidden . '-' . $year->year . '.pdf');
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

        // Récupérer l'année scolaire, la classe et l'école de l'utilisateur connecté
        $year = Year::findOrFail($request->year_id);
        $classroom = Classroom::findOrFail($request->classroom_id);
        $schoolId = auth()->user()->school->id;

        // Récupérer les enregistrements pour l'année scolaire, la classe, le semestre et l'école spécifiés
        $recordings = Recording::where('year_id', $request->year_id)
            ->where('classroom_id', $request->classroom_id)
            ->where('school_id', $schoolId)  // Filtrer par école
            ->with(['student', 'notes' => function ($query) use ($request) {
                $query->where('semester', $request->semester_hidden)->with('ratio', 'subject');
            }])
            ->get();

        // Vérification si les enregistrements existent
        if ($recordings->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun bulletin trouvé pour les critères sélectionnés.');
        }

        // Récupérer l'effectif de la classe pour cette année et cette école
        $classSize = Recording::where('year_id', $request->year_id)
            ->where('classroom_id', $request->classroom_id)
            ->where('school_id', $schoolId)
            ->count(); // Compter le nombre d'enregistrements (effectif)

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
            'classSize' => $classSize, // Ajout de l'effectif de la classe dans la vue
        ]);

        return $pdf->stream('Bulletins-'. $classroom->classroom . '-semestre' . $request->semester_hidden . '-' . $year->year . '.pdf');
    }

    public function loadNotes(Request $request)
    {
        $classroomId = $request->input('classroom');
        $yearId = $request->input('year');
        $subjectId = $request->input('subject');
        $semester = $request->input('semester');
        $schoolId = auth()->user()->school_id; // Assurez-vous que l'utilisateur est relié à une école

        // Récupération des notes en fonction des filtres
        $notes = Note::with(['recording.student']) // Chargez la relation student
            ->whereHas('recording', function ($query) use ($classroomId, $yearId, $schoolId) {
                $query->where('classroom_id', $classroomId)
                      ->where('year_id', $yearId)
                      ->where('school_id', auth()->user()->school_id)
                      ->where('school_id', $schoolId);
            })
            ->where('subject_id', $subjectId)
            ->where('semester', $semester)
            ->get();
    return response()->json($notes);
}
public function getNotes(Request $request)
{
    // Valider la requête entrante
    $request->validate([
        'year_id' => 'required|integer|exists:years,id',
        'classroom_id' => 'required|integer|exists:classrooms,id',
        'subject_id' => 'required|integer|exists:subjects,id',
        'semester' => 'required|string|in:1,2', // Ajustez selon vos besoins
    ]);

    try {
        $yearId = $request->year_id;
        $classroomId = $request->classroom_id;
        $subjectId = $request->subject_id;
        $semester = $request->semester;

        // Récupérer les étudiants dans la classe et l'année spécifiées
        $students = Student::whereHas('recordings', function ($query) use ($yearId, $classroomId) {
            $query->where('year_id', $yearId)
                  ->where('classroom_id', $classroomId)
                  ->where('school_id', auth()->user()->school_id);
        })->get(); // Pas besoin de charger les notes ici

        // Transformer les données
        $notesData = $students->map(function ($student) use ($yearId, $classroomId, $subjectId, $semester) {
            // Récupérer l'enregistrement de l'étudiant pour l'année et la classe spécifiées
            $recording = Recording::where('student_id', $student->id)
                ->where('year_id', $yearId)
                ->where('classroom_id', $classroomId)
                ->first();

            // Vérifier si l'enregistrement existe
            if ($recording) {
                // Récupérer la note associée à cet enregistrement
                $note = $recording->notes()->where('subject_id', $subjectId)
                                             ->where('semester', $semester)
                                             ->first();

                return [
                    'student_name' => $student->name,
                    'student_surname' => $student->surname,
                    'average' => $note ? $note->note : null, // Utilisez 'note' ici
                ];
            }

            // Si aucun enregistrement n'existe, renvoyer null pour la note
            return [
                'student_name' => $student->name,
                'student_surname' => $student->surname,
                'average' => null,
            ];
        });

        // Vérifier si notesData est vide
        if ($notesData->isEmpty()) {
            return response()->json(['message' => 'Aucune note trouvée.'], 404);
        }

        Log::info('Notes récupérées:', $notesData->toArray());
        return response()->json($notesData);
    } catch (\Exception $e) {
        Log::error('Erreur lors de la récupération des notes: ' . $e->getMessage());
        return response()->json(['message' => 'Erreur lors de la récupération des notes.'], 500);
    }
}

     }

