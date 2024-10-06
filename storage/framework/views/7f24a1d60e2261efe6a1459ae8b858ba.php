<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement des élèves</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Classement des élèves</h2>

    <p>
        <strong>Année scolaire : </strong><?php echo e($year); ?> |
        <strong>Classe : </strong><?php echo e($classroom); ?> |
        <strong>Semestre : </strong><?php echo e($semester_hidden); ?>

    </p>

    <table>
        <thead>
            <tr>
                <th>Rang</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Moyenne Générale</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $rankings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ranking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($ranking['rank']); ?></td>
                    <td><?php echo e($ranking['student']->name); ?></td>
                    <td><?php echo e($ranking['student']->surname); ?></td>
                    <td class="text-center"><?php echo e(number_format($ranking['moyenne_generale'], 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</body>
</html>
<?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/notes/printed/print-classement.blade.php ENDPATH**/ ?>