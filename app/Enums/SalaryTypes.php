<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MONTHLY()
 * @method static static SEMI_MONTHLY()
 * @method static static WEEKLY()
 */
final class SalaryTypes extends Enum
{
    const MONTHLY = 'MONTHLY';
    const SEMI_MONTHLY = 'SEMI_MONTHLY';
    const WEEKLY = 'WEEKLY';
}
