<?php

namespace App\Controller;

use App\Form\PizzaType;
use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddPizzaController extends AbstractController
{
    // Pour les prochains projets voir la correction LUDO pour faire un ADDUPDATE en une seule function !! 
    #[Route('/add/pizza', name: 'app_add_pizza')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $pizza = new Pizza(); // Création du nouvel objet Pizza

        $pizzaForm = $this->createForm(PizzaType::class, $pizza);

        // Indique a symfony de prendre les données et de les associer au formulaire
        $pizzaForm->handleRequest($request);

        // On vérifie si formulaire est soumis et qu'il est valide
        if ($pizzaForm->isSubmitted() && $pizzaForm->isValid()) {

            // Gestion relations Many to Many
            // foreach($pizza->getIngredient() as $Ingredient) {
            //     $Ingredient->addPizza($pizza);
            // }

            // On marque les infos de l'objet article prêt a être envoyé en database
            $entityManager->persist($pizza);

            // On envoie les données
            $entityManager->flush();

            // Message get
            $this->addFlash('success', 'Pizza ajoutée avec succès !');

            // Redirection
            return $this->redirectToRoute('app_home');
        }

        return $this->render('add_pizza/add.html.twig', [
            'pizza_form' => $pizzaForm->createView(),
        ]);
    }
}
