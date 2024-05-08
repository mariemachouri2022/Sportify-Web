<?php

namespace App\Controller\Admin;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/terrain')]
class TerrainAdminController extends AbstractController
{
    #[Route('/all', name: 'app_terrain_indexadmin', methods: ['GET'])]
    public function index(TerrainRepository $terrainRepository): Response
    {
        return $this->render('terrain/admin/index.html.twig', [
            'terrains' => $terrainRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_terrain_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($terrain);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_terrain_indexadmin', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('terrain/admin/new.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_terrain_showadmin', methods: ['GET'])]
    public function show(Terrain $terrain): Response
    {
        return $this->render('terrain/admin/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_terrain_editadmin', methods: ['GET', 'POST'])]
    public function edit(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_terrain_indexadmin', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('terrain/admin/edit.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id_Terrain}', name: 'admin_terrain_deleteadmin')]
    public function deleteTerrain(Request $request, EntityManagerInterface $entityManager, Terrain $terrain): Response
    {
        if ($this->isCsrfTokenValid('delete'.$terrain->getIdTerrain(), $request->request->get('_token'))) {
            // Remove the terrain object
            $entityManager->remove($terrain);
            $entityManager->flush();
        }
    
        // Redirect to the index route after deleting terrain
        return $this->redirectToRoute('app_terrain_indexadmin');
    }
    

}
