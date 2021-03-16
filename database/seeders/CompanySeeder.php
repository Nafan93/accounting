<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'user_id' => 1,
            'name' => 'My company 1',
            'slug' => 'my-company-1',
            'full_name' => 'My company 1 director',
            'director_post' => 'Директор',
            'director_name' => 'My company 1',
            'inn' => rand(111111,999999),
            'kpp' => rand(111111,999999),
            'legal_addres' => 'My company 1 legal addres',
        ]);
        DB::table('companies')->insert([
            'user_id' => 2,
            'name' => 'My company 2',
            'slug' => 'my-company-2',
            'full_name' => 'My company 2 director',
            'director_post' => 'Директор',
            'director_name' => 'My company 2',
            'inn' => rand(111111,999999),
            'kpp' => rand(111111,999999),
            'legal_addres' => 'My company 2 legal addres',
        ]);
    }
}
