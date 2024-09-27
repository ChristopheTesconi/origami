<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\FrontUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    //SHOW
    #[Route('/front/{id}/user', name: 'app_front_user_show')]
    public function show(User $user): Response
    {
        return $this->render('front/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    //UPDATE
    #[Route('/front/user/{id}/edit', name: 'app_front_user_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository): Response
    {
    $user = $userRepository->find($id);

    if (!$user) {
        throw $this->createNotFoundException('Utilisateur non trouvé');
    }

    $form = $this->createForm(FrontUserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        
            // Vérifier l'ancien mot de passe
            $oldPassword = $form->get('oldPassword')->getData();
            if ($oldPassword && !$userPasswordHasher->isPasswordValid($user, $oldPassword)) {
                $this->addFlash('danger', 'L\'ancien mot de passe est incorrect.');
                return $this->redirectToRoute('app_front_user_edit', ['id' => $user->getId()]);
            }

            // Récupérer le nouveau mot de passe
            $newPassword = $form->get('plainPassword')->getData();

            // Vérifier que le nouveau mot de passe est différent de l'ancien
            if ($newPassword && $userPasswordHasher->isPasswordValid($user, $newPassword)) {
                $this->addFlash('danger', 'Le nouveau mot de passe doit être différent de l\'ancien.');
                return $this->redirectToRoute('app_front_user_edit', ['id' => $user->getId()]);
            }

            // Si un nouveau mot de passe a été soumis, le hacher et le définir
            if ($newPassword) {
                $hashedPassword = $userPasswordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
            }

        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur mis à jour avec succès.');

        return $this->redirectToRoute('app_front_user_show', ['id' => $user->getId()]);
    }

        return $this->render('front/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    //DELETE
    #[Route('/front/user/{id}/delete', name: 'app_front_user_delete')]
    public function delete(int $id, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
    $user = $userRepository->find($id);

    if (!$user) {
        throw $this->createNotFoundException('Utilisateur non trouvé');
    }

    $entityManager->remove($user);
    $entityManager->flush();

    $this->addFlash('success', 'Utilisateur supprimé avec succès.');

    return $this->redirectToRoute('app_logout');

    }
}
