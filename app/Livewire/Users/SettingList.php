<?php

namespace App\Livewire\Users;

use App\Enums\SalaryOptions;
use App\Enums\SalaryTypes;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SettingList extends Component
{
    public $setting;
    public array $options = [];

    public function mount()
    {
        if (!user()->setting) {
            user()->setting()->create([
                'salary_type' => SalaryTypes::MONTHLY,
                'salary_options' => SalaryOptions::getOptions(SalaryTypes::MONTHLY),
            ]);
        }

        $this->setting = user()->setting->toArray();
        $this->setting['salary_options'] = $this->setting['salary_options'] ?? [];
        $this->options['salary_types'] = collectEnums(SalaryTypes::class);

        $this->options['weeks'] = collect(range(1, 7))
            ->map(function($i) {
                return [
                    'value' => $i,
                    'label' => now()
                            ->startOfWeek(Carbon::SUNDAY)
                            ->addDays($i - 1)
                            ->format('l'),
                ];
            })->values()
            ->toArray();
    }

    public function updatedSettingSalaryType($value)
    {
        if (in_array($value, SalaryTypes::getValues())) {
            $this->setting['salary_options'] = SalaryOptions::getOptions($value);

        }
        else {
            $this->setting['salary_options'] = [];
        }

    }


    public function setOptions()
    {
        switch ($this->setting['salary_type']) {
            case SalaryTypes::SEMI_MONTHLY:
                $start = $this->setting['salary_options'][SalaryOptions::SEMI_MONTHLY_FIRST_SALARY_DAY] ?? null;
                if (filled($start)) {
                    $options['SEMI_MONTHLY_FIRST_SALARY_DAY'] = $start;
                    $options['SEMI_MONTHLY_FIRST_SALARY_START_DAY'] = $start - 14;
                    $options['SEMI_MONTHLY_FIRST_SALARY_END_Day'] = $start;
                    $options['SEMI_MONTHLY_SECOND_SALARY_DAY'] = $start + 15;
                    $options['SEMI_MONTHLY_SECOND_SALARY_START_DAY'] = $start +1;
                    $options['SEMI_MONTHLY_SECOND_SALARY_END_Day'] = $start + 15;
                }
                break;

            default:
                $options = $this->setting['salary_options'];
                break;
        }

        $this->setting['salary_options'] = $options;
    }

    public function saveSetting()
    {
        $data = $this->validate();

        user()->setting->update($data['setting']);
    }

    public function render()
    {
        return view('livewire.users.setting-list');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'setting.salary_type' => [
                'required',
                'string',
                'max:60',
                Rule::in(SalaryTypes::getValues())
            ],
            'setting.salary_options' => [
                function ($attribute, $value, $fail) {
                    if (!is_array($value)) return;

                    $checkForInvalidKeys = array_diff(array_keys($value), SalaryOptions::getValues());

                    if (count($checkForInvalidKeys) > 0) return $fail("There is invalid key");
                },
            ],
        ];

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function validationAttributes()
    {
        $attributes = [
            'setting.salary_type' => 'Salary Type',
            'setting.salary_options' => 'Salary Options',
        ];

        return $attributes;
    }
}
