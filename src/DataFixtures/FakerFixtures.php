<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Contact;
use App\Entity\Groupe;
use App\Entity\GroupeType;
use App\Entity\Organisateur;
use App\Entity\OrganisateurType;


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
        for ($i=0; $i < 25; $i++) {
            $groupe = new Groupe();
            $contact = new Contact();
            $account = new Account();
            $groupeType = new GroupeType();

            $contact->setPhone($this->faker->phoneNumber)
            ->setWebsite('https://www.google.com')
            ->setTwitter('@ElsasZikos')
            ->setFb(NULL)
            ;

            $account->setEmail($this->faker->email)
            ->setPassword($this->passwordEncoder->encodePassword($account, $this->faker->text(10)));

            $groupeType->setName('groupe');

            $groupe->setName($this->faker->name)
            ->setNombreMembre(rand(0, 5))
            ->setDescription($this->faker->realText(200, 2))
            ->setADomicile(rand(0,1) < 0.5) //bool random
            ->setAToutSonMateriel(rand(0,1) < 0.5)
            ->setType($groupeType)
            ->setContacts($contact)
            ->setAccount($account)
            ;

            $manager->persist($groupe);
            $manager->persist($contact);
            $manager->persist($account);
            $manager->persist($groupeType);
            // $manager->flush();
        }

        for ($i=0; $i < 6; $i++) {
            $orga = new Organisateur();
            $contact = new Contact();
            $account = new Account();
            $orgaType = new OrganisateurType();

            $contact->setPhone($this->faker->phoneNumber)
            ->setWebsite('https://www.google.com')
            ->setTwitter('@ElsasZikos')
            ->setFb(NULL)
            ;

            $account->setEmail($this->faker->email)
            ->setPassword($this->passwordEncoder->encodePassword($account, $this->faker->text(10)));

            $orgaType->setName('entreprise');

            $orga->setName($this->faker->name)
            ->setType($orgaType)
            ->setContacts($contact)
            ->setAccount($account)
            ;

            $manager->persist($orga);
            $manager->persist($contact);
            $manager->persist($account);
            $manager->persist($orgaType);

        }

        $manager->flush();
    }
}
