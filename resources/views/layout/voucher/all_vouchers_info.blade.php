@extends('layout/dashboard')

@section('style')

@endsection

@section('dashboard_main_content')
    <div id="full_content">
        <div class="col-sm-12 col-auto">
            <h3 class="page-title">Voucher</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                <li class="breadcrumb-item active">Voucher List</li>
            </ul>
        </div>

        <div class="row text-center">
            <div class="col-md-4"></div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Supplier</label>
                    <select class=" form-select form-control" name="supplier" id="supplier" onchange="supplier_selection(this.value)">
                        <option>Select Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{$supplier->supplier_id}}">{{$supplier->supplier_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <!-- Voucher List -->
                <div class="card" >
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="purchase-table" class="datatable table table-hover table-center mb-0">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Voucher ID</th>
                                    <th>Voucher Date</th>
                                    <th>Supplier</th>
                                    <th>Payment Amount</th>
                                    <th>Discount Amount</th>
                                    <th>Adjustment Type</th>
                                    <th>Adjustment Amount</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $counter = 1;
                                ?>
                                @foreach ($all_vouchers_info as $data)
                                    <tr>
                                        <td>{{$counter}}</td>
                                        <td>VO_{{$data->voucher_header_id}}</td>
                                        <td>{{$data->voucher_date}}</td>
                                        <td>{{$data->supplier_name}}</td>
                                        <td>{{$data->payment_amount}}</td>
                                        <td>{{$data->discount_amount}}</td>
                                        <td>{{$data->adjustment_type}}</td>
                                        <td>{{$data->adjustment_amount}}</td>
                                        <td>
                                            <form action="{{'voucher_view'}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" name="voucher_id" id="voucher_id" value="{{$data->voucher_header_id}}"
                                                        >View</button>
                                            </form>
                                        </td>
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

            </div>
        </div>

    </div>
@endsection

@section('script_dashboard')
    <!-- custom style for select2 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>

    <!-- Script -->
    <script type='text/javascript'>

        function voucher_view(voucher_id)
        {
            alert(voucher_id);

            // let _token = $('meta[name="csrf-token"]').attr('content');
            // $.ajax({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     url: "details_info_for_voucher",
            //     type: "post",
            //     data: {_token: _token, supplier_id:supplier},
            //     success: function(data)
            //     {
            //         //alert(data);
            //         document.getElementById("payment_full_data").innerHTML = data;
            //     }
            // });
        }

    </script>

@endsection

