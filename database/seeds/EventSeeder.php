<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = \App\Models\Category::all();
        factory(\App\Models\Event::class, 100)->create()->each(function ($event) use ($categories) {
            $event->categories()->attach(
                $categories->random(rand(1,3))->pluck('category_id')->toArray()
            );
        });
    }
}
