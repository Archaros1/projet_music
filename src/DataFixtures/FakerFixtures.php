<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Contact;
use App\Entity\Groupe;
use App\Entity\Organisateur;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FakerFixtures extends Fixture
{

    private $passwordEncoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = new Factory();
        $this->faker = $this->faker->create();
    }

    public function load(ObjectManager $manager)
    {
        

        $manager->flush();
    }
}
