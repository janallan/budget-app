<div>
    <div class="mx-auto max-w-lg">
        <x-forms.form-errors />

        <flux:heading size="lg">Salary Settings</flux:heading>

        <div class="space-y-6 mt-6 mb-4">
            <x-forms.select
                :options="$options['salary_types']"
                option-value-key="value"
                option-label-key="label"
                label="Salary Type"
                wire:model.change="setting.salary_type"
            />

            @switch($setting['salary_type'])
                @case(SalaryTypes::MONTHLY)
                    <flux:input
                        type="number"
                        label="{{ SalaryOptions::getDescription(SalaryOptions::MONTHLY_SALARY_DAY) }}"
                        wire:model="setting.salary_options.{{ SalaryOptions::MONTHLY_SALARY_DAY }}"
                        wire:change="setOptions"
                        />

                    @break
                @case(SalaryTypes::SEMI_MONTHLY)
                    <flux:input
                        type="number"
                        label="{{ SalaryOptions::getDescription(SalaryOptions::SEMI_MONTHLY_FIRST_SALARY_DAY) }}"
                        wire:model="setting.salary_options.{{ SalaryOptions::SEMI_MONTHLY_FIRST_SALARY_DAY }}"
                        wire:change="setOptions"
                        />

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 space-y-6 space-x-4 mb-0">
                        <flux:input
                            type="number"
                            label="{{ SalaryOptions::getDescription(SalaryOptions::SEMI_MONTHLY_FIRST_SALARY_START_DAY) }}"
                            wire:model="setting.salary_options.{{ SalaryOptions::SEMI_MONTHLY_FIRST_SALARY_START_DAY }}"
                            wire:change="setOptions"
                            disabled
                            />
                        <flux:input
                            type="number"
                            label="{{ SalaryOptions::getDescription(SalaryOptions::SEMI_MONTHLY_FIRST_SALARY_END_Day) }}"
                            wire:model="setting.salary_options.{{ SalaryOptions::SEMI_MONTHLY_FIRST_SALARY_END_Day }}"
                            wire:change="setOptions"
                            disabled
                            />
                    </div>

                    <flux:input
                        wire:model.change="setting.salary_options.{{ SalaryOptions::SEMI_MONTHLY_SECOND_SALARY_DAY }}"
                        label="{{ SalaryOptions::getDescription(SalaryOptions::SEMI_MONTHLY_SECOND_SALARY_DAY) }}"
                        type="number"
                        disabled
                        />

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 space-y-6 space-x-4 mb-0">
                        <flux:input
                            wire:model.change="setting.salary_options.{{ SalaryOptions::SEMI_MONTHLY_SECOND_SALARY_START_DAY }}"
                            label="{{ SalaryOptions::getDescription(SalaryOptions::SEMI_MONTHLY_SECOND_SALARY_START_DAY) }}"
                            type="number"
                            disabled
                            />
                        <flux:input
                            wire:model.change="setting.salary_options.{{ SalaryOptions::SEMI_MONTHLY_SECOND_SALARY_END_Day }}"
                            label="{{ SalaryOptions::getDescription(SalaryOptions::SEMI_MONTHLY_SECOND_SALARY_END_Day) }}"
                            type="number"
                            disabled
                            />
                    </div>

                    @break
                @case(SalaryTypes::WEEKLY)

                    <x-forms.select
                        :options="$options['weeks']"
                        option-value-key="value"
                        option-label-key="label"
                        label="{{ SalaryOptions::getDescription(SalaryOptions::WEEKLY_SALARY_WEEKDAY) }}"
                        wire:model="setting.salary_options.{{ SalaryOptions::WEEKLY_SALARY_WEEKDAY }}"
                        wire:change="setOptions"
                    />
                    @break
                @default

            @endswitch
        </div>

        <div class="col-span-1 sm:col-span-3 md:col-span-3 mt-3">
            <flux:button variant="primary" class="w-full" wire:click="saveSetting">Update</flux:button>
        </div>

    </div>
</div>
