<?php

use Illuminate\Database\Seeder;

class MammifereTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('mammifere')->insert(
            [
                'fourrure' => 'moyenne',
                'idAnimal' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('mammifere')->insert(
            [
                'fourrure' => 'épaisse, bouclée',
                'idAnimal' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('mammifere')->insert(
            [
                'fourrure' => 'moyenne',
                'idAnimal' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
