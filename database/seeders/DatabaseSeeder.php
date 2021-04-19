<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('establishments')->insert([
            'id' => Uuid::uuid6(),
            'name' => "IBAIA Café",
            'slug' => "ibaia-cafe",
            'description' => 'blabla',
            'long' => '89',
            'lat' => '67',
            'address' => '78 rue des ',
            'city' => 'Bordeaux',
            'zipcode' => 33000,
            'rating' => 5,
            'reviewsCount' => 123,
            'isActive' => true
        ]);

        DB::table('thumbnails')->insert([
            'id' => Uuid::uuid6(),
            'path' => "IBAIA Café",
            'order' => 1,
            'thumbnaible_id' => '34',
            'thumbnaible_type' => "App\Domain\Establishment\Entity\Establishment",
        ]);
    }
}
