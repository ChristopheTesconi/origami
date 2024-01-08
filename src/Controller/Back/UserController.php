<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\BackUserType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    //CREATE
    #[Route('/back/newuser', name: 'app_back_new_user')]
    public function newUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, User $user): Response
    {
        $user = new User();
        $form = $this->createForm(BackUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur créé avec succès.');

            // Rediriger vers la liste des utilisateurs
            return $this->redirectToRoute('app_back_user');
    }
        return $this->render('back/user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    //READ
        #[Route('/back/users', name: 'app_back_user')]
        public function index(UserRepository $userRepository): Response
        {
            return $this->render('back/user/index.html.twig', [
                'users' => $userRepository->findAll()
            ]);
        }

    //UPDATE
        #[Route('/back/user/{id}', name: 'app_back_user_update')]
        public function update(int $id): Response
        {
            return $this->render('back/user/update.html.twig', [
                'id' => $id
            ]);
        }

    //DELETE
        #[Route('/back/user/{id}', name: 'app_back_user_delete')]
        public function delete(int $id): Response
        {
            return $this->render('back/user/delete.html.twig', [
                'id' => $id
            ]);
        }

}
