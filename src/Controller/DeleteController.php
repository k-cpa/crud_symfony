<?php

namespace App\Controller;

use App\Entity\Pizza;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteController extends AbstractController
{
    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(Pizza $pizza, Request $request, EntityManagerInterface $entityManager): Response
    {

        // On verifie si le token csrf provient bien du formulaire de suppression correspondant a l'ID
        if ($this->isCsrfTokenValid('SUP'. $pizza->getId(), $request->get('_token'))) {
            $entityManager->remove($pizza); // On marque l'article pour la suppression
            $entityManager->flush(); // On effectue la requête en database
            $this->addFlash('succes', 'La pizza est bien supprimée');
            return $this->redirectToRoute('app_home');
        }
        $this->addFlash('error', 'Token invalide');
        return $this->redirectToRoute('app_home');
    }
}
