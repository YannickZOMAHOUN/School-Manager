<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin(s)</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-size: 14px;
            min-height: 100vh;
        }

        .header-info-table {
            width: 100%;
            border-spacing: 10px;
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
            border-bottom: 2px solid rgb(56,56,56);
            margin-top: 5px;
        }

        h1 {
            margin: 0;
            font-size: 18px;
            color: rgb(56,56,56);
            text-align: center;
        }

        .progress-card {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            position: relative; /* Pour le positionnement des signatures */
            box-sizing: border-box;
            min-height: calc(100vh - 200px); /* Ajuste la hauteur pour laisser de la place pour les signatures */
        }

        .header-info-table td {
            font-size: 12px;
            vertical-align: top;
            padding: 5px 0;
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .grades-table th, .grades-table td {
            border: 1px solid rgb(56,56,56);
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        .grades-table th {
            background-color: rgb(56,56,56);
            color: white;
        }

        .average, .stat, .appreciations {
            width: 30%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 2.5;
            display: inline-block;
            vertical-align: top;
        }

        .average {
            float: left;
        }

        .stat {
            float: left;
            margin-left: 5%;
        }

        .appreciations {
            float: right;
        }

        .signature-left {
            position: absolute;
            left: 5%;
            bottom: 200px; /* Ajusté pour rester en bas de la carte */
            text-align: left;
        }

        .signature-right {
            position: absolute;
            right: 5%;
            bottom: 200px; /* Ajusté pour rester en bas de la carte */
            text-align: right;
        }
        .signature {
            position: absolute;
            right: 5%;
            bottom: 150px; /* Ajusté pour rester en bas de la carte */
            text-align: right;
        }
        footer {
            font-size: 10px;
            color: rgb(56,56,56);
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .page-break {
            page-break-after: always;
        }

        strong {
            text-decoration: underline;
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

    <div style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; text-align: center; color: rgb(56,56,56);">
        BULLETIN DE NOTES
    </div>

    <div class="progress-card">
        <div class="header-title">
            <h1>{{ auth()->user()->school->school }}</h1>
        </div>

        <div class="header-info">
            <table class="header-info-table">
                <tr>
                    <td><strong>Matricule :</strong> {{ $bulletin['student']['matricule'] }}</td>
                    <td><strong>Nom : </strong>{{ $bulletin['student']['name'] }} {{ $bulletin['student']['surname'] }}</td>
                </tr>
                <tr>
                    <td><strong>Date et lieu de naissance :</strong>{{ \Carbon\Carbon::parse($bulletin['student']['birthday'])->format('d/m/Y') }} à {{ $bulletin['student']['birthplace'] }}</td>
                    <td><strong>Année scolaire :</strong> {{ $year }}</td>
                </tr>
                <tr>
                    <td><strong>Classe :</strong> {{ $classroom }}</td>
                    <td><strong>Semestre :</strong> {{ $semester }}</td>
                </tr>
                <tr>
                    <td><strong>Effectif de la classe :</strong> {{ $classSize }}</td>
                </tr>
            </table>
        </div>

        <table class="grades-table">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Coefficient</th>
                    <th>Moyenne /20</th>
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
                    <th colspan="4" class="text-end">Total :</th>
                    <th class="text-end">{{ $bulletin['total_moyenne_coefficiee'] }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="average">
            <div><strong>Moyenne générale : </strong>{{ $bulletin['moyenne_generale'] }}</div>
            <div><strong>En lettres :</strong> {{ $bulletin['en_lettres'] }}</div>
            <div><strong>Rang semestriel:</strong> {{ $bulletin['rank'] }}</div>
            @if ($semester == 2)
                <div><strong>Moyenne semestre 1: </strong>{{ $bulletin['moyenne_semestre'] }}</div>
                <div><strong>Moyenne Annuelle:</strong> {{ $bulletin['moyenne_annuelle'] }}</div>
                <div><strong>Rang Annuel: </strong>{{ $bulletin['annual_rank'] }}</div>
            @endif
        </div>

        <div class="stat">
            <div><strong>Plus forte moyenne:</strong> {{ $maxMoyenneSemestre }}</div>
            <div><strong>Plus faible moyenne: </strong>{{ $minMoyenneSemestre }}</div>
            @if ($semester == 2)
                <div><strong>Plus forte moyenne annuelle:</strong> {{ $maxMoyenneAnnuelle }}</div>
                <div><strong>Plus faible moyenne annuelle:</strong> {{ $minMoyenneAnnuelle }}</div>
            @endif
        </div>
        <div class="appreciations">
            <label style="margin-left: 20px;">
                <input type="checkbox" {{ $bulletin['moyenne_generale'] >= 14 ? 'checked' : '' }}> Félicitations
            </label> <br>
            <label style="margin-left: 20px;">
                <input type="checkbox" {{ $bulletin['moyenne_generale'] >= 10 && $bulletin['moyenne_generale'] < 14 ? 'checked' : '' }}> Encouragement
            </label> <br>
            <label style="margin-left: 20px;">
                <input type="checkbox" {{ $bulletin['moyenne_generale'] < 10 ? 'checked' : '' }}> Avertissement
            </label>
        </div>

        <div class="signature-left">
            <strong>Professeur(e) Principal(e)</strong>
        </div>
        <div class="signature-right">
            <p>{{ auth()->user()->school->city->name }} le {{ now()->format('d/m/Y') }}</p><br><br><br><br>
            <strong>{{ auth()->user()->staff->surname }} {{ auth()->user()->staff->name }}</strong>
        </div>
        <div class="signature"> {{ auth()->user()->staff->role->role_name }} du {{ auth()->user()->school->school }}</div>
    </div>

    <footer>
        Bulletin de l'année scolaire {{ $year }}, généré le {{ now()->format('d/m/Y') }}
    </footer>

    <div class="page-break"></div>
    @endforeach
</body>
</html>
