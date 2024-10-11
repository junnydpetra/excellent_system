<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    use HasFactory;

    protected $table = 'tab_clients';
    protected $primaryKey = 'cli_id';
    public $timestamps = false;
    protected $fillable = [
        'cli_api_id',
        'cli_company_name',
        'cli_cnpj',
        'cli_email',
    ];
}
