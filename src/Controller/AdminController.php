<?php


namespace App\Controller;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\AsciiSlugger;


class AdminController extends AbstractController
{

    private $corganisateurRepository;
    private $annonceRepository;
    private $groupeRepository;
    private $musicienRepository;
    private $eventRepository;
        

    public function admin_home(){
        $organisateur = $this->organisateurRepository->findAllOrganisateur();
        return $this->render('admin/home.html.twig', ["organisateur"=> $organisateur]);

        $annonce = $this->annonceRepository->findAllAnnonce();
        return $this->render('admin/home.html.twig', ["annonce"=> $annonce]);

        $groupe = $this->groupeRepository->findAllGroupe();
        return $this->render('admin/home.html.twig', ["groupe"=> $groupe]);

        $musicien = $this->musicienRepository->findAllMusicien();
        return $this->render('admin/home.html.twig', ["musicien"=> $musicien]);

        $event = $this->eventRepository->findAllEvent();
        return $this->render('admin/home.html.twig', ["event"=> $event]);
    }
}