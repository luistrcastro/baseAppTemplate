<?php

/*
 * This file is part of Laravel Optimus.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Optimus Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [
        'main' => ['prime'=> env('HASH_MAIN'), 'inverse'=> env('HASH_MAIN_INVERSE'), 'random'=> env('HASH_MAIN_RANDOM')],

        'alternative' => ['prime' => '1805598649', 'inverse'=> '1060443785', 'random' => '1884825897'],

        'Account' => ['prime' => env('HASH_ACCOUNT', '212790001'), 'inverse' => env('HASH_ACCOUNT_INVERSE', '1366083089'), 'random' => env('HASH_ACCOUNT_RANDOM', '1436866104')],
        
        'Budget' => ['prime' => env('HASH_BUDGET', '212790001'), 'inverse' => env('HASH_BUDGET_INVERSE', '1366083089'), 'random' => env('HASH_BUDGET_RANDOM', '1436866104')],
        
        'Category' => ['prime' => env('HASH_CATEGORY', '1412622791'), 'inverse' => env('HASH_CATEGORY_INVERSE', '228853751'), 'random' => env('HASH_CATEGORY_RANDOM', '679295758')],
        
        'MonthBudget' => ['prime' => env('HASH_MONTH_BUDGET', '212790001'), 'inverse' => env('HASH_MONTH_BUDGET_INVERSE', '1366083089'), 'random' => env('HASH_MONTH_BUDGET_RANDOM', '1436866104')],

        'Transaction' => ['prime' => env('HASH_TRANSACTION', '401346571'), 'inverse' => env('HASH_TRANSACTION_INVERSE', '977664931'), 'random' => env('HASH_TRANSACTION_RANDOM', '1530135426')],

        'User' => ['prime' => env('HASH_USER', '1996228051'), 'inverse' => env('HASH_USER_INVERSE', '80976475'), 'random' => env('HASH_USER_RANDOM', '1957844967')],
    ],

];
