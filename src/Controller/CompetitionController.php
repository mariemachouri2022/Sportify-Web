<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Entity\Equipe;
use App\Entity\EquipeMembers;
use App\Entity\Utilisateurs;
use App\Form\CompetitionType;
use App\Repository\CompetitionRepository;
use App\Repository\EquipeMembersRepository;
use App\Repository\UtilisateursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mercure\PublisherInterface;
use MercurySeries\FlashyBundle\FlashyNotifier; 
use Symfony\Contracts\HttpClient\HttpClientInterface;
use DateTime;
use Stripe;



#[Route('/competition')]
class CompetitionController extends AbstractController
{
    


    private $client;

    public function __construct(HttpClientInterface $client)
    {
       $this->client = $client;
    }



    #[Route('/', name: 'app_competition_index', methods: ['GET'])]
    public function index(CompetitionRepository $competitionRepository): Response
    {
        return $this->render('competition/index.html.twig', [
            'competitions' => $competitionRepository->findAll(),
        ]);
    }
       

    #[Route('/match/{idCompetition}', name: 'app_competition_match', methods: ['GET'])]
    public function match(Competition $competition , EntityManagerInterface $entityManager): Response
    {
        $city = 'Tunis';
        $apiKey = "bfb411fdff194de2a8801622240205";
        // Get the current date
        $currentDate = new DateTime();
        // Get the date of the competition
        $competitionDate = $competition->getDate();
    
        // Check if the current date is before the competition date
        if ($currentDate > $competitionDate) {
            // Use historical weather API call
            $url = sprintf('https://api.weatherapi.com/v1/history.json?key=%s&q=%s&dt=%s', $apiKey, $city, $competitionDate->format('Y-m-d'));
        } else {
            // Use future weather API call
            $url = sprintf('https://api.weatherapi.com/v1/future.json?key=%s&q=%s&dt=%s', $apiKey, $city, $competitionDate->format('Y-m-d'));
        }
    
        // Make request to the weather API
        $response = $this->client->request('GET', $url);
        $weatherData = $response->toArray();
    
        // Extract relevant weather details
        $cityName = $weatherData['location']['name'];
        $temperature = $weatherData['forecast']['forecastday'][0]['day']['avgtemp_c'];
        $condition = $weatherData['forecast']['forecastday'][0]['day']['condition']['text'];
        // Pass weather data to the Twig template
       
    // Get the EquipeMembers for equipe1
    $equipe1Members = $entityManager->getRepository(EquipeMembers::class)->findBy(['equipeId' => $competition->getEquipe1()->getIdEquipe()]);

    // Get the EquipeMembers for equipe2
    $equipe2Members = $entityManager->getRepository(EquipeMembers::class)->findBy(['equipeId' => $competition->getEquipe2()->getIdEquipe()]);
    
        $equipe1Users = [];
        $equipe2Users = [];
    
        // Fetch users for equipe1
        foreach ($equipe1Members as $equipe1Member) {
            $user = $entityManager->getRepository(Utilisateurs::class)->find($equipe1Member->getUserId());
            if ($user) {
                $equipe1Users[] = $user;
            }
        }
    
        // Fetch users for equipe2
        foreach ($equipe2Members as $equipe2Member) {
            $user = $entityManager->getRepository(Utilisateurs::class)->find($equipe2Member->getUserId());
            if ($user) {
                $equipe2Users[] = $user;
            }
        }
    
        return $this->render('competition/matchcompet.html.twig', [
            'competition' => $competition,
            'equipe1Members' => $equipe1Users,
            'equipe2Members' => $equipe2Users,
            'cityName' => $cityName,
            'temperature' => $temperature,
            'condition' => $condition,
            'stripe_key' => $_ENV["STRIPE_KEY"],
        ]);
    
    }

   


#[Route('/stripe/create-charge', name:'stripee_charge', methods:['POST'])]
public function createCharge(FlashyNotifier $flashy,Request $request)
{
    Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
    Stripe\Charge::create ([
            "amount" => 5 * 100,
            "currency" => "usd",
            "source" => $request->request->get('stripeToken'),
            "description" => "Binaryboxtuts Payment Test"
    ]);
    $flashy->success('Success', 'https://127.0.0.1:8000/competition/');

    return $this->redirectToRoute('stripe', [], Response::HTTP_SEE_OTHER);
}
   
