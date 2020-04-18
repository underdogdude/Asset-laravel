<!DOCTYPE html>
<html>
    <head>
        <title>Vida App Starter with Flat Admin V.3</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

        <link rel="stylesheet" type="text/css" href="{{asset('flat-admin/css/vendor.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('flat-admin/css/flat-admin.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('flat-admin/css/jasny-bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('flat-admin/css/sweetalert2.min.css')}}">

        <link rel="stylesheet" href="{{asset('flat-admin/css/codemirror.min.css')}}">
        <link href="{{asset('flat-admin/css/froala_editor.pkgd.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('flat-admin/css/froala_style.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('flat-admin/jquery.Thailand.js/dist/jquery.Thailand.min.css')}}" rel="stylesheet" type="text/css" />

        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700,700italic&subset=latin,vietnamese,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700&subset=latin,greek,greek-ext,vietnamese,cyrillic-ext,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('flat-admin/css/bootstrap-material-datetimepicker.css')}}">
        @yield('head')

    </head>

    <body>
        <div class="app app-default">

            @include('layouts.sidebar')

            <div class="app-container">

                @include('layouts.header')
                @include('layouts.float-button')

                @include('layouts.success-errors')
                @yield('content')
                @include('layouts.footer')

            </div>
        </div>
        <script type="text/javascript" src="{{asset('flat-admin/js/jquery-3.3.1.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/js/vendor.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/js/app.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/js/jasny-bootstrap.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/js/sweetalert2.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/js/codemirror.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/js/xml.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/js/froala_editor.pkgd.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/js/font_family.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/js/moment-with-locales.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/js/bootstrap-material-datetimepicker.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/jquery.Thailand.js/dependencies/zip.js/zip.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/jquery.Thailand.js/dependencies/JQL.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/jquery.Thailand.js/dependencies/typeahead.bundle.js')}}"></script>
        <script type="text/javascript" src="{{asset('flat-admin/jquery.Thailand.js/dist/jquery.Thailand.min.js')}}"></script>

        @yield('script')
    </body>

</html>
