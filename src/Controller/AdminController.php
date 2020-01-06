<?php


namespace App\Controller;
use App\Entity\Organisateur;
use App\Entity\Annonce;
use App\Form\Groupe;
use App\Form\Musicien;
use App\Form\Event;
use App\Form\OrganisateurFormType;
use App\Repository\OrganisateurRepository;
use App\Repository\AnnonceRepository;
use App\Repository\GroupeRepository;
use App\Repository\MusicienRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;



class AdminController extends AbstractController
{

    private $organisateurRepo;
    private $annonceRepo;
    private $groupeRepo;
    private $musicienRepo;
    private $eventRepo;

    public function __construct(OrganisateurRepository $organisateurRepository, AnnonceRepository $annonceRepository, GroupeRepository $groupeRepository, MusicienRepository $musicienRepository, EventRepository $eventRepository)
    {
        $this->organisateurRepo = $organisateurRepository;
        $this->annonceRepo = $annonceRepository;
        $this->groupeRepo = $groupeRepository;
        $this->musicienRepo = $musicienRepository;
        $this->eventRepo = $eventRepository;
    }

    public function admin_sous_form(){
        return $this->render('admin/pages/sous_form.html.twig');
    }
    
    
    public function admin_home(Request $request){
        $organisateur = $this->organisateurRepo->findAll();
        $annonce = $this->annonceRepo->findAll();
        $groupe = $this->groupeRepo->findAll();
        $musicien = $this->musicienRepo->findAll();
        $event = $this->eventRepo->findAll();
        return $this->render("admin/pages/home.html.twig", ["organisateurs" => $organisateur, "annonces" => $annonce, "groupes" => $groupe, "musiciens" => $musicien, "event" => $event]);
    }

    public function updateOrganisateur(Request $request, Security $security, $id){
        $organisateur = $this->organisateurRepo->find($id);
        $form = $this->createForm(OrganisateurFormType::class, $organisateur);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $organisateur = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organisateur);
            $entityManager->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render('admin/pages/update_orga.html.twig', ["organisateurForm" => $form->createView()]);
    }

    public function updateGroupe(Request $request, Security $security, $id){
        $groupe = $this->groupeRepo->find($id);
        $form = $this->createForm(GroupeFormType::class, $groupe);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $groupe = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render('admin/pages/update_groupe.html.twig', ["groupeForm" => $form->createView()]);
    }

    public function updateAnnonce(Request $request, Security $security, $id){

    }

    public function updateMusicien(Request $request, Security $security, $id){

    }

    public function updateEvent(Request $request, Security $security, $id){
        
    }



}