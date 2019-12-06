<?php

use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 4)->create()->each(function ($user) {
            $user_to_id = $user->id + 1;
            if ($user_to_id == 5) {
                $user_to_id = 1;
            }
            $user->transactions()->saveMany(
                factory(Transaction::class, 3)->make(['user_to_id' => $user_to_id])
            );
        });
    }
}
