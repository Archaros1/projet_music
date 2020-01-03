<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Organisateur;
use App\Repository\OrganisateurRepository;
use App\Form\OrganisateurFormType;


class FormController extends AbstractController
{
    // private $orgaRepo;

    public function createOrga(Request $request){
        $orga = new Organisateur();
        $form = $this->createForm(OrganisateurFormType::class, $orga);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $orga = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orga);
            $entityManager->flush();
            return $this->redirectToRoute("login");

        }

        return $this->render("forms/form_orga.html.twig", [
            "orgaForm" => $form->createView()
        ]);


    }
}