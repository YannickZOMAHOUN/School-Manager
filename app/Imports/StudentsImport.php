<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Recording;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Exception;

class StudentsImport implements ToModel, WithStartRow
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
     * Définir la ligne de départ pour l'importation (ligne 3)
     */
    public function startRow(): int
    {
        return 3; // Ignorer les deux premières lignes
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            // Gestion du format de la date (colonne F -> index 5 dans Excel)
            $birthday = Carbon::createFromFormat('d/m/Y', $row[5])->format('Y-m-d');
        } catch (Exception $e) {
            // Enregistrer l'erreur de format de date dans les logs
            Log::error("Erreur de format de date pour l'étudiant avec matricule {$row[1]} (Ligne Excel: " . json_encode($row) . "). Détails: " . $e->getMessage());
            return null; // Ignorer la ligne si la date est incorrecte, mais poursuivre l'importation
        }

        // Vérifier si l'étudiant existe déjà
        try {
            $existingStudent = Student::where('matricule', $row[1]) // Matricule est dans la colonne B (index 1)
                ->where('school_id', $this->school_id)
                ->first();

            if ($existingStudent) {
                // Enregistrer dans les logs si l'étudiant existe déjà
                Log::info("L'étudiant avec le matricule {$row[1]} existe déjà (Ligne Excel: " . json_encode($row) . ").");
                return null; // Ignorer cette ligne
            }
        } catch (Exception $e) {
            // Enregistrer toute erreur lors de la vérification de l'existence de l'étudiant
            Log::error("Erreur lors de la vérification de l'étudiant avec matricule {$row[1]} (Ligne Excel: " . json_encode($row) . "). Détails: " . $e->getMessage());
            return null; // Continuer à importer les autres lignes
        }

        try {
            // Envelopper dans une transaction pour garantir l'intégrité
            return DB::transaction(function () use ($row, $birthday) {
                // Créer un étudiant (en commençant à partir de la colonne B -> index 1)
                $student = Student::create([
                    'matricule' => $row[1],      // Colonne B
                    'name' => $row[2],           // Colonne C
                    'surname' => $row[3],        // Colonne D
                    'sex' => $row[4],            // Colonne E
                    'birthday' => $birthday,     // Colonne F
                    'birthplace' => $row[6],     // Colonne G
                    'school_id' => $this->school_id,
                ]);

                // Vérifier si un enregistrement pour cet étudiant existe déjà dans cette classe et année
                $existingRecording = Recording::where('student_id', $student->id)
                    ->where('classroom_id', $this->classroom_id)
                    ->where('year_id', $this->year_id)
                    ->first();

                if (!$existingRecording) {
                    // Créer un enregistrement dans Recording
                    Recording::create([
                        'student_id' => $student->id,
                        'classroom_id' => $this->classroom_id,
                        'year_id' => $this->year_id,
                        'school_id' => $this->school_id,
                    ]);
                } else {
                    // Enregistrer dans les logs si un enregistrement existe déjà
                    Log::info("Un enregistrement existe déjà pour l'étudiant avec matricule {$row[1]} dans la classe {$this->classroom_id} pour l'année {$this->year_id}.");
                }

                return $student;
            });
        } catch (Exception $e) {
            // Enregistrer toute autre erreur dans les logs
            Log::error("Erreur lors de l'importation de l'étudiant avec matricule {$row[1]} (Ligne Excel: " . json_encode($row) . "). Détails: " . $e->getMessage());
            return null; // Ignorer la ligne en cas d'erreur
        }
    }
}
