<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidComparison extends Model
{
    protected $fillable = [
        'supplier_name',
        'currency',
        'payment_term',
        'delivery_period',
        'unit_cost',
        'vat',
        'awarded_line'
    ];
}
