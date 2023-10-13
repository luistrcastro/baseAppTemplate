<?php

return [
    'hashMap' => [
        'Account' => 'Account',
        'Budget' => 'Budget',
        'Category' => 'Category',
        'MonthBudget' => 'MonthBudget',
        'Transaction' => 'Transaction',
        'User' => 'User',
    ],
    'isEnabled' => env('HASH_PRIMARY_KEYS', true),
];