    #[Route('/join-team/{equipeId}/{competitionId}', name:'join_team', methods:['GET', 'POST'])]
    public function joinTeam(CompetitionRepository $competRepo ,EntityManagerInterface $entityManager,UtilisateursRepository $userrepo, Request $request, int $equipeId, int $competitionId): Response
{
    // Get the current authenticated user
    $user = $userrepo->findOneBy(['id' => 8]);
    $compet= $competRepo->find($competitionId) ; 

    $equipe1Members = $entityManager->getRepository(EquipeMembers::class)->findBy(['equipeId' => $compet->getEquipe1()->getIdEquipe()]);

    // Get the EquipeMembers for equipe2
    $equipe2Members = $entityManager->getRepository(EquipeMembers::class)->findBy(['equipeId' => $compet->getEquipe2()->getIdEquipe()]);
    
        $equipe1Users = [];
        $equipe2Users = [];
    
        // Fetch users for equipe1
        foreach ($equipe1Members as $equipe1Member) {
            $user = $entityManager->getRepository(Utilisateurs::class)->find($equipe1Member->getUserId());
            if ($user) {
                $equipe1Users[] = $user;
            }
        }
    
        // Fetch users for equipe2
        foreach ($equipe2Members as $equipe2Member) {
            $user = $entityManager->getRepository(Utilisateurs::class)->find($equipe2Member->getUserId());
            if ($user) {
                $equipe2Users[] = $user;
            }
        }
    // Check if the user is logged in
    if (!$user) {
        // Handle case where user is not logged in
        // You may redirect the user to login page or return an error response
        return new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }

    // Get the team repository
    $equipeRepository = $this->getDoctrine()->getRepository(Equipe::class);

    // Find the team by ID
    $equipe = $equipeRepository->find($equipeId);

    // Check if the team exists
    if (!$equipe) {
        // Handle case where team is not found
        // You may redirect the user to an error page or return an error response
        return new Response('Team not found', Response::HTTP_NOT_FOUND);
    }

    // Add the user to the team
    $equipeMember = new EquipeMembers();
    $equipeMember->setEquipeId($equipe->getIdEquipe());
    $equipeMember->setUserId($user->getId());

    // Persist the new EquipeMember
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($equipeMember);
    $entityManager->flush();

    // Fetch equipe members after joining
    $equipeMembers = $entityManager->getRepository(EquipeMembers::class)->findBy(['equipeId' => $equipeId]);

    // Render the lineup section as HTML
    $lineupHtml = $this->renderView('competition/_lineup.html.twig', [
        'equipeMembers' => $equipeMembers,
        'competition' => $compet,
        'equipe1Members' => $equipe1Users,
        'equipe2Members' => $equipe2Users,

    ]);

    // Return JSON response with the lineup HTML
    return new JsonResponse(['lineupHtml' => $lineupHtml]);
}

    #[Route('/Solo', name: 'app_competition_soloclient', methods: ['GET'])]
    public function SoloClient(CompetitionRepository $competitionRepository): Response
    {
        return $this->render('competition/SoloClient.html.twig', [
            'competitions' => $competitionRepository->findByType("SOLO"),
        ]);
    }  

    #[Route('/Teams', name: 'app_competition_teamsclient', methods: ['GET'])]
    public function TeamsClient(CompetitionRepository $competitionRepository): Response
    {
        return $this->render('competition/TeamsClient.html.twig', [
            'competitions' => $competitionRepository->findByType("TEAM"),
        ]);
    }

    #[Route('/new', name: 'app_competition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $competition = new Competition();
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if the competition type is 'SOLO'
            if ($competition->getType() === 'SOLO') {
                // Generate random team names
                $teamName1 = 'EQUIPE I';
                $teamName2 = 'EQUIPE II';

                // Create random teams
                $team1 = (new Equipe())
                    ->setNom($teamName1)
                    ->setIsrandom(true);
                $team2 = (new Equipe())
                    ->setNom($teamName2)
                    ->setIsrandom(true);

                // Persist the teams
                $entityManager->persist($team1);
                $entityManager->persist($team2);

                // Add the teams to the competition
                $competition->setEquipe1($team1);
                $competition->setEquipe2($team2);
            }

            $entityManager->persist($competition);
            $entityManager->flush();

            return $this->redirectToRoute('app_competition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competition/new.html.twig', [
            'competition' => $competition,
            'form' => $form,
        ]);
    }

    #[Route('/{idCompetition}', name: 'app_competition_show', methods: ['GET'])]
    public function show(Competition $competition): Response
    {
        return $this->render('competition/show.html.twig', [
            'competition' => $competition,
        ]);
    }

    #[Route('/{idCompetition}/edit', name: 'app_competition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Competition $competition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_competition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competition/edit.html.twig', [
            'competition' => $competition,
            'form' => $form,
        ]);
    }

    #[Route('/{idCompetition}', name: 'app_competition_delete', methods: ['POST'])]
    public function delete(Request $request, Competition $competition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competition->getIdCompetition(), $request->request->get('_token'))) {
            $entityManager->remove($competition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_competition_index', [], Response::HTTP_SEE_OTHER);
    }
}
