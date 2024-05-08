<?php

namespace App\Controller;

use App\Entity\Equipe;
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
use Dompdf\Dompdf;
use Dompdf\Options;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class AdminController extends AbstractController
{

    #[Route('/ExportPdf', name: 'app_user_pdf', methods: ['GET', 'POST'])]
    public function ExportPdf(UtilisateursRepository $utilisateurRepository) :Response
    {
          $users=$utilisateurRepository->findAll();
          $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $html = $this->renderView('admin/pdf.html.twig', [
           
            'users' => $users,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
 
    #[Route('/admin', name: 'app_admin', methods: ['GET','POST'])]
    public function index(UtilisateursRepository $utilisateursRepository, Request $request,EntityManagerInterface $entityManager): Response
    {
        $search = $request->query->get('search');
        $qb = $utilisateursRepository->createQueryBuilder('u');
        if ($search) {
            $query = $entityManager->createQuery(
                'SELECT u FROM App\Entity\Utilisateurs u WHERE lower(u.nom) LIKE :searchTerm OR lower(u.prenom) LIKE :searchTerm OR lower(u.email) LIKE :searchTerm'
            )->setParameter('searchTerm', '%'.$search.'%');
    
            $utilisateurs = $query->getResult();
        }
        else{
            $utilisateurs=$utilisateursRepository->findAll();
        }
        return $this->render('admin/admin.html.twig', [
            'utilisateurs' => $utilisateurs,
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
