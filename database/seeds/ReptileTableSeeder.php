<?php

use Illuminate\Database\Seeder;

class ReptileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('reptile')->insert(
            [
                'ecaille' => 'petites',
                'idAnimal' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
