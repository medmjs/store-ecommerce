<?php

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandDataBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Brand::class,20)->create();
    }
}
