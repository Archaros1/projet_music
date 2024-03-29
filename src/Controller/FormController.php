<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
// use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

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

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class FormController extends AbstractController
{
    private $orgaRepo;
    private $user;
    private $security;
    private $groupeRepo;
    private $accountRepo;
    private $annonceRepo;
    private $passwordEncoder;
    private $slugger;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, AnnonceRepository $annonceRepository, OffreRepository $offreRepository, GroupeRepository $groupeRepository, AccountRepository $accountRepository, Security $security, OrganisateurRepository $orgaRepository, SluggerInterface $slugger){
        $this->groupeRepo = $groupeRepository;
        $this->orgaRepo = $orgaRepository;
        $this->accountRepo = $accountRepository;
        $this->offreRepo = $offreRepository;
        $this->annonceRepo = $annonceRepository;
        $this->security = $security;
        $this->slugger = $slugger;
        $this->passwordEncoder = $passwordEncoder;
        $this->user = $security->getUser();
        // echo '<pre>' . var_export($this->user, true) . '</pre>';

    }

    public function createAccount(Request $request, $typeUser){
        $account = new Account();
        // $typeUser = $_GET['typeUser'];

        $formAccount = $this->createForm(AccountFormType::class, $account);
        $formAccount->handleRequest($request);

        if ($formAccount->isSubmitted() && $formAccount->isValid()) {
            $account = $formAccount->getData();
            $account->setPassword($this->passwordEncoder->encodePassword($account, $account->getPassword()));

            if ($typeUser == 'orga') {
                $account->setRoles(['ROLE_USER', 'ROLE_ORGA']);
            } elseif ($typeUser == 'groupe') {
                $account->setRoles(['ROLE_USER', 'ROLE_GROUPE']);
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
            "accountForm" => $formAccount->createView()
            ]);
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
        $account = $this->accountRepo->findOneByIdAndEmail($_SESSION['idAccount'], $_SESSION['emailAccount']);

        $formGroupe = $this->createForm(GroupeFormType::class, $groupe);

        $formGroupe->handleRequest($request);
        
        if ($formGroupe->isSubmitted()) {
            $groupe = $formGroupe->getData();

            $account->setRoles = ['ROLE_USER', 'ROLE_GROUPE'];

            $groupe->setAccount($account);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();
            return $this->redirectToRoute("login");
        }

        return $this->render("forms/form_groupe.html.twig", [
            "groupeForm" => $formGroupe->createView()
        ]);


    }

    public function createAnnonce(Request $request){
        $annonce = new Annonce();
        $formAnnonce = $this->createForm(AnnonceFormType::class, $annonce);

        $formAnnonce->handleRequest($request);

        if ($formAnnonce->isSubmitted()) {
            $annonce = $formAnnonce->getData();

            $userOrga = $this->user->getOrganisateur();
            
            $randomToken = bin2hex(random_bytes(16));;
            $slug = $this->slugger->slug($annonce->getNomEvent())."-".$randomToken;
            $annonce->setOrganisateur($userOrga)
                    ->setSlug($slug);

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


    public function updateOrga(Request $request)
    {
        $idAccount = $this->user->getId();
        $account = $this->accountRepo->find($idAccount);
        $orga = $this->orgaRepo->find($account->getOrganisateur());

        $formOrga = $this->createForm(OrganisateurFormType::class, $orga);
        $formOrga->handleRequest($request);
        if ($formOrga->isSubmitted()) {
            $orga = $formOrga->getData();

            $orga->setAccount($account);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orga);
            $entityManager->flush();

            return $this->redirectToRoute("user_home");
        }
        
        return $this->render("forms/update_orga.html.twig", [
            "orgaForm" => $formOrga->createView()
        ]);
    }

    public function createOffre($idGroupe, Request $request)
    {
        $offre = new Offre();
        $formOffre = $this->createForm(OffreFormType::class, $offre);

        $formOffre->handleRequest($request);

        if ($formOffre->isSubmitted()) {
            $offre = $formOffre->getData();

            $annonce = $this->annonceRepo->findOneBySlug($_SESSION['annonceCourante']);
            
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
            return $this->redirectToRoute("search_groupe", ['slug' => $_SESSION['annonceCourante']]);
            // search_groupe
            // return $this->redirectToRoute("orga_home");

        }
        return $this->render('forms/form_offre.html.twig', [
            "offreForm" => $formOffre->createView()
        ]);
    }
}