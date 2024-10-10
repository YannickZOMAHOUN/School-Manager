<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin(s)</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .header {
            width: 100%;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

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
            font-size: 10px;
            line-height: 1.4;
        }

        .header-left img {
            height: 80px;
        }

        .underline {
            display: block;
            width: 100%;
            border-bottom: 2px solid #1d3557;
            margin-top: 5px;
        }

        h1 {
            margin: 0;
            font-size: 18px;
            color: #2c3e50;
            text-align: center;
        }

        .progress-card {
            width: 100%;
            background-color: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .header-info-table td {
            font-size: 12px;
            vertical-align: top;
            padding: 5px 0;
        }

        /* Grades table */
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
            background-color: #457b9d;
            color: white;
        }

        /* Average block */
        .average {
            width: 30%;
            float: left;
            background-color: #e8f0fe;
            padding: 10px;
            border-radius: 8px;
            margin-right: 20px;
            font-size: 12px;
        }

        /* Stat block */
        .stat {
            width: 30%;
            float: left;
            background-color: #fef5e7;
            padding: 10px;
            border-radius: 8px;
            font-size: 12px;
        }

        .signature {
            clear: both;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
        }

        .signature-left {
            float: left;
            width: 40%;
            text-align: center;
        }

        .signature-right {
            float: right;
            width: 40%;
            text-align: center;
        }

        footer {
            font-size: 10px;
            color: #777;
            text-align: center;
            margin-top: 30px;
        }

        .page-break {
            page-break-after: always;
        }

    </style>
</head>
<body>
    @foreach ($bulletins as $bulletin)
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-left">
                    <img src="{{ public_path('images/logobul.png') }}" alt="Logo du Bénin">
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
        <div class="header-title">
            <h1>{{ auth()->user()->school->school }}</h1>
        </div>

        <div class="header-info">
            <table class="header-info-table">
                <tr>
                    <td>Matricule : {{ $bulletin['student']['matricule'] }}</td>
                    <td>Nom : {{ $bulletin['student']['name'] }} {{ $bulletin['student']['surname'] }}</td>
                </tr>
                <tr>
                    <td>Date et lieu de naissance : {{ \Carbon\Carbon::parse($bulletin['student']['birthday'])->format('d/m/Y') }} à {{ $bulletin['student']['birthplace'] }}</td>
                    <td>Année scolaire : {{ $year }}</td>
                </tr>
                <tr>
                    <td>Classe : {{ $classroom }}</td>
                    <td>Semestre : {{ $semester }}</td>
                </tr>
                <tr>
                    <td>Effectif de la classe : {{ $classSize }}</td>
                </tr>
            </table>
        </div>

        <table class="grades-table">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Coefficient</th>
                    <th>Moyenne /20 </th>
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
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total :</th>
                    <th class="text-end">{{ $bulletin['total_moyenne_coefficiee']}}</th>
                </tr>
            </tfoot>
        </table>

        <div class="average">
            <div>Moyenne générale : {{ $bulletin['moyenne_generale'] }}</div>
            <div>En lettres : {{ $bulletin['en_lettres'] }}</div>
            <div>Rang semestriel: {{ $bulletin['rank']}}</div>

            @if ($semester == 2)
                <div>Moyenne semestre 1: {{ $bulletin['moyenne_semestre'] }}</div>
                <div>Moyenne Annuelle: {{ $bulletin['moyenne_annuelle'] }}</div>
                <div>Rang Annuel: {{ $bulletin['annual_rank'] }}</div>
            @endif
        </div>

        <div class="stat">
            <div> Plus forte moyenne:{{ $maxMoyenneSemestre}} </div>
            <div> Plus faible moyenne:{{$minMoyenneSemestre}} </div>
            @if ($semester == 2)
                <div>Plus forte moyenne annuelle: {{ $maxMoyenneAnnuelle}}</div>
                <div>Plus faible moyenne annuelle: {{ $minMoyenneAnnuelle }}</div>
            @endif
        </div>

        <div class="signature">
            <div>{{ auth()->user()->school->city->name }} le {{ date('d/m/y') }}</div>
            <div class="signature-left">Professeur(e) Principal(e)</div>
            <div class="signature-right">{{ auth()->user()->staff->surname }} {{ auth()->user()->staff->name}} <br> {{ auth()->user()->staff->role->role_name}} du {{ auth()->user()->school->school}} </div>
        </div>

        <footer>
            <div>Contact : Yannick ZOMAHOUN +229 68-37-49-02.</div>
        </footer>
    </div>
    <div class="page-break"></div>
    @endforeach
</body>
</html>
