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
                                    <input id="date1" type="text" class="form-control" placeholder="Date 1" value="" />
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">To</button>
                                    </span>
                                    <input id="date2" type="text" class="form-control" placeholder="Date 1" value="" />
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->
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
                                <button type="button" class="btn btn-primary">Submit</button>
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
                                    <input id="date1" type="text" class="form-control" placeholder="Date 1" value="" />
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">To</button>
                                    </span>
                                    <input id="date2" type="text" class="form-control" placeholder="Date 1" value="" />
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->
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
                                <button type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row"><hr>
        <div class="col-md-12">
            <span id="recordsFound">0</span> records found.
            <button type="button" class="btn btn-primary pull-right">Save Report</button>

            <table id="table_id" class="display" cellspacing="5" width="100%">
                <thead>
                    <tr>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Position</th>
                        <th>Address</th>
                        <th>Birthday</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Position</th>
                        <th>Address</th>
                        <th>Birthday</th>
                        <th>Salary</th>
                    </tr>
                </tfoot>    
            </table>
        </div>
    </div>
</div>
@endsection
