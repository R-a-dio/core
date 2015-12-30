<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // make a bunch of DJ users
        factory(App\User::class, 3)->create()
            ->each(function ($user) {
                $dj = factory(App\DJ::class)->create();
                $user->update(['dj_id' => $dj->id]);
            });

        // make a bunch of regular users
        factory(App\User::class, 7)->create();
    }
}
