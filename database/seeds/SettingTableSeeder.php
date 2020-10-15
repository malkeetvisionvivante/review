<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	DB::table('setting')->insert([
       		[
			    'u_code' => "email",
			    'info' => "blossamtesting@gmail.com",
			],
			[
			    'u_code' => "phone",
			    'info' => "1234567890",
			],
			[
			    'u_code' => "facebook_link",
			    'info' => "facebook.com",
			],
			[
			    'u_code' => "twitter_link",
			    'info' => "twitter.com",
			],
			[
			    'u_code' => "linked_in_link",
			    'info' => "linked.in",
			],
			[
			    'u_code' => "instagram_link",
			    'info' => "instagram.com",
			],
			[
			    'u_code' => "pinterest_link",
			    'info' => "pinterest.com",
			]
		]);
        echo "Setting Data Insert Successfully";
    }
}
