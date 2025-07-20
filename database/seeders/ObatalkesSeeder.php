<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObatalkesSeeder extends Seeder
{
    public function run()
    {
        $data = include database_path('seeders/data/ObatalkesSeederData.php');
        DB::table('obatalkes_m')->insert($data);
    }
}
