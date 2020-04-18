<?php

use App\UserAppTable;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(AssetTableSeeder::class);
         $this->call(StatusSeeder::class);
         $this->call(LocationSeeder::class);
         $this->call(RoomSeeder::class);
         $this->call(UserAppTableSeeder::class);
    }
}
