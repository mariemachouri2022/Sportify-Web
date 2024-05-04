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
use App\Entity\Classementequipe;
use App\Entity\Equipe;
use App\Repository\ClassementEquipeRepository;

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
    public function new(ScoreRepository $scoreRepo ,Request $request, Competition $competition ,EntityManagerInterface $entityManager , ClassementEquipeRepository $classementEquipeRepository): Response
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
            $this->updateClassement($score->getWinnerId(),$score->getLoserId(),$score->getEquipe1Score() === $score->getEquipe2Score(),$classementEquipeRepository) ; 

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
    
    #[Route('/{idCompetition}/newAdmin', name: 'app_score_newAdmin', methods: ['GET', 'POST'])]
    public function newAdmin(ScoreRepository $scoreRepo ,Request $request, Competition $competition ,EntityManagerInterface $entityManager , ClassementEquipeRepository $classementEquipeRepository): Response
    { 
        $existScore = $scoreRepo->findOneBy(['competitionId' => $competition]);
        if ($existScore !== null) {
            return $this->redirectToRoute('app_score_editAdmin', ['idscore' => $existScore->getIdscore()]);
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
            $this->updateClassement($score->getWinnerId(),$score->getLoserId(),$score->getEquipe1Score() === $score->getEquipe2Score(),$classementEquipeRepository) ; 

            $entityManager->persist($score);
            $entityManager->flush();

            return $this->redirectToRoute('app_score_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('score/newAdmin.html.twig', [
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

 
    #[Route('/{idscore}', name: 'app_score_show', methods: ['GET'])]
    public function show(Score $score): Response
    {
        return $this->render('score/show.html.twig', [
            'score' => $score,
        ]);
    }

    #[Route('/{idscore}/edit', name: 'app_score_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Score $score, EntityManagerInterface $entityManager,ClassementEquipeRepository $classementEquipeRepository): Response
    {
        $form = $this->createForm(ScoreType::class, $score);
        $form->handleRequest($request);
         $competition=$score->getCompetitionid() ; 
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
            $this->updateClassement($score->getWinnerId(),$score->getLoserId(),$score->getEquipe1Score() === $score->getEquipe2Score(),$classementEquipeRepository) ; 
            $entityManager->flush();

            return $this->redirectToRoute('app_score_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('score/edit.html.twig', [
            'competition' => $competition,
            'score' => $score,
            'form' => $form,
        ]);
    } 
    
    #[Route('/{idscore}/editAdmin', name: 'app_score_editAdmin', methods: ['GET', 'POST'])]
    public function editAdmin(Request $request, Score $score, EntityManagerInterface $entityManager,ClassementEquipeRepository $classementEquipeRepository): Response
    {
        $form = $this->createForm(ScoreType::class, $score);
        $form->handleRequest($request);
         $competition=$score->getCompetitionid() ; 
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
            $this->updateClassement($score->getWinnerId(),$score->getLoserId(),$score->getEquipe1Score() === $score->getEquipe2Score(),$classementEquipeRepository) ; 
            $entityManager->flush();

            return $this->redirectToRoute('app_score_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('score/editAdmin.html.twig', [
            'competition' => $competition,
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

    private function updateClassement(Equipe $winner, Equipe $loser, bool $isDraw,ClassementEquipeRepository $classementEquipeRepository): void
{
    $entityManager = $this->getDoctrine()->getManager();

    // Update Classement Equipe for winner
    $winnerClassement = $classementEquipeRepository->findOneBy(['equipeId' => $winner]);
    if (!$winnerClassement) {
        $winnerClassement = new Classementequipe();
        $winnerClassement->setEquipeId($winner);
    }
    $winnerClassement->setLoss($winnerClassement->getLoss() + 0);
    $winnerClassement->setPoints($winnerClassement->getPoints() + 3);
    $winnerClassement->setWin($winnerClassement->getWin() + 1);
    $winnerClassement->setNbreDeMatch($winnerClassement->getNbreDeMatch() + 1);
    $winnerClassement->setRank(0) ; 
    $winnerClassement->setdraw(0) ; 
    $entityManager->persist($winnerClassement);

    // Update Classement Equipe for loser
    $loserClassement = $classementEquipeRepository->findOneBy(['equipeId' => $loser]);
    if (!$loserClassement) {
        $loserClassement = new Classementequipe();
        $loserClassement->setEquipeId($loser);
    }
    $loserClassement->setPoints($loserClassement->getPoints() + 0);
    $loserClassement->setWin($loserClassement->getWin() + 0);
    $loserClassement->setLoss($loserClassement->getLoss() + 1);
    $loserClassement->setNbreDeMatch($loserClassement->getNbreDeMatch() + 1);
    $loserClassement->setRank(0) ; 
    $loserClassement->setDraw(0) ; 

    $entityManager->persist($loserClassement);

    $entityManager->flush();

    // Update ranks
    $this->updateRanks($classementEquipeRepository , $entityManager);
}

private function updateRanks(ClassementEquipeRepository $classementEquipeRepository , EntityManagerInterface $entityManager ): void
{

    // Get all Classement Equipe entries
    $classementEquipeList = $classementEquipeRepository->findAll();

    // Sort teams by points in descending order
    usort($classementEquipeList, function($a, $b) {
        return $b->getPoints() - $a->getPoints();
    });

    // Update ranks based on sorted list
    $rank = 1;
    foreach ($classementEquipeList as $classement) {
        $classement->setRank($rank++);
        $entityManager->persist($classement);
    }

    $entityManager->flush();
}
}
