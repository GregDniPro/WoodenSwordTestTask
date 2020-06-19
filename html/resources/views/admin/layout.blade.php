<html>
    <head>
        <meta charset="utf-8">
        <title>WoodenSwordTT @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="stylesheet" href="{{ asset('assets/css/theme/bootstrap.css') }}" media="screen">
        <link rel="stylesheet" href="{{ asset('assets/css/theme/custom.min.css') }}">
        @yield('css')
    </head>
    <body>
        <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
            <div class="container">
                <a href="{{ env('APP_URL') . '/adminpanel/groups' }}" class="navbar-brand">WS TestTask</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                </div>
                <p>Use <code>{{ env('APP_URL') }}/api/create</code> endpoint to create new users.</p>
            </div>
        </div>
        <div class="container">
            @if(Session::has('message'))
                <div class="alert alert-dismissible alert-{{ Session::get('alert-class', 'success') }}">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4 class="alert-heading">Hey!</h4>
                    <p class="mb-0">{{ Session::get('message') }}</p>
                </div>
            @endif
            @yield('content')
            <footer id="footer">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-unstyled">
                            <li class="float-lg-right"><a href="#top">Back to top</a></li>
                            <li><a target="_blank" href="https://github.com/GregDniPro/WoodenSwordTestTask">GitHub</a></li>
                        </ul>
                        <p>Made by <a href="https://www.linkedin.com/in/greg-hachatryan-196523116/" target="_blank">Gregory Hachatryan</a>.</p>
                    </div>
                </div>
            </footer>
        </div>
        <script src="{{ asset('assets/js/theme/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/theme/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/theme/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/theme/custom.js') }}"></script>
        @yield('js')
    </body>
</html>
