<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $table      = "product";
    public $primaryKey = 'product_id';
    public $timestamps = false;
    
    protected $fillable = [
        'product_name',
        'prod_cat_id',
        'brand_id',
        'amount',
        'create_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
