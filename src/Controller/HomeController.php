<?php


namespace App\Controller;

use Symfony\Component\Security\Core\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Groupe;
use App\Repository\GroupeRepository;


class HomeController extends AbstractController
{
    private $groupeRepo;
    private $user;
    private $security;

    public function __construct(GroupeRepository $groupeRepository){
        $this->groupeRepo = $groupeRepository;
   
    $this->security = $security;
    $this->user = $security->getUser();


    }

    public function home()
    {
        return $this->render('pages/home.html.twig');
    }

    public function agenda()
    {
        return $this->render('pages/agenda.html.twig');
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
        } else {
            return $this->redirectToRoute("login");
        }
    }

    

    

}
