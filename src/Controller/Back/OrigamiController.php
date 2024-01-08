<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrigamiController extends AbstractController
{
    #[Route('/back/origami', name: 'app_back_origami')]
    public function index(): Response
    {
        return $this->render('back/origami/index.html.twig', [
            'controller_name' => 'OrigamiController',
        ]);
    }
}
