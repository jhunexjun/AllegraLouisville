@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12"><br>
                <div role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#salesDataTab" aria-controls="salesDataTab" role="tab" data-toggle="tab">Sales Data</a></li>
                        <li role="presentation"><a href="#serviceDataTab" aria-controls="serviceDataTab" role="tab" data-toggle="tab">Service Data</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="salesDataTab">
                            <h4><strong>Sales Data Filters</strong></h4><br>
                            <form method="get" action="sales">
                                <div class="row">
                                    <div class="col-lg-3">Purchase Date:</div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">From</button>
                                            </span>
                                            <input id="salesStartDate" name="salesStartDate" type="text" class="form-control" placeholder="MM/dd/YYYY" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">To</button>
                                            </span>
                                            <input id="salesEndDate" name="salesEndDate" type="text" class="form-control" placeholder="MM/dd/YYYY" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button id="submitSalesQuery" type="submit" type="button" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form><hr>
                            <div class="row">
                                <div class="col-md-12"><div id="salesLoader" class="loader"></div>
                                    <span id="recordsFound">0</span> record(s) found.
                                    <button id="dlSalesReportBtn" type="button" class="btn btn-primary pull-right disabled">Download Report</button>

                                    <div id="FISalesTableDiv"></div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="serviceDataTab">
                            <h4><strong>Service Data Filters</strong></h4><br>
                            <form method="get" action="service">
                                <div class="row">
                                    <div class="col-lg-3">Repair Order Date:</div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">From</button>
                                            </span>
                                            <input id="serviceStartDate" name="serviceStartDate" type="text" class="form-control" placeholder="MM/dd/YYYY" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">To</button>
                                            </span>
                                            <input id="serviceEndDate" name="serviceEndDate" type="text" class="form-control" placeholder="MM/dd/YYYY" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button id="submitServiceQuery" type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form><hr>
                            <div class="row">
                                <div class="col-md-12"><div id="serviceLoader" class=""></div>
                                    <span id="serviceReportRecordsFound">0</span> record(s) found.
                                    <button id="dlServiceReportBtn" type="button" class="btn btn-primary pull-right disabled">Download Report</button>

                                    <div id="serviceDiv"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><hr>
            </div>
        </div>
    </div>
@endsection

@push('scriptsForSales')
    <script type="text/javascript">
        $(function() {
            // Datepickers
            $( "#salesStartDate" ).datepicker();
            $( "#salesEndDate" ).datepicker();
            $( "#serviceStartDate" ).datepicker();
            $( "#serviceEndDate" ).datepicker();
            // end Datepickers

            var dlSalesReportBtn = $("#dlSalesReportBtn");

            function replaceEmptyObjectInAnArrayOrObject(arrayOrObject) {
                this.arrayOrObject = arrayOrObject;

                // this will avoid [object Object] in the DataTable values.
                this.getSanitized = function() {
                    var that = this.arrayOrObject;

                    if (this.arrayOrObject.constructor !== Array) {  // Means there are only 1 returned item.
                        $.each(this.arrayOrObject, function(key, value) {
                            if (typeof value === "object")
                                that[key] = "";
                        });                        
                    } else {    // if arrayOrObject is actually array of objects
                        $.each(this.arrayOrObject, function(key, value) {
                            $.each(value, function(key2, value2) {
                                if (typeof value2 === "object")
                                    that[key][key2] = "";
                            });
                        });
                    }

                    return this.arrayOrObject;
                }
            };

            $("#submitSalesQuery").on("click", function (event) {
                $('#salesLoader').addClass('loader');
                $('#recordsFound').text("0");
                $("#tableDiv").empty();
                dlSalesReportBtn.addClass("disabled");

                var salesStartDate = $( "#salesStartDate" ).val();
                var salesEndDate = $( "#salesEndDate" ).val();

                if (!salesStartDate || !salesEndDate) {
                    $('#salesLoader').removeClass('loader');
                    alert("Please specify start and end date.");
                    $( "#salesStartDate" ).focus();
                    event.preventDefault();
                    return;
                }
            });

            var result = {!! $result !!};

            var sanitizedFISalesClosed = new replaceEmptyObjectInAnArrayOrObject(result.FISalesClosed);
            result.FISalesClosed = sanitizedFISalesClosed.getSanitized();

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

            $("#FISalesTableDiv").empty();
            $("#FISalesTableDiv").append('<table id="FI_SalesClosedTable" class="display" cellspacing="0" width="100%"><thead><tr>' + tableHeaders + '</tr></thead></table>');
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
            $('#salesLoader').removeClass('loader');

            // event for download FI SalesClosed report
            dlSalesReportBtn.on("click", function() {
                if (dlSalesReportBtn.hasClass('disabled'))
                    return;

                var FI_SalesClosedTable = $("#FI_SalesClosedTable").DataTable();
                var csvContent = '';

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

                var blob = new Blob([csvContent],{type: "text/csv;charset=utf-8;"});

                if (navigator.msSaveBlob) { // IE 10+
                    navigator.msSaveBlob(blob, "FI_SalesClosed.csv")
                } else {
                    var link = document.createElement("a");
                    if (link.download !== undefined) { // feature detection
                        // Browsers that support HTML5 download attribute
                        var url = URL.createObjectURL(blob);
                        link.setAttribute("href", url);
                        link.setAttribute("download", "FI_SalesClosed.csv");
                        link.style = "visibility:hidden";
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                }
            }); // end event for download sales report
        });
    </script>
@endpush
