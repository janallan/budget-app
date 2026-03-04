<?php

namespace App\Models;

use App\Observers\RecurringTransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(RecurringTransactionObserver::class)]
class RecurringTransaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'account_id',
        'category_id',
        'frequency',
        'day_of_month',
        'amount',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the category that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Scope - common filters
     *
     * @param \Illuminate\Database\Eloquent\Builder $q
     * @param array $filters
     */
    public function scopeCommonFilters(Builder $q, array $fitlers = [])
    {
        $search = $fitlers['search'] ?? null;
        $type = $fitlers['type'] ?? null;
        $category = $fitlers['category'] ?? null;
        $dates = $fitlers['dates'] ?? null;

        $q->when($search, function ($q) use ($search) {
            $q->where('transactions.description', 'like', "%{$search}%");
        })->when($type, function ($q) use ($type) {
            $q->where('transactions.type', $type);
        })->when($category, function ($q) use ($category) {
            $q->where('transactions.category_id', $category);
        })->when($category, function ($q) use ($category) {
            $q->where('transactions.category_id', $category);
        })->when($dates, function ($q) use ($dates) {
            if (isset($dates['from']) && isset($dates['to'])) {
                $q->whereBetween('transactions.transaction_date', [$dates['from'], $dates['to']]);
            }
        });
    }
}
