<?php

namespace App\Controller;

use App\Form\PizzaType;
use App\Repository\PizzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PizzaRepository $repository): Response
    {
        $pizzas = $repository->findAll();
        // On stocke le resultat de la requete 'findAll dans $article
        return $this->render('home/index.html.twig', [
            'pizzas' => $pizzas,
            // On envoie résultat dans VUE 
        ]);
    }
}
