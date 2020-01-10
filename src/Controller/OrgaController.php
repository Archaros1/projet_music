<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

use App\Entity\Organisateur;
use App\Repository\OrganisateurRepository;

use App\Entity\Account;
use App\Repository\AccountRepository;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;

use App\Entity\Event;
use App\Repository\EventRepository;


class OrgaController extends AbstractController
{
    private $orgaRepo;
    private $accountRepo;
    private $annonceRepo;
    private $user;
    private $security;

    public function __construct(OrganisateurRepository $orgaRepository, AccountRepository $accountRepository, AnnonceRepository $annonceRepository, Security $security, EventRepository $eventRepository){
        $this->orgaRepo = $orgaRepository;
        $this->annonceRepo = $annonceRepository;
        $this->accountRepo = $accountRepository;
        $this->eventRepo = $eventRepository;
        $this->security = $security;
        $this->user = $security->getUser();
        // echo '<pre>' . var_export($this->user, true) . '</pre>';

    }

    public function index()
    {
        $account = new Account();
        $orga = new Organisateur();

        $id = $this->user->getId();
        // echo $id;
        $account = $this->accountRepo->findOneById($id);
        $orga = $account->getOrganisateur();
        // echo '<pre>' . var_export($account, true) . '</pre>';

        $annonces = $this->annonceRepo->findByOrganisateur($orga->getId());
        $events = $this->eventRepo->findByOrganisateur($orga->getId());


        return $this->render('organisateur/orga_home.html.twig', ["orga"=>$orga, "annonces"=>$annonces, "events"=>$events]);
    }
    
}
