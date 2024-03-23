<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//here1 *********************
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends AbstractController
{
 
   
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    public function contact(StudentRepository $studentRepository): Response
    {
        return $this->render('contact.html.twig');
    }

    #[Route('/login', name: 'app_login', methods: ['GET'])]
    public function login(StudentRepository $studentRepository): Response
    {
        return $this->render('login.html.twig');
    }

    #[Route('/admin', name: 'app_admin', methods: ['GET'])]
    public function admin(StudentRepository $studentRepository): Response
    {
        return $this->render('admin.html.twig');
    }

    #[Route('/acc', name: 'app_acc', methods: ['GET'])]
    public function acc(StudentRepository $studentRepository): Response
    {
        return $this->render('acc.html.twig');
    }
    #[Route('/acc2', name: 'app_acc2', methods: ['GET'])]
    public function acc2(StudentRepository $studentRepository): Response
    {
        return $this->render('acc2.html.twig');
    }
    #[Route('/categorie', name: 'app_categorie', methods: ['GET'])]
    public function categorie(StudentRepository $studentRepository): Response
    {
        return $this->render('categorie.html.twig');
    }
    #[Route('/evenement', name: 'app_evenement', methods: ['GET'])]
    public function evenement(StudentRepository $studentRepository): Response
    {
        return $this->render('evenement.html.twig');
    }
    #[Route('/profile', name: 'app_profile', methods: ['GET'])]
    public function profile(StudentRepository $studentRepository): Response
    {
        return $this->render('profile.html.twig');
    }
    #[Route('/profile2', name: 'app_profile2', methods: ['GET'])]
    public function profile2(StudentRepository $studentRepository): Response
    {
        return $this->render('profile2.html.twig');
    }
    #[Route('/team', name: 'app_team', methods: ['GET'])]
    public function team(StudentRepository $studentRepository): Response
    {
        return $this->render('team.html.twig');
    }
    #[Route('/update', name: 'app_update', methods: ['GET'])]
    public function update(StudentRepository $studentRepository): Response
    {
        return $this->render('update.html.twig');
    }
    #[Route('/updateprofile', name: 'app_updateprofile', methods: ['GET'])]
    public function updateprofile(StudentRepository $studentRepository): Response
    {
        return $this->render('updateprofile.html.twig');
    }

//here1 *********************
    #[Route('/list', name: 'app_student_index', methods: ['GET'])]
    public function list(StudentRepository $studentRepository): Response
    {
        return $this->render('student/show.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_student_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StudentRepository $studentRepository,ManagerRegistry $manager): Response
    {
        $em = $manager->getManager();
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           // $studentRepository->save($student, true);
           $em->persist($student);
           $em->flush();

            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student/new.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_student_show', methods: ['GET'])]
    public function show(Student $student): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Student $student, StudentRepository $studentRepository,ManagerRegistry $manager): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_delete', methods: ['POST'])]
    public function delete($id,ManagerRegistry $manager,Request $request, Student $student, StudentRepository $studentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            
            $em = $manager->getManager();
        $student = $studentRepository->find($id);

        $em->remove($student);
        $em->flush();
        }

        return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
    }
}
