<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;



class FunctionavancéeController extends AbstractController
{
    #[Route('/functionavance', name: 'app_functionavanc_e')]
    public function index(): Response
    {
        return $this->render('functionavancée/index.html.twig', [
            'controller_name' => 'FunctionavancéeController',
        ]);
    }




    #[Route('/export-csv', name: 'app_reservation_export_csv', methods: ['GET'])]
    public function exportCsv(ReservationRepository $reservationRepository, Filesystem $filesystem, SerializerInterface $serializer): Response
    {
        $reservations = $reservationRepository->findAll();

        // Normalize the data using Symfony Serializer
        $data = $serializer->normalize($reservations);

        // Write data to CSV file
        $filePath = 'export_reservations.csv';
        $filesystem->dumpFile($filePath, $serializer->encode($data, 'csv'));

        // Return the CSV file as a response
        return $this->file($filePath, 'export_reservations.csv');
    }
    #[Route("/stats", name: "stats")]
    public function statistiques(TerrainRepository $terrainRepo): Response {
        $count200 = $terrainRepo->createQueryBuilder('t')
            ->select('count(t.id_Terrain)')
            ->where('t.prix = :price')
            ->setParameter('price', 200.00)
            ->getQuery()
            ->getSingleScalarResult();

        $count110 = $terrainRepo->createQueryBuilder('t')
            ->select('count(t.id_Terrain)')
            ->where('t.prix = :price')
            ->setParameter('price', 110.00)
            ->getQuery()
            ->getSingleScalarResult();

        $count100 = $terrainRepo->createQueryBuilder('t')
            ->select('count(t.id_Terrain)')
            ->where('t.prix = :price')
            ->setParameter('price', 100.00)
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('stats/stats.html.twig', [
            'count200' => $count200,
            'count110' => $count110,
            'count100' => $count100
        ]);
    }



    
}
