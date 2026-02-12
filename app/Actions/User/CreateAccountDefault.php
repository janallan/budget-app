<?php

namespace App\Actions\User;

use App\Enums\SalaryOptions;
use App\Enums\SalaryTypes;
use App\Models\Category;
use App\Models\User;

class CreateAccountDefault
{
    /**
     * Create initial details for account
     */
    public function __invoke(User $user)
    {
        if (!$user->setting) {
            $user->setting()->create([
                'salary_type' => SalaryTypes::SEMI_MONTHLY,
                'salary_options' => SalaryOptions::getOptions(SalaryTypes::SEMI_MONTHLY),
            ]);
        }

        foreach (__('default_categories') as $key => $values) {
            foreach ($values as $value) {
                Category::create([
                    'account_id' => $user->id,
                    'name' => $value,
                    'type' => $key,
                    'is_active' => true,
                ]);
            }
        }

    }
}
