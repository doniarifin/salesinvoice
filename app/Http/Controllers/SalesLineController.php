<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SalesLine;
use App\Models\SalesOrder;
use Carbon\Carbon;
use App\Exports\SalesLineExport;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator as ValidationValidator;


class SalesLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sl = SalesLine::select('no_invoice', 'date', 'code_customer', 'name_customer', 'item_code', 'name_product', 'qty', 'price_product', 'total_harga')->join('sales_orders', 'sales_orders.id', '=', 's_order_id')->join('customers', 'customers.id', '=', 'customer_id')->join('products', 'products.id', '=', 'product_id')->get();

        return view('salesline.index', compact('sl'));
    }

    public function export()
    {
        return Excel::download(new SalesLineExport, 'saleslines.xlsx');
    }

    public function api()
    {
        $sl = SalesLine::select('no_invoice', 'date', 'code_customer', 'name_customer', 'item_code', 'name_product', 'qty', 'price_product', 'total_harga')->join('sales_orders', 'sales_orders.id', '=', 's_order_id')->join('customers', 'customers.id', '=', 'customer_id')->join('products', 'products.id', '=', 'product_id')->get();

        $datatables = datatables()->of($sl)->addIndexColumn();

        return $datatables->make(true);
    }

    public function chart()
    {
        $data_donut = SalesLine::select(DB::raw("COUNT(product_id) as total"))->groupBy('product_id')->orderBy('product_id', 'asc')->pluck('total');
        $label_donut = Product::orderBy('product_id', 'asc')->join('sales_lines', 'sales_lines.product_id', '=', 'products.id')->groupBy('products.name_product')->pluck('products.name_product');

        $label_bar = SalesLine::orderBy('customer_id', 'asc')->join('sales_orders', 'sales_orders.id', '=', 's_order_id')->join('customers', 'customers.id', '=', 'customer_id')->groupBy('customers.name_customer')->pluck('customers.name_customer');
        $data_bar = [];

        return view('salesline.charts', compact('data_donut', 'label_donut', 'label_bar', 'data_bar'));
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
    public function store(Request $request)
    {
        $today = Carbon::now();
        $cust_id = $request->customer_id;
        $no = $request->no_invoice;

        $product = $request->product_id;
        $qty = $request->qty;


        $so = SalesOrder::insertGetId([
            'no_invoice' => $no,
            'date' => $today,
            'customer_id' => $cust_id,
            'created_at' => $today,
            'updated_at' => $today,
        ]);
        foreach ($product as $i => $pd) {
            $pro = Product::find($pd);
            $hg = $pro->price_product;
            $sl = SalesLine::insert([
                's_order_id' => $so,
                'product_id' => $pd,
                'qty' => $qty[$i],
                'total_harga' => $hg * $qty[$i],
                'created_at' => $today,
                'updated_at' => $today,
            ]);
            $product1 = Product::find($pd);
            $qtyNow = $product1->stock;
            $qtyUpdated = $qtyNow - $qty[$i];
            Product::where('id', $pd)->update([
                'stock' => $qtyUpdated,
            ]);
        };

        return view('salesline.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesLine  $salesLine
     * @return \Illuminate\Http\Response
     */
    public function show(SalesLine $salesLine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesLine  $salesLine
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesLine $salesLine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesLine  $salesLine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesLine $salesLine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesLine  $salesLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesLine $salesLine)
    {
        //
    }
}
