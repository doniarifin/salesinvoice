<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['item_code', 'name_product', 'price_product', 'stock'];

    public function sales_lines()
    {
        return $this->hasMany('App\Models\SalesLine', 'product_id');
    }
}
