<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentUpdateController extends Controller
{
    public function vouchers_for_payment()
    {
        $suppliers = DB::connection('mysql2')->table('supplier')
            ->select('*')
            ->get();

        return view('layout.payment_update.payment_form')->with(['suppliers'=> $suppliers]);
    }

    public function supplier_wise_all_data(Request $request)
    {
        $supplier_id = $request->supplier_id;
        dd($supplier_id);
        $item_wise_receiving_all_data = DB::connection('mysql2')->table('receiving')
            ->select('receiving.*','items.*')
            ->leftJoin('items', 'items.item_id' ,'=','receiving.item_id')
            ->leftJoin('payment_set', 'receiving.supplier_id' ,'=','payment_set.supplier_id')
            ->where('receiving.supplier_id', '=', $supplier_id)
            ->groupBy('receiving.receiving_id')
            ->get();

        $item_wise_receiving_for_po = DB::connection('mysql2')->table('receiving')
            ->select('receiving.purchase_order_id')
            ->distinct()
            ->where('receiving.supplier_id', '=', $supplier_id)
            ->get();

        //dd($item_wise_receiving_all_data);

        return view('layout.payment.purchase_receive_view_list')->with(['item_wise_receiving'=> $item_wise_receiving_all_data, 'all_purchase_order'=> $item_wise_receiving_for_po]);
    }
}
