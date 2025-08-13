<?php

namespace App\Services\Pdf;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Mpdf\Config\ConfigVariables;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class PdfService implements PdfManager
{
    protected Mpdf $pdf;

    protected array $config = [];

    protected string $html;

    public function __construct(array $config = [])
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();

        $this->config = array_merge($defaultConfig, $config);

        $this->pdf = new Mpdf($this->config);

    }

    /** {@inheritDoc} */
    public function save(string $path): ?string
    {
        return $this->pdf->Output($path, Destination::FILE);
    }

    /** {@inheritDoc} */
    public function output(): ?string
    {
        return $this->pdf->Output('', Destination::STRING_RETURN);
    }

    /** {@inheritDoc} */
    public function stream(string $filename): Response
    {
        return response($this->pdf->Output($filename, Destination::INLINE), Response::HTTP_OK)->header('Content-Type', 'application/pdf');
    }

    /** {@inheritDoc} */
    public function make(): self
    {
        $this->pdf->WriteHTML($this->getHtml());

        return $this;
    }

    /** {@inheritDoc} */
    public function viewToHtml(string $view, array $data = []): self
    {
        $this->setHtml(View::make($view, $data)->render());

        return $this;
    }

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function setHtml(string $html): self
    {
        $this->html = $html;

        return $this;
    }
}
