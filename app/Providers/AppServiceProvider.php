<?php

namespace App\Providers;

use App\Http\EntityExists;
use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\MonthBudget;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      /* Morph Map: */
      Relation::enforceMorphMap(map: [
        'Account' => Account::class,
        'Budget' => Budget::class,
        'Category' => Category::class,
        'MonthBudget' => MonthBudget::class,
        'Transaction' => Transaction::class,
        'User' => User::class
      ]);
        
      Validator::extend('entity_exists', function ($attribute, $value, $parameters) {
        return ( new EntityExists(...$parameters) )->passes($attribute, $value);
    });
    }
}
