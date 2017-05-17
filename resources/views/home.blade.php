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
                        <div class="row">
                            <div class="col-lg-3">Dates:</div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">From</button>
                                    </span>
                                    <input id="salesStartDate" type="text" class="form-control" placeholder="Date 1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">To</button>
                                    </span>
                                    <input id="salesEndDate" type="text" class="form-control" placeholder="Date 1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <button id="submitSalesQuery" type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div><hr>
                        <div class="row">
                            <div class="col-md-12"><div id="loader" class=""></div>
                                <span id="recordsFound">0</span> record(s) found.
                                <button id="dlSalesReportBtn" type="button" class="btn btn-primary pull-right disabled">Download Report</button>

                                <div id="tableDiv"></div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="serviceDataTab">
                        <h4><strong>Service Data Filters</strong></h4><br>
                        <div class="row">
                            <div class="col-lg-3">Dates:</div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">From</button>
                                    </span>
                                    <input id="serviceStartDate" type="text" class="form-control" placeholder="Date 1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">To</button>
                                    </span>
                                    <input id="serviceEndDate" type="text" class="form-control" placeholder="Date 1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <button id="submitServiceQuery" type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div><hr>
                        <div class="row">
                            <div class="col-md-12"><div id="serviceLoader" class=""></div>
                                <span id="serviceReportRecordsFound">0</span> record(s) found.
                                <button id="dlServiceReportBtn" type="button" class="btn btn-primary pull-right disabled">Download Report</button>

                                <div id="serviceDiv"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
