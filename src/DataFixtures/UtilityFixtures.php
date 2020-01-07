<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Faker\Factory;

use App\Entity\Lieu;
use App\Entity\Style;

class UtilityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $lieu = new Lieu();

        //LIEUX
        $lieu->setName('Place Gutenberg')
            ->setVille('Strasbourg')
            ->setDepartement('Bas-Rhin');
        $manager->persist($lieu);

        $lieu->setName('Palais Rohan')
            ->setVille('Strasbourg')
            ->setDepartement('Bas-Rhin');
        $manager->persist($lieu);

        $lieu->setName('Place Kleber')
            ->setVille('Strasbourg')
            ->setDepartement('Bas-Rhin');
        $manager->persist($lieu);

        $lieu->setName("Place de l'Ancienne-Douane")
            ->setVille('Colmar')
            ->setDepartement('Haut-Rhin');
        $manager->persist($lieu);

        //


        $manager->flush();
    }
}
