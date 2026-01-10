@section('title', 'Home')
<div>
    <div class="grid grid-cols-3 gap-x-4 gap-y-6">
        <div class="col-span-2">
            <div class="flex gap-6 mb-6">
                @foreach ($cards as $card)
                    <div class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700">
                        <flux:subheading>{{ $card['title'] }}</flux:subheading>

                        <flux:heading size="xl" class="mb-2">{{ money_format($card['total_today']) }}</flux:heading>

                        <div class="flex items-center gap-1 font-medium text-sm @if ($card['trend'] == 'increase') text-green-600 dark:text-green-400 @elseif($card['trend'] == 'decrease') text-red-500 dark:text-red-400 @endif">
                            <flux:icon :icon="$card['trendUp'] ? 'arrow-trending-up' : 'arrow-trending-down'" variant="micro" /> {{ $card['percent_change'] }}&percnt;
                            <flux:text variant="subtle" size="sm">&nbsp;Last Month: {{ money_format($card['total_yesterday']) }}</flux:text>
                        </div>
                    </div>
                @endforeach
            </div>

            <flux:card>
                <flux:chart wire:model="data">
                    <flux:chart.viewport class="min-h-[20rem]">
                        <flux:chart.svg>
                            <flux:chart.line field="income" class="text-green-500"/>
                            <flux:chart.line field="expense" class="text-red-500" />

                            <flux:chart.axis axis="x" field="date"  :format="['month' => '2-digit', 'day' => '2-digit', 'year' => '2-digit']">
                                <flux:chart.axis.tick />
                                <flux:chart.axis.line />
                            </flux:chart.axis>

                            <flux:chart.axis axis="y" :format="['style' => 'currency', 'currency' => 'PHP']" >
                                <flux:chart.axis.grid />
                                <flux:chart.axis.tick />
                            </flux:chart.axis>

                            <flux:chart.cursor />
                        </flux:chart.svg>
                            <flux:chart.tooltip>
                                <flux:chart.tooltip.heading field="date" :format="['year' => 'numeric', 'month' => 'numeric', 'day' => 'numeric']" />
                                <flux:chart.tooltip.value field="income" label="Income" :format="['style' => 'currency', 'currency' => 'PHP']" />
                                <flux:chart.tooltip.value field="expense" label="Expense" :format="['style' => 'currency', 'currency' => 'PHP']" />
                            </flux:chart.tooltip>
                    </flux:chart.viewport>
                </flux:chart>

            </flux:card>
        </div>
        <div>
            <livewire:transaction.quick-add />

            <flux:heading size="lg" variant="subtle" >Recent Transactions </flux:heading>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Category</flux:table.column>
                    <flux:table.column align="center">Type</flux:table.column>
                    <flux:table.column align="end">Amount</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($transactions as $transaction)
                        <flux:table.row :key="$transaction->id">
                            <flux:table.cell class="text-xs">
                                {{ $transaction->category ? $transaction->category->name : 'NO ASSIGNED CATEGORY' }}
                                <flux:text class="text-xs">{{ formatDate($transaction->transaction_date) }}</flux:text>
                            </flux:table.cell>
                            <flux:table.cell class="text-xs" align="center">{{ $transaction->type }}</flux:table.cell>
                            <flux:table.cell class="text-xs" align="end">{{ money_format($transaction->amount) }}</flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

    </div>
</div>
