<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'symbol',
        'decimal_separator',
        'thousand_separator',
        'decimal_places',
        'is_active',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function recurringTransactions()
    {
        return $this->hasMany(RecurringTransaction::class);
    }

    public function scheduledTransactions()
    {
        return $this->hasMany(ScheduledTransaction::class);
    }
}

