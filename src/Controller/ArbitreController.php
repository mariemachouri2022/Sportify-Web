<?php

namespace App\Controller;

use App\Entity\Arbitre;
use App\Form\ArbitreType;
use App\Repository\ArbitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/arbitre')]
class ArbitreController extends AbstractController
{
    #[Route('/', name: 'app_arbitre_index', methods: ['GET'])]
    public function index(ArbitreRepository $arbitreRepository): Response
    {
        return $this->render('arbitre/index.html.twig', [
            'arbitres' => $arbitreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_arbitre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $arbitre = new Arbitre();
        $form = $this->createForm(ArbitreType::class, $arbitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($arbitre);
            $entityManager->flush();

            return $this->redirectToRoute('app_arbitre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('arbitre/new.html.twig', [
            'arbitre' => $arbitre,
            'form' => $form,
        ]);
    }

    #[Route('/{idArbitre}', name: 'app_arbitre_show', methods: ['GET'])]
    public function show(Arbitre $arbitre): Response
    {
        return $this->render('arbitre/show.html.twig', [
            'arbitre' => $arbitre,
        ]);
    }

    #[Route('/{idArbitre}/edit', name: 'app_arbitre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Arbitre $arbitre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArbitreType::class, $arbitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_arbitre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('arbitre/edit.html.twig', [
            'arbitre' => $arbitre,
            'form' => $form,
        ]);
    }

    #[Route('/{idArbitre}', name: 'app_arbitre_delete', methods: ['POST'])]
    public function delete(Request $request, Arbitre $arbitre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$arbitre->getIdArbitre(), $request->request->get('_token'))) {
            $entityManager->remove($arbitre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_arbitre_index', [], Response::HTTP_SEE_OTHER);
    }
}
