<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledTransaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'due_date',
        'name',
        'description',
        'amount',
        'currency_id',
        'category_id',
        'recurring_transactions_id',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function recurringTransaction()
    {
        return $this->belongsTo(RecurringTransaction::class);
    }
}
