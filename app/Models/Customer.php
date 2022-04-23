<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['code_customer', 'name_customer', 'phone_customer', 'address_customer'];

    public function sales_orders()
    {
        return $this->hasMany('App\Models\SalesOrder', 'customer_id');
    }
}
