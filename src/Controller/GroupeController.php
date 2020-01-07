<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use App\Entity\Account;
use App\Repository\AccountRepository;


class GroupeController extends AbstractController
{
    private $groupeRepo;
    private $user;
    private $security;

    public function __construct(GroupeRepository $groupeRepository, AccountRepository $accountRepository, Security $security){
        $this->groupeRepo = $groupeRepository;
        $this->accountRepo = $accountRepository;
        $this->security = $security;
        $this->user = $security->getUser();
        // echo '<pre>' . var_export($this->user, true) . '</pre>';

    }

    public function index()
    {
        $account = new Account();
        $groupe = new Groupe();

        $id = $this->user->getId();
        // echo $id;
        $account = $this->accountRepo->findOneById($id);
        $groupe = $account->getGroupe();
        // echo '<pre>' . var_export($account, true) . '</pre>';



        return $this->render('groupe/groupe_home.html.twig', ["groupe"=>$groupe]);
    }
    
}
