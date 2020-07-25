<?php

use Illuminate\Database\Seeder;

class SubjectLevel1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(\App\SubjectLevel1::class,50)->create();
        factory(\App\SubjectLevel1::class, 10)->create()
        ->each(function ($subject_level1)
        {
            $subject_level1->subjectLevel1s()->saveMany(factory(App\SubjectLevel1::class, 2)->make());

            $videos = \App\Video::inRandomOrder()->limit(rand(1,4))->get();
            foreach ($videos as $video)
            {
                $subject_level1->videos()->attach($video->id);
            }

            $pdfs = \App\FilePDF::inRandomOrder()->limit (rand(5,10))->get();
            foreach ($pdfs as $pdf)
            {
                $subject_level1->filePDFs()->attach($pdf->id);
            }
        });
    }
}
