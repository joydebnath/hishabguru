<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherExpenseItem extends Model
{
    protected $table = 'other_expense_items';
    protected $guarded = ['id'];

    public function expense()
    {
        return $this->hasOne(OtherExpense::class);
    }
}
