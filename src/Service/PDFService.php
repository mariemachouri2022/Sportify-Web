<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;

class PDFService
{
    private $domPdf;

    public function __construct()
    {
        $this->domPdf = new Dompdf();

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Garamond');
        $this->domPdf->setOptions($pdfOptions);
    }

    public function generatePdfResponse($html)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();

        $output = $this->domPdf->output();

        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="details.pdf"');

        return $response;
    }

    // You can remove the generateBinaryPDF method if you don't need it
}
