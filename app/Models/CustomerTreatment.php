<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTreatment extends Model
{
    use HasFactory;

    public $table      = "customer_treatment";
    public $primaryKey = 'cus_treat_id';
    public $timestamps = false;

    protected $fillable = [
        'treatment_id',
        'treatment_auto_id',
        'customer_id',
        'tc_id',
        'progress',
        'madicine_prefered',
        'remarks',
        'amount',
        'discount',
        'generate_invoice',
        'complete_status',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
