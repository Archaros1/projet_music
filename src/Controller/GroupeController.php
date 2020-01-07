<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


use App\Entity\Groupe;
use App\Repository\GroupeRepository;


class GroupeController extends AbstractController
{
    

    

    public function index()
    {
        return $this->render('groupe/groupe_home.html.twig');
    }
    
}
