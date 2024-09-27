<?php

namespace App\Controller\Front;

use App\Repository\OrigamiRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, OrigamiRepository $origamiRepository): JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        $origamis = $origamiRepository->findAll();
        $origamiPictures = [];
        foreach ($origamis as $origami) {
            $origamiPictures[] = $origami->getPictures();
        }
         // Si la requête demande du JSON, retournez une JsonResponse
         if ($request->headers->get('Accept') === 'application/json') {
        return $this->json($origamiPictures, Response::HTTP_OK, []);
    }
      // Sinon, retournez une vue Twig
      return $this->render('front/main/home.html.twig', [
        'origamis' => $origamis,
    ]);
}
}