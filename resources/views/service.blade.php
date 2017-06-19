@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12"><br>
                <div role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation"><a href="#salesDataTab" aria-controls="salesDataTab" role="tab" data-toggle="tab">Sales Data</a></li>
                        <li role="presentation" class="active"><a href="#serviceDataTab" aria-controls="serviceDataTab" role="tab" data-toggle="tab">Service Data</a></li>
                    </ul>

                    <!-- Sales tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane" id="salesDataTab">
                            <h4><strong>Sales Data Filters</strong></h4><br>
                            <form method="get" action="sales">
                                <div class="row">
                                    <div class="col-lg-3">Dealer ID</div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <select id="dealerIDforSalesTab" name="dealerID" class="form-control">
                                                @foreach ($dealerIDs as $dealerID)
                                                    <option value="{{ $dealerID->dealerId }}">{{ $dealerID->dealerId }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div><br>
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
                                <div class="col-md-12">
                                    <span id="salesReportRecordsFound">0</span> record(s) found.
                                    <button id="dlSalesReportBtn" type="button" class="btn btn-primary pull-right disabled">Download Report</button>

                                    <div id="FISalesTableDev"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Service tab panes -->
                        <div role="tabpanel" class="tab-pane active" id="serviceDataTab">
                            <h4><strong>Service Data Filters</strong></h4><br>
                            <form method="get" action="service">
                                <div class="row">
                                    <div class="col-lg-3">Dealer ID</div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <select id="dealerIDforServiceTab" name="dealerID" class="form-control">
                                                @foreach ($dealerIDs as $dealerID)
                                                    <option value="{{ $dealerID->dealerId }}">{{ $dealerID->dealerId }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div><br>
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
                                <div class="col-md-12">
                                    <span id="serviceReportRecordsFound">0</span> record(s) found.
                                    <button id="dlServiceReportBtn" type="button" class="btn btn-primary pull-right disabled">Download Report</button>

                                    <div id="serviceDiv"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><hr>
                <div id="loader" class="loader"></div>
            </div>
        </div>
    </div>
@endsection

@push('scriptsForSales')
    <script type="text/javascript">
        $(function() {
            // default the dates based from url param
            var getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : sParameterName[1];
                    }
                }
            };

            $('#serviceStartDate').val(getUrlParameter('serviceStartDate'))
            $('#serviceEndDate').val(getUrlParameter('serviceEndDate'))
            $('#dealerIDforServiceTab').val(getUrlParameter('dealerID'))


            // Datepickers
            $( "#salesStartDate" ).datepicker();
            $( "#salesEndDate" ).datepicker();
            $( "#serviceStartDate" ).datepicker();
            $( "#serviceEndDate" ).datepicker();
            // end Datepickers

            var dlSalesReportBtn = $("#dlSalesReportBtn");
            var dlServiceReportBtn = $('#dlServiceReportBtn');

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
                $('#loader').addClass('loader');
                $('#salesReportRecordsFound').text("0");
                $("#FISalesTableDev").empty();
                dlSalesReportBtn.addClass("disabled");

                var salesStartDate = $( "#salesStartDate" ).val();
                var salesEndDate = $( "#salesEndDate" ).val();

                if (!salesStartDate || !salesEndDate) {
                    $('#loader').removeClass('loader');
                    alert("Please specify start and end date.");
                    $( "#salesStartDate" ).focus();
                    event.preventDefault();
                    return;
                }
            });

            $("#submitServiceQuery").on("click", function (event) {
                $('#loader').addClass('loader');
                $('#serviceReportRecordsFound').text("0");
                $("#serviceDiv").empty();
                dlServiceReportBtn.addClass("disabled");

                var serviceStartDate = $( "#serviceStartDate" ).val();
                var serviceEndDate = $( "#serviceEndDate" ).val();

                if (!serviceStartDate || !serviceEndDate) {
                    $('#loader').removeClass('loader');
                    alert("Please specify start and end date.");
                    $( "#serviceStartDate" ).focus();
                    event.preventDefault();
                    return;
                }
            });

            var result = {!! $result !!};

            if (!result.ServiceSalesClosed) {
                $('#loader').removeClass('loader');
                alert ('No data available.');
                return;
            }

            if (result.error) {
                $('#loader').removeClass('loader');
                alert(result.message);
                return;
            }

            var sanitizedServiceSalesClosed = new replaceEmptyObjectInAnArrayOrObject(result.ServiceSalesClosed);
            result.ServiceSalesClosed = sanitizedServiceSalesClosed.getSanitized();

            var tableHeaders = '', columns = [], sanitizedData = [];

            // Note: when the returned json returns only 1 row of result.ServiceSalesClosed, it's an object not array of objects. So they have diff implementation because $('DataTable')rows.add() only accepts array.
            if (result.ServiceSalesClosed.constructor !== Array) {  // Means there are only 1 returned item.
                $.each(result.ServiceSalesClosed, function(key, val){
                    tableHeaders += "<th>" + key + "</th>";
                    columns.push({data: key});
                });

                sanitizedData.push(result.ServiceSalesClosed);
            } else {
                $.each(result.ServiceSalesClosed[0], function(key, val){
                    tableHeaders += "<th>" + key + "</th>";
                    columns.push({data: key});
                });

                sanitizedData = result.ServiceSalesClosed;
            }

            $("#serviceDiv").empty();
            $("#serviceDiv").append('<table id="Service_SalesClosedTable" class="display" cellspacing="0" width="100%"><thead><tr>' + tableHeaders + '</tr></thead></table>');
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

            var Service_SalesClosedTable = $("#Service_SalesClosedTable").DataTable(dtConstructorObj);

            Service_SalesClosedTable.clear().draw();
            Service_SalesClosedTable.rows.add(sanitizedData).draw();

            $('#serviceReportRecordsFound').text(Service_SalesClosedTable.rows().data().length);
            dlServiceReportBtn.removeClass("disabled");
            $('#loader').removeClass('loader');

            // event for download Service Sales Closed report
            dlServiceReportBtn.on("click", function() {
                if (dlServiceReportBtn.hasClass('disabled'))
                    return;

                var Service_SalesClosedTable = $("#Service_SalesClosedTable").DataTable();
                var csvContent = '';

                // get the columns
                var columns = Service_SalesClosedTable.data()[0];

                $.each(columns, function(key, value) {
                    csvContent += key + ',';
                });

                csvContent = csvContent.substring(0, csvContent.length - 1);    // remove the the last character, i.e. ","
                csvContent += "\r\n";

                var data = Service_SalesClosedTable.data();
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
                    navigator.msSaveBlob(blob, "service_sales_closed.csv")
                } else {
                    var link = document.createElement("a");
                    if (link.download !== undefined) { // feature detection
                        // Browsers that support HTML5 download attribute
                        var url = URL.createObjectURL(blob);
                        link.setAttribute("href", url);
                        link.setAttribute("download", "service_sales_closed.csv");
                        link.style = "visibility:hidden";
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                }
            }); // end event for download service sales report
        });
    </script>
@endpush
