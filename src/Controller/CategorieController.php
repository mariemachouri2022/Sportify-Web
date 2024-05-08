<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\FormFactoryInterface;
use Knp\Component\Pager\PaginatorInterface;
use Endroid\QrCode\Writer\Result\PngResult;
use Endroid\QrCode\Builder\BuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


#[Route('/categorie')]
class CategorieController extends AbstractController
{

    private $qrCodeBuilder;

    public function __construct(BuilderInterface $qrCodeBuilder)
    {
        $this->qrCodeBuilder = $qrCodeBuilder;
    }

    #[Route('/categorii', name: 'app_categorie_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request, CategorieRepository $categorieRepository): Response
    {
        $categoriesQuery = $categorieRepository->createQueryBuilder('c');
    
        $pagination = $paginator->paginate(
            $categoriesQuery,
            $request->query->getInt('page', 1),
            2
        );
    
        return $this->render('categorie/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
    

    #[Route('/search', name: 'app_categorie_search', methods: ['GET'])]
    public function search(Request $request, CategorieRepository $categorieRepository): Response
    {
        $searchTerm = $request->query->get('search');
        $categories = $categorieRepository->search($searchTerm);

        return $this->render('categ.html.twig', [
            'pagination' => $categories,
        ]);
    }
    #[Route('/categories', name: 'app_categories_index_paginate', methods: ['GET'])]
    public function listAction(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
{
    $categoriesQuery = $em->getRepository(Categorie::class)->createQueryBuilder('c');

    $pagination = $paginator->paginate(
        $categoriesQuery,
        $request->query->getInt('page', 1),
        2
    );

    return $this->render('categ.html.twig', ['pagination' => $pagination]);
}

    #[Route('/admin', name: 'app_categorie_index_admin', methods: ['GET'])]
    public function indexAdmin(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/indexAdmin.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/categorie/new', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $categorie = new Categorie();
    $form = $this->createForm(CategorieType::class, $categorie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile $file */
        $file = $form->get('image')->getData();
        if ($file) {
            $categorie->setImageFile($file); 
        }
    
        $entityManager->persist($categorie);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_categories_index_paginate', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('categorie/new.html.twig', [
        'categorie' => $categorie,
        'form' => $form->createView(), 
    ]);
}


   #[Route('/admin/new', name: 'app_categorie_new_admin', methods: ['GET', 'POST'])]
public function newAdmin(Request $request, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory): Response
{
    $categorie = new Categorie();
    $form = $formFactory->create(CategorieType::class, $categorie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile $file */
        $file = $form->get('image')->getData();
        if ($file) {
            $categorie->setImageFile($file); 
        }
    
        $entityManager->persist($categorie);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_categorie_index_admin', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('categorie/newAdmin.html.twig', [
        'form' => $form->createView(), 
    ]);
}


#[Route('/categorie/{IDCateg}', name: 'app_categorie_show', methods: ['GET'])]
public function show(Categorie $categorie, UrlGeneratorInterface $urlGenerator): Response
{
  
    $searchUrl = $urlGenerator->generate('app_categorie_search', [
        'name' => $categorie->getNom(),
    ], UrlGeneratorInterface::ABSOLUTE_URL);

    
    if ($this->qrCodeBuilder !== null) {
      
        $qrCodeResult = $this->qrCodeBuilder
            ->data($searchUrl) 
            ->build();

        
        $qrCodeString = $this->convertQrCodeResultToString($qrCodeResult);

        $categorie->setQrCode($qrCodeString);
    }

    return $this->render('categorie/show.html.twig', [
        'categorie' => $categorie,
    ]);
}

private function convertQrCodeResultToString(PngResult $qrCodeResult): string
{
    
    return 'data:image/png;base64,' . base64_encode($qrCodeResult->getString());
}

    #[Route('/admin/categorie/{IDCateg}', name: 'app_categorie_show_admin', methods: ['GET'])]
    public function showAdmin(Categorie $categorie): Response
    {
        return $this->render('categorie/showAdmin.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/categorie/{IDCateg}/edit', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
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
    #[Route('/admin/{IDCateg}/edit', name: 'app_categorie_edit_admin', methods: ['GET', 'POST'])]
    public function editAdmin(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/editAdmin.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/categorie/{IDCateg}/delete', name: 'app_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getIDCateg(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/{IDCateg}/delete', name: 'app_categorie_delete_admin', methods: ['POST'])]
    public function deleteAdmin(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getIDCateg(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie/indexAdmin.html.twig', [], Response::HTTP_SEE_OTHER);
    }
}