<?php

namespace App\Controller\Front;

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
    #[Route('/origami', name: 'app_origami')]
    public function list(OrigamiRepository $origamiRepository): Response
    {
        return $this->render('front/origami/list.html.twig', [
            'origamis' => $origamiRepository->findAll()
        ]);
    }

    //CREATE
    #[Route('/new/origami', name: 'app_new_origami')]
    public function newOrigami(Request $request, EntityManagerInterface $entityManager): Response
    {
        $origami = new Origami();
        $form = $this->createForm(OrigamiType::class, $origami);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $origami->setName($form->get('name')->getData());
            $origami->setCreatedAt(new \DateTimeImmutable());
    
            // Associer l'utilisateur connecté à l'origami
            $origami->setUser($this->getUser());
    
            /** @var UploadedFile[] $pictureFiles */
            $pictureFiles = $form->get('pictures')->getData();
    
            // Validation côté serveur : limiter à 3 images
            if (count($pictureFiles) > 3) {
                $this->addFlash('error', 'Vous ne pouvez uploader que 3 images au maximum');
                return $this->redirectToRoute('app_new_origami');
            }
    
            if ($pictureFiles) {
                $pictures = [];
    
                foreach ($pictureFiles as $pictureFile) {
                    $newFilename = uniqid().'.'.$pictureFile->guessExtension();
    
                    try {
                        $pictureFile->move(
                            $this->getParameter('origami_directory'),
                            $newFilename
                        );
                        $pictures[] = $newFilename;
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Impossible d\'uploader les fichiers');
                    }
                }
    
                // Enregistrer les noms des fichiers dans le tableau pictures
                $origami->setPictures($pictures);
            }
    
            $entityManager->persist($origami);
            $entityManager->flush();
    
            $this->addFlash('success', 'L\'origami a bien été ajouté');
    
            return $this->redirectToRoute('app_favorite');
        }
    
        return $this->render('front/origami/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //UPDATE
    #[Route('/update/origami/{id}', name: 'app_edit_origami')]
    public function editOrigami(
    int $id,
    Request $request,
    OrigamiRepository $origamiRepository,
    EntityManagerInterface $entityManager
): Response {
    $user = $this->getUser();
    if (!$user) {
        throw $this->createAccessDeniedException('Vous devez être connecté pour retirer des favoris.');
    }

    // Récupérer l'origami existant
    $origami = $origamiRepository->find($id);

    if (!$origami) {
        throw $this->createNotFoundException('Origami non trouvé');
    }

    // Créer le formulaire et le pré-remplir avec les données existantes
    $form = $this->createForm(OrigamiType::class, $origami);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Mettre à jour les champs modifiés
        $origami->setName($form->get('name')->getData());
        $origami->setUpdatedAt(new DateTimeImmutable('now'));

        /** @var UploadedFile $pictureFile */
        $pictureFile = $form->get('pictures')->getData();

        if ($pictureFile) {
            // Supprimer l'ancienne image si nécessaire
            if ($origami->getPictures()) {
                $oldFile = $this->getParameter('origami_directory') . '/' . $origami->getPictures();
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            // Générer un nouveau nom pour la nouvelle image
            $newFilename = uniqid() . '.' . $pictureFile->guessExtension();

            try {
                $pictureFile->move(
                    $this->getParameter('origami_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $this->addFlash('error', 'Impossible de télécharger le fichier');
            }

            // Mettre à jour le nom du fichier dans la base de données
            $origami->setPicture($newFilename);
        }

        // Persister les modifications
        $entityManager->flush();

        $this->addFlash('success', 'L\'origami a bien été modifié');
        return $this->redirectToRoute('app_favorite');
    }

    return $this->render('front/origami/update.html.twig', [
        'form' => $form->createView(),
        'origami' => $origami
    ]);
}
    //DELETE
    #[Route('/delete/origami/{id}', name: 'app_delete_origami', methods: ['POST','DELETE'])]
    public function deleteOrigami(int $id, OrigamiRepository $origamiRepository, EntityManagerInterface $entityManager): Response
    {

    $user = $this->getUser();
    if (!$user) {
        throw $this->createAccessDeniedException('Vous devez être connecté pour retirer des favoris.');
    }

    $origami = $origamiRepository->find($id);

    if (!$origami) {
        throw $this->createNotFoundException('Origami non trouvé');
    }

    // Supprimer l'image associée si elle existe
    if ($origami->getPictures()) {
        // Boucle sur chaque image dans le tableau
        foreach ($origami->getPictures() as $picture) {
            $oldFile = $this->getParameter('origami_directory') . '/' . $picture;
            
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    }

    // Supprimer l'entité de la base de données
    $entityManager->remove($origami);
    $entityManager->flush();

    $this->addFlash('success', 'L\'origami a bien été supprimé');
    return $this->redirectToRoute('app_favorite');
    }

    //SHOW
    #[Route('/show/origami/{id}', name: 'app_show_origami')]
    public function showOrigami(int $id, OrigamiRepository $origamiRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour ajouter des favoris.');
        }

    $origami = $origamiRepository->find($id);

    if (!$origami) {
        throw $this->createNotFoundException('Origami non trouvé');
    }

    return $this->render('front/origami/show.html.twig', [
        'origami' => $origami
    ]);
    }

}
