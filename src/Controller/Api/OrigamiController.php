<?php

namespace App\Controller\Api;

use App\Repository\OrigamiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrigamiController extends AbstractController
{   
    //READ
    #[Route('/api/origami', name: 'app_api_origami', methods: ['GET'])]
    public function getOrigamis(OrigamiRepository $origamiRepository): JsonResponse
    {
        // on récupère les origamis en bdd
        $origamis = $origamiRepository->findAll();
        
        return $this->json([
            $origamis, Response::HTTP_OK, []
        ]);
    }

    //CREATE
    #[Route('/api/ajouter/origami', name: 'app_api_origami', methods: ['POST'])]
    public function postOrigamis(OrigamiRepository $origamiRepository): JsonResponse
    {
        // on récupère les origamis en bdd
        $origamis = $origamiRepository->findAll();
        
        return $this->json([
            $origamis, Response::HTTP_OK, []
        ]);
    }

    //UPDATE
    #[Route('/api/modifier/origami', name: 'app_api_origami', methods: ['PATCH'])]
    public function editOrigamis(OrigamiRepository $origamiRepository): JsonResponse
    {
        // on récupère les origamis en bdd
        $origamis = $origamiRepository->findAll();
        
        return $this->json([
            $origamis, Response::HTTP_OK, []
        ]);
    }

    //DELETE
    #[Route('/api/supprimer/origami/{id}', name: 'app_api_origami_delete', methods: ['DELETE'])]
    public function deleteOrigami(int $id, OrigamiRepository $origamiRepository, EntityManagerInterface $entityManager,): JsonResponse
    {
        // Récupérer l'origami à supprimer
        $origami = $origamiRepository->find($id);

        // Vérifier si l'origami existe
        if (!$origami) {
            return $this->json([
                'message' => 'Origami non trouvé.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Supprimer l'origami de la base de données
        $entityManager->remove($origami);
        $entityManager->flush();

        // Récupérer tous les origamis après la suppression
        $origamis = $origamiRepository->findAll();

        // Retourner la liste des origamis mise à jour
        return $this->json([
            'origamis' => $origamis,
            'status' => Response::HTTP_OK,
            'message' => 'Origami supprimé avec succès.',
        ]);
    }
}
