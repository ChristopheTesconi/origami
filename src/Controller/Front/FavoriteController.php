<?php

namespace App\Controller\Front;

use App\Repository\OrigamiRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{
    //READ
    #[Route('/favorite', name: 'app_favorite')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Vérifier si un utilisateur est connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir vos favoris.');
        }

        // Récupérer les origamis
        $Origamis = $user->getOrigamis();

        return $this->render('front/favorite/index.html.twig', [
            'Origamis' => $Origamis,
        ]);
    }

    // SHOW - Afficher la photo d'un origami favori
    #[Route('/favorite/show/{id}', name: 'app_show_origami_picture')]
    public function showFavorite(int $id, OrigamiRepository $origamiRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir les détails de vos favoris.');
        }

        // Récupérer l'origami à partir de son ID
        $origami = $origamiRepository->find($id);
        if (!$origami) {
            throw $this->createNotFoundException('Origami non trouvé.');
        }

        return $this->render('front/favorite/showorigamipicture.html.twig', [
            'origami' => $origami,
        ]);
    }

}
