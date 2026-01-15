<?php

namespace App\Livewire;

use App\Enums\TransactionTypes;
use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Component;

class Home extends Component
{
    public array $filters = [];
    public array $cards = [];
    public array $data = [];

    #[On('transaction-added')]
    public function refreshDashboard()
    {
        $this->cards = Transaction::dashboardCard();
        $this->data = Transaction::commonFilters($this->filters)->dailyPerType()->get()->toArray();
    }

    public function mount()
    {
        $this->filters['dates']['from'] = now()->startOfMonth()->toDateString();
        $this->filters['dates']['to'] = now()->toDateString();

        $this->cards = Transaction::dashboardCard();
        $this->data = Transaction::commonFilters($this->filters)->dailyPerType()->get()->toArray();

        // dd($this->data);
    }

    public function render()
    {
        $transactions = Transaction::latest()->take(5)->get();
        return view('livewire.home', compact('transactions'));
    }

}
