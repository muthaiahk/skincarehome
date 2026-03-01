<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    public $table      = "staff";
    public $primaryKey = 'staff_id';
    public $timestamps = false;

    protected $fillable = [

        'name',
        'date_of_birth',
        'gender',
        'email',
        'phone_no',
        'emergency_contact',
        'address',
        'role_id',
        'date_of_joining',
        'company_id',
        'branch_id',
        'dept_id',
        'desg_id',
        'job_id',      
        'salary',
        'date_of_relieve',
        'profile_pic',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'marital_status',
        'status',
    ];
}
