<?php

namespace App\Livewire;

use App\Enums\TransactionTypes;
use App\Models\Transaction;
use Livewire\Component;

class Home extends Component
{
    public array $filters = [];
    public array $cards = [];
    public array $data = [];

    // public array $data = [
    //     ['date' => '2026-01-01', 'twitter' => 0.22, 'facebook' => 0.30, 'instagram' => 0.15],
    //     ['date' => '2026-01-02', 'twitter' => 0.19, 'facebook' => 0.28, 'instagram' => 0.18],
    //     ['date' => '2026-01-03', 'twitter' => 0.25, 'facebook' => 0.33, 'instagram' => 0.20],
    //     ['date' => '2026-01-04', 'twitter' => 0.23, 'facebook' => 0.31, 'instagram' => 0.17],
    //     ['date' => '2026-01-05', 'twitter' => 0.21, 'facebook' => 0.29, 'instagram' => 0.19],
    // ];

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
