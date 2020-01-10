<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Event;
use App\Entity\EventType;
use App\Entity\Groupe;
use App\Entity\GroupeType;
use App\Entity\Lieu;
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
        // FAKE ACCOUNTS LAMBDA
        $groupeType = new GroupeType();
        $groupeType->setName('fake');
        $manager->persist($groupeType);

        for ($i=0; $i < 10; $i++) {
            $groupe = new Groupe();
            $account = new Account();

            $account->setEmail($this->faker->email)
            ->setRoles(['ROLE_USER', 'ROLE_GROUPE'])
            ->setPassword($this->passwordEncoder->encodePassword($account, $this->faker->text(10)));

            $groupe->setName($this->faker->name)
            ->setNombreMembre(rand(0, 5))
            ->setDescription($this->faker->realText(200, 2))
            ->setADomicile(rand(0,1) < 0.5) //bool random
            ->setAToutSonMateriel(rand(0,1) < 0.5)
            ->setType($groupeType)
            ->setAccount($account)
            ;

            $manager->persist($groupe);
            $manager->persist($account);
            // $manager->flush();
        }

        $orgaType = new OrganisateurType();
        $orgaType->setName('fake');
        $manager->persist($orgaType);

        for ($i=0; $i < 3; $i++) {
            $orga = new Organisateur();
            $account = new Account();
            
            $account->setEmail($this->faker->email)
            ->setRoles(['ROLE_USER', 'ROLE_ORGA'])
            ->setPassword($this->passwordEncoder->encodePassword($account, $this->faker->text(10)));

            $orga->setName($this->faker->name)
            ->setType($orgaType)
            ->setAccount($account)
            ;

            $manager->persist($orga);
            $manager->persist($account);

        }

        $eventType = new EventType();
        $eventType->setName('fake');

        $lieu = new Lieu();
        $lieu->setName('fakePlace')
            ->setVille('Saverne')
            ->setDepartement('Bas-Rhin')
        ;
        $manager->persist($eventType);
        $manager->persist($lieu);

        for ($i=0; $i < 3; $i++) { 
            $event = new Event();

            $event->setName($this->faker->cityPrefix.$this->faker->lastName)
            ->setDescription($this->faker->realText(200, 2))
            ->setDateBegin(new \DateTime('1'.($i+2).' September 200'.$i))
            ->setDateEnd(new \DateTime('1'.$i.' September 200'.($i+1)))
            ->setType($eventType)
            ->setLieu($lieu)
            ;

            $manager->persist($event);
            

        }

        // FAKE USER pour test
        $account = new Account();
        $account->setEmail("usertest@hotmail.fr")
            ->setPassword($this->passwordEncoder->encodePassword($account, "webforce"))
            ->setRoles(['ROLE_USER', 'ROLE_ORGA', 'ROLE_GROUPE']);

        $orga = new Organisateur();
        $orga->setName($this->faker->name)
            ->setType($orgaType)
            ->setAccount($account);

        $groupe = new Groupe();
        $groupe->setName($this->faker->name)
            ->setNombreMembre(rand(0, 5))
            ->setDescription($this->faker->realText(200, 2))
            ->setADomicile(rand(0,1) < 0.5) //bool random
            ->setAToutSonMateriel(rand(0,1) < 0.5)
            ->setType($groupeType)
            ->setAccount($account);

        // $manager->persist($orga);
        $manager->persist($account);


        // FAKE ORGA pour test
        $orga = new Organisateur();
        $accountOrga = new Account();
            
        $accountOrga->setEmail("orgatest@hotmail.fr")
        ->setRoles(['ROLE_USER', 'ROLE_ORGA'])
        ->setPassword($this->passwordEncoder->encodePassword($accountOrga, 'webforce'));

        $orga->setName($this->faker->name)
        ->setType($orgaType)
        ->setAccount($accountOrga)
        ;

        $manager->persist($orga);
        $manager->persist($accountOrga);


        // FAKE GROUPE pour test
        $account = new Account();
        $account->setEmail("groupetest@hotmail.fr")
            ->setPassword($this->passwordEncoder->encodePassword($account, "webforce"))
            ->setRoles(['ROLE_USER', 'ROLE_GROUPE']);

        $groupe = new Groupe();
        $groupe->setName($this->faker->name)
            ->setNombreMembre(rand(0, 5))
            ->setDescription($this->faker->realText(200, 2))
            ->setADomicile(rand(0,1) < 0.5) //bool random
            ->setAToutSonMateriel(rand(0,1) < 0.5)
            ->setType($groupeType)
            ->setAccount($account);

        $manager->persist($account);

        $manager->flush();
    }
}
