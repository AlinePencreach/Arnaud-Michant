<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Formula;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FormulaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
      
        
        for ($i=0; $i < 10; $i++) { 
            $formula = new Formula();
            $formula->setTitle($faker->sentence());
            $formula->setDescription($faker->sentence(8));
            $formula->setPrice($faker->randomFloat(10, 30, 50));

           
            
            $manager->persist($formula);
            
        }

        $manager->flush();
    }
}
