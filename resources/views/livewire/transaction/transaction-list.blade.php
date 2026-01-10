@section('title', 'Transactions')
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
            <flux:table.column>ID</flux:table.column>
            <flux:table.column align="center">Type</flux:table.column>
            <flux:table.column align="end">Amount</flux:table.column>
            <flux:table.column align="center">Transaction Date</flux:table.column>
            <flux:table.column>Category</flux:table.column>
            <flux:table.column>Description</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($transactions as $transaction)
                <flux:table.row :key="$transaction->id">
                    <flux:table.cell>{{ $transaction->id }}</flux:table.cell>
                    <flux:table.cell align="center">{{ $transaction->type }}</flux:table.cell>
                    <flux:table.cell align="end">{{ money_format($transaction->amount) }}</flux:table.cell>
                    <flux:table.cell align="center">{{ formatDate($transaction->transaction_date) }}</flux:table.cell>
                    <flux:table.cell>
                        @if ($transaction->category)
                            {{ $transaction->category->name }}
                        @else
                            <flux:badge size="sm" color="red" inset="top bottom" icon="exclamation-triangle" icon:variant="outline">NO ASSIGNED CATEGORY</flux:badge>
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>{{ $transaction->description }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:modal.trigger name="transaction-form-modal">
                            <flux:button size="xs" icon="pencil" variant="primary" inset="top bottom"
                                wire:click="$dispatch('edit-transaction', {transactionId: {{ $transaction->id }}})"
                            >Edit</flux:button>
                        </flux:modal.trigger>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach

            @if ($transactions->count() == 0)
                <flux:table.row>
                    <flux:table.cell colspan="4">
                        No Transactions found.
                    </flux:table.cell>
                </flux:table.row>
            @endif
        </flux:table.rows>
    </flux:table>

    <flux:modal name="transaction-form-modal" class="md:w-96">
        <form wire:submit="saveTransaction" class="space-y-6">
            <flux:heading size="lg">Transaction</flux:heading>

            <flux:input wire:model="transaction.amount" label="Amount" />

            <x-forms.select
                :options="$options['categories']"
                option-value-key="id"
                option-label-key="name"
                label="Category"
                wire:model.change="transaction.category_id"
            />

            <x-forms.select
                :options="$options['types']"
                option-value-key="value"
                option-label-key="label"
                label="Type"
                wire:model.change="transaction.type"
            />

            <flux:input wire:model="transaction.description" label="Description" />

            <div class="flex">
                <flux:spacer />

                <flux:button wire:click="saveTransaction" variant="primary">Save changes</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
