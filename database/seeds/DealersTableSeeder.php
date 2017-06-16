<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class DealersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dealers')->insert([
        		['dealerId' => '3PAACONCEPTSDEV1', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
        		['dealerId' => '3PAACONCEPTSDEV2', 'created_at' => date('Y-m-d H:m:s'), 'updated_at' => date('Y-m-d H:m:s')],
        	]);
    }
}
