<?php

namespace App\Controller;

use App\Entity\Arbitre;
use App\Form\ArbitreType;
use App\Repository\ArbitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


#[Route('/admin/arbitre')]
class ArbitreController extends AbstractController
{
    #[Route('/', name: 'app_arbitre_index', methods: ['GET'])]
    public function index(ArbitreRepository $arbitreRepository): Response
    {
        return $this->render('arbitre/index.html.twig', [
            'arbitres' => $arbitreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_arbitre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $arbitre = new Arbitre();
        $form = $this->createForm(ArbitreType::class, $arbitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($arbitre);
            $entityManager->flush();

            return $this->redirectToRoute('app_arbitre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('arbitre/new.html.twig', [
            'arbitre' => $arbitre,
            'form' => $form,
        ]);
    }

    #[Route('/{idArbitre}', name: 'app_arbitre_show', methods: ['GET'])]
    public function show(Arbitre $arbitre): Response
    {
        return $this->render('arbitre/show.html.twig', [
            'arbitre' => $arbitre,
        ]);
    }

    #[Route('/{idArbitre}/edit', name: 'app_arbitre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Arbitre $arbitre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArbitreType::class, $arbitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_arbitre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('arbitre/edit.html.twig', [
            'arbitre' => $arbitre,
            'form' => $form,
        ]);
    }

    #[Route('/{idArbitre}', name: 'app_arbitre_delete', methods: ['POST'])]
    public function delete(Request $request, Arbitre $arbitre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$arbitre->getIdArbitre(), $request->request->get('_token'))) {
            $entityManager->remove($arbitre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_arbitre_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/arbitres/export', name: 'export_arbitres_excel')]
public function exportArbitresExcel(ArbitreRepository $arbitreRepository): Response
{
    // Récupérer la liste des arbitres depuis la base de données
    $arbitres = $arbitreRepository->findAll();

    // Créer un nouveau Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Ajouter les en-têtes
    $headers = ['Nom', 'Prénom', 'Email', 'Téléphone'];
    $rowIndex = 1;

    foreach ($headers as $index => $header) {
        // Vous pouvez utiliser la fonction chr() pour convertir un index en lettre de colonne
        $column = chr(65 + $index); // A = 65, B = 66, etc.
    
        // Utilisez la lettre de colonne calculée et le numéro de ligne actuel pour affecter la valeur de l'en-tête
        $sheet->setCellValue($column . $rowIndex, $header);
    }

    // Ajouter les données des arbitres
    $rowIndex = 2;
    foreach ($arbitres as $arbitre) {
        $sheet->setCellValue('A' . $rowIndex, $arbitre->getNom());
        $sheet->setCellValue('B' . $rowIndex, $arbitre->getPrenom());
        $sheet->setCellValue('C' . $rowIndex, $arbitre->getEmail());
        $sheet->setCellValue('D' . $rowIndex, $arbitre->getPhone());
        $rowIndex++;
    }

    // Sauvegarder le fichier Excel
    $excelFilename = 'arbitres_export.xlsx';
    $excelFilePath = $this->getParameter('kernel.project_dir') . '/public/' . $excelFilename;
    $writer = new Xlsx($spreadsheet);
    $writer->save($excelFilePath);

    // Retourner le fichier Excel en tant que réponse
    return new BinaryFileResponse($excelFilePath);
}

    
}
