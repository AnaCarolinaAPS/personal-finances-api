<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'is_income',
        'is_active',
        'hex_color',
        'parent_id',
    ];

    // Relação com a categoria “pai”
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relação com as subcategorias
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function recurringTransactions()
    {
        return $this->hasMany(RecurringTransaction::class);
    }
}
