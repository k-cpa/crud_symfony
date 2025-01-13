<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_signin')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $passwordHasher->hashPassword($user,$userForm->get('password')->getData())
            );

            $entityManager->persist($user);

            $entityManager->flush();

            $this->addFlash('success', 'Votre profil est enregistré sur la plateforme');
            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('security/signin.html.twig', [
            'userForm' => $userForm->createView(),
        ]);
    }
}
