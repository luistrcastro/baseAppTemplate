<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $firstUser = User::first();
        Auth::login($firstUser);
        Transaction::where('user_id', 1)->delete();
        Transaction::factory()->count(30)->create();
    }
}
