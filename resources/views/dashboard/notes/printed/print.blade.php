<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin(s)</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        td {
            background-color: #fff;
        }
        h2 {
            color: #0056b3;
            font-size: 20px;
            margin-top: 0;
        }
        p {
            margin: 8px 0;
            color: #555;
        }
        .total, .average {
            font-weight: bold;
            color: #333;
        }
        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }
        .page-break {
            page-break-after: always;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            height: auto;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="container">
    @foreach ($bulletins as $bulletin)
    <div class="header">
        <h1>Bulletin de Notes</h1>
    </div>
        <div class="page-break">
            <h2>Bulletin de {{ $bulletin['student']['name'] }} {{ $bulletin['student']['surname'] }}</h2>
            <p><strong>Année scolaire:</strong> {{ $year }}</p>
            <p><strong>Classe:</strong> {{ $classroom }}</p>
            <p><strong>Semestre:</strong> {{ $semester }}</p>

            <table>
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Coefficient</th>
                        <th>Moyenne</th>
                        <th>Moyenne Coefficiée</th>
                        <th>Appréciation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bulletin['notes'] as $note)
                        <tr>
                            <td>{{ $note['subject'] }}</td>
                            <td>{{ $note['coefficient'] }}</td>
                            <td>{{ $note['note'] }}</td>
                            <td>{{ $note['moyenne_coefficiee'] }}</td>
                            <td>{{ $note['appreciation'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="total"><strong>Total Moyenne Coefficiée:</strong> {{ $bulletin['total_moyenne_coefficiee'] }}</p>
            <p class="average"><strong>Moyenne Générale:</strong> {{ $bulletin['moyenne_generale'] }}</p>

            <hr>
        </div>
    @endforeach
</div>

</body>
</html>
