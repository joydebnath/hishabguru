<?php

namespace App\Services\ImportData;

class ImportService
{
    public static function getImportFactory($type): Importable
    {
        switch ($type) {
            case 'clients':
                return new StoreClient;
            case 'suppliers':
                return new StoreSupplier;
            case 'products':
                return new StoreProduct;
            default:
                throw new \Exception('Unsupported import type: ' . $type);
        }
    }
}
