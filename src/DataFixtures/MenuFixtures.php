<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
      
        
        for ($i=0; $i < 5; $i++) { 
            $menu = new Menu();
            $menu->setTitle($faker->word(3, true));
            
            $manager->persist($menu);
            
        }

        $manager->flush();
    }
}
