<?php

namespace App\Controller\Back;

use DateTimeImmutable;
use App\Entity\Origami;
use App\Form\OrigamiType;
use App\Repository\OrigamiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrigamiController extends AbstractController
{
    //READ
    #[Route('/back/origami', name: 'app_back_origami')]
    public function index(OrigamiRepository $origamiRepository): Response
    {
        return $this->render('back/origami/index.html.twig', [
            'origamis' => $origamiRepository->findAll()
        ]);
    }

    //CREATE
    #[Route('/back/new/origami', name: 'app_back_new_origami')]
    public function newOrigami(Request $request, EntityManagerInterface $entityManager, Origami $origami): Response
    {
        $origami = new Origami();
        $form = $this->createForm(OrigamiType::class, $origami);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $origami->setName($form->get('name')->getData());
            $origami->setCreatedAt(new DateTimeImmutable('now'));

            $entityManager->persist($origami);
            $entityManager->flush();
    
            $this->addFlash('success', 'L\'origami a bien été ajouté');

            return $this->redirectToRoute('app_back_origami');
        }

        return $this->render('back/origami/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //UPDATE

    //DELETE

    //SHOW
    
}
