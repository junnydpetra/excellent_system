<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    use HasFactory;

    protected $table = 'tab_images';
    protected $primaryKey = 'ima_id';
    public $timestamps = false;
    protected $fillable = [
        'ima_path',
        'ima_pro_id_fk',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'ima_pro_id_fk', 'pro_id');
    }
}
