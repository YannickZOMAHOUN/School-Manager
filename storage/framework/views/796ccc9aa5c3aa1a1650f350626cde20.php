<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin(s)</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif; /* Compatible avec Dompdf */
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        /* Table pour diviser l'en-tête en deux colonnes */
        .header-table {
            width: 100%;
        }

        .header-left {
            width: 50%;
            text-align: left;
        }

        .header-right {
            width: 50%;
            text-align: right;
        }

        .header-left img {
            height: 80px; /* Ajustez la hauteur du logo si nécessaire */
        }

        .header-right {
            font-size: 10px;
            line-height: 1.4;
        }

        .underline {
            display: block;
            width: 100%;
            border-bottom: 2px solid rgb(37, 39, 153);
            margin-top: 5px;
        }

        .progress-card {
            width: 100%;
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
            font-size: 18px;
            color: #34495E;
            text-align: center;
        }

        /* Informations de l'élève en colonnes */
        .header-info {
            width: 100%;
            margin-bottom: 10px;
        }

        .header-info-table {
            width: 100%;
            border-spacing: 10px; /* Espacement entre les colonnes */
        }

        .header-info-table td {
            font-size: 12px;
            vertical-align: top;
        }

        /* Informations de présence */
        .attendance {
            text-align: left;
            font-size: 12px;
            color: #333;
        }

        .attendance h3 {
            font-size: 14px;
            color: #34495E;
            margin-bottom: 10px;
        }

        footer {
            font-size: 10px;
            color: #777;
            text-align: center;
            margin-top: 30px;
        }

        .page-break {
            page-break-after: always; /* Pour forcer un saut de page entre les bulletins */
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .grades-table th, .grades-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        .grades-table th {
            background-color: #34495E;
            color: white;
        }

    </style>
</head>
<body>
    <?php $__currentLoopData = $bulletins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bulletin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-left">
                    <!-- Image du logo -->
                    <img src="<?php echo e(public_path('images/logobul.png')); ?>" alt="Logo du Bénin">
                </td>
                <td class="header-right">
                    Route de l'aéroport<br>
                    📫 : 10 BP 250 Cotonou<br>
                    📞 : (229) 21 32 38 43 ; Fax : 21 32 41 88<br>
                    web: www.enseignementsecondaire.gouv.bj
                </td>
            </tr>
        </table>
        <div class="underline"></div>
    </div>
    <div style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; text-align: center;">
        BULLETIN DE NOTES
    </div>

    <div class="progress-card">
        <!-- Titre de l'école et du bulletin -->
        <div class="header-title">
            <h1><?php echo e(auth()->user()->school->school); ?></h1>

        </div>

        <!-- Informations sur l'élève (Réparties sur 2 à 3 colonnes) -->
        <div class="header-info">
            <table class="header-info-table">
                <tr>
                    <td>Matricule : <?php echo e($bulletin['student']['matricule']); ?></td>
                    <td>Nom : <?php echo e($bulletin['student']['name']); ?> <?php echo e($bulletin['student']['surname']); ?></td>
                </tr>
                <tr>
                    <td>Date et lieu de naissance : <?php echo e(\Carbon\Carbon::parse($bulletin['student']['birthday'])->format('d/m/Y')); ?> à <?php echo e($bulletin['student']['birthplace']); ?></td>
                    <td>Année scolaire : <?php echo e($year); ?></td>

                </tr>
                <td>Classe : <?php echo e($classroom); ?></td>
                <td>Semestre : <?php echo e($semester); ?></td>
                <tr>
                    <td>Effectif de la classe : <?php echo e($classSize); ?></td>

                </tr>
            </table>
        </div>

        <!-- Tableau des notes -->
        <table class="grades-table">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Coefficient</th>
                    <th>Moyenne</th>
                    <th>Moyenne Coefficientée</th>
                    <th>Appréciation</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $bulletin['notes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($note['subject']); ?></td>
                    <td><?php echo e($note['coefficient']); ?></td>
                    <td><?php echo e($note['note']); ?></td>
                    <td><?php echo e($note['moyenne_coefficiee']); ?></td>
                    <td><?php echo e($note['appreciation']); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <!-- Section de présence -->
        <div class="attendance">
            <h3>Récapitulatif</h3>
            <div>Total des moyennes coefficientées : <?php echo e($bulletin['total_moyenne_coefficiee']); ?></div>
            <div>Moyenne générale : <?php echo e($bulletin['moyenne_generale']); ?></div>
        </div>

        <!-- Pied de page -->
        <footer>
            <div>Contact : 123 Rue Christopher...</div>
        </footer>
    </div>

    <!-- Saut de page entre chaque bulletin -->
    <div class="page-break"></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/notes/printed/print.blade.php ENDPATH**/ ?>