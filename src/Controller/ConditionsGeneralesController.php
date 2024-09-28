<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConditionsGeneralesController extends AbstractController
{
    #[Route('/conditions/generales', name: 'app_conditions_generales')]
    public function index(): Response
    {
        return $this->render('conditions_generales/index.html.twig', [
            'controller_name' => 'ConditionsGeneralesController',
        ]);
    }
}
