<?php

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
        // $this->call(UsersTableSeeder::class);
        // Role comes before User seeder here.
		// User seeder will use the roles above created.
		$this->call(UserTableSeeder::class);
        $this->call(LaratrustSeeder::class);
    }
}
