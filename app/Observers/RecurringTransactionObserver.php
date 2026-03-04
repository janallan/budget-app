<?php

namespace App\Observers;

use App\Models\RecurringTransaction;

class RecurringTransactionObserver
{
    /**
     * Handle the RecurringTransaction "creating" event.
     */
    public function creating(RecurringTransaction $recurringTransaction): void
    {
        $recurringTransaction->account_id = user()->id;
    }

    /**
     * Handle the RecurringTransaction "created" event.
     */
    public function created(RecurringTransaction $recurringTransaction): void
    {
        //
    }

    /**
     * Handle the RecurringTransaction "updated" event.
     */
    public function updated(RecurringTransaction $recurringTransaction): void
    {
        //
    }

    /**
     * Handle the RecurringTransaction "deleted" event.
     */
    public function deleted(RecurringTransaction $recurringTransaction): void
    {
        //
    }

    /**
     * Handle the RecurringTransaction "restored" event.
     */
    public function restored(RecurringTransaction $recurringTransaction): void
    {
        //
    }

    /**
     * Handle the RecurringTransaction "force deleted" event.
     */
    public function forceDeleted(RecurringTransaction $recurringTransaction): void
    {
        //
    }
}
