<?php

namespace App\Controller\Back;

use App\Entity\About;
use App\Form\AboutType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    #[Route('/edit', name: 'app_back_about_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $about = $entityManager->getRepository(About::class)->find(1);

        if (!$about) {
            $about = new About();
        }

        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($about);
            $entityManager->flush();

            $this->addFlash('success', 'À propos mis à jour avec succès !');

            return $this->redirectToRoute('app_back_about_edit');
        }

        return $this->render('back/about/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
