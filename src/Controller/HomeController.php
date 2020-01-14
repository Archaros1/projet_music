<?php


namespace App\Controller;

use Symfony\Component\Security\Core\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Groupe;
use App\Entity\Event;
use App\Entity\Style;
use App\Entity\Lieu;
use App\Entity\Organisateur;
use App\Entity\Annonce;
use App\Repository\GroupeRepository;
use App\Repository\EventRepository;
use App\Repository\StyleRepository;
use App\Repository\LieuRepository;
use App\Repository\OrganisateurRepository;
use App\Repository\AnnonceRepository;

use App\Form\RechercheAnnonceType;

use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator


class HomeController extends AbstractController
{
    private $groupeRepo;
    private $user;
    private $security;
    private $eventRepo;
    private $styleRepo;
    private $lieuRepo;
    private $organisateurRepo;
    private $annonceRepo;

    public function __construct(GroupeRepository $groupeRepository, Security $security, EventRepository $eventRepository, StyleRepository $styleRepository, LieuRepository $lieuRepository, OrganisateurRepository $organisateurRepository, AnnonceRepository $annonceRepository){
        
    $this->groupeRepo = $groupeRepository;
    $this->security = $security;
    $this->user = $security->getUser();
    $this->eventRepo = $eventRepository;
    $this->styleRepo = $styleRepository;
    $this->lieuRepo = $lieuRepository;
    $this->organisateurRepo = $organisateurRepository;
    $this->annonceRepo = $annonceRepository;
    }

    public function home()
    {
        return $this->render('pages/home.html.twig');
    }

    public function annonce()
    {
        return $this->render('form/form_annonce.html.twig');
    }

    public function eventVitrine($idEvent)
    {
        $event = $this->eventRepo->findOneById($idEvent);
        return $this->render('pages/vitrine_event.html.twig', ['event' => $event]);
    }

    public function groupeVitrine($id)
    {
        $groupe = $this->groupeRepo->findOneBy(['id' => $id]);
        return $this->render('groupe/vitrine_groupe.html.twig', [
            'groupe' => $groupe
        ]);
    }

    public function agenda(Request $request, PaginatorInterface $paginator)
    {
        $donnees = $this->eventRepo->findAllOrderByDate();

        $events = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            2 // Nombre de résultats par page
        );

        return $this->render('pages/agenda.html.twig', ["events" => $events]);
    }


    public function vitrineGroupe($id){
        $groupe = $this->groupeRepo->find($id);
        return $this->render("groupe/vitrine_groupe.html.twig", ["groupe" => $groupe]);
    }


    public function index()
    {
        $roles = $this->user->getRoles();
        if (in_array('ROLE_GROUPE', $roles)) {
            return $this->redirectToRoute("groupe_home");
        } elseif (in_array('ROLE_ORGA', $roles)) {
            return $this->redirectToRoute("orga_home");
        } elseif (in_array('ROLE_ADMIN', $roles)) {
            return $this->redirectToRoute("admin_home");
        } else {
            return $this->redirectToRoute("login");
        }
    }

    public function searchAnnonce(Request $request, Security $security){
        $from = $request->query->get("from");
        if ($from == 0) {
            $from++;
        }

        $annonces = $this->annonceRepo->findAll();
        $annonces = $this->annonceRepo->findPaginatedAnnonces($from);

        $infoTriAnnonce = new Annonce();

        $form = $this->createForm(RechercheAnnonceType::class, $infoTriAnnonce);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $annoncesTries = [];
            $infoTriAnnonce = $form->getData();

            foreach ($annonces as $annonce) {
                $isOk = true;
                $styles = $annonce->getStyleRecherche()->getValues();


                foreach ($infoTriAnnonce->getStyleRecherche() as $styleTrieur) {
                    if (! in_array($styleTrieur, $styles)) {
                        $isOk = false;
                    }
                }
                if ($isOk == true) {
                    array_push($annoncesTries, $annonce);
                }
                $isOk = true;
            }
            $annonces = $annoncesTries;
        }

        return $this->render("groupe/search_annonce.html.twig", [
            "annonces" => $annonces, 
            "infoTriAnnonces" => $infoTriAnnonce,
            "from" => $from,
            "annonceForm" => $form->createView()]);
    }
    
}