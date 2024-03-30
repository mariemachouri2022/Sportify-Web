<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
 
   
 

    

    

    #[Route('/acc', name: 'app_acc', methods: ['GET'])]
    public function acc(Request $request,PostRepository $postrepository): Response
    {
       
            return $this->render('home/acc.html.twig', [
                'posts' => $postrepository->findByuserRole("PROPRIETAIRE"),
            ]);
       
        
        
    }
    #[Route('/acc/Post', name: 'app_post_acc', methods: ['GET','POST'])]
    public function accPost(Request $request,EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $content = $request->request->get('content');
        $post->setDescription($content);
        $post->setHeure(new \DateTime());
        $post->setDate(new \DateTime());
        $post->setIdUser(1);
        $role=$this->getUser()->getRole();
        $post->setUserRole($role);
        $entityManager->persist($post);
        $entityManager->flush();
        return $this->redirectToRoute('app_acc');
        
        return $this->render('home/acc.html.twig');
    }
    #[Route('/acc2/Post', name: 'app_post_acc2', methods: ['GET','POST'])]
    public function acc2Post(Request $request,EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $content = $request->request->get('content');
        $post->setDescription($content);
        $post->setHeure(new \DateTime());
        $post->setDate(new \DateTime());
        $post->setIdUser(1);
        $role=$this->getUser()->getRole();
        $post->setUserRole($role);
        $entityManager->persist($post);
        $entityManager->flush();
        return $this->redirectToRoute('app_acc2');
        
        return $this->render('home/acc2.html.twig');
    }
    #[Route('/acc2', name: 'app_acc2', methods: ['GET'])]
   public function acc2(Request $request,PostRepository $postrepository): Response
    {
        return $this->render('home/acc2.html.twig', [
            'posts' => $postrepository->findByuserRole("USER"),
        ]);
   
        
    }
}
