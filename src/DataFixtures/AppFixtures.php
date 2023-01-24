<?php

namespace App\DataFixtures;

use Faker;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        //$product = new Product();
        //$manager->persist($product);

        $manager->flush();
    }
}
