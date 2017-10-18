<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;

class OrganismosTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = F::create('App\Organismos');
        for ($i=0; $i < 3; $i++)
        {
        	DB::table('organismos')->insert([
        	'nombre' => $faker->name,
	        'cuit' => $faker->randomNumber(8),
        	]);
	        }
	     
    }
}
