<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $faker = Faker\Factory::create('fr_FR');
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
        
        
        for ($i=0; $i < 50; $i++) { 
            $user = new User();
            $user->setRoles(['ROLE_USER']);
            $user->setEmail($faker->email());
            $user->setName($faker->name());
            $user->setPhoneNumber($faker->phoneNumber());
            
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
