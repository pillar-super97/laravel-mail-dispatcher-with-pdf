<?php

namespace Database\Seeders;

use App\Models\Filter;
use Illuminate\Database\Seeder;

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filter = [
            [
                'id'             => 1,
                'mailto'           => 'pillartest4@outlook.com',
            ],
        ];

        Filter::insert($filter);
    }
}
