<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Organisateur;
use App\Repository\OrganisateurRepository;
use App\Form\OrganisateurFormType;

use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use App\Form\GroupeFormType;

use App\Entity\Account;
use App\Form\AccountFormType;

use App\Entity\Contact;
use App\Form\ContactFormType;


class FormController extends AbstractController
{
    // private $orgaRepo;

    public function createOrga(Request $request){
        $orga = new Organisateur();
        $account = new Account();
        $contact = new Contact();

        $form = $this->createForm(OrganisateurFormType::class, $orga);
        $formAccount = $this->createForm(AccountFormType::class, $account);
        $formContact = $this->createForm(ContactFormType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $formAccount->isSubmitted() && $formContact->isSubmitted()) {
            $orga = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orga);
            $entityManager->flush();
            return $this->redirectToRoute("login");

        }

        return $this->render("forms/form_orga.html.twig", [
            "orgaForm" => $form->createView(),
            "accountForm" => $formAccount->createView(),
            "contactForm" => $formContact->createView()
        ]);


    }

    public function createGroupe(Request $request){
        $groupe = new Groupe();
        $account = new Account();
        $contact = new Contact();
        $formGroupe = $this->createForm(GroupeFormType::class, $groupe);
        $formAccount = $this->createForm(AccountFormType::class, $account);
        $formContact = $this->createForm(ContactFormType::class, $contact);

        $formGroupe->handleRequest($request);
        $formAccount->handleRequest($request);
        $formContact->handleRequest($request);
        
        if ($formGroupe->isSubmitted() && $formAccount->isSubmitted() && $formContact->isSubmitted()) {
            $groupe = $formGroupe->getData();
            $account = $formAccount->getData();
            $contact = $formContact->getData();

            $groupe->setAccount($account);
            $groupe->setContact($contact);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();
            return $this->redirectToRoute("login");

        }

        return $this->render("forms/form_groupe.html.twig", [
            "groupeForm" => $formGroupe->createView(),
            "accountForm" => $formAccount->createView(),
            "contactForm" => $formContact->createView()
        ]);


    }
}