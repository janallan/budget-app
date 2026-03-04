<?php

namespace App\Livewire\RecurringTransaction;

use App\Enums\RecurringFrequency;
use App\Models\Category;
use App\Models\RecurringTransaction;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RecurringTransactionList extends Component
{
    use WithPagination;
    public ?int $id = null;
    public array $transaction = [];
    public array $filters = [];
    public array $options = [];

    #[On('add-transaction')]
    public function addRecurringTransaction()
    {
        $this->reset('id', 'transaction');

        $this->transaction = modelFillableToArray(RecurringTransaction::class);
        $this->transaction['is_active'] = true;
        $this->transaction['day_of_month'] = 1;
        $this->transaction['frequency'] = RecurringFrequency::MONTHLY;
    }

    #[On('edit-transaction')]
    public function editRecurringTransaction($transactionId)
    {
        $transaction = RecurringTransaction::findOrFail($transactionId);

        $this->id = $transaction->id;
        $this->transaction = $transaction->toArray();
    }

    #[On('delete-transaction')]
    public function deleteRecurringTransaction($transactionId)
    {
        $transaction = RecurringTransaction::findOrfail($transactionId);
        $transaction->delete();

        Flux::toast('Recurring Transaction successfully deleted', variant: 'success');
        $this->redirectRoute('recurring-transactions.index');
    }

    public function mount()
    {
        $this->options['categories'] = Category::active()->orderBy('name')->get();
        $this->options['days'] = collect(range(1,31))
            ->map(fn ($i)  => ['label' => $i, 'value' => $i])
            ->toArray();

    }

    public function render()
    {
        $transactions = RecurringTransaction::commonFilters($this->filters)
            ->orderBy('day_of_month')
            ->paginate();

        return view('livewire.recurring-transaction.recurring-transaction-list', compact('transactions'));
    }

    public function saveRecurringTransaction()
    {
        $data = $this->validate();

        if (filled($this->id)) {
            $transaction = RecurringTransaction::findOrFail($this->id);
            $transaction->update($data['transaction']);

            Flux::toast('Recurring Transaction successfully updated', variant: 'success');
        } else {

            $transaction = RecurringTransaction::create($data['transaction']);
            $transaction->refresh();

            Flux::toast('Recurring Transaction successfully created', variant: 'success');
        }

        $this->redirectRoute('recurring-transactions.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'transaction.category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('is_active', true),
            ],
            'transaction.frequency' => [
                'required',
                Rule::in(RecurringFrequency::getValues()),
            ],
            'transaction.day_of_month' => [
                'required',
                'numeric',
                'between:1,31',
            ],
            'transaction.amount' => [
                'required',
                'numeric',
                'gt:0',
            ],
            'transaction.is_active' => [
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
            'transaction.category_id' => 'Category',
            'transaction.frequency' => 'Frequency',
            'transaction.day_of_month' => 'Day of Month',
            'transaction.amount' => 'Amount',
            'transaction.is_active' => 'Active',
        ];

        return $attributes;
    }
}
