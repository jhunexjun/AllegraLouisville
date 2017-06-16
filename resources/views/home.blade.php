@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
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
                                <div class="col-lg-3">Dealer ID</div>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <select id="" class="form-control">
                                            
                                            <option value="">3PAACONCEPTSDEV1</option>
                                            <option value="">3PAACONCEPTSDEV2</option>
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
                                    <button id="submitSalesQuery" type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- service tab -->
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
                                    <button id="submitServiceQuery" type="submit" type="button" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><hr>
            <div id="loaderDiv"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts-dtPicker')
    <script type="text/javascript">
        $(function() {
            // Datepickers
            $( "#salesStartDate" ).datepicker();
            $( "#salesEndDate" ).datepicker();
            $( "#serviceStartDate" ).datepicker();
            $( "#serviceEndDate" ).datepicker();
            // end Datepickers

            $('#submitSalesQuery').on('click', function(event) {
                $('#loaderDiv').addClass('loader');

                var salesStartDate = $( "#salesStartDate" ).val();
                var salesEndDate = $( "#salesEndDate" ).val();

                if (!salesStartDate || !salesEndDate) {
                    $('#loaderDiv').removeClass('loader');
                    alert("Please specify start and end date.");
                    $( "#salesStartDate" ).focus();
                    event.preventDefault();
                    return;
                }
            });
            $('#submitServiceQuery').on('click', function() {
                $('#loaderDiv').addClass('loader');
                
                var serviceStartDate = $( "#serviceStartDate" ).val();
                var serviceEndDate = $( "#serviceEndDate" ).val();

                if (!serviceStartDate || !serviceEndDate) {
                    $('#loaderDiv').removeClass('loader');
                    alert("Please specify start and end date.");
                    $( "#serviceStartDate" ).focus();
                    event.preventDefault();
                    return;
                }
            });
        });
    </script>
@endpush()
