<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(1)->create();
//         \App\Models\Admin\Blog::factory(50)->create();
         $this->call([
             BlogSeeder::class,
        ]);
    }
}
