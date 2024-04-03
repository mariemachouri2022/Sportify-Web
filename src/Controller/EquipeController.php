<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Form\EquipeType;
use App\Form\UtilisateurType;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;


#[Route('/equipe')]
class EquipeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_equipe_index', methods: ['GET'])]
    public function index(EquipeRepository $equipeRepository): Response
    {
        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipeRepository->findAll(),
        ]);
    }

    
    #[Route('/equipe/new', name: 'app_equipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);
        
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist and flush the equipe
    
            return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('equipe/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/equipe/{IDEquipe}', name: 'app_equipe_show', methods: ['GET'])]
    public function show(Equipe $equipe): Response
    {
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    #[Route('/equipe/{IDEquipe}/edit', name: 'app_equipe_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
{
    // Retrieve existing users
    $existingUsers = $this->entityManager->getRepository(Utilisateur::class)->findAll();

    // Ensure the IDEquipe property is included in the Equipe entity
    $equipe->getIDEquipe(); // This ensures that the IDEquipe property is accessed

    $form = $this->createForm(EquipeType::class, $equipe);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('equipe/edit.html.twig', [
        'equipe' => $equipe,
        'form' => $form,
        'existing_users' => $existingUsers,
    ]);
}

    

    #[Route('/equipe/{IDEquipe}', name: 'app_equipe_delete', methods: ['POST'])]
    public function delete(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipe->getIDEquipe(), $request->request->get('_token'))) {
            $entityManager->remove($equipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
    }
}
