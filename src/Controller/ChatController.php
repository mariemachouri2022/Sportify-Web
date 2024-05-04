<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\PublisherInterface;
use GoogleMaps\GoogleMaps;
use GuzzleHttp\Client;
use Symfony\Contracts\HttpClient\HttpClientInterface;






class ChatController extends AbstractController
{      
    private PublisherInterface $publisher;
    private $client;


    public function __construct(PublisherInterface $publisher,HttpClientInterface $client)
    {
        $this->publisher = $publisher;
        $this->client = $client;
    }

    #[Route("/map", name:"map")]
    public function indexmap(): Response
    {
        // Initialize Guzzle client
         // Initialize Guzzle client
        
         // Decode JSON response
 
         // Check if the response contains any results
       
         // Pass latitude and longitude to the template
         return $this->render('metier/maps.html.twig');
     }


  

    

    #[Route('/chat', name: 'chat')]
    public function index(): Response
    {
        return $this->render('chat/index.html.twig');
    }
    
    #[Route('/send', name: 'send_message')]
    public function sendMessage(Request $request , HubInterface $hub): Response
    {
        $message = $request->request->get('message');

        $update = new Update(
            'https://127.0.0.1:8000/chat',
            json_encode(['message' => $message]),
            true // This targets all subscribers
        );

        $hub->publish($update);

        return $this->render('chat/index.html.twig');

   
    }

    #[Route('/stream', name: 'stream_messages')]
    public function streamMessages(HubInterface $hub): Response
    {
        // Set the response headers for an event stream
        $response = new Response();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Powered-By', 'Symfony/Mercure');
    
        // Stream the data using Mercure hub
        $update = new Update(
            '/chat',
            json_encode(['message' => 'New message']),
            true // This targets all subscribers
        );
    
        $response->setContent($hub->publish($update));
    
        return $response;
    }
  
}
