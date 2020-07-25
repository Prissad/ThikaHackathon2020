<?php

use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Video::class, 60)->create()
            ->each(function ($video) {
                $pdfs = \App\FilePDF::inRandomOrder()->limit (rand(1,4))->get();
                foreach ($pdfs as $pdf)
                {
                    $video->filePDFs()->attach($pdf->id);
                }
            });
    }
}
