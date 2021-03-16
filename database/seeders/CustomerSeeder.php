<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Customer;
class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            'company_id' => '1',
            'name' => 'My company 1 customer 1',
            'full_name' => 'My company 1 customer 1',
            'director_name' => 'My company 1 customer 1 director',
            'director_post' => 'Директор',
            'inn' => rand(111111,999999),
            'kpp' => rand(111111,999999),
            'legal_addres' => 'My company 1 customer 1 legal addres',
            
        ]);
        DB::table('customers')->insert([
            'company_id' => '1',
            'name' => 'My company 1 customer 2',
            'full_name' => 'My company 1 customer 2',
            'director_name' => 'My company 1 customer 2 director',
            'director_post' => 'Директор',
            'inn' => rand(111111,999999),
            'kpp' => rand(111111,999999),
            'legal_addres' => 'My company 1 customer 2 legal addres',
        ]);
        DB::table('customers')->insert([
            'company_id' => '2',
            'name' => 'My company 2 customer 1',
            'full_name' => 'My company 2 customer 1',
            'director_name' => 'My company 2 customer 1 director',
            'director_post' => 'Директор',
            'inn' => rand(111111,999999),
            'kpp' => rand(111111,999999),
            'legal_addres' => 'My company 2 customer 1 legal addres' ,
        ]);
        DB::table('customers')->insert([
            'company_id' => '2',
            'name' => 'My company 2 customer 1',
            'full_name' => 'My company 2 customer 1',
            'director_name' => 'My company 2 customer 1 director',
            'director_post' => 'Директор',
            'inn' => rand(111111,999999),
            'kpp' => rand(111111,999999),
            'legal_addres' => 'My company 2 customer 1 legal addres',
        ]);
    }
}
