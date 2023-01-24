<?php

namespace App\DataFixtures;

use Faker;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Allergy;
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
        $allergy = new Allergy();
        // $product = new Product();
        
        for ($i=0; $i < 50; $i++) { 
            $user = new User();
            $user->setRoles(['ROLE_USER']);
            $user->setEmail($faker->email());
            $user->setName($faker->name());
            $user->setPhoneNumber($faker->phoneNumber());
            $user->addAllergy($allergy);
            
            $hashPassword = $this->hasher->hashPassword(
                $user,
                'password'
            );
            
            $user->setPassword($hashPassword);
            
            $manager->persist($user);
            
        }

        $manager->flush();
    }
}
