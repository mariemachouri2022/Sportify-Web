<?php

namespace App\Controller;



use App\Entity\Utilisateurs;
use App\Form\UtilisateursType;
use App\Repository\UtilisateursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
 
    #[Route('/admin', name: 'app_admin', methods: ['GET'])]
    public function index(UtilisateursRepository $utilisateursRepository): Response
    {
        return $this->render('admin/admin.html.twig', [
            'utilisateurs' => $utilisateursRepository->findAll(),
        ]);
    }
 

    

    

}
