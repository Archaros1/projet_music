<?php


namespace App\Controller;

use Symfony\Component\Security\Core\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Groupe;
use App\Entity\Event;
use App\Repository\GroupeRepository;
use App\Repository\EventRepository;

use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator


class HomeController extends AbstractController
{
    private $groupeRepo;
    private $user;
    private $security;
    private $eventRepo;

    public function __construct(GroupeRepository $groupeRepository, Security $security, EventRepository $eventRepository){
        
    $this->groupeRepo = $groupeRepository;
    $this->security = $security;
    $this->user = $security->getUser();
    $this->eventRepo = $eventRepository;
    }

    public function home()
    {
        return $this->render('pages/home.html.twig');
    }

    public function annonce()
    {
        return $this->render('form/form_annonce.html.twig');
    }

    public function EventVitrine()
    {
        return $this->render('pages/vitrine_event.html.twig');
    }

    public function agenda(Request $request, PaginatorInterface $paginator)
    {
        $donnees = $this->eventRepo->findAll();

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
        /* if (in_array('ROLE_GROUPE', $roles)) {
            return $this->redirectToRoute("groupe_home");
        } else */if (in_array('ROLE_ORGA', $roles)) {
            return $this->redirectToRoute("orga_home");
        } elseif (in_array('ROLE_ADMIN', $roles)) {
            return $this->redirectToRoute("admin_home");
        } else {
            return $this->redirectToRoute("login");
        }
    }

    

    

}
