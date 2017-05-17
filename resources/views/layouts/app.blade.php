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
                    <a class="navbar-brand" href="{{ url('/home') }}">
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
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        @if (Auth::user()->admin)
                                            <a href="{{ route('register') }}">Add user</a>
                                        @endif

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
            $( "#salesStartDate" ).datepicker();
            $( "#salesEndDate" ).datepicker();
            $( "#serviceStartDate" ).datepicker();
            $( "#serviceEndDate" ).datepicker();
            // end Datepicker

            var dlSalesReportBtn = $("#dlSalesReportBtn");

            // Sales query
            $("#submitSalesQuery").on("click", function (event) {
                $('#loader').addClass('loader');
                $('#recordsFound').text("0");
                $("#tableDiv").empty();
                dlSalesReportBtn.addClass("disabled");

                var salesStartDate = $( "#salesStartDate" ).val();
                var salesEndDate = $( "#salesEndDate" ).val();

                if (!salesStartDate || !salesEndDate) {
                    $('#loader').removeClass('loader');
                    alert("Please specify start and end date.");
                    $( "#salesStartDate" ).focus();
                    return;
                }

                var queryParams = "salesStartDate=" + salesStartDate + "&salesEndDate=" + salesEndDate;

                $.get("{{ Request::root() }}/api/sales?" + queryParams, function(result) {
                    if (!result.FISalesClosed) {
                        $('#loader').removeClass('loader');
                        alert ('No data available.');
                        return;
                    }

                    if (result.error) {
                        $('#loader').removeClass('loader');
                        alert(result.message);
                        $( "#salesStartDate" ).focus();
                        return;
                    }

                    var tableHeaders = '', columns = [], sanitizedData = [];

                    // Note: when the returned json returns only 1 row of result.FISalesClosed, it's an object not array of objects. So they have diff implementation because $('DataTable')rows.add() only accepts array.
                    if (result.FISalesClosed.constructor !== Array) {  // Means there are only 1 returned item.
                        $.each(result.FISalesClosed, function(key, val){
                            tableHeaders += "<th>" + key + "</th>";
                            columns.push({data: key});
                        });

                        sanitizedData.push(result.FISalesClosed);
                    } else {
                        $.each(result.FISalesClosed[0], function(key, val){
                            tableHeaders += "<th>" + key + "</th>";
                            columns.push({data: key});
                        });

                        sanitizedData = result.FISalesClosed;
                    }

                    $("#tableDiv").empty();
                    $("#tableDiv").append('<table id="FI_SalesClosedTable" class="display" cellspacing="0" width="100%"><thead><tr>' + tableHeaders + '</tr></thead></table>');
                    var dtConstructorObj = {
                                            "scrollX": true,
                                            "columns": columns,
                                            rowCallback: function (row, data) {},
                                            filter: false,
                                            info: false,
                                            ordering: false,
                                            processing: true,
                                            retrieve: true,
                                        };

                    var FI_SalesClosedTable = $("#FI_SalesClosedTable").DataTable(dtConstructorObj);

                    FI_SalesClosedTable.clear().draw();
                    FI_SalesClosedTable.rows.add(sanitizedData).draw();

                    $('#recordsFound').text(FI_SalesClosedTable.rows().data().length);
                    dlSalesReportBtn.removeClass("disabled");
                    $('#loader').removeClass('loader');
                });
            });

            // event for download FI SalesClosed report
            dlSalesReportBtn.on("click", function() {
                var FI_SalesClosedTable = $("#FI_SalesClosedTable").DataTable();
                var csvContent = "data:text/csv;charset=utf-8,";

                // get the columns
                var columns = FI_SalesClosedTable.data()[0];

                $.each(columns, function(key, value) {
                    csvContent += key + ',';
                });

                csvContent = csvContent.substring(0, csvContent.length - 1);    // remove the the last character, i.e. ","
                csvContent += "\r\n";

                var data = FI_SalesClosedTable.data();
                $.each(data, function(key, value) {
                    $.each(value, function(key, value) {
                        // In their API, if the value is an object, means null value
                        if (typeof value != "object")
                            csvContent += "\"" + value + "\"";

                        csvContent += ",";
                    });

                    csvContent = csvContent.substring(0, csvContent.length - 1);
                    csvContent += "\r\n";
                });

                var encodedUri = encodeURI(csvContent);
                window.open(encodedUri);
            }); // end event for download sales report


            // Service query
            $("#submitServiceQuery").on("click", function (event) {
                $.get("{{ Request::root() }}/api/testServiceJson", function(result) {
                    datatableObj.clear().draw();
                    datatableObj.rows.add(result).draw();
                });
            });


        });
    </script>
</body>
</html>
