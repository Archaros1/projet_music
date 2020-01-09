<?php


namespace App\Controller;
use App\Entity\Style;
use App\Entity\Offre;
use App\Entity\Organisateur;
use App\Entity\Annonce;
use App\Form\Groupe;
use App\Form\Event;
use App\Form\OrganisateurFormType;
use App\Form\GroupeFormType;
use App\Repository\OrganisateurRepository;
use App\Repository\StyleRepository;
use App\Repository\OffreRepository;
use App\Repository\AnnonceRepository;
use App\Repository\GroupeRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Knp\Component\Pager\PaginatorInterface;



class AdminController extends AbstractController
{

    private $organisateurRepo;
    private $annonceRepo;
    private $groupeRepo;
    private $eventRepo;
    private $offreRepo;
    private $styleRepo;

    public function __construct(OrganisateurRepository $organisateurRepository, AnnonceRepository $annonceRepository, GroupeRepository $groupeRepository, EventRepository $eventRepository, OffreRepository $offreRepository, StyleRepository $styleRepository)
    {
        $this->organisateurRepo = $organisateurRepository;
        $this->annonceRepo = $annonceRepository;
        $this->groupeRepo = $groupeRepository;
        $this->eventRepo = $eventRepository;
        $this->offreRepo = $offreRepository;
        $this->styleRepo = $styleRepository;
    }
    
    
    public function admin_Home(Request $request){
        $organisateur = $this->organisateurRepo->findAll();
        $annonce = $this->annonceRepo->findAll();
        $groupe = $this->groupeRepo->findAll();
        $event = $this->eventRepo->findAll();
        $offre = $this->offreRepo->findAll();
        $style = $this->styleRepo->findAll();
         return $this->render("admin/pages/admin_home.html.twig", [
            "organisateurs" => $organisateur, 
            "annonces" => $annonce, 
            "groupes" => $groupe,  
            "events" => $event,
            "offres" => $offre,
            "styles" =>$style
            ]);
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
            return $this->redirectToRoute("admin_home");
        }
        return $this->render('admin/pages/update_orga.html.twig', [
            "organisateurForm" => $form->createView()]);
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
            return $this->redirectToRoute("admin_home");
        }
        return $this->render('admin/pages/update_groupe.html.twig', ["groupeForm" => $form->createView()]);
    }

    public function updateOffre(Request $request, Security $security, $id){
        $offre = $this->offreRepo->find($id);
        $form = $this->createForm(OffreFormType::class, $offre);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $offre = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();
            return $this->redirectToRoute("admin_home");
        }
        return $this->render('admin/pages/update_offre.html.twig', ["offreForm" => $form->createView()]);
    }

    public function updateAnnonce(Request $request, Security $security, $id){
        $annonce = $this->annonceRepo->find($id);
        $form = $this->createForm(AnnonceFormType::class, $annonce);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $annonce = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();
            return $this->redirectToRoute("admin_home");
        }
        return $this->render('admin/pages/update_annonce.html.twig', ["annonceForm" => $form->createView()]);
    }


    public function updateEvent(Request $request, Security $security, $id){
        $event = $this->eventRepo->find($id);
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $event = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute("admin_home");
        }
        return $this->render('admin/pages/update_event.html.twig', ["eventForm" => $form->createView()]);
    }

    
    public function admin_agenda(Request $request){
        $event = $this->eventRepo->findAll();
        return $this->render("admin/pages/agenda.html.twig", ["events" => $event]);
    }
}