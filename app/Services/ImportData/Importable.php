<?php


namespace App\Services\ImportData;


interface Importable
{
    public function import($records);
}
