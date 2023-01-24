<?php

namespace App\DataFixtures;

use Faker;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppUser extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Faker\Factory::create('fr_FR');
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);

        for ($i=0; $i < 50; $i++) { 
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPhoneNumber($faker->phoneNumber);
            $user->setPassword($faker->phoneNumber);

            $hashPassword = $this->hasher->hashPassword(
                $user,
                'password'
            );

            $user->setPassword($hashPassword);


        }

        $manager->flush();
    }
}
