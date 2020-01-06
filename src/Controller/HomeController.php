<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{


    public function home()
    {
        return $this->render('pages/home.html.twig');
    }

    public function VitrineEvent()
    {
        return $this->render('pages/vitrine_event.html.twig');
    }
    
    public function FormAnnonces()
    {
        return $this->render('pages/FormAnnonces.html.twig');
    }
    
    
    

    

}
