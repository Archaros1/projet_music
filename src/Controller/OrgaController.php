<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Organisateur;
use App\Repository\OrganisateurRepository;


class OrgaController extends AbstractController
{
    private $orgaRepo;

    public function index()
    {
        return $this->render('organisateur/orga_home.html.twig');
    }
    
}
