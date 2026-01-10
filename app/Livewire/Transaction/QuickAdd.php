<?php

namespace App\Livewire\Transaction;

use App\Enums\TransactionTypes;
use App\Models\Transaction;
use Livewire\Component;

class QuickAdd extends Component
{
    public array $transaction = [];

    public function render()
    {
        return view('livewire.transaction.quick-add');
    }

    public function saveTransaction()
    {
        $extracted = explode(' ', $this->transaction['details'] ?? '', 2);

        $this->transaction['amount'] = (float) $extracted[0];
        $this->transaction['description'] = $extracted[1] ?? null;

        $data = $this->validate();

        $data['transaction']['transaction_date'] = now()->toDateString();
        $data['transaction']['type'] = TransactionTypes::EXPENSE;

        $sameDescription = Transaction::where('description', 'like', "%{$data['transaction']['description']}%")->latest()->first();
        if ($sameDescription) {
            $data['transaction']['category_id'] = $sameDescription->category_id;
            $data['transaction']['type'] = $sameDescription->type;
        }

        Transaction::create($data['transaction']);

        $this->resetValidation();
        $this->reset('transaction');

        toast('Transaction successfully saved');
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
            'transaction.amount' => 'Amount',
            'transaction.description' => 'Description',
        ];

        return $attributes;
    }
}
