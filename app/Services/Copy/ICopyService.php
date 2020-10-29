<?php


namespace App\Services\Copy;


interface ICopyService
{
    public function store($type, $copyFrom, $userId);
}
