<?php

namespace App\Livewire\Transaction;

use App\Enums\TransactionTypes;
use App\Models\Category;
use App\Models\Transaction;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionList extends Component
{
    use WithPagination;
    public ?int $id = null;
    public array $transaction = [];
    public array $filters = [];
    public array $options = [];

    #[On('add-transaction')]
    public function addTransaction()
    {
        $this->reset('id', 'transaction');

        $this->transaction = modelFillableToArray(Transaction::class);
        $this->transaction['type'] = TransactionTypes::EXPENSE;
        $this->transaction['transaction_date'] = now()->toDateString();
    }

    #[On('edit-transaction')]
    public function editTransaction($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);

        $this->id = $transaction->id;
        $this->transaction = $transaction->toArray();
    }

    #[On('delete-transaction')]
    public function deleteTransaction($transactionId)
    {
        $transaction = Transaction::findOrfail($transactionId);
        $transaction->delete();

        Flux::toast('Transaction Type successfully deleted')->success();
    }

    public function updatedTransactionCategoryId($value)
    {
        $category = Category::find($value);
        if ($category) {
            $this->transaction['type'] = $category->type;
        }
        else $this->transaction['type'] = TransactionTypes::EXPENSE;
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->options['categories'] = Category::active()->orderBy('name')->get();
        $this->options['types'] = collectEnums(TransactionTypes::class);
    }

    public function render()
    {
        $transactions = Transaction::commonFilters($this->filters)
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.transaction.transaction-list', compact('transactions'));
    }

    public function saveTransaction()
    {
        $data = $this->validate();

        if (filled($this->id)) {
            $transaction = Transaction::findOrFail($this->id);
            $transaction->update($data['transaction']);

            Flux::toast('Transaction Type successfully updated', variant: 'success');
        } else {

            $transaction = Transaction::create($data['transaction']);
            $transaction->refresh();

            Flux::toast('Transaction Type successfully created', variant: 'success');
        }

        $this->redirectRoute('transactions.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'transaction.is_active' => [
                'sometimes',
                'nullable',
                'boolean',
            ],
            'transaction.amount' => [
                'required',
                'numeric',
                'gt:0',
            ],
            'transaction.category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('is_active', true),
            ],
            'transaction.type' => [
                'required',
                Rule::in(TransactionTypes::getValues()),
            ],
            'transaction.transaction_date' => [
                'required',
                'date',
            ],
            'transaction.description' => [
                'sometimes',
                'nullable',
                'string',
                'max:200',
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
            'transaction.type' => 'Type',
            'transaction.amount' => 'Amount',
            'transaction.category_id' => 'Category',
            'transaction.transaction_date' => 'Transaction Date',
            'transaction.description' => 'Description',
        ];

        return $attributes;
    }
}
