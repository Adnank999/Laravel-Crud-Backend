<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'company', 'position', 'country', 'state', 'city', 'address',
        'postal_code', 'timezone', 'language', 'bill_to', 'tax_id', 'billing_address', 'billing_phone',
        'billing_email', 'details', 'reference', 'shared_files', 'can_access_portal', 'password','country_code','profile_pic',
    ];

    protected $casts = [
        'shared_files' => 'array', 
    ];
}
