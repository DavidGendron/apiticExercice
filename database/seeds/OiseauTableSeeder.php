<?php

use Illuminate\Database\Seeder;

class OiseauTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('oiseau')->insert(
            [
                'plumage' => 'moyen',
                'idAnimal' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('oiseau')->insert(
            [
                'plumage' => 'moyen',
                'idAnimal' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
