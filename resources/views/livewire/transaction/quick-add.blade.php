<div>
    <flux:card class="p-3 mb-3">
        <form wire:submit="saveTransaction">
            <flux:field>
                <div class="flex gap-2">
                    <flux:label><flux:icon.bolt class="size-4" />Quick Add </flux:label>
                    <flux:tooltip toggleable>
                        <flux:button icon="information-circle" size="xs" variant="ghost" icon:variant="outline" />

                        <flux:tooltip.content class="max-w-[20rem] space-y-2">
                            <p>Input either Amount only OR Amount &lt;space&gt; Description</p>
                        </flux:tooltip.content>
                    </flux:tooltip>
                </div>

                <flux:input wire:model.change="transaction.details" autofocus>
                    <x-slot name="iconTrailing">
                        <flux:button type="submit" size="sm" variant="subtle" icon="check" class="-mr-1"/>
                    </x-slot>
                </flux:input>

                <flux:error name="transaction.details" />
                <flux:error name="transaction.amount" />
                <flux:error name="transaction.description" />
            </flux:field>
        </form>
    </flux:card>
</div>
