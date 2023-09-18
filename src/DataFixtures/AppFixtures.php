<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Origami;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
       
        for ($o = 0; $o < 10; $o++) {
            $origami = new Origami; 
            $origami->setName($faker->word());
            $origami->setPicture("https://picsum.photos/id/".mt_rand(50,120)."/768/1024");
            $origami->setCreatedAt(new \DateTimeImmutable($faker->date()));
            $origami->setUpdatedAt(new \DateTimeImmutable($faker->date()));
            $origami->setDescription($faker->text(100));

            $manager->persist($origami);
        }

        $manager->flush();
    }
}
