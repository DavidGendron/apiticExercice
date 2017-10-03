<?php

use Illuminate\Database\Seeder;

class AnimalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('animal')->insert(
            [
            	'id' => 1,
                'nom' => 'chat',
                'genre' => 'Masculin',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('animal')->insert(
            [
            	'id' => 2,
                'nom' => 'couleuvre',
                'genre' => 'Féminin',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('animal')->insert(
            [
            	'id' => 3,
                'nom' => 'mouton',
                'genre' => 'Masculin',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('animal')->insert(
            [
            	'id' => 4,
                'nom' => 'chien',
                'genre' => 'Masculin',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('animal')->insert(
            [
            	'id' => 5,
                'nom' => 'poule',
                'genre' => 'Féminin',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('animal')->insert(
            [
            	'id' => 6,
                'nom' => 'aigle',
                'genre' => 'Masculin',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
