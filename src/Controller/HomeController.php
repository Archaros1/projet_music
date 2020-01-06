<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{


    public function home()
    {
        return $this->render('pages/home.html.twig');
    }

    public function agenda()
    {
        return $this->render('pages/agenda.html.twig');
    }

    

    

}
