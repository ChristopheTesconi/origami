<?php

namespace App\Controller;

use App\Entity\Origami;
use App\Form\SearchType;
use App\Repository\OrigamiRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods: ['GET'])]
    public function search(Request $request, OrigamiRepository $origamiRepository): Response
    {
        $searchOrigami = new Origami();
        $form = $this->createForm(SearchType::class, $searchOrigami);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

        }

        // Afficher les résultats dans une vue
        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
