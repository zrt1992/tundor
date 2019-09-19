<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class categories_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'food',
        ]);

        DB::table('categories')->insert([
            'name' => 'music',

        ]);

        DB::table('categories')->insert([
            'name' => 'football',

        ]);
    }
}
