<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeinterfaceController extends AbstractController
{

    #[Route('/InterfaceClient', name: 'app_indexAcc', methods: ['GET'])]
    public function indexAcc(): Response
    {
        return $this->render('homeInterfaces/acc.html.twig');
    }

    #[Route('/InterfaceProp', name: 'app_indexAcc2', methods: ['GET'])]
    public function indexAcc2(): Response
    {
        return $this->render('homeInterfaces/acc2.html.twig');
    }

    #[Route('/InterfaceAdmin', name: 'app_indexAdmin', methods: ['GET'])]
    public function indexAdmin(): Response
    {
        return $this->render('homeInterfaces/admin.html.twig');
    }
}