<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;

    protected $table = 'tab_orders';
    protected $primaryKey = 'ord_id';
    public $timestamps = false;
    protected $fillable = [
        'ord_client_id_fk',
    ];

    public function client()
    {
        return $this->belongsTo(ClientModel::class, 'ord_client_id_fk', 'cli_id');
    }

    public function products()
    {
        return $this->hasMany(OrderProductModel::class, 'op_order_id_fk', 'ord_id');
    }
}
