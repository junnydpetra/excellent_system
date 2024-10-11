<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductModel extends Model
{
    use HasFactory;

    protected $table = 'tab_order_product';
    protected $primaryKey = 'op_id';
    public $timestamps = false;
    protected $fillable = [
        'op_order_id_fk',
        'op_product_id_fk',
        'op_product_quantity',
    ];

    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'op_order_id_fk', 'ord_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'op_product_id_fk', 'pro_id');
    }
}
