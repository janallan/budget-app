<?php

use Carbon\Carbon;
use Flux\Flux;
use Illuminate\Support\Str;

if (! function_exists('uuid')) {
    /**
     * Generate UUID
     *
     * @return string
     */
    function uuid(): string
    {
        return (string) str_replace("-", "", Str::uuid());
    }
}

if (! function_exists('toast')) {
    /**
     * Create Flux Toast
     *
     * @return string
     */
    function toast($message, $variant = 'success')
    {
        Flux::toast($message, variant: $variant);
    }
}

if (! function_exists('money_format')) {
    /**
     * Format Money
     *
     * @return string
     */
    function money_format(float|int|string $amount, $currency = 'PHP', $locale = 'en_PH'): string|false
    {
        $fmt = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        return $fmt->formatCurrency((float)$amount, $currency);
    }
}

if (! function_exists('collectEnums')) {
    /**
     * Converts enums value into value & label collection
     * Enums generated using \BenSampo\Enum Package
     *
     * @param $enums
     * @param array $except = []
     * @param array $only = []
     * @return array
     */
    function collectEnums($enum, $except = [], $only = []): array
    {
        return collect($enum::getValues())
            ->filter(function ($value) use ($except, $only) {
                if (count($except) > 0 && in_array($value, $except)) {
                    return false;
                }

                if (count($only) > 0) {
                    return in_array($value, $only);
                }

                return true;
            })
            ->map(function ($value) use ($enum) {
                return [
                    'value' => $value,
                    'label' => $enum::getDescription($value),
                ];
            })
            ->toArray();
    }
}

if (! function_exists('modelFillableToArray')) {
    /**
     * Convert model fillable to array that can be used in fields
     *
     * @param $model
     * @return array
     */
    function modelFillableToArray($modelClass): array
    {
        $model = new $modelClass();
        $fillables = $model->getFillable();
        $casts = $model->getCasts();
        $data = [];

        foreach ($fillables as $value) {
            $default = null;
            if (isset($casts[$value])) {
                switch ($casts[$value]) {
                    case 'array':
                        $default = [];
                        break;
                    case 'integer':
                        $default = 0;
                        break;
                    case 'float':
                        $default = 0;
                        break;
                    case 'boolean':
                        $default = false;
                        break;
                }
                if (Str::contains($casts[$value], 'decimal')) $default = 0;;
            }
            $data[$value] = $default;
        }
        return $data;
    }
}

if (! function_exists('formatDateTime')) {
    /**
     * Format Date Display
     *
     * @param string $date
     * @param null|string $format = null
     * @return string
     */
    function formatDateTime(?string $date, ?string $format = null): string
    {
        if (is_null($format)) $format = env('DEFAULT_DATETIME_FORMAT', 'm/d/Y h:i A');

        if (!filled($date)) return '';
        return Carbon::parse($date)->tz('Asia/Manila')->format($format);
    }
}

if (! function_exists('formatDate')) {
    /**
     * Format Date Display
     *
     * @param string $date
     * @param null|string $format = null
     * @return string
     */
    function formatDate(?string $date, ?string $format = null): string
    {
        if (is_null($format)) $format = env('DEFAULT_DATE_FORMAT', 'm/d/Y');

        if (!filled($date)) return '';
        return Carbon::parse($date)->tz('Asia/Manila')->format($format);
    }
}
