<?php

namespace App\Controller\Back;

use DateTimeImmutable;
use App\Entity\Origami;
use App\Form\OrigamiType;
use App\Repository\OrigamiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class OrigamiController extends AbstractController
{
    //READ
    #[Route('/back/origami', name: 'app_back_origami')]
    public function index(OrigamiRepository $origamiRepository): Response
    {
        return $this->render('back/origami/index.html.twig', [
            'origamis' => $origamiRepository->findAll()
        ]);
    }

    //CREATE
    #[Route('/back/new/origami', name: 'app_back_new_origami')]
public function newOrigami(Request $request, EntityManagerInterface $entityManager): Response
{
    $origami = new Origami();
    $form = $this->createForm(OrigamiType::class, $origami);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $origami->setName($form->get('name')->getData());
        $origami->setCreatedAt(new DateTimeImmutable('now'));

        // Associer l'utilisateur connecté à l'origami
        $origami->setUser($this->getUser());

        /** @var UploadedFile $pictureFile */
        $pictureFile = $form->get('picture')->getData();
        if ($pictureFile) {
            $newFilename = uniqid().'.'.$pictureFile->guessExtension();
            try {
                $pictureFile->move(
                    $this->getParameter('origami_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $this->addFlash('error', 'Impossible d\'uploader le fichier');
            }
            $origami->setPicture($newFilename);
        }

        $entityManager->persist($origami);
        $entityManager->flush();

        $this->addFlash('success', 'L\'origami a bien été ajouté');
        return $this->redirectToRoute('app_back_origami');
    }

    return $this->render('back/origami/new.html.twig', [
        'form' => $form->createView(),
    ]);
}


    // UPDATE
    #[Route('/back/update/origami/{id}', name: 'app_back_edit_origami')]
public function editOrigami(
    int $id,
    Request $request,
    OrigamiRepository $origamiRepository,
    EntityManagerInterface $entityManager
): Response {
    $origami = $origamiRepository->find($id);

    if (!$origami) {
        throw $this->createNotFoundException('Origami non trouvé');
    }

    // Vérifier si l'utilisateur connecté est bien le créateur de l'origami
    if ($origami->getUser() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
        throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à modifier cet origami.');
    }
    

    $form = $this->createForm(OrigamiType::class, $origami);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $origami->setName($form->get('name')->getData());
        $origami->setUpdatedAt(new DateTimeImmutable('now'));

        /** @var UploadedFile $pictureFile */
        $pictureFile = $form->get('pictures')->getData();
        if ($pictureFile) {
            if ($origami->getPictures()) {
                $oldFile = $this->getParameter('origami_directory') . '/' . $origami->getPictures();
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $newFilename = uniqid() . '.' . $pictureFile->guessExtension();
            try {
                $pictureFile->move(
                    $this->getParameter('origami_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $this->addFlash('error', 'Impossible de télécharger le fichier');
            }

            $origami->setPicture($newFilename);
        }

        $entityManager->flush();
        $this->addFlash('success', 'L\'origami a bien été modifié');
        return $this->redirectToRoute('app_back_origami');
    }

    return $this->render('back/origami/update.html.twig', [
        'form' => $form->createView(),
        'origami' => $origami,
    ]);
}


    //DELETE
    #[Route('/back/delete/origami/{id}', name: 'app_back_delete_origami', methods: ['POST','DELETE'])]
    public function deleteOrigami(int $id, OrigamiRepository $origamiRepository, EntityManagerInterface $entityManager): Response
    {
    $origami = $origamiRepository->find($id);

    if (!$origami) {
        throw $this->createNotFoundException('Origami non trouvé');
    }

    if ($origami->getUser() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
        throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à modifier cet origami.');
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
    return $this->redirectToRoute('app_back_origami');
    }

    //SHOW
    #[Route('/back/show/origami/{id}', name: 'app_back_show_origami')]
    public function showOrigami(int $id, OrigamiRepository $origamiRepository): Response
    {
    $origami = $origamiRepository->find($id);

    if (!$origami) {
        throw $this->createNotFoundException('Origami non trouvé');
    }

    return $this->render('back/origami/show.html.twig', [
        'origami' => $origami
    ]);
    }
}
