<?php

use Illuminate\Database\Seeder;

class TeachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Teach::class, 10)->create();/*->each(function ($teach) {

            $teacher = \App\Teacher::inRandomOrder()->get();
            $teach->teacher()->associate($teacher->id);

        });*/

        /*->each(function ($teach)
        {
            $subjects = \App\Subject::inRandomOrder()->limit(rand(1, 3))->get();
            $classes = \App\Classe::inRandomOrder()->limit(rand(1, 3))->get();
            $teachers = \App\Teacher::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($teachers as $teacher) {
                $teach->teachers()->attach($teacher->id);
            }
            foreach ($subjects as $subject) {
                $teach->subjects()->attach($subject->id);
            }
            foreach ($classes as $classe) {
                $teach->classes()->attach($classe->id);
            }

        });*/
    }
}
