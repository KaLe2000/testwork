<?php

namespace App\Jobs;

use App\Transaction;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class MakeTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction;

    /**
     * Create a new job instance.
     *
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Throwable
     */
    public function handle()
    {
        $transaction = $this->transaction;

        DB::transaction(function () use ($transaction) {

            User::where('id', $transaction->user_id)->decrement('balance', $transaction->sum);

            User::where('id', $transaction->user_to_id)->increment('balance', $transaction->sum);

            $transaction->update(['status' => 1]);

        });
    }
}
