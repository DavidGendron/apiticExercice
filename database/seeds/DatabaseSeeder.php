<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AnimalTableSeeder::class);
        $this->call(MammifereTableSeeder::class);
        $this->call(OiseauTableSeeder::class);
        $this->call(ReptileTableSeeder::class);

        Model::reguard();
    }
}