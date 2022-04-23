<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesLine;
use App\Models\SalesOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintOutController extends Controller
{
    public function index()
    {
        return view('printout');
    }
    public function printOut(Request $request)
    {
        $today = Carbon::now();
        $date = $request->date_picker;
        $cust_id = $request->customer_id;
        $cust_name = $request->name_customer;
        $no = $request->no_invoice;

        $product = $request->product_id;
        $name_pro = $request->name_product;
        $qty = $request->qty;
        $total = $request->total_price;
        $gtotal = $request->grand_total;

        $cus = Customer::where('id', $cust_id)->first();
        $cus_code = $cus->code_customer;

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
        }

        $sl1 = SalesLine::where('s_order_id', $so)->join('products', 'products.id', '=', 'product_id')->get();

        return view('printout', compact('date', 'cust_name', 'cus_code', 'no', 'sl1', 'gtotal'));
    }
}
