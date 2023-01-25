<?php

namespace App\DataFixtures;

use App\Entity\Allergy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AllergyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $allergy = new Allergy();
        $allergy->setName('Arachides');
        $manager->persist($allergy);

        $allergy = new Allergy();
        $allergy->setName('Fruit de mer');
        $manager->persist($allergy);

        $allergy = new Allergy();
        $allergy->setName('Gluten');
        $manager->persist($allergy);

        $allergy = new Allergy();
        $allergy->setName('Produits laitier');
        $manager->persist($allergy);

        $manager->flush();
    }
}
