<?php

namespace App\DataFixtures;

use App\Entity\Allergy;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppAllergy extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        
        for ($i=0; $i < 10; $i++) { 
            $allergy = new Allergy();
            $allergy->setName($faker->lexify('????????'));
    
            $manager->persist($allergy);
        }


        
        $manager->flush();
    }
}
