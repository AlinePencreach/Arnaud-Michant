<?php

namespace App\DataFixtures;

use App\Entity\Dishe;
use App\Entity\Allergy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;
use Doctrine\Persistence\ObjectManager;

class AppDishe extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
        $allergy = new Allergy();
        
        for ($i=0; $i < 50; $i++) { 
            $dishe = new Dishe();
            $dishe->setTitle($faker->lexify('??? ????'));
            $dishe->setDescription($faker->sentence());
            $dishe->setPrice($faker->randomFloat(1, 20, 30));
            $dishe->addAllergy($allergy);

           
            
            $manager->persist($dishe);
            
        }

        $manager->flush();
    }
}
