<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'name',
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
            'is_active' => 'boolean',
        ];
    }


    /**
     * Scope - get active records
     */
    public function scopeActive($q)
    {
        return $q->where('categories.is_active', true);
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
        $active = $fitlers['active'] ?? null;

        $q->when($search, function ($q) use ($search) {
            $q->where('categories.name', 'like', "%{$search}%");
        })->when($type, function ($q) use ($type) {
            $q->where('categories.type', $type);
        })->when($active, function ($q) use ($active) {
            $a = null;
            if ($active == 'active') $a = true;
            else if ($active == 'inactive') $a = false;

            if (!is_null($a)) {
                $q->where('categories.is_active', $a);
            }
        });
    }
}
