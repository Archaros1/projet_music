<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Groupe;
use App\Repository\GroupeRepository;

class HomeController extends AbstractController
{
    private $groupeRepo;

    public function __construct(GroupeRepository $groupeRepository){
        $this->groupeRepo = $groupeRepository;
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


    

    

}
