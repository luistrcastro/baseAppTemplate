<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonthBudgetSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('categories')->upsert(array (
      0 =>
      array (
        'id' => 1,
        'user_id' => null,
        'name' => 'Income',
        'color' => 'blue-darken-4',
        'icon' => 'cash-plus',
        'description' => 'Month income transactions',
        'type' => 'income'
      ),
      1 =>
      array (
        'id' => 2,
        'user_id' => null,
        'name' => 'Essencials',
        'color' => 'orange-darken-4',
        'icon' => 'cash-minus',
        'description' => 'Month essencial expenses, such as rent, groceries, gas, electricity, etc.',
        'type' => 'expense',
        'percentage' => 55,
      ),
      2=>
      array (
        'id' => 3,
        'user_id' => null,
        'name' => 'Education',
        'color' => 'blue-grey',
        'icon' => 'school-outline',
        'description' => 'Month education expenses',
        'type' => 'expense',
        'percentage' => 5,
      ),
      3=>
      array (
        'id' => 4,
        'user_id' => null,
        'name' => 'Free',
        'color' => 'green-accent-3',
        'icon' => 'cash-fast',
        'description' => 'Month free expenses, such as alcohol, leisure, cinema, etc.',
        'type' => 'expense',
        'percentage' => 10
      ),
      4=>
      array (
        'id' => 5,
        'user_id' => null,
        'name' => 'Savings / Investiments',
        'color' => 'light-blue',
        'icon' => 'chart-bell-curve-cumulative',
        'description' => 'Month savings and investiments transactions',
        'type' => 'expense',
        'percentage' => 30
      ),
    ), 'id');
  }
}
