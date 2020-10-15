<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	DB::table('admins')->insert([
		    'name' => "Admin",
		    'last_name' => "Admin",
		    'email' => 'admin@gmail.com',
		    'password' => bcrypt('admin@123'),
		    'role' => 1,
		    'type' => 'Registerd',
		]);
        echo "Insert Successfully Email: admin@gmail.com, Password: admin@123";
    }
}
