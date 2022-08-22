<?php


	namespace App\Http\Controllers\API;

	use App\Http\Controllers\Controller;
	use App\Http\Requests\PurchaseRrequest;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;

class APINewPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

	function store(PurchaseRrequest $request)
	{
		$today_date = date('Y-m-d H:i');
		$message = 'Error Occure';
		$purchase_order_id = '';

		$purchase_order_header_data = [
			'purchase_order_date' => $today_date,
			'supplier_id' => $request->input('supplier'),
			'status' => 'PO_GENERATED',
			'transection_type' => 'purchase_order'
		];

		$transection = DB::transaction(function () use ($today_date, $request, $purchase_order_header_data,
			&$message, &$purchase_order_id) {

			$purchase_order_header_saving = DB::connection('mysql2')->table('purchase_order')
				->insertGetId($purchase_order_header_data);

			$purchase_order_id = $purchase_order_header_saving;

			for ($i = 1; $i <= 50; $i++) {
				if ($request->input('category' . $i)) {
					$purchase_order_details_data = [
						'purchase_order_id' => $purchase_order_id,
						'item_category' => $request->input('category' . $i),
						'item_id' => $request->input('item_name' . $i),
						'quantity' => $request->input('quantity' . $i),
						'per_unit_price' => $request->input('per_unit_price' . $i)
					];

					$purchase_order_details_saving = DB::connection('mysql2')->table('purchase_order_details')
						->insert($purchase_order_details_data);
				}
			}

			$message = 'Sales Order Submitted Successfully';

			return compact('message', 'purchase_order_id');
		});


		$message = $transection['message'];
		$purchase_order_id = $transection['purchase_order_id'];

		$purchase_order_after_insert_data = DB::connection('mysql2')->table('purchase_order')
			->select('purchase_order.*', 'supplier.supplier_name')
			->join('supplier', 'supplier.supplier_id', '=', 'purchase_order.supplier_id')
			->where('purchase_order.purchase_order_id', '=', $purchase_order_id)
			->get();

		$purchase_order_details_after_insert_data = DB::connection('mysql2')->table('purchase_order_details')
			->select('purchase_order_details.*', 'brands_url.*')
			->join('brands_url', 'brands_url.id', '=', 'purchase_order_details.item_id')
			->where('purchase_order_details.purchase_order_id', '=', $purchase_order_id)
			->get();

		//dd($purchase_order_details_after_insert_data);

		return response(['status' => $message,
							'purchase_order_data' => $purchase_order_after_insert_data,
							'purchase_order_details_data' => $purchase_order_details_after_insert_data]);
	}


	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
