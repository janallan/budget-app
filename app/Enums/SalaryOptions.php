<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;
use Carbon\Carbon;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SalaryOptions extends Enum
{
    #[Description('Salary Day of Month')]
    const MONTHLY_SALARY_DAY = 'MONTHLY_SALARY_DAY';

    #[Description('1st Salary Day')]
    const SEMI_MONTHLY_FIRST_SALARY_DAY = 'SEMI_MONTHLY_FIRST_SALARY_DAY';

    #[Description('1st Salary - Coverage Start Day')]
    const SEMI_MONTHLY_FIRST_SALARY_START_DAY = 'SEMI_MONTHLY_FIRST_SALARY_START_DAY';

    #[Description('1st Salary - Coverage End Day')]
    const SEMI_MONTHLY_FIRST_SALARY_END_Day = 'SEMI_MONTHLY_FIRST_SALARY_END_Day';

    #[Description('2nd Salary Day')]
    const SEMI_MONTHLY_SECOND_SALARY_DAY = 'SEMI_MONTHLY_SECOND_SALARY_DAY';

    #[Description('2nd Salary - Coverage Start Day')]
    const SEMI_MONTHLY_SECOND_SALARY_START_DAY = 'SEMI_MONTHLY_SECOND_SALARY_START_DAY';

    #[Description('2nd Salary - Coverage End Day')]
    const SEMI_MONTHLY_SECOND_SALARY_END_Day = 'SEMI_MONTHLY_SECOND_SALARY_END_Day';

    #[Description('Salary Weekday')]
    const WEEKLY_SALARY_WEEKDAY = 'WEEKLY_SALARY_WEEKDAY';

    /**
     * Get options by group
     *
     * @param string <SalaryTypes> $group
     * @param bool $hasDefaul
     * @return array
     */
    public static function getOptions($group , bool $hasDefault = true): array
    {
        switch ($group) {
            case SalaryTypes::MONTHLY:
                return [
                    self::MONTHLY_SALARY_DAY => $hasDefault ? 1 : null,
                ];
            case SalaryTypes::SEMI_MONTHLY:
                return [
                    self::SEMI_MONTHLY_FIRST_SALARY_DAY => $hasDefault ? 15 : null,
                    self::SEMI_MONTHLY_FIRST_SALARY_START_DAY => $hasDefault ? 1 : null,
                    self::SEMI_MONTHLY_FIRST_SALARY_END_Day => $hasDefault ? 15 : null,
                    self::SEMI_MONTHLY_SECOND_SALARY_DAY => $hasDefault ? 30 : null,
                    self::SEMI_MONTHLY_SECOND_SALARY_START_DAY => $hasDefault ? 16 : null,
                    self::SEMI_MONTHLY_SECOND_SALARY_END_Day => $hasDefault ? 30 : null,
                ];
            case SalaryTypes::WEEKLY:
                return [
                    self::WEEKLY_SALARY_WEEKDAY => $hasDefault ? 1 : null, //SUNDAY
                ];
            default:
                return [];
        }

    }
}
