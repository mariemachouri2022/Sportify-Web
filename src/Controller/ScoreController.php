<?php

namespace App\Controller;

use App\Entity\Score;
use App\Entity\Competition;
use App\Form\ScoreType;
use App\Repository\ScoreRepository;
use App\Repository\CompetitionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/score')]
class ScoreController extends AbstractController
{
    #[Route('/', name: 'app_score_index', methods: ['GET'])]
    public function index(ScoreRepository $scoreRepository): Response
    {
        return $this->render('score/index.html.twig', [
            'scores' => $scoreRepository->findAll(),
        ]);
    } 
    #[Route('/competition', name: 'app_competitonall_index', methods: ['GET'])]
    public function competitionall(CompetitionRepository $competRepository): Response
    {
        return $this->render('score/competiton.html.twig', [
            'competitions' => $competRepository->findAll(),
        ]);
    }

    

    #[Route('/{idCompetition}/new', name: 'app_score_new', methods: ['GET', 'POST'])]
    public function new(ScoreRepository $scoreRepo ,Request $request, Competition $competition ,EntityManagerInterface $entityManager): Response
    { 
        $existScore = $scoreRepo->findOneBy(['competitionId' => $competition]);
        if ($existScore !== null) {
            return $this->redirectToRoute('app_score_edit', ['idscore' => $existScore->getIdscore()]);
        } else {
  
        $score = new Score();
        $form = $this->createForm(ScoreType::class, $score);
        $form->handleRequest($request);
          $score->setCompetitionid($competition ) ; 
        if ($form->isSubmitted() && $form->isValid()) {
            if ($score->getEquipe1score() > $score->getEquipe2score()) {
                $score->setWinnerid($competition->getEquipe1());
                $score->setLoserid($competition->getEquipe2());
            } elseif ($score->getEquipe1score() < $score->getEquipe2score()) {
                $score->setWinnerid($competition->getEquipe2());
                $score->setLoserid($competition->getEquipe1());
            } else {
                $score->setWinnerid(null);
                $score->setLoserid(null);
            }
            $entityManager->persist($score);
            $entityManager->flush();

            return $this->redirectToRoute('app_score_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('score/new.html.twig', [
            'competition'=>$competition,
            'score' => $score,
            'form' => $form,
        ]); }
        
    }
    #[Route('/new', name: 'app_score_neww', methods: ['GET', 'POST'])]
    public function neww(Request $request ,EntityManagerInterface $entityManager): Response
    {   
        
        $score = new Score();
        $form = $this->createForm(ScoreType::class, $score);
        $form->handleRequest($request);
          
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($score);
            $entityManager->flush();

            return $this->redirectToRoute('app_score_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('score/new.html.twig', [
            'score' => $score,
            'form' => $form,
        ]);
    }

    #[Route('/{idCompetition}', name: 'app_competition_show', methods: ['GET'])]
    public function showw(Competition $competition): Response
    {
        return $this->render('score/new.html.twig', [
            'competition' => $competition,
        ]);
    }

    #[Route('/{idscore}', name: 'app_score_show', methods: ['GET'])]
    public function show(Score $score): Response
    {
        return $this->render('score/show.html.twig', [
            'score' => $score,
        ]);
    }

    #[Route('/{idscore}/edit', name: 'app_score_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Score $score, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScoreType::class, $score);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_score_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('score/edit.html.twig', [
            'score' => $score,
            'form' => $form,
        ]);
    }

    #[Route('/{idscore}', name: 'app_score_delete', methods: ['POST'])]
    public function delete(Request $request, Score $score, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$score->getIdscore(), $request->request->get('_token'))) {
            $entityManager->remove($score);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_score_index', [], Response::HTTP_SEE_OTHER);
    }
}
