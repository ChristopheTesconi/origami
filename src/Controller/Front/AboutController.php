<?php

namespace App\Controller\Front;

use App\Entity\About;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $about = $entityManager->getRepository(About::class)->find(1);

        return $this->render('front/about/index.html.twig', [
            'content' => $about ? $about->getContent() : 'Le texte à propos est vide pour le moment.',
        ]);
    }
}
