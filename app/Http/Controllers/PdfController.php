<?php

namespace App\Http\Controllers;

use App\Models\AirTransportRequest;
use App\Models\AssistanceRequest;
use App\Models\ConferenceRequest;
use App\Models\EntryRequest;
use App\Models\VehicleRequest;
use App\Models\JanitorialRequest;
use App\Models\OvernightParkingRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\Pdf\PdfManager;
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

    public function vehicleCnas(string|int $id): Response
    {
        $data = VehicleRequest::findOrFail($id)->toArray();
        $filename = 'vehicle-cnas.pdf';

        $config = [
            'format' => 'A4',
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.vehicle-cnas', $data)->make()->stream($filename);
    }

    public function conferenceRequest(string|int $id): Response
    {
        $data = ConferenceRequest::findOrFail($id)->toArray();
        $filename = 'conference-request.pdf';

        $config = [
            'format' => 'A4',
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.conference-request', $data)->make()->stream($filename);
    }
    public function conferenceCnas(string|int $id): Response
    {
        $data = ConferenceRequest::findOrFail($id)->toArray();
        $filename = 'conference-cnas.pdf';

        $config = [
            'format' => 'A4',
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.conference-cnas', $data)->make()->stream($filename);
    }
    public function technicalAssistanceRequest(string|int $id): Response
    {
        $data = AssistanceRequest::findOrFail($id)->toArray();
        $filename = 'technical-assistance-request.pdf';

        $config = [
            'format' => 'A4',
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.technical-assistance-request', $data)->make()->stream($filename);
    }

    public function overnightParkingRequest(string|int $id): Response
    {
        $data = OvernightParkingRequest::findOrFail($id)->toArray();
        $filename = 'overnight-parking-request.pdf';

        $config = [
            'format' => 'A4',
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.overnight-parking-request', $data)->make()->stream($filename);
    }

    public function janitorialServicesRequest(string|int $id): Response
    {
        $data = JanitorialRequest::findOrFail($id)->toArray();
        $filename = 'janitorial-request.pdf';

        $config = [
            'format' => 'A4',
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.janitorial-request', $data)->make()->stream($filename);
    }
    public function airTransportRequest(string|int $id): Response
    {
        $data = AirTransportRequest::findOrFail($id)->toArray();
        $filename = 'janitorial-request.pdf';

        $config = [
            'format' => 'A4',
            'orientation' => 'L'
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.air-transport-request', $data)->make()->stream($filename);
    }
    public function entryRequest(string|int $id): Response
    {
        $data = EntryRequest::findOrFail($id)->toArray();
        $filename = 'entry-request.pdf';

        $config = [
            'format' => 'A4',
        ];

        return $this->pdfManager->setConfig($config)->viewToHtml('pdf.entry-request', $data)->make()->stream($filename);
    }
}
