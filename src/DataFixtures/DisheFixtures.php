<?php

namespace App\DataFixtures;

use App\Entity\Dishe;
use App\Entity\Allergy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;
use Doctrine\Persistence\ObjectManager;

class DisheFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
      
        
        for ($i=0; $i < 50; $i++) { 
            $dishe = new Dishe();
            $dishe->setTitle($faker->sentence(3));
            $dishe->setDescription($faker->sentence());
            $dishe->setPrice($faker->randomFloat(1, 20, 30));

           
            
            $manager->persist($dishe);
            
        }

        $manager->flush();
    }
}
