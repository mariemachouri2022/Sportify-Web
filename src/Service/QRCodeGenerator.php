<?php

namespace App\Service;

use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\ErrorCorrectionLevel\Low;

use Endroid\QrCode\Label\Label;
use Endroid\QrCode\QrCode;

use Endroid\QrCode\Builder\QrCodeBuilder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Component\HttpFoundation\Response;
use Endroid\QrCode\ErrorCorrectionLevel;


use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;

use Endroid\QrCode\Writer\ValidationException;
use Endroid\QrCode\Builder\Builder;
use Symfony\Component\HttpKernel\KernelInterface;


use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;

class QRCodeGenerator
{
    private $qrCodeBuilder;

    private $kernel;
    public function __construct(BuilderInterface $qrCodeBuilder,KernelInterface $kernel)
    {
        $this->qrCodeBuilder = $qrCodeBuilder;
        $this->kernel = $kernel;
    }

    
    public function generateQRCode(string $data): string
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->logoPath('images/logo.png')
            ->logoResizeToWidth(50)
            ->logoPunchoutBackground(true)
            ->labelText('This is the label')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(LabelAlignment::Center)
            ->validateResult(false)
            ->build();
    
        // Get the public directory path
        $publicDir = $this->kernel->getProjectDir() . '/public';
    
        // Save the QR code to a file in the public directory
        $qrCodeFilePath = '/qrcode.png'; // Adjust the path as needed
        $result->saveToFile($publicDir . $qrCodeFilePath);
    
        // Return the path to the generated QR code file
        return $qrCodeFilePath;
    }
}