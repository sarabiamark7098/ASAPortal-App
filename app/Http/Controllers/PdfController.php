<?php

namespace App\Http\Controllers;

use App\Models\VehicleRequest;
use App\Services\Pdf\PdfManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    private PdfManager $pdfManager;

    public function __construct(PdfManager $pdfManager)
    {
        $this->pdfManager = $pdfManager;
    }

    public function vehicleRequest(string|int $id): Response
    {
        $data = VehicleRequest::with(['vehicleAssignment'])->findOrFail($id)->toArray();
        $filename = 'vehicle-request.pdf';
        // dd($data);
        $config = [
            'format' => [216, 330],
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.vehicle-request', $data)->make()->stream($filename);
    }
    public function travelOrder(string|int $id, string $pageSize = 'A4'): Response
    {
        $data = VehicleRequest::with(['vehicleAssignment'])->findOrFail($id)->toArray();
        $filename = 'travel-order.pdf';

        $config = [
            'format' => 'A4',
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.travel-order', $data)->make()->stream($filename);
    }

    public function vehicleCNAS(string|int $id): Response
    {
        $data = VehicleRequest::findOrFail($id)->toArray();
        $filename = 'vehicle-cnas.pdf';

        $config = [
            'format' => 'A4',
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.vehicle-cnas', $data)->make()->stream($filename);
    }
}
