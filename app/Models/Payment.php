<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $table      = "payment";
    public $primaryKey = 'p_id';
    public $timestamps = false;

    protected $fillable = [
        'invoice_no',
        'receipt_no',
        'payment_date',
        'tcate_id',
        'treatment_id',
         'product_id',
        'customer_id',
        'lead_id',
        'sitting_count',
        'amount',
        'total_amount',
        'balance',
        'discount',
        'cgst',
        'sgst',
        'payment_status',
        'payment_mode',
        'created_by',
        'created_on',
        'updated_by',
        'updated_on',
        'status',
        'cus_treat_id',
    ];
     public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
