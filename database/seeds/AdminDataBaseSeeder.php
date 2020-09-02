<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminDataBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Admin::create([
           'name'=>'mohammed',
           'email'=>'mohammed@gmail.com',
           'password'=>bcrypt('123456789'),
       ]);
        Admin::create([
            'name'=>'omar',
            'email'=>'omar@gmail.com',
            'password'=>bcrypt('123456789'),
        ]);
        Admin::create([
            'name'=>'hosam',
            'email'=>'hosam@gmail.com',
            'password'=>bcrypt('123456789'),
        ]);
    }
}
