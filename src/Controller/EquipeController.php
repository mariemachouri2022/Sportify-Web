<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Categorie;
use App\Entity\Utilisateurs;
use App\Service\PDFService;
use App\Form\EquipeType;
use App\Form\UtilisateursType;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateursRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\TeamStatisticsService;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/equipe')]
class EquipeController extends AbstractController
{
    private $entityManager;
   

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        
    }
    
   

    #[Route('/', name: 'app_equipe_index', methods: ['GET'])]
    public function index(Request $request, EquipeRepository $equipeRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');
    
        if (empty($searchTerm)) {
     
            $query = $equipeRepository->createQueryBuilder('e')
                ->select('e') 
                ->getQuery();
            $data = $query->getResult();
        } else {
           
            $data = $equipeRepository->findBy(['nom' => $searchTerm]);
        }
    
        return $this->render('equipe/index.html.twig', [
            'equipes' => $data,
        ]);
    }
    


#[Route('/pdf/{id}', name: 'equipe_pdf')]
public function generatePdfEquipe(Equipe $equipe = null, PDFService $pdf) {
   
    $html = $this->renderView('pdf_layout.html.twig', ['equipe' => $equipe]);
    return $pdf->generatePdfResponse($html);

}


    
    #[Route('/admin', name: 'app_equipe_index_admin', methods: ['GET'])]
    public function indexAdmin(EquipeRepository $equipeRepository): Response
    {
        return $this->render('equipe/indexAdmin.html.twig', [
            'equipes' => $equipeRepository->findAll(),
        ]);
    }


    #[Route('/equipe/new', name: 'app_equipe_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, UtilisateursRepository $userRepository): Response
{
   
    $users = $userRepository->findAll();
    $equipe = new Equipe();
    $form = $this->createForm(EquipeType::class, $equipe, [
        'users' => $users,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        foreach ($equipe->getUtilisateurs() as $utilisateurs) {
            $utilisateurs->setEquipe($equipe);
        }

        $entityManager->persist($equipe);
        $entityManager->flush();

        return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('equipe/new.html.twig', [
        'equipe' => $equipe,
        'form' => $form,
    ]);
}

#[Route('/admin/new', name: 'app_equipe_new_admin', methods: ['GET', 'POST'])]
public function newAdmin(Request $request, EntityManagerInterface $entityManager, UtilisateursRepository $userRepository): Response
{
   
    $users = $userRepository->findAll();
    $equipe = new Equipe();
    $form = $this->createForm(EquipeType::class, $equipe, [
        'users' => $users,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        foreach ($equipe->getUtilisateurs() as $utilisateurs) {
            $utilisateurs->setEquipe($equipe);
        }

        $entityManager->persist($equipe);
        $entityManager->flush();

        return $this->redirectToRoute('app_equipe_index_admin', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('equipe/newAdmin.html.twig', [
        'equipe' => $equipe,
        'form' => $form,
    ]);
}



#[Route('/equipe/{IDEquipe}', name: 'app_equipe_show', methods: ['GET'])]
public function show(Equipe $equipe): Response
{
    return $this->render('equipe/show.html.twig', [
        'equipe' => $equipe,
    ]);
}


    #[Route('/admin/{IDEquipe}', name: 'app_equipe_show_admin', methods: ['GET'])]
    public function showAdmin(Equipe $equipe): Response
    {
        return $this->render('equipe/showAdmin.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    #[Route('/equipe/{IDEquipe}/edit', name: 'app_equipe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
    {
        
        $existingUsers = $entityManager->getRepository(Utilisateurs::class)->findAll();
    
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);
        dump($request->request->all());
    
        if ($form->isSubmitted() && $form->isValid()) {
            dump($equipe);
    
            $entityManager->flush();
    
            return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('equipe/edit.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
            'existing_users' => $existingUsers,
        ]);
    }
    
    #[Route('/admin/{IDEquipe}/edit', name: 'app_equipe_edit_admin', methods: ['GET', 'POST'])]
    public function editAdmin(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
    {
        $existingUsers = $entityManager->getRepository(Utilisateurs::class)->findAll();
    
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);
        dump($request->request->all());
    
        if ($form->isSubmitted() && $form->isValid()) {
            dump($equipe);
    
            $entityManager->flush();
    
            return $this->redirectToRoute('app_equipe_index_admin', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('equipe/editAdmin.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
            'existing_users' => $existingUsers,
        ]);
    }
    




    #[Route('/equipe/{IDEquipe}', name: 'app_equipe_delete', methods: ['POST'])]
    public function delete(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$equipe->getIDEquipe(), $request->request->get('_token'))) {
        // Dissocier les utilisateurs associés
        foreach ($equipe->getUtilisateurs() as $utilisateur) {
            $utilisateur->setEquipe(null);
        }
        
        // Supprimer l'équipe
        $entityManager->remove($equipe);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
}
    

    #[Route('/admin/{IDEquipe}', name: 'app_equipe_delete_admin', methods: ['POST'])]
    public function deleteAdmin(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipe->getIDEquipe(), $request->request->get('_token'))) {
            $entityManager->remove($equipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_equipe_index_admin', [], Response::HTTP_SEE_OTHER);
    }
   

    #[Route('/stats', name: 'stats')]
    public function statistiques(ChartBuilderInterface $chartBuilder): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        
        $chart->setData([
            'labels' => ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            'datasets' => [
                [
                    'label' => 'My First Dataset',
                    'backgroundColor' => ['red', 'blue', 'yellow', 'green', 'purple', 'orange'],
                    'data' => [12, 19, 3, 5, 2, 3],
                ],
            ],
        ]);
        
        $chart->setOptions([]);

        return $this->render('equipe/stats.html.twig', [
            'chart' => $chart,
        ]);
    }

}
