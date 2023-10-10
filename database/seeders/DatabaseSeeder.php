<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
//        \App\Models\User::factory()->create([
//            'first_name' => 'Luis',
//            'email' => 'luistrcastro@hotmail.com',
//            'last_name' => 'Castro',
//            'full_name' => 'Luis Castro',
//            'receives_browser_notifications' => true,
//            'receives_email_notifications' => true,
//            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
//            'created_at' => '2022-08-28 14:18:26',
//            'email_verified_at' => '2022-09-05 16:03:02',
//        ]);
      //  \App\Models\User::factory()->create([
      //      'first_name' => 'Test',
      //      'email' => 'test@test.com',
      //      'last_name' => 'Test',
      //      'full_name' => 'Test Test',
      //      'receives_browser_notifications' => true,
      //      'receives_email_notifications' => true,
      //      'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
      //      'created_at' => '2022-08-28 14:18:26',
      //      'email_verified_at' => '2022-09-05 16:03:02',
      //  ]);

        // \App\Models\User::factory(10)->create();

        $this->call([
           CategorySeeder::class,
           TransactionSeeder::class,
            AccountSeeder::class,
        ]);
    }
}
