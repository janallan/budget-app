<?php

namespace App\Models;

use App\Enums\TransactionTypes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'amount',
        'category_id',
        'transaction_date',
        'description'
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

    /**
     * Scope for Dashboard Card (Today vs Yesterday)
     *
     * @param \Illuminate\Database\Eloquent\Builder $q
     */
    public function scopeDashboardCard(Builder $q)
    {
        $all = 0;
        $response = [];
        foreach (TransactionTypes::getValues() as $type) {
            $today = now()->month;
            $yesterday = now()->subMonth()->month;

            $todayQuery = self::whereMonth('transaction_date', $today);
            $yesterdayQuery = self::whereMonth('transaction_date', $yesterday);

            if ($type) {
                $todayQuery->where('type', $type);
                $yesterdayQuery->where('type', $type);
            }

            $todayTotal = $todayQuery->sum('amount');
            $yesterdayTotal = $yesterdayQuery->sum('amount');

            $percentChange = $yesterdayTotal == 0
                ? ($todayTotal == 0 ? 0 :100)
                : round((($todayTotal - $yesterdayTotal) / $yesterdayTotal) * 100, 2);

            $trend = $todayTotal > $yesterdayTotal
                ? 'increase'
                : ($todayTotal < $yesterdayTotal ? 'decrease' : 'no_change');

            $response[$type] =[
                'title' => $type,
                'total_today' => $todayTotal,
                'total_yesterday' => $yesterdayTotal,
                'percent_change' => $percentChange,
                'trend' => $trend,
                'trendUp' => $trend == 'increase',
            ];
        }

        $response['all'] = [
            'title' => 'TOTAL (INCOME - EXPENSE)',
            'total_today' => $response[TransactionTypes::INCOME]['total_today'] - $response[TransactionTypes::EXPENSE]['total_today'],
            'total_yesterday' => $response[TransactionTypes::INCOME]['total_yesterday'] - $response[TransactionTypes::EXPENSE]['total_yesterday'],
            'percent_change' => 0,
            'trend' => 'increase',
            'trendUp' => true,
        ];

        $response['all']['percent_change'] = $response['all']['total_yesterday'] == 0
            ? ($response['all']['total_today'] == 0 ? 0 :100)
            : round((($response['all']['total_today'] - $response['all']['total_yesterday']) / $response['all']['total_yesterday']) * 100, 2);

        $response['all']['trend'] = $response['all']['total_today'] > $response['all']['total_yesterday']
            ? 'increase'
            : ($response['all']['total_today'] < $response['all']['total_yesterday'] ? 'decrease' : 'no_change');

        $response['all']['trendUp'] = $response['all']['trend'] == 'increase';

        return $response;
    }

    /**
     * Scope for Dashboard Card (Today vs Yesterday)
     *
     * @param \Illuminate\Database\Eloquent\Builder $q
     */
    public function scopeDailyPerType($q)
    {
        return $q->select(
            'transaction_date as date',
            DB::raw("SUM(CASE type WHEN 'INCOME' THEN amount ELSE 0 END) as income"),
            DB::raw("SUM(CASE type WHEN 'EXPENSE' THEN amount ELSE 0 END) as expense"),
        )
        ->groupBy('transaction_date')
        ;
    }

}
