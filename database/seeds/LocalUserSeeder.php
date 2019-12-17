<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LocalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $token = Str::random(60);
        $datetime = (new \DateTime())->format('Y-m-d H:i:s');
        DB::table('users')->insert([
            [
                'name' => 'Test user',
                'email' => 'testuser@testuser',
                'password' => bcrypt('token'),
                'api_token' => $token,
                'created_at' => $datetime,
                'updated_at' => $datetime
            ]
        ]);
        echo "Token generated: {$token}";
    }
}
