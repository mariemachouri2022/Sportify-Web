<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Psr\Log\LoggerInterface;

#[Route('/terrain')]
class TerrainController extends AbstractController
{
    #[Route('/all', name: 'app_terrain_index', methods: ['GET'])]
    public function index(TerrainRepository $terrainRepository): Response
    {
        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrainRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_terrain_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $file = $form['imageTer']->getData();
            if ($file) {
                // Define the directory to store uploaded images
                $terrainImagesDirectory = $this->getParameter('kernel.project_dir').'/public/uploads/terrain_images';
    
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$file->getClientOriginalExtension();
    
                // Move the file to the desired directory
                try {
                    $file->move(
                        $terrainImagesDirectory,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle file upload error, if any
                }
    
                // Store the file name in the entity
                $terrain->setImageTer($newFilename);
            }
    
            $entityManager->persist($terrain);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('terrain/new.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }
    
    

    #[Route('/{id}', name: 'app_terrain_show', methods: ['GET'])]
    public function show(Terrain $terrain): Response
    {
        return $this->render('terrain/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_terrain_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Terrain $terrain, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
{
    $form = $this->createForm(TerrainType::class, $terrain);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle file upload
        $file = $form['imageTer']->getData();
        if ($file) {
            // Define the directory to store uploaded images
            $terrainImagesDirectory = $this->getParameter('kernel.project_dir').'/public/uploads/terrain_images';

            // Generate a unique filename
            $newFilename = uniqid().'.'.$file->getClientOriginalExtension();

            // Move the file to the desired directory
            try {
                $file->move(
                    $terrainImagesDirectory,
                    $newFilename
                );

                // Update the image filename in the entity
                $terrain->setImageTer($newFilename);
            } catch (FileException $e) {
                // Log or handle the file upload error
                // For debugging, you can log the exception message
                $logger->error('File upload error: ' . $e->getMessage());
                // You can also provide a user-friendly error message
                $this->addFlash('error', 'Failed to upload the file.');
                // Redirect back to the edit form with an error message
                return $this->redirectToRoute('app_terrain_edit', ['id' => $terrain->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        // Update the terrain information
        $entityManager->flush();

        // Redirect to the terrain index page
        return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
    }

    // Render the edit form
    return $this->renderForm('terrain/edit.html.twig', [
        'terrain' => $terrain,
        'form' => $form,
    ]);
}

    

    #[Route('/terrain/delete/{id_Terrain}', name: 'app_terrain_delete')]
public function deleteTerrain(Request $request, EntityManagerInterface $entityManager, Terrain $terrain): Response
{
    if ($this->isCsrfTokenValid('delete'.$terrain->getIdTerrain(), $request->request->get('_token'))) {
        // Remove the terrain object
        $entityManager->remove($terrain);
        $entityManager->flush();
    }

    // Redirect to the index route after deleting terrain
    return $this->redirectToRoute('app_terrain_index');
}

}