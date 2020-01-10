<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;


use App\Entity\Organisateur;
use App\Repository\OrganisateurRepository;

// use App\Entity\Groupe;
use App\Repository\GroupeRepository;

use App\Entity\Account;
use App\Repository\AccountRepository;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;

use App\Entity\Offre;
use App\Repository\OffreRepository;

use App\Entity\Event;
use App\Repository\EventRepository;


class AnnonceController extends AbstractController
{
    private $orgaRepo;
    private $groupeRepo;
    private $accountRepo;
    private $annonceRepo;
    private $offreRepo;
    private $user;
    private $security;

    public function __construct(OffreRepository $offreRepository, GroupeRepository $groupeRepository, OrganisateurRepository $orgaRepository, AccountRepository $accountRepository, AnnonceRepository $annonceRepository, Security $security){
        $this->orgaRepo = $orgaRepository;
        $this->groupeRepo = $groupeRepository;
        $this->annonceRepo = $annonceRepository;
        $this->accountRepo = $accountRepository;
        $this->offreRepo = $offreRepository;
        $this->security = $security;
        $this->user = $security->getUser();
        // echo '<pre>' . var_export($this->user, true) . '</pre>';

    }

    /**
     * @Route("/annonce", name="annonce")
     */
    public function index()
    {
        $idAnnonce = $_GET['id'];
        $idOrgaUser = $this->user->getOrganisateur()->getId();

        $annonce = new Annonce();
        $annonce = $this->annonceRepo->findAnnonceByIdAndOrga($idAnnonce, $idOrgaUser);

        if (is_null($annonce)) {
            return $this->redirectToRoute("user_home");
        } else {
            $_SESSION['annonceCourante'] = $idAnnonce;
            $offres = $annonce->getOffres();
            return $this->render('annonce/annonce_gestion.html.twig', [
                'annonce' => $annonce, 
                'offres' => $offres
            ]);
        }
        
    }

    
    public function chercheGroupe()
    {
        $idAnnonce = $_SESSION['annonceCourante'];
        $idOrgaUser = $this->user->getOrganisateur()->getId();

        $annonce = new Annonce();
        $annonce = $this->annonceRepo->findAnnonceByIdAndOrga($idAnnonce, $idOrgaUser);

        if (is_null($annonce)) {
            return $this->redirectToRoute("user_home");
        } else {
            $orga = $this->user->getOrganisateur();
            $departement = $annonce->getLieu()->getDepartement();

            $groupes = $this->groupeRepo->findAll();

            $blacklist = $orga->getBlacklist();
            $groupesNotBlacklisted = [];
            $ban = false;
            
            foreach ($groupes as $groupe) {
                foreach ($blacklist as $blacklisted) {
                    if ($groupe == $blacklisted) {
                        $ban = true;
                    }
                }
                if ($ban == false) {
                    array_push($groupesNotBlacklisted, $groupe);
                }
                $ban = false;
                
            }
        }

        return $this->render('annonce/search_groupe.html.twig', [
            'groupes' => $groupesNotBlacklisted
        ]);
    }


    public function deleteOffre($idOffre)
    {
        $offre = $this->offreRepo->findOneById($idOffre);
        if ($offre->getAnnonce()->getOrganisateur()->getAccount()->getId() == $this->user->getId() ||
            $offre->getGroupe()->getAccount()->getId() == $this->user->getId())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offre);
            $entityManager->flush();
        }
        return $this->redirectToRoute("user_home");
    }


    public function validateOffre($idOffre)
    {
        $offre = $this->offreRepo->findOneById($idOffre);
        if ($offre->getAnnonce()->getOrganisateur()->getAccount()->getId() == $this->user->getId() ||
            $offre->getGroupe()->getAccount()->getId() == $this->user->getId())
        {
            $offre->setValidated(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();
        }
        return $this->redirectToRoute("user_home");
    }
    

    public function deleteAnnonce($idAnnonce)
    {
        $annonce = $this->annonceRepo->findOneById($idAnnonce);
        if ($annonce->getOrganisateur()->getAccount()->getId() == $this->user->getId())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }
        return $this->redirectToRoute("user_home");
    }


    public function createEvent($idAnnonce)
    {
        $annonce = $this->annonceRepo->findOneById($idAnnonce);


        $event = new Event();
        $offres = $annonce->getOffres();
        $groupesValidated = [];

        foreach ($offres as $offre) {
            if ($offre->getValidated()) {
                array_push($groupesValidated, $offre->getGroupe());
            }
        }

        foreach ($annonce->getStyleRecherche() as $style) {
            $event->addStyle($style);
        }


        $event->setName($annonce->getNomEvent())
        ->setDescription($annonce->getDescription())
        ->setDateBegin($annonce->getDateBegin())
        ->setDateEnd($annonce->getDateEnd())
        ->setGroupes($groupesValidated)
        ->setType($annonce->getTypeEvent())
        ->setLieu($annonce->getLieu())
        ->setOrganisateur($annonce->getOrganisateur())
        // ->setStyle($annonce->getStyleRecherche())
        ;

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($event);
        $entityManager->flush();

        foreach ($annonce->getOffres() as $offre) {
            $entityManager->remove($offre);
        }

        $entityManager->remove($annonce);
        $entityManager->flush();

        return $this->redirectToRoute("vitrine_event", ['idEvent' => $event->getId()]);
    }
}
