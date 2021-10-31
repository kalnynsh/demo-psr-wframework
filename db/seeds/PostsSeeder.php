<?php

use Phinx\Seed\AbstractSeed;
use Faker;

class PostsSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $this
            ->table('posts')
            ->truncate();

        $faker = Faker\Factory::create('en_US');
        $data = [];

        for ($idx = 0; $idx < 50; $idx++) {
            $data[] = [
                'date' =>  $dateTime = $faker->date('Y-m-d H:i:s'),
                'created_at' => $dateTime,
                'updated_at' => \date_modify(
                    new \DateTime($dateTime),
                    '+' . \rand(1, 30) . ' day'
                )->format('Y-m-d H:i:s'),
                'title' => \rtrim(\substr($faker->sentence, 0, 64), '.'),
                'content' => $faker->text(200),
            ];
        }

        $posts = $this->table('posts');

        $posts
            ->insert($data)
            ->saveData()
        ;
    }
}
