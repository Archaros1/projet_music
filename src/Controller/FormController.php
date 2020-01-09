<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

use App\Entity\Organisateur;
use App\Repository\OrganisateurRepository;
use App\Form\OrganisateurFormType;

use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use App\Form\GroupeFormType;

use App\Entity\Account;
use App\Repository\AccountRepository;
use App\Form\AccountFormType;

use App\Entity\Contact;
use App\Form\ContactFormType;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use App\Form\AnnonceFormType;

use App\Entity\Offre;
use App\Repository\OffreRepository;
use App\Form\OffreFormType;


class FormController extends AbstractController
{
    // private $orgaRepo;
    private $user;
    private $security;
    private $groupeRepo;
    private $accountRepo;
    private $annonceRepo;

    public function __construct(AnnonceRepository $annonceRepository, OffreRepository $offreRepository, GroupeRepository $groupeRepository, AccountRepository $accountRepository, Security $security){
        $this->groupeRepo = $groupeRepository;
        $this->accountRepo = $accountRepository;
        $this->offreRepo = $offreRepository;
        $this->annonceRepo = $annonceRepository;
        $this->security = $security;
        $this->user = $security->getUser();
        // echo '<pre>' . var_export($this->user, true) . '</pre>';

    }

    public function createAccount(Request $request){
        $account = new Account();
        $typeUser = $_GET['typeUser'];

        $formAccount = $this->createForm(AccountFormType::class, $account);
        $formAccount->handleRequest($request);

        if ($formAccount->isSubmitted()) {
            $account = $formAccount->getData();

            if ($typeUser == 'orga') {
                $account->setRoles = ['ROLE_USER', 'ROLE_ORGA'];
            } elseif ($typeUser == 'groupe') {
                $account->setRoles = ['ROLE_USER', 'ROLE_GROUPE'];
            } else {
                return $this->redirectToRoute("home");
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($account);
            $entityManager->flush();

            $_SESSION['idAccount'] = $account->getId();
            $_SESSION['emailAccount'] = $account->getEmail();

            if ($typeUser == 'orga') {
                return $this->redirectToRoute("form_orga");
            } elseif ($typeUser == 'groupe') {
                return $this->redirectToRoute("form_groupe");
            } else {
                return $this->redirectToRoute("home");
            }
        }
        return $this->render("forms/form_account.html.twig", [
            "accountForm" => $formAccount->createView()]);
    }

    public function createOrga(Request $request){
        $orga = new Organisateur();
        $account = new Account();

        $account = $this->accountRepo->findOneByIdAndEmail($_SESSION['idAccount'], $_SESSION['emailAccount']);

        $form = $this->createForm(OrganisateurFormType::class, $orga);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $orga = $form->getData();

            $orga->setAccount($account);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orga);
            $entityManager->flush();
            return $this->redirectToRoute("login");

        }

        return $this->render("forms/form_orga.html.twig", [
            "orgaForm" => $form->createView(),
        ]);
    }

    

    public function createGroupe(Request $request){
        $groupe = new Groupe();
        $account = new Account();
        $formGroupe = $this->createForm(GroupeFormType::class, $groupe);

        $formGroupe->handleRequest($request);
        
        if ($formGroupe->isSubmitted() && $formAccount->isSubmitted()) {
            $groupe = $formGroupe->getData();
            $account = $formAccount->getData();

            $account->setRoles = ['ROLE_USER', 'ROLE_GROUPE'];

            $groupe->setAccount($account);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();
            return $this->redirectToRoute("login");
        }

        return $this->render("forms/form_groupe.html.twig", [
            "groupeForm" => $formGroupe->createView(),
            "accountForm" => $formAccount->createView()
        ]);


    }

    public function createAnnonce(Request $request){
        $annonce = new Annonce();
        $formAnnonce = $this->createForm(AnnonceFormType::class, $annonce);

        $formAnnonce->handleRequest($request);

        if ($formAnnonce->isSubmitted()) {
            $annonce = $formAnnonce->getData();

            $userOrga = $this->user->getOrganisateur();
            $annonce->setOrganisateur($userOrga);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            // return $this->redirectToRoute("gestion_ann", ['id' => $annonce->getId()]);
            return $this->redirectToRoute("orga_home");

        }
        return $this->render("forms/form_annonce.html.twig", [
            "annonceForm" => $formAnnonce->createView()     
        ]);
    }


    public function updateGroupe(Request $request)
    {
        $idAccount = $this->user->getId();
        $account = $this->accountRepo->find($idAccount);
        $groupe = $this->groupeRepo->find($account->getGroupe());

        $formGroupe = $this->createForm(GroupeFormType::class, $groupe);
        $formGroupe->handleRequest($request);
        if ($formGroupe->isSubmitted()) {
            $groupe = $formGroupe->getData();

            $groupe->setAccount($account);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();

            return $this->redirectToRoute("user_home");
        }
        
        return $this->render("forms/update_groupe.html.twig", [
            "groupeForm" => $formGroupe->createView()
        ]);

    }

    public function createOffre($idGroupe, Request $request)
    {
        $offre = new Offre();
        $formOffre = $this->createForm(OffreFormType::class, $offre);

        $formOffre->handleRequest($request);

        if ($formOffre->isSubmitted()) {
            $offre = $formOffre->getData();

            $annonce = $this->annonceRepo->findAnnonceByIdAndOrga($_SESSION['annonceCourante'], $this->user->getOrganisateur()->getId());
            $groupe = $this->groupeRepo->findOneById($idGroupe);

            $offre->setCaller('organisateur')
            ->setValidated(false)
            ->setAnnonce($annonce)
            ->setGroupe($groupe)
            ;

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            // return $this->redirectToRoute("gestion_ann", ['id' => $annonce->getId()]);
            return $this->redirectToRoute("search_groupe");
            // search_groupe
            // return $this->redirectToRoute("orga_home");

        }
        return $this->render('forms/form_offre.html.twig', [
            "offreForm" => $formOffre->createView()
        ]);
    }
}