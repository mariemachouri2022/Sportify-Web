<?php

namespace App\Controller;

use App\Entity\Classementequipe;
use App\Form\ClassementequipeType;
use App\Repository\ClassementEquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/classement')]
class ClassementequipeController extends AbstractController
{
    #[Route('/', name: 'app_classementequipe_index', methods: ['GET'])]
    public function index(ClassementEquipeRepository $classementEquipeRepository): Response
    {
        return $this->render('classementequipe/index.html.twig', [
            'classementequipes' => $classementEquipeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classementequipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classementequipe = new Classementequipe();
        $form = $this->createForm(ClassementequipeType::class, $classementequipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classementequipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_classementequipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('classementequipe/new.html.twig', [
            'classementequipe' => $classementequipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classementequipe_show', methods: ['GET'])]
    public function show(Classementequipe $classementequipe): Response
    {
        return $this->render('classementequipe/show.html.twig', [
            'classementequipe' => $classementequipe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classementequipe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Classementequipe $classementequipe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClassementequipeType::class, $classementequipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classementequipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('classementequipe/edit.html.twig', [
            'classementequipe' => $classementequipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classementequipe_delete', methods: ['POST'])]
    public function delete(Request $request, Classementequipe $classementequipe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classementequipe->getId(), $request->request->get('_token'))) {
            $entityManager->remove($classementequipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classementequipe_index', [], Response::HTTP_SEE_OTHER);
    }
}
