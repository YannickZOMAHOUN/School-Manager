<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>School Manager</title>

    <!-- Preconnect to Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Include CSS files -->
    @include("layouts.css")

    <!-- Additional CSS -->
    @yield("another_CSS")

    <style>
        #spinner {
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #spinner:before {
            content: "";
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 20000;
            background-color: rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body>

    <!-- Include Header -->
    @include("layouts.header")

    <!-- Include Sidebar -->
    @include("layouts.sidebar")

    <main id="main" class="main">
        @yield("content")
    </main>



    <footer id="footer" class="footer">
        <div class="copyright">
            &copy;{{date('Y') }} <strong>{{auth()->user()->school->school }}</strong></span></strong> powered by <strong><span class="fw-bold"> Zym SOLUTIONS</span></strong>
        </div>
    </footer>

    <!-- Include JavaScript files -->
    @include("layouts.js")

    <!-- Additional JavaScript -->
    @yield("another_Js")

    <script type="text/javascript">
        document.onreadystatechange = function() {
            if (document.readyState === "complete") {
                $('#spinner').hide();
            }
        };

        function showLoader() {
            $('#spinner').show();
        }
    </script>

</body>

</html>
