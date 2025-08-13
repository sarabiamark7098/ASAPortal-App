<?php

namespace Tests\Unit;

use App\Services\Pdf\PdfManager;
use App\Services\Pdf\PdfService;
use Tests\TestCase;

class PdfServiceTest extends TestCase
{
    private PdfManager $pdfService;

    protected function setUp(): void
    {
        $this->pdfService = new PdfService();
    }

    public function test_it_can_create_write_html_to_pdf(): void
    {
        $this->pdfService->setHtml(fake()->randomHtml());
        $pdf = $this->pdfService->make();
        $this->assertInstanceOf(PdfService::class, $pdf);
    }

    public function test_it_can_create_save_pdf(): void
    {
        $filename = 'sample-test.pdf';
        $this->pdfService->setHtml(fake()->randomHtml());
        $this->pdfService->make()->save($filename);

        $this->assertFileExists($filename);
        unlink($filename);
    }
}
