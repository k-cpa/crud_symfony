<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\PizzaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UpdateController extends AbstractController
{
    #[Route('/update/{id}', name: 'app_update')]
    public function modify(Pizza $pizza, Request $request, EntityManagerInterface $entityManager): Response
    {
        // GLOBALEMENT ON FAIT COPIER COLLER DE 'ADD' AVEC QUELQUES MODIFS LEGERES 

        // $pizza = new Pizza(); // --> INUTILE CAR EXISTE DEJA <---

        $pizzaForm = $this->createForm(PizzaType::class, $pizza);

        // Indique a symfony de prendre les données et de les associer au formulaire
        $pizzaForm->handleRequest($request);

        // On vérifie si formulaire est soumis et qu'il est valide
        if ($pizzaForm->isSubmitted() && $pizzaForm->isValid()) {

            // On marque les infos de l'objet article prêt a être envoyé en database
            $entityManager->persist($pizza);

            // On envoie les données
            $entityManager->flush();

            // Message get
            $this->addFlash('success', 'Pizza modifié avec succès !');

            // Redirection
            return $this->redirectToRoute('app_home');
        }

        return $this->render('update/update.html.twig', [
            'pizza_form' => $pizzaForm->createView(),
        ]);
    }
}
