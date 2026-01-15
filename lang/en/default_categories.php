<?php

use App\Enums\TransactionTypes;

return [

    TransactionTypes::INCOME => [
        'Salary',
        'Commissions',
        'Allowance',
        'Bonuses',
        'Loan',
    ],
    TransactionTypes::EXPENSE => [
        'Food & Groceries',
        'Rent',
        'Utilities',
        'Transportation',
        'Personal Care',
        'Health & Medical',
        'Clothing',
        'Entertainment',
        'Dining Out',
        'Travel',
        'Subscriptions',
        'Loan Payments',
        'Miscellaneous',
    ],
];
