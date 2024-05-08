<?php

namespace App\Controller;

use App\Entity\Matc;
use App\Mailer\MatchMailer;
use App\Form\MatcType;
use App\Mailer\Weather;
use App\Repository\MatcRepository;
use BaconQrCode\Common\ErrorCorrectionLevel as CommonErrorCorrectionLevel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\JsonResponse;


use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;




#[Route('/user/matc')]
class MatcController extends AbstractController
{
    #[Route('/', name: 'app_matc_index', methods: ['GET'])]
    public function index(Request $request, MatcRepository $matcRepository,PaginatorInterface $paginatorInterface,
    ): Response
    {
        $orderBy = $request->query->get('orderBy', 'default');

        if ($orderBy === 'default') {
            $data = $matcRepository->findAll();
            $matchs = $paginatorInterface->paginate(
                $data,
                $request->query->getInt('page', 1), // Page number
                3// Items per page
            );
        } else {
            $data = $matcRepository->findBy([], ['date' => 'ASC']);
            $matchs = $paginatorInterface->paginate(
                $data,
                $request->query->getInt('page', 1), // Page number
                3 // Items per page
            );
        }

        return $this->render('matc/index.html.twig', [
            'matcs' => $matchs,
        ]);
    }

    #[Route('/new', name: 'app_matc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Weather $weather): Response
    {
        $matc = new Matc();
        $form = $this->createForm(MatcType::class, $matc);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $equipe1 = $form->get('Equipe1')->getData();
            $equipe2 = $form->get('Equipe2')->getData();
            $selectedCity = $form->get('selectedCity')->getData();

            

            // Vérification si les équipes sont identiques
            if ($equipe1 === $equipe2) {
                // Ajoutez une erreur au formulaire pour le champ equipe2
                $form->get('Equipe2')->addError(new FormError('L\'équipe 2 doit être différente de l\'équipe 1.'));
                
                // Retournez le formulaire avec les erreurs
                return $this->renderForm('matc/new.html.twig', [
                    'matc' => $matc,
                    'form' => $form,
                    'selectedCity' => $selectedCity
                ]);
            }
            
            $entityManager->persist($matc);
            $entityManager->flush();
            // Dans votre méthode de contrôleur Symfony
            $city = $request->request->get('selectedCity');
            $weatherData = $weather->getWeatherDataForCity($selectedCity);


           # $recipientEmail1 = $equipe1->getIdUser()->getEmail();

           # $recipientEmail2 = $equipe2->getIdUser()->getEmail();
           # $matchMailer->sendMatchDetails($matc, $recipientEmail1, $recipientEmail2,$selectedCity,$weatherData);
            $recipientPhone=$matc->getArbitre()->getPhone();
            
           # $matchMailer->sendSMS($matc, $recipientPhone, $selectedCity,$weatherData);



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
    #public function sendEmail(MailerInterface $mailer)
#{
    #$email = (new Email())
      #  ->from('gimmework3@gmail.com')
      #  ->to('louaygnima123@gmail.com')
      #  ->subject('Test Email')
       # ->text('This is a test email sent from Symfony.');

   # $mailer->send($email);
#}
public function weather(Weather $weatherService, string $city): JsonResponse
    {
        $weatherData = $weatherService->getWeatherDataForCity($city);

        return $this->json($weatherData);
    }
    /*#[Route('/pagination', name: 'app_matc_pagination',methods: ['GET'])]
    public function pagination(Request $request, PaginatorInterface $paginator,MatcRepository $matcRepository): Response
    {
        

        // Récupérez votre liste de données à paginer (par exemple, tous les Matcs)
        $data = $matcRepository->findAll();

        // Paginer les données
        $pagination = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), // Numéro de la page par défaut
            10 // Nombre d'éléments par page
        );

        // Passez la pagination à votre vue pour l'affichage
        return $this->render('matc/pagination.html.twig', [
            'pagination' => $pagination,
        ]);
    }*/
    #[Route('/ExportPdf/{idMatc}', name: 'app_pdf', methods: ['GET', 'POST'])]
    public function exportPdf($idMatc, MatcRepository $matcRepository): Response
    {
        // Récupérer les détails du match depuis la base de données
        $matc = $matcRepository->find($idMatc);
    
        // Générer le texte du QR code avec les détails du match
        $qrCodeText = sprintf(
            "Match ID: %d\nNom: %s\nType: %s\nDate: %s\nHeure: %s\nDescription: %s\nEquipe 1: %s\nEquipe 2: %s\nArbitre: %s",
            $matc->getIdMatc(),
            $matc->getNom(),
            $matc->getType(),
            $matc->getDate()->format('Y-m-d'),
            $matc->getHeure()->format('H:i:s'),
            $matc->getDescription(),
            $matc->getEquipe1()->getNom(),
            $matc->getEquipe2()->getNom(),
            $matc->getArbitre()->getNom()
        );
    
        // Configuration du QR code
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($qrCodeText)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevel())
            ->size(200)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeMode())
            ->build();
    
        // Créer une instance de Dompdf avec des options par défaut
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
    
        // Rendre le template Twig en HTML
        $html = $this->renderView('matc/pdf.html.twig', [
            'matc' => $matc,
            'qrCode' => $qrCode->getDataUri(),
        ]);
    
        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);
    
        // Définir la taille du papier et l'orientation
        $dompdf->setPaper('A4', 'portrait');
    
        // Rendre le PDF
        $dompdf->render();
    
        // Renvoyer le PDF généré en tant que réponse
        return new Response($dompdf->output(), Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}