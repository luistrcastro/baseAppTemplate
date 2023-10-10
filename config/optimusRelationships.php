<?php

return [
    'hashMap' => [
        'Account' => 'Account',
        'Category' => 'Category',
        'Transaction' => 'Transaction',
        'User' => 'User',
    ],
    'isEnabled' => env('HASH_PRIMARY_KEYS', true),
];
