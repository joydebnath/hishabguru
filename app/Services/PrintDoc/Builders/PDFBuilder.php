<?php


namespace App\Services\PrintDoc\Builders;


interface PDFBuilder
{
    public function build();
    public function stream();
    public function builderHeader();
    public function buildProductsTable();
    public function buildFooter();
    public function generatePDF();
}
