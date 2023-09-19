<?php

namespace App\Controller\Front;

use App\Repository\OrigamiRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrigamiController extends AbstractController
{
    #[Route('/origami', name: 'app_origami')]
    public function list(OrigamiRepository $origamiRepository): Response
    {
        return $this->render('front/origami/list.html.twig', [
            'origamis' => $origamiRepository->findAll()
        ]);
    }
}
