<?php

namespace App\Livewire\Templates;

use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class FormListTemplate extends Component
{
    use WithPagination;
    public ?int $id = null;
    public array $template = [];
    public array $filters = [];
    public array $options = [];

    #[On('add-template')]
    public function addTemplate()
    {
        $this->reset('id', 'template');

        $this->template = modelFillableToArray(Template::class);
        $this->template['is_active'] = true;
    }

    #[On('edit-template')]
    public function editTemplate($templateId)
    {
        $template = Template::findOrFail($templateId);

        $this->id = $template->id;
        $this->template = $template->toArray();
    }

    #[On('delete-template')]
    public function deleteTemplate($templateId)
    {
        $template = Template::findOrfail($templateId);
        $template->delete();

        Flux::toast('Transaction Type successfully deleted')->success();
    }

    public function mount()
    {

    }

    public function render()
    {
        $types = Template::commonFilters($this->filters)
            ->orderBy('name')
            ->paginate();

        return view('livewire.templates.form-list-template', compact('types'));
    }

    public function saveTemplate()
    {
        $data = $this->validate();

        if (filled($this->id)) {
            $template = Template::findOrFail($this->id);
            $template->update($data['template']);

            Flux::toast('Transaction Type successfully updated', variant: 'success');
        } else {

            $template = Template::create($data['template']);
            $template->refresh();

            Flux::toast('Transaction Type successfully created', variant: 'success');
        }

        $this->redirectRoute('templates.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'template.name' => [
                'required',
                'string',
                'max:60',
                Rule::unique('template_types', 'name')->ignore($this->id),
            ],
            'template.is_active' => [
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
            'template.name' => 'Name',
            'template.is_active' => 'Active',
        ];

        return $attributes;
    }
}
