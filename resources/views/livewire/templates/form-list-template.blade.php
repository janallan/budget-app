@section('title', 'Templates')
<div>
    <div class="flex justify-end">
        <flux:modal.trigger name="template-form-modal">
            <flux:button icon="plus" variant="primary" inset="top bottom"
                wire:click="$dispatch('add-template')"
            >Add</flux:button>
        </flux:modal.trigger>

    </div>
    <flux:table :paginate="$templates">
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Active</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($templates as $template)
                <flux:table.row :key="$template->id">
                    <flux:table.cell>{{ $template->name }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm" :color="$template->is_active ? 'green' : 'red'" inset="top bottom">{{ $template->is_active ? 'Active' : 'Inactive' }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:modal.trigger name="template-form-modal">
                            <flux:button size="xs" icon="pencil" variant="primary" inset="top bottom"
                                wire:click="$dispatch('edit-template', {templateId: {{ $template->id }}})"
                            >Edit</flux:button>
                        </flux:modal.trigger>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach

            @if ($templates->count() == 0)
                <flux:table.row>
                    <flux:table.cell colspan="4">
                        No Templates found.
                    </flux:table.cell>
                </flux:table.row>
            @endif
        </flux:table.rows>
    </flux:table>

    <flux:modal name="template-form-modal" class="md:w-96">
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
    </flux:modal>
</div>
