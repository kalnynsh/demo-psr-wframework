<?php

namespace Fixtures;

use Faker;
use App\Entity\Post\Meta;
use App\Entity\Post\Post;
use App\Entity\Post\Content;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class BlogFixture implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('en_US');

        for ($idx = 0; $idx < 50; $idx++) {
            $createdAt = $faker->date('Y-m-d H:i:s');
            $updatedAt = \date_modify(
                new \DateTime($createdAt),
                '+' . random_int(0, 28) . ' day'
            );

            $post = new Post(
                \DateTimeImmutable::createFromMutable(new \DateTime($createdAt)),
                \rtrim(\substr($faker->sentence, 0, 64), '.'),
                new Content(
                    $faker->text(300),
                    $faker->paragraph(5, true)
                ),
                new Meta(
                    \rtrim(\substr($faker->sentence, 0, 128), '.'),
                    $faker->text(200)
                )
            );

            $post->setUpdateDate(
                \DateTimeImmutable::createFromMutable($updatedAt)
            );

            $count = random_int(0, 10);

            for ($j = 0; $j < $count; $j++) {
                $post->addComment(
                    \DateTimeImmutable::createFromMutable($faker->dateTime),
                    $faker->name,
                    $faker->text(200)
                );
            }

            $manager->persist($post);
        }

        $manager->flush();
    }
}
