@section('title', 'Transactions')
<div>
    <div class="flex justify-end mb-4 pb-2">
        <flux:modal.trigger name="transaction-form-modal">
            <flux:button icon="plus" variant="primary" inset="top bottom"
                wire:click="$dispatch('add-transaction')"
            >Add</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-4">
        <div>
            <flux:input wire:model.change="filters.search" label="Search" placeholder="Search" />
        </div>
        <div>
            <flux:label class="mb-3">Transaction Dates</flux:label>
            <flux:input.group class="grid grid-cols-2">
                <flux:input wire:model.change="filters.dates.from" type="date" />
                <flux:input wire:model.change="filters.dates.to" type="date" />
            </flux:input.group>

        </div>
        <div>
            <x-forms.select
                :options="$options['categories']"
                option-value-key="id"
                option-label-key="name"
                label="Filter by Category"
                wire:model.change="filters.category"
                :has-empty-option="true"
                variant="listbox" searchable
            />
        </div>
        <div>
            <x-forms.select
                :options="$options['types']"
                option-value-key="value"
                option-label-key="label"
                label="Filter by Type"
                wire:model.change="filters.type"
                :has-empty-option="true"
                variant="listbox" searchable
            />
        </div>
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

    <flux:modal name="transaction-form-modal" class="w-lg" :dismissible="false">
        <form wire:submit="saveTransaction" class="space-y-6">
            <flux:heading size="lg">Transaction</flux:heading>

            <div class="grid grid-cols-12 gap-4 mb-4">
                <div class="col-span-6">
                    <flux:input wire:model="transaction.amount" label="Amount" type="number" step="0.01" />
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

                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
