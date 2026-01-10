<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static INCOME()
 * @method static static EXPENSE()
 */
final class TransactionTypes extends Enum
{
    const INCOME = 'INCOME';
    const EXPENSE = 'EXPENSE';
}
