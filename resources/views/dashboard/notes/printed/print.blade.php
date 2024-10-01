<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin(s)</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .progress-card {
            width: 600px;
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
        }

        .progress-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        h1 {
            margin: 0;
            font-size: 22px;
            color: #34495E;
        }

        .header-title {
            background-color: #34495E;
            color: #fff;
            padding: 15px 0;
            margin-bottom: 20px;
            border-radius: 8px 8px 0 0;
        }

        .header-title .subtitle {
            font-size: 16px;
            font-weight: normal;
            margin-top: 5px;
        }

        .header-info {
            margin: 20px 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            font-size: 14px;
            color: #555;
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .grades-table th, .grades-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }

        .grades-table th {
            background-color: #34495E;
            color: white;
        }

        .grades-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .attendance {
            text-align: left;
            margin: 25px 0;
            font-size: 14px;
            color: #333;
        }

        .attendance h3 {
            font-size: 18px;
            color: #34495E;
            margin-bottom: 10px;
        }

        footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }

        footer div {
            margin-bottom: 5px;
        }

        .page-break {
            page-break-after: always;
        }

        @media print {
            body {
                background-color: white;
            }

            .progress-card {
                box-shadow: none;
                border-radius: 0;
                width: 100%;
            }

            footer {
                display: none;
            }

            .grades-table th, .grades-table td {
                border: 1px solid black;
            }
        }

        @media (max-width: 768px) {
            .progress-card {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    @foreach ($bulletins as $bulletin)
    <div class="progress-card">
        <div class="header-title">
            <h1>{{ auth()->user()->school->school }}</h1>
            <div class="subtitle">Bulletin de Notes</div>
        </div>

        <div class="header-info">
            <div>Nom : {{ $bulletin['student']['name'] }} {{ $bulletin['student']['surname'] }}</div>
            <div>Année scolaire : {{ $year }}</div>
            <div>Classe : {{ $classroom }}</div>
            <div>Semestre : {{ $semester }}</div>
            <div>Matricule : {{ $bulletin['student']['matricule'] }}</div>
            <div>Date et lieu de naissance : {{ \Carbon\Carbon::parse($bulletin['student']['birthday'])->format('d/m/Y') }} à {{ $bulletin['student']['birthplace'] }}</div>
        </div>

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

        <div class="attendance">
            <h3>Récapitulatif</h3>
            <div>Total des moyennes coefficientées : {{ $bulletin['total_moyenne_coefficiee'] }}</div>
            <div>Moyenne générale : {{ $bulletin['moyenne_generale'] }}</div>
        </div>

        <footer>
            <div>Votre Logo</div>
            <div>Contact : 123 Rue Christopher, Email : info@votresite.com, Téléphone : 123-456-7890</div>
        </footer>
    </div>

    <div class="page-break"></div>
    @endforeach

</body>
</html>
