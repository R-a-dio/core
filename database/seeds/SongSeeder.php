<?php

use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // make a whole truckload of songs, randomly pointing to test files
        factory(App\Song::class, 20)->create();
    }
}
