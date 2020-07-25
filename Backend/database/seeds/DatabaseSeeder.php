<?php


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
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(ClasseSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(TeachSeeder::class);
        $this->call(FilePDFSeeder::class);
        $this->call(VideoSeeder::class);
        $this->call(SubjectLevel1Seeder::class);
        $this->call(CommentSeeder::class);
        $this->call(RatingSeeder::class);


    }
}
