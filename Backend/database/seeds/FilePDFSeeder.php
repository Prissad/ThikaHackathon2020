<?php

use Illuminate\Database\Seeder;

class FilePDFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\FilePDF::class, 100)->create();

    }
}
