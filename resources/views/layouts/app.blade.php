<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.15/css/jquery.dataTables.css">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- <script src="//code.jquery.com/jquery-1.10.2.min.js"></script> -->
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            // Datepicker
            $( "#salesDate1" ).datepicker();
            $( "#salesDate2" ).datepicker();
            $( "#serviceDate1" ).datepicker();
            $( "#serviceDate2" ).datepicker();
            // end Datepicker

            // definations of Datatable
            var datatableObj = $("#table_id").DataTable({
                data:[],
                rowCallback: function (row, data) {},
                    filter: false,
                    info: false,
                    ordering: false,
                    processing: true,
                    retrieve: true
            });

            $("#submitSalesQuery").on("click", function (event) {
                $.get("{{ Request::root() }}/api/testJson", function(result) {
                    datatableObj.clear().draw();
                    datatableObj.rows.add(result).draw();
                });
            });

            $("#submitServiceQuery").on("click", function (event) {
                $.get("{{ Request::root() }}/api/testServiceJson", function(result) {
                    datatableObj.clear().draw();
                    datatableObj.rows.add(result).draw();
                });
            });
            // end definations of Datatable

            // event for Save Report
            $("#saveReport").on("click", function() {
                var url = "http://170.168.21.55/api/testJson";

                $.get(url, function(result) {
                    var csvContent = "data:text/csv;charset=utf-8,";
                    result.forEach(function(infoArray, index) {

                       dataString = infoArray.join(",");
                       csvContent += index < result.length ? dataString+ "\n" : dataString;

                    });

                    var encodedUri = encodeURI(csvContent);
                    window.open(encodedUri);
                });
            });
            // end event for Save Report

        });
    </script>
</body>
</html>
