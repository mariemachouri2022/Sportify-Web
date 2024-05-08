<?php
namespace App\Controller;

use App\Form\SearchType;
use App\Service\QRCodeGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function search(Request $request, QRCodeGenerator $qrCodeGenerator): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData()['name'];


            $qrCodeResponse = $qrCodeGenerator->generateQRCode($data);

          //  $googleUrl = sprintf('https://www.google.com/search?q=les+cat%C3%A9gories+de+sports&rlz=1C1CHZN_frTN1036TN1036&oq=les+cat%C3%A9gories+de+sports&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIICAEQABgWGB4yCggCEAAYgAQYogQyCggDEAAYgAQYogQyCggEEAAYgAQYogTSAQg1MTc2ajBqN6gCALACAA&sourceid=chrome&ie=UTF-8');
          return $this->redirectToRoute('search');

           // return $this->redirect('https://www.google.com/search?q=les+cat%C3%A9gories+de+sports&rlz=1C1CHZN_frTN1036TN1036&oq=les+cat%C3%A9gories+de+sports&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIICAEQABgWGB4yCggCEAAYgAQYogQyCggDEAAYgAQYogQyCggEEAAYgAQYogTSAQg1MTc2ajBqN6gCALACAA&sourceid=chrome&ie=UTF-8');
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}