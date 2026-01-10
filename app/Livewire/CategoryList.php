<?php

namespace App\Livewire;

use App\Enums\TransactionTypes;
use App\Models\Category;
use App\Models\TransactionType;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;
    public ?int $id = null;
    public array $category = [];
    public array $filters = [];
    public array $options = [];

    #[On('add-category')]
    public function addCategory()
    {
        $this->reset('id', 'category');

        $this->category = modelFillableToArray(Category::class);
        $this->category['is_active'] = true;
        $this->category['type'] = TransactionTypes::EXPENSE;
    }

    #[On('edit-category')]
    public function editCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $this->id = $category->id;
        $this->category = $category->toArray();
    }

    #[On('delete-category')]
    public function deleteCategory($categoryId)
    {
        $category = Category::findOrfail($categoryId);
        $category->delete();

        Flux::toast('Category successfully deleted')->success();
    }

    public function mount()
    {
        $this->options['types'] = collectEnums(TransactionTypes::class);
    }

    public function render()
    {
        $categories = Category::commonFilters($this->filters)
            ->orderBy('name')
            ->paginate();

        return view('livewire.category-list', compact('categories'));
    }

    public function saveCategory()
    {
        $data = $this->validate();

        if (filled($this->id)) {
            $category = Category::findOrFail($this->id);
            $category->update($data['category']);

            Flux::toast('Category successfully updated', variant: 'success');
        } else {

            $category = Category::create($data['category']);
            $category->refresh();

            Flux::toast('Category successfully created', variant: 'success');
        }

        $this->redirectRoute('categories.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'category.name' => [
                'required',
                'string',
                'max:60',
                Rule::unique('categories', 'name')->ignore($this->id),
            ],
            'category.type' => [
                'required',
                Rule::in(TransactionTypes::getValues()),
            ],
            'category.is_active' => [
                'sometimes',
                'nullable',
                'boolean',
            ],
        ];

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function validationAttributes()
    {
        $attributes = [
            'category.name' => 'Name',
            'category.type' => 'Default Type',
            'category.is_active' => 'Active',
        ];

        return $attributes;
    }
}
