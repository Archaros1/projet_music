<?php


namespace App\Controller;

use Symfony\Component\Security\Core\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class HomeController extends AbstractController
{
    private $user;
    private $security;

    public function __construct(Security $security){
        $this->security = $security;
        $this->user = $security->getUser();
        // echo '<pre>' . var_export($this->user, true) . '</pre>';

    }

    public function home()
    {
        return $this->render('pages/home.html.twig');
    }

    public function annonce()
    {
        return $this->render('form/form_annonce.html.twig');
    }

    public function eventVitrine()
    {
        return $this->render('pages/vitrine_event.html.twig');
    }

    public function groupeVitrine()
    {
        return $this->render('pages/vitrine_groupe.html.twig');
    }

    public function agenda()
    {
        return $this->render('pages/agenda.html.twig');
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
