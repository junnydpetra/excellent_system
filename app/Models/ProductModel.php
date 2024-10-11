<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'tab_products';
    protected $primaryKey = 'pro_id';
    public $timestamps = false;
    protected $fillable = [
        'pro_description',
        'pro_sale_price',
        'pro_stock'
    ];
}
