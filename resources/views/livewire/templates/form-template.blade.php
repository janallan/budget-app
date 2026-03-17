<div>
    <form wire:submit="saveTemplate" class="space-y-6">
        <flux:heading size="lg">Template</flux:heading>

        <flux:input wire:model="template.name" label="Name" placeholder="e.g. Income, Expenses, Bills, etc." />

        <flux:field variant="inline">
            <flux:checkbox wire:model="template.is_active" />
            <flux:label>Active</flux:label>
            <flux:error name="template.is_active" />
        </flux:field>

        <div class="flex">
            <flux:spacer />

            <flux:button wire:click="saveTemplate" variant="primary">Save changes</flux:button>
        </div>
    </form>
</div>
