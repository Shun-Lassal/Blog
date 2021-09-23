<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create();

        for($i=1;$i<10;$i++){

            $post = new post();
            $post->setTitle($faker->sentence($nbWords = 3, $variableNbWords = true));
            $post->setAuthor($faker->name());
            $post->setContent($faker->paragraph($nbSentences = 3, $variableNbSentences = true));
            $post->setCreatedAt($faker->dateTimeBetween('-3 months'));
            
            $manager->persist($post);

        }
        $manager->flush();
    }
}
