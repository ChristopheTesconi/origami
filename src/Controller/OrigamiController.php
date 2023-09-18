<?php

namespace App\Controller;

use App\Repository\OrigamiRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrigamiController extends AbstractController
{
    #[Route('/origami', name: 'app_origami')]
    public function list(OrigamiRepository $origamiRepository): Response
    {
        return $this->render('origami/list.html.twig', [
            'origamis' => $origamiRepository->findAll()
        ]);
    }
}
