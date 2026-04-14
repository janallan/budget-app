<?php

namespace App\Livewire\RecurringTransaction;

use App\Enums\TransactionTypes;
use App\Models\Category;
use App\Models\RecurringTransaction;
use App\Models\Transaction;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class PayTransactionForm extends Component
{
    public ?int $id = null;
    public $recurringTransaction = null;
    public array $transaction = [];
    public array $filters = [];
    public array $options = [];

    #[On('add-pay-transaction')]
    public function addTransaction($recurringTransactionId)
    {
        $this->reset('id', 'transaction');

        $this->recurringTransaction = RecurringTransaction::findOrFail($recurringTransactionId);
        $this->transaction = modelFillableToArray(Transaction::class);

        $this->transaction['account_id'] = $this->recurringTransaction->account_id;
        $this->transaction['type'] = $this->recurringTransaction->category->type;
        $this->transaction['amount'] = $this->recurringTransaction->amount;
        $this->transaction['category_id'] = $this->recurringTransaction->category_id;
        $this->transaction['transaction_date'] = now()->toDateString();
        $this->transaction['description'] = $this->recurringTransaction->description;
        $this->transaction['recurring_transaction_id'] = $this->recurringTransaction->recurring_transaction_id;
    }

    #[On('edit-pay-transaction')]
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

        Flux::toast('Transaction successfully deleted')->success();
    }

    public function mount()
    {
        $this->options['categories'] = Category::active()->orderBy('name')->get();
        $this->options['types'] = collectEnums(TransactionTypes::class);
    }

    public function render()
    {
        return view('livewire.recurring-transaction.pay-transaction-form');
    }

    public function saveTransaction()
    {
        $data = $this->validate();

        $data['transaction']['recurring_transaction_id'] = $this->recurringTransaction->id;
        $transaction = Transaction::create($data['transaction']);
        $transaction->refresh();

        Flux::toast('Transaction successfully created', variant: 'success');

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
