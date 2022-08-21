<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddSupplierRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APISupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::connection('mysql2')
            ->table('supplier')
            ->get();
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
    public function store(AddSupplierRequest $request)
    {
        $duplicate = DB::connection('mysql2')
            ->table('supplier')
            ->where('supplier_email', '=', $request->supplier_email)
            ->get();
        if (count($duplicate) > 0) {
            $duplicate_email = "Supplier already present";
            return response($duplicate_email);
        } else {
            $insert_into_supplier = DB::connection('mysql2')
                ->insert("Insert into supplier(company_name,supplier_name,supplier_email,
					supplier_phone_number,supplier_address) values
					('$request->company_name','$request->supplier_name','$request->supplier_email',
					'$request->supplier_phone_number','$request->supplier_address')");
            return response('New Supplier Added');
        }
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
