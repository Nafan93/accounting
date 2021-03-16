<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\USer;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'user1@mail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$CeNVo3kNLpFz8dFh5fv5AeEpjpEeM1G1zRvTs3EzeOe.KrDN0Kkfq', // password
            'remember_token' => Str::random(10),
        ]);
        DB::table('users')->insert([
            'name' => 'user2',
            'email' => 'user2@mail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$CeNVo3kNLpFz8dFh5fv5AeEpjpEeM1G1zRvTs3EzeOe.KrDN0Kkfq', // password
            'remember_token' => Str::random(10),
        ]);
    }
}
