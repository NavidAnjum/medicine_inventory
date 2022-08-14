@extends('layout/dashboard')

@section('style')
    {{--    custom style for select2--}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('dashboard_main_content')
    <div class="col-sm-12">
        <h3 class="page-title">Add Purchase</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
            <li class="breadcrumb-item active">View Voucher</li>
        </ul>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body custom-edit-service">

                    <!-- Add Medicine -->

                        <div class="service-fields mb-3 border border-success">
                            <div class="container-fluid row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Transaction Type<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" value="Voucher(ID - VO_{{$voucher_header_info[0]->voucher_header_id}})" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Supplier <span class="text-danger">*</span></label>
                                        <span>{{$voucher_header_info[0]->supplier_name}}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Voucher Date<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" value="{{$voucher_header_info[0]->voucher_date}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Recent payment -->
                        <div class="card" id="purchase_order_wise_selection">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="purchase-table" class="datatable table table-hover table-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Receiving Number</th>
                                            <th>Receiving Date</th>
                                            <th>PO Number</th>
                                            <th>Item Name</th>
                                            <th>Generic Name</th>
                                            <th>Rcv Qty.</th>
                                            <th>PUP(B)</th>
                                            <th>Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $counter = 1;
                                        ?>
                                        @foreach ($voucher_details_info as $data)
                                            <tr>
                                                <td>{{$counter}}</td>
                                                <td>RECV_{{$data->receiving_id}}</td>
                                                <td>{{$data->receiving_date}}</td>
                                                <td>PO_{{$data->purchase_order_id}}</td>
                                                <td>{{$data->item_name}}</td>
                                                <td>{{$data->generic_name}}</td>
                                                <td>{{$data->quantity}}</td>
                                                <td>{{$data->per_unit_price}}</td>
                                                <td>{{ ($data->per_unit_price * $data->quantity) }}</td>
                                            </tr>
                                            <?php
                                            ++$counter;
                                            ?>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /Recent Orders -->

                    <!-- /Add Medicine -->

                </div>
            </div>
        </div>
    </div>
@endsection



