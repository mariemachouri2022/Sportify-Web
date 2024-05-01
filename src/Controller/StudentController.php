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
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use App\Controller\EquipeController;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use App\Controller\QrCodeController;
use App\Form\SearchType;
use App\Service\QrCodeService;
use App\Controller\SearchController;

class StudentController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
   
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('acc2.html.twig');
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
    #[Route('/categories', name: 'app_categorie', methods: ['GET'])]
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
    //Categorie *********************
    #[Route('/categ', name: 'app_categorie_index', methods: ['GET'])]
    public function indexCategories(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }
    #[Route('/categorie/new', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function newCategorie(Request $request, EntityManagerInterface $entityManager): Response
   {
    $categorie = new Categorie();
    $form = $this->createForm(CategorieType::class, $categorie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($categorie);
        $entityManager->flush();

        return $this->redirectToRoute('app_categorie', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('categorie/new.html.twig', [
        'categorie' => $categorie,
        'form' => $form,
    ]);
    }
    #[Route('/categorie/{IDCateg}', name: 'app_categorie_show', methods: ['GET'])]
    public function showCategorie(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/categorie/{IDCateg}/edit', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
    public function editCategorie(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }
    #[Route('/categorie/{IDCateg}/delete', name: 'app_categorie_delete', methods: ['POST'])]
    public function deleteCategorie(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getIDCateg(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }

    //Equipe *********************
    #[Route('/equipe/new', name: 'app_equipe_new', methods: ['GET', 'POST'])]
    public function newEquipe(Request $request, EntityManagerInterface $entityManager, UtilisateurRepository $userRepository): Response
    {
        // Fetch existing users
        $users = $userRepository->findAll();
    
        // Create a new Equipe instance
        $equipe = new Equipe();
    
        // Create a form with the fetched users as choices
        $form = $this->createForm(EquipeType::class, $equipe, [
            'users' => $users,
        ]);
    
        // Handle form submission
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Associate selected users with the equipe
            foreach ($equipe->getUtilisateurs() as $utilisateur) {
                $utilisateur->setEquipe($equipe);
            }
    
            $entityManager->persist($equipe);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('equipe/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }
    
    #[Route('/equipe/{IDEquipe}', name: 'app_equipe_show', methods: ['GET'])]
    public function showEquipe(Equipe $equipe): Response
    {
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    #[Route('/equipe/{IDEquipe}/edit', name: 'app_equipe_edit', methods: ['GET', 'POST'])]
    public function editEquipe(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
    {
        // Retrieve existing users
        $existingUsers = $entityManager->getRepository(Utilisateur::class)->findAll();
    
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);
    
        // Debugging: Dump submitted form data
        dump($request->request->all());
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Debugging: Dump updated equipe entity
            dump($equipe);
    
            $entityManager->flush();
    
            return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('equipe/edit.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
            'existing_users' => $existingUsers,
        ]);
    }
    



    #[Route('/equipe/{IDEquipe}', name: 'app_equipe_delete', methods: ['POST'])]
    public function deleteEquipe(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipe->getIDEquipe(), $request->request->get('_token'))) {
            $entityManager->remove($equipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/qrcode', name: 'qrcode', methods: ['GET'])]
    public function indexQr(Request $request, QrCodeService $qrcodeService): Response
    {
        $qrCode = null;
        $form = $this->createForm(SearchType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $qrCode = $qrcodeService->qrcode($data['name']);
        }

        return $this->render('/qrcode.html.twig', [
            'form' => $form->createView(),
            'qrCode' => $qrCode
        ]);
    }
    #[Route('/search-student', name: 'search_student')]
public function searchStudent(Request $request, QRCodeGenerator $qrCodeGenerator): Response
{
    $form = $this->createForm(SearchType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData()['name'];

        // Generate QR Code
        $qrCodeResponse = $qrCodeGenerator->generateQRCode($data);

        // Redirect to Google search with the entered query
        $googleUrl = sprintf('https://www.google.com/search?q=%s', urlencode($data));

        return $this->redirect($googleUrl);
    }

    return $this->render('search/index.html.twig', [
        'form' => $form->createView(),
    ]);
}

}
