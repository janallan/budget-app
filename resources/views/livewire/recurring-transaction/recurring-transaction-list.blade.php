@section('title', 'Recurring Transaction')
<div>
    <div class="flex justify-end">
        <flux:modal.trigger name="transaction-form-modal">
            <flux:button icon="plus" variant="primary" inset="top bottom"
                wire:click="$dispatch('add-transaction')"
            >Add</flux:button>
        </flux:modal.trigger>

    </div>
    <flux:table :paginate="$transactions">
        <flux:table.columns>
            <flux:table.column>Category</flux:table.column>
            <flux:table.column align="center">Day of Month</flux:table.column>
            <flux:table.column align="center">Amount</flux:table.column>
            <flux:table.column align="center">Active</flux:table.column>
            <flux:table.column align="center">Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($transactions as $transaction)
                <flux:table.row :key="$transaction->id">
                    <flux:table.cell>{{ $transaction->category?->name }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $transaction->day_of_month }}</flux:table.cell>
                    <flux:table.cell align="end">{{ money_format($transaction->amount) }}</flux:table.cell>
                    <flux:table.cell align="center">
                        <flux:badge size="sm" :color="$transaction->is_active ? 'green' : 'red'" inset="top bottom">{{ $transaction->is_active ? 'Active' : 'Inactive' }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell align="end">
                        <div class="flex justify-end gap-4">
                            <flux:button size="xs" icon="trash" variant="danger" inset="top bottom"
                                wire:click="$dispatch('delete-transaction', {transactionId: {{ $transaction->id }}})"
                                wire:confirm="Are you sure you want to delete this?"
                            >Delete</flux:button>
                            <flux:modal.trigger name="transaction-form-modal">
                                <flux:button size="xs" icon="pencil" variant="primary" inset="top bottom"
                                    wire:click="$dispatch('edit-transaction', {transactionId: {{ $transaction->id }}})"
                                >Edit</flux:button>
                            </flux:modal.trigger>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach

            @if ($transactions->count() == 0)
                <flux:table.row>
                    <flux:table.cell colspan="4">
                        No Recurring Transaction found.
                    </flux:table.cell>
                </flux:table.row>
            @endif
        </flux:table.rows>
    </flux:table>

    <flux:modal name="transaction-form-modal" class="md:w-96" :dismissible="false">
        <form wire:submit="saveRecurringTransaction" class="space-y-6">
            <flux:heading size="lg">Recurring Transaction</flux:heading>

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
                <x-forms.select
                    :options="$options['days']"
                    option-value-key="value"
                    option-label-key="label"
                    label="Day of the Month"
                    wire:model.change="transaction.day_of_month"
                    variant="listbox" searchable
                    description="When 28, 29, 30, or 31 is selected, will be used the available last day of the month"
                />
            </div>

            <flux:field variant="inline">
                <flux:checkbox wire:model="transaction.is_active" />
                <flux:label>Active</flux:label>
                <flux:error name="transaction.is_active" />
            </flux:field>

            <div class="flex">
                <flux:spacer />

                <flux:button wire:click="saveRecurringTransaction" variant="primary">Save changes</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
