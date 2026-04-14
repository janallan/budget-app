<div>
    <form wire:submit="saveTransaction" class="space-y-6">
        <flux:heading size="lg">Transaction</flux:heading>

        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-6">
                <flux:input
                    wire:model="transaction.amount"
                    label="Amount"
                    type="number"
                    step="0.01"
                    x-data
                    @focus="if($el.value == 0) $el.value=''"
                    @blur="if($el.value == 0) $el.value=''"
                />
            </div>
            <div class="col-span-6">
                <flux:input wire:model="transaction.transaction_date" label="Transaction Date" type="date" />
            </div>
            <div class="col-span-6">
                <x-forms.select
                    :options="$options['categories']"
                    option-value-key="id"
                    option-label-key="name"
                    label="Category"
                    wire:model.change="transaction.category_id"
                    variant="listbox" searchable
                />
            </div>
            <div class="col-span-6">
                <x-forms.select
                    :options="$options['types']"
                    option-value-key="value"
                    option-label-key="label"
                    label="Type"
                    wire:model.change="transaction.type"
                />
            </div>
            <div class="col-span-12">
                <flux:input wire:model="transaction.description" label="Description" />
            </div>
        </div>
        <div class="flex">
            <flux:spacer />

            <flux:button type="submit" variant="primary">Pay</flux:button>
        </div>
    </form>
</div>
