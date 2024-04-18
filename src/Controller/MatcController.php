<?php

namespace App\Controller;

use App\Entity\Matc;
use App\Form\MatcType;
use App\Repository\MatcRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

#[Route('/matc')]
class MatcController extends AbstractController
{
    #[Route('/', name: 'app_matc_index', methods: ['GET'])]
    public function index(MatcRepository $matcRepository): Response
    {
        return $this->render('matc/index.html.twig', [
            'matcs' => $matcRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_matc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $matc = new Matc();
        $form = $this->createForm(MatcType::class, $matc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipe1 = $form->get('Equipe1')->getData();
            $equipe2 = $form->get('Equipe2')->getData();
            

            // Vérification si les équipes sont identiques
            if ($equipe1 === $equipe2) {
                // Ajoutez une erreur au formulaire pour le champ equipe2
                $form->get('Equipe2')->addError(new FormError('L\'équipe 2 doit être différente de l\'équipe 1.'));
                
                // Retournez le formulaire avec les erreurs
                return $this->renderForm('matc/new.html.twig', [
                    'matc' => $matc,
                    'form' => $form,
                ]);
            }
            $entityManager->persist($matc);
            $entityManager->flush();

            return $this->redirectToRoute('app_matc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('matc/new.html.twig', [
            'matc' => $matc,
            'form' => $form,
        ]);
    }

    #[Route('/{idMatc}', name: 'app_matc_show', methods: ['GET'])]
    public function show(Matc $matc): Response
    {
        return $this->render('matc/show.html.twig', [
            'matc' => $matc,
        ]);
    }

    #[Route('/{idMatc}/edit', name: 'app_matc_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Matc $matc, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MatcType::class, $matc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_matc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('matc/edit.html.twig', [
            'matc' => $matc,
            'form' => $form,
        ]);
    }

    #[Route('/{idMatc}', name: 'app_matc_delete', methods: ['POST'])]
    public function delete(Request $request, Matc $matc, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matc->getIdMatc(), $request->request->get('_token'))) {
            $entityManager->remove($matc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_matc_index', [], Response::HTTP_SEE_OTHER);
    }
}
