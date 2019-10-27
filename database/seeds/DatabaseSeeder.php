<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        
        $this->call([UsersTableSeeder::class]);
        $this->call([AccountTableSeeder::class]);
        $this->call([FarmTableSeeder::class]);

        //$this->call([UserAccountTableSeeder::class]);
        
    }
}
