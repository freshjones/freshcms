<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('variables')->insert([
            ['name' => 'language', 'value' => 'en', ],
            ['name' => 'template', 'value' => 'default', ],
            ['name' => 'front', 'value' => 'default', ],
        ]);

    }
}
