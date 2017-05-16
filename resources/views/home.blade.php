@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="col-md-3">
                Choose Dealership: 
            </div>
            <div class="col-md-3">
                <select class="form-control">
                  <option>Dealer Name 1</option>
                  <option>Dealer Name 2</option>
                </select>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
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
                            <div class="col-lg-3">Purchased Data:</div>
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
                                    <input id="salesDate2" type="text" class="form-control" placeholder="Date 1" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="row"><br>
                            <div class="col-lg-3">Option Label 1</div>
                            <div class="col-lg-3">
                                <select class="form-control">
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="row"><br>
                            <div class="col-lg-3">Option Label 2</div>
                            <div class="col-lg-3">
                                <select class="form-control">
                                    <option>Option 1</option>
                                    <option>Option 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="row"><hr>
                            <div class="col-lg-3">
                                <button id="submitSalesQuery" type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="serviceDataTab">
                        <h4><strong>Service Data Filters</strong></h4><br>
                        <div class="row">
                            <div class="col-lg-3">Purchased Data:</div>
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
                        </div>
                        <div class="row"><br>
                            <div class="col-lg-3">Option Label 1</div>
                            <div class="col-lg-3">
                                <select class="form-control">
                                    <option>Service Option 1</option>
                                    <option>Service Option 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="row"><br>
                            <div class="col-lg-3">Option Label 2</div>
                            <div class="col-lg-3">
                                <select class="form-control">
                                    <option>Service Option 1</option>
                                    <option>Service Option 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="row"><hr>
                            <div class="col-lg-3">
                                <button id="submitServiceQuery" type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row"><hr>
        <div class="col-md-12"><div id="loader" class=""></div>
            <span id="recordsFound">0</span> record(s) found.
            <button id="dlSalesReport" type="button" class="btn btn-primary pull-right">Download Report</button>

            <div id="tableDiv"></div>
        </div>
    </div>
</div>
@endsection
