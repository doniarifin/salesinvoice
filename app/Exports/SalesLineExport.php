<?php

namespace App\Exports;

use App\Models\SalesLine;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesLineExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SalesLine::select('no_invoice', 'date', 'code_customer', 'name_customer', 'item_code', 'name_product', 'qty', 'price_product', 'total_harga')->join('sales_orders', 'sales_orders.id', '=', 's_order_id')->join('customers', 'customers.id', '=', 'customer_id')->join('products', 'products.id', '=', 'product_id')->get();
    }
}
