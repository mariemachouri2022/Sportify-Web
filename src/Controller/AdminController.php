<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\UtilisateursType;
use App\Repository\PostRepository;
use App\Form\RoleType;
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
    #[Route('/posts', name: 'app_posts', methods: ['GET'])]
    public function indexPosts(PostRepository $repo): Response
    {
        return $this->render('admin/posts.html.twig', [
            'posts' => $repo->findAll(),
        ]);
    }

    #[Route('/{id}/confirmRole', name: 'confirm_role', methods: ['GET', 'POST'])]
    public function ConfirmRole(Request $request, Utilisateurs $user,EntityManagerInterface $entityManager): Response
    {
      
        $form = $this->createForm(RoleType::class);
        $form->handleRequest($request);
       

        return $this->renderForm('admin/RoleEdit.html.twig', [
            
            'user' => $user,
            'form' => $form,
        ]);

    }

    #[Route('/{id}/AssignRole/DB', name: 'assign_role', methods: ['GET', 'POST'])]
    public function AssignRole(Request $request, Utilisateurs $user, EntityManagerInterface $entityManager): Response
    {
        $role=$request->request->get('role');
        $user->setRole($role);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    } 

}
