<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
  
    public $table      = "branch";
    public $primaryKey = 'branch_id';
    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'branch_name',
        'branch_location',
        'branch_phone',
        'branch_email',
        'branch_authority',
        'branch_opening_date',
        'is_franchise',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
