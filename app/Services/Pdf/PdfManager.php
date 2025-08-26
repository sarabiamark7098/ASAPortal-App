<?php

namespace App\Services\Pdf;

use Illuminate\Http\Response;

interface PdfManager
{
    /**
     * Save the PDF to a file
     */
    public function setConfig(array $config): ?self;
    /**
     * Save the PDF to a file
     */
    public function save(string $filename): ?string;

    /**
     * Get PDF Blob
     */
    public function output(): ?string;

    /**
     * Return a response with the PDF to show in the browser
     */
    public function stream(string $path): Response;

    /**
     * Make PDF using Laravel View
     */
    public function make(): PdfManager;

    /**
     * Convert laravel view blade to html
     */
    public function viewToHtml(string $view, array $data = []): PdfManager;

    public function getHtml(): ?string;

    public function setHtml(string $html): PdfManager;
}
