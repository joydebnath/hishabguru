<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactCreditRecord extends Model
{
    use HasFactory;

    protected $table = 'contact_credit_records';
    protected $guarded = ['id'];
}
