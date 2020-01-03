<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Groupe;
use App\Repository\GroupeRepository;


class GroupeController extends AbstractController
{
    private $groupeRepo;

    public function index()
    {
        return $this->render('groupe/groupe_home.html.twig');
    }
    
}
