<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{


    public function home()
    {
        return $this->render('pages/home.html.twig');
    }

    public function vitrine_groupe()
    {
        return $this->render('pages/vitrine_groupe.html.twig');
    }

    

    

}
