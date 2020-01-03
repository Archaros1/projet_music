<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $slugger = new AsciiSlugger();

        $adminAccount = new Account();
        $adminAccount->setEmail("admin")
        ->setPassword($this->passwordEncoder->encodePassword($adminAccount, "webforce"))
        ->setRoles(['ROLE_ADMIN']);
        $manager->persist($adminAccount);




        $manager->flush();
    }
}
