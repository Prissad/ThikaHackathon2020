<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Comment::class, 4)->create()
            ->each(function ($comment) {
                $comment->comments()->saveMany(factory(App\Comment::class, 2)->make());
            });
    }
}
