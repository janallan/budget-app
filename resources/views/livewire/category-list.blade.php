@section('title', 'Categories')
<div>
    <div wire:loading >
        <x-ui.loading />
    </div>
    <div class="flex justify-end">
        <flux:modal.trigger name="category-form-modal">
            <flux:button icon="plus" variant="primary" inset="top bottom"
                wire:click="$dispatch('add-category')"
            >Add</flux:button>
        </flux:modal.trigger>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-4">
        <div>
            <flux:input wire:model.change="filters.search" label="Search" placeholder="Search" />
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

    <flux:table :paginate="$categories">
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Default Type</flux:table.column>
            <flux:table.column>Active</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($categories as $category)
                <flux:table.row :key="$category->id">
                    <flux:table.cell>{{ $category->name }}</flux:table.cell>
                    <flux:table.cell>{{ $category->type }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm" :color="$category->is_active ? 'green' : 'red'" inset="top bottom">{{ $category->is_active ? 'Active' : 'Inactive' }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:modal.trigger name="category-form-modal">
                            <flux:button size="xs" icon="pencil" variant="primary" inset="top bottom"
                                wire:click="$dispatch('edit-category', {categoryId: {{ $category->id }}})"
                            >Edit</flux:button>
                        </flux:modal.trigger>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach

            @if ($categories->count() == 0)
                <flux:table.row>
                    <flux:table.cell colspan="4">
                        No Categories found.
                    </flux:table.cell>
                </flux:table.row>
            @endif
        </flux:table.rows>
    </flux:table>

    <flux:modal name="category-form-modal" class="md:w-96" :dismissible="false">
        <form wire:submit="saveCategory" class="space-y-6">
            <flux:heading size="lg">Category</flux:heading>

            <flux:input wire:model="category.name" label="Name" placeholder="e.g. Rent, Internet, etc." />

            <x-forms.select
                :options="$options['types']"
                option-value-key="value"
                option-label-key="label"
                label="Default Type"
                wire:model.change="category.type"
            />

            <flux:field variant="inline">
                <flux:checkbox wire:model="category.is_active" />
                <flux:label>Active</flux:label>
                <flux:error name="category.is_active" />
            </flux:field>

            <div class="flex">
                <flux:spacer />

                <flux:button wire:click="saveCategory" variant="primary">Save changes</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
