<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Account;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $slugger = new AsciiSlugger();

        $adminAccount = new Account();
        $adminAccount->setEmail("admin@webforce.com")
        ->setPassword($this->passwordEncoder->encodePassword($adminAccount, "webforce"))
        ->setRoles(['ROLE_ADMIN']);
        $manager->persist($adminAccount);




        $manager->flush();
    }
}
