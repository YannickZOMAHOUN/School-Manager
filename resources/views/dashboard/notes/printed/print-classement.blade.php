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
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
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
            margin-bottom: 20px;
        }
        .text-center {
            text-align: center;
        }
        .highlight {
            background-color: #dff0d8; /* Vert clair pour les élèves en tête */
        }
    </style>
</head>
<body>

    <h2>Classement des élèves</h2>

    <p>
        <strong>Année scolaire : </strong>{{ $year }} |
        <strong>Classe : </strong>{{ $classroom }} |
        <strong>Semestre : </strong>{{ $semester_hidden == 1 ? '1' : '2' }}
    </p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rang</th>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Moyenne Générale</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankings as $ranking)
                <tr>
                    <td>{{ $ranking['rank_text'] }}</td>
                    <td>{{ $ranking['student']->matricule }}</td>
                    <td>{{ $ranking['student']->name }}</td>
                    <td>{{ $ranking['student']->surname }}</td>
                    <td>{{ number_format($ranking['moyenne_generale'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
