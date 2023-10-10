<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->delete();

        \DB::table('categories')->insert(array (
            0 =>
            array (
                'id' => 1,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Beauty',
                'slug' => 'beauty',
                'color' => 'purple',
                'icon' => 'hair-dryer-outline',
                'description' => 'Hair cut, Waxxing, Nails...',
            ),
            1 =>
            array (
                'id' => 2,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Alcohol',
                'slug' => 'alcohol',
                'color' => 'orange',
                'icon' => 'glass-mug-variant',
                'description' => 'Beer, Wine, Whiskey...',
            ),
            2 =>
            array (
                'id' => 3,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Education',
                'slug' => 'education',
                'color' => 'blue',
                'icon' => 'school-outline',
                'description' => 'General Education Expenses',
            ),
            3 =>
            array (
                'id' => 4,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Electricity',
                'slug' => 'electricity',
                'color' => 'yellow accent-2',
                'icon' => 'flash-outline',
                'description' => null,
            ),
            4 =>
            array (
                'id' => 5,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Grocery',
                'slug' => 'grocery',
                'color' => 'light-green accent-3',
                'icon' => 'basket-outline',
                'description' => null,
            ),
            5 =>
            array (
                'id' => 6,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'House',
                'slug' => 'house',
                'color' => 'green accent-3',
                'icon' => 'home-outline',
                'description' => 'General expenses with the house',
            ),
            6 =>
            array (
                'id' => 7,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Insurances',
                'slug' => 'insurances',
                'color' => 'green lighten-2',
                'icon' => 'shield-check-outline',
                'description' => 'House, Car, Life...',
            ),
            7 =>
            array (
                'id' => 8,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Communication',
                'slug' => 'communication',
                'color' => 'red accent-2',
                'icon' => 'access-point',
                'description' => 'Internet, Cellphone',
            ),
            8 =>
            array (
                'id' => 9,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Pharmacy',
                'slug' => 'pharmacy',
                'color' => 'red accent-4',
                'icon' => 'hospital-box-outline',
                'description' => null,
            ),
            9 =>
            array (
                'id' => 10,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Rent',
                'slug' => 'rent',
                'color' => 'purple lighten-2',
                'icon' => 'home-city-outline',
                'description' => null,
            ),
            10 =>
            array (
                'id' => 11,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Restaurant, Fast-food',
                'slug' => 'restaurant_fast_food',
                'color' => 'deep-orange',
                'icon' => 'silverware-fork-knife',
                'description' => null,
            ),
            11 =>
            array (
                'id' => 12,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Pets',
                'slug' => 'pets',
                'color' => 'orange darken-3',
                'icon' => 'paw',
                'description' => null,
            ),
            12 =>
            array (
                'id' => 13,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Tax',
                'slug' => 'tax',
                'color' => 'yellow accent-4',
                'icon' => 'cash-multiple',
                'description' => null,
            ),
            13 =>
            array (
                'id' => 14,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Transportation',
                'slug' => 'transportation',
                'color' => 'amber lighten-1',
                'icon' => 'train-car',
                'description' => null,
            ),
            14 =>
            array (
                'id' => 15,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Streaming',
                'slug' => 'streaming',
                'color' => 'orange lighten-2',
                'icon' => 'youtube-tv',
                'description' => 'YouTube, Amazon Prime, Paramount...',
            ),
            15 =>
            array (
                'id' => 16,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Health & Well-being',
                'slug' => 'health_&_well_being',
                'color' => 'orange lighten-1',
                'icon' => 'bicycle-basket',
                'description' => 'Gym, Yoga, Sports...',
            ),
            16 =>
            array (
                'id' => 17,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Tech',
                'slug' => 'tech',
                'color' => 'deep-orange lighten-2',
                'icon' => 'devices',
                'description' => 'VPN, Anti-virus, Software...',
            ),
            17 =>
            array (
                'id' => 18,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Daily Expenses',
                'slug' => 'daily_expenses',
                'color' => 'blue-grey darken-2',
                'icon' => 'hand-coin-outline',
                'description' => 'Small daily expenses which do not belong to any major category',
            ),
            18 =>
            array (
                'id' => 19,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Leisure',
                'slug' => 'leisure',
                'color' => 'grey darken-2',
                'icon' => 'ticket',
                'description' => 'Cinema, Theatre, Sightseeing...',
            ),
            19 =>
            array (
                'id' => 20,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Purchase',
                'slug' => 'purchase',
                'color' => 'blue-grey darken-4',
                'icon' => 'credit-card-outline',
                'description' => 'General purchases',
            ),
            20 =>
            array (
                'id' => 21,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Gift',
                'slug' => 'gift',
                'color' => 'brown darken-4',
                'icon' => 'gift-outline',
                'description' => 'Birthday, Anniversaries, Other gifts',
            ),
            21 =>
            array (
                'id' => 22,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Travel',
                'slug' => 'travel',
                'color' => 'brown lighten-1',
                'icon' => 'airplane-takeoff',
                'description' => 'Tickets, Hotels, Car Rentals',
            ),
            22 =>
            array (
                'id' => 23,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Withdrawal',
                'slug' => 'withdrawal',
                'color' => 'deep-orange lighten-4',
                'icon' => 'bank-transfer-out',
                'description' => null,
            ),
            23 =>
            array (
                'id' => 24,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Coffee Shops',
                'slug' => 'coffee_shops',
                'color' => 'brown',
                'icon' => 'coffee',
                'description' => 'Starbucks, Tim Hortons, Second Cup...',
            ),
            24 =>
            array (
                'id' => 25,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Savings',
                'slug' => 'savings',
                'color' => 'lime accent-4',
                'icon' => 'cash-plus',
                'description' => 'Savings Account',
            ),
            25 =>
            array (
                'id' => 26,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Investing',
                'slug' => 'investing',
                'color' => 'lime accent-2',
                'icon' => 'bitcoin',
                'description' => 'TFSA, Crypto, Stocks...',
            ),
            27 =>
            array (
                'id' => 28,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Vehicle',
                'slug' => 'vehicle',
                'color' => 'lime darken-4',
                'icon' => 'car-hatchback',
                'description' => 'Fuel, Leasing, Maintenance...',
            ),
            28 =>
            array (
                'id' => 29,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Kids',
                'slug' => 'kids',
                'color' => 'light-green accent-1',
                'icon' => 'baby-carriage',
                'description' => null,
            ),
            29 =>
            array (
                'id' => 30,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Transfer',
                'slug' => 'transfer',
                'color' => 'light-green',
                'icon' => 'bank-transfer',
                'description' => null,
            ),
            30 =>
            array (
                'id' => 31,
                'parent_category_id' => null,
                'user_id' => null,
                'created_at' => '2022-08-28 14:18:26',
                'name' => 'Income',
                'slug' => 'income',
                'color' => 'green accent-4',
                'icon' => 'bank-transfer-in',
                'description' => 'Paycheck, Bonus, Gifts...',
            ),
        ));
    }
}
