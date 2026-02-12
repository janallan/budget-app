<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'account_id',
        'salary_type',
        'salary_options',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'salary_options' => 'object',
        ];
    }
}
