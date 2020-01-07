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
        $lieux = [
            [
                'name' => 'Place Gutenberg',
                'ville' => 'Strasbourg',
                'departement' => 'Bas-Rhin'
            ],
            [
                'name' => 'Place Kleber',
                'ville' => 'Strasbourg',
                'departement' => 'Bas-Rhin'
            ],
            [
                'name' => 'Chateau des Rohans',
                'ville' => 'Saverne',
                'departement' => 'Bas-Rhin'
            ],
            [
                'name' => "Place de l'Ancienne-Douane",
                'ville' => 'Colmar',
                'departement' => 'Haut-Rhin'
            ]
        ];

        foreach ($lieux as $lieu) {
            $lieuObjet = new Lieu();

            $lieuObjet->setName($lieu['name'])
                ->setVille($lieu['ville'])
                ->setDepartement($lieu['departement']);
            $manager->persist($lieuObjet);
        }

        $styles = ['Metal', 'Rock', 'Electro', 'Jazz'];
        foreach ($styles as $style) {
            $styleObjet = new Style();
            $styleObjet->setName($style);
            $manager->persist($styleObjet);
        }


        $manager->flush();
    }
}
