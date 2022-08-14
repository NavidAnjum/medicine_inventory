<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Voucher extends Controller
{
    public function purchase_wise_receive_list_which_not_make_voucher()
    {
        $suppliers = DB::connection('mysql2')->table('supplier')
            ->select('*')
            ->get();

        return view('layout.voucher.voucher_form')->with(['suppliers'=> $suppliers]);
    }

    public function details_for_voucher(Request $request)
    {
        $supplier_id = $request->supplier_id;
        //dd($supplier_id);
        $item_wise_receiving_all_data = DB::connection('mysql2')->table('receiving')
            ->select('receiving.*','items.*')
            ->leftJoin('items', 'items.item_id' ,'=','receiving.item_id')
            ->leftJoin('voucher_header', 'receiving.supplier_id' ,'=','voucher_header.supplier_id')
            ->where('receiving.supplier_id', '=', $supplier_id)
            ->groupBy('receiving.receiving_id')
            ->get();

        $item_wise_receiving_for_po = DB::connection('mysql2')->table('receiving')
            ->select('receiving.purchase_order_id')
            ->distinct()
            ->where('receiving.supplier_id', '=', $supplier_id)
            ->get();

        //dd($item_wise_receiving_all_data);

        return view('layout.voucher.purchase_receive_view_list')->with(['item_wise_receiving'=> $item_wise_receiving_all_data, 'all_purchase_order'=> $item_wise_receiving_for_po]);

    }

    function details_for_purchase_order_wise_voucher(Request $request)
    {
        $purchase_order_id = $request->purchase_order_id;

        $item_wise_receiving_all_data = DB::connection('mysql2')->table('receiving')
            ->select('receiving.*','items.*')
            ->leftJoin('items', 'items.item_id' ,'=','receiving.item_id')
            ->where('receiving.purchase_order_id', '=', $purchase_order_id)
            ->get();

        return view('layout.voucher.purchase_order_wise_receive_view_list')->with(['item_wise_receiving'=> $item_wise_receiving_all_data]);
    }

    function adjustment_amount_form()
    {
        return view('layout.voucher.adjustment_amount_form');
    }

    function voucher_to_database(Request $request)
    {
        //dd($request->payment_check[0]);

        //payment header value asign
        $voucher_date = date('Y-m-d');
        $supplier_id = $request->supplier;
        $discount_amount = $request->discount_amount;
        $payment_amount = $request->payment_amount;
        $adjustment_type = $request->adjustment_type;
        $adjustment_amount = $request->adjustment_amount;

        //receiving data insert
        $voucher_header_data_insert = [
            'voucher_date' => $voucher_date,
            'supplier_id' => $supplier_id,
            'discount_amount' => $discount_amount,
            'payment_amount' => $payment_amount,
            'adjustment_type' => $adjustment_type,
            'adjustment_amount' => $adjustment_amount
        ];

        $voucher_header_insert_id = DB::connection('mysql2')->table('voucher_header')
            ->insertGetId($voucher_header_data_insert);

        //money transaction details value
//        $source_transaction_id = $voucher_header_insert_id;
//        $source_transaction_type =  'RECEIVING_PAYMENT';
//        $transaction_date = date('Y-m-d');
//        $price = $payment_amount;

        //receiving data insert
//        $money_transaction_details_insert = [
//            'source_transaction_id' => $source_transaction_id,
//            'source_transaction_type' => $source_transaction_type,
//            'transaction_date' => $transaction_date,
//            'price' => $price
//        ];
//
//        $money_transaction_details_id = DB::connection('mysql2')->table('money_transection_details')
//            ->insertGetId($money_transaction_details_insert);

        //payment line value assign
        echo $row_count = $request->total_counter;

        for ($i=1; $i < $row_count; $i++)
        {
            if ( isset($request->payment_check[$i-1]) )
            {

                //item stock information value
                $voucher_line_date = date('Y-m-d');
                $source_transaction_id = $request->input('receiving_id'.$i);
                $source_transaction_type =  'RECEIVING_VOUCHER';
                $source_item_id = $request->input('item_id'.$i);
                $voucher_header_id = $voucher_header_insert_id;
                $status = '';

                //receiving data insert
                $voucher_line_data_insert = [
                    'voucher_line_date' => $voucher_line_date,
                    'source_transaction_id' => $source_transaction_id,
                    'source_transaction_type' => $source_transaction_type,
                    'source_item_id' => $source_item_id,
                    'voucher_header_id' => $voucher_header_id,
                    'status' => $status
                ];

                $payment_voucher_insert_id = DB::connection('mysql2')->table('voucher_line')
                    ->insertGetId($voucher_line_data_insert);

            }
        }

    }

    public function all_voucher_list()
    {
        $suppliers = DB::connection('mysql2')->table('supplier')
            ->select('*')
            ->get();

        $all_voucher_list = DB::connection('mysql2')->table('voucher_header')
            ->select('voucher_header.*','supplier.*')
            ->leftJoin('supplier', 'supplier.supplier_id' ,'=','voucher_header.supplier_id')
            ->get();

        return view('layout.voucher.all_vouchers_info')->with(['suppliers'=> $suppliers, 'all_vouchers_info' => $all_voucher_list]);
    }

    public function voucher_view_details(Request $request)
    {
        $voucher_id = $request->voucher_id;

        $voucher_header_after_insert_data = DB::connection('mysql2')->table('voucher_header')
            ->select('voucher_header.*', 'supplier.supplier_name')
            ->join('supplier', 'supplier.supplier_id', '=', 'voucher_header.supplier_id')
            ->where('voucher_header.voucher_header_id', '=', $voucher_id)
            ->get();

        $voucher_details_after_insert_data = DB::connection('mysql2')->table('voucher_line')
            ->select('voucher_line.*', 'items.*', 'receiving.*')
            ->join('items', 'items.item_id', '=', 'voucher_line.source_item_id')
            ->join('receiving', 'receiving.receiving_id', '=', 'voucher_line.source_transaction_id')
            ->where('voucher_line.voucher_header_id', '=', $voucher_id)
            ->get();
        //dd($voucher_details_after_insert_data);
        return view('layout.voucher.voucher_details_info')->with(['voucher_header_info'=> $voucher_header_after_insert_data, 'voucher_details_info' => $voucher_details_after_insert_data]);
    }

}
