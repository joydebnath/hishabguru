<?php

namespace App\Services\Setting;

use Exception;

class BusinessSettingFactory
{
    public static function getFactory($type): SettingUpdatable
    {
        if ($type === 'business-details') {
            return new BusinessDetails();
        } elseif ($type === 'contact-details') {
            return new ContactDetails();
        } elseif ($type === 'operation-details') {
            return new OperationDetails();
        } elseif ($type === 'business-logo') {
            return new BusinessLogo();
        }
        throw new Exception('Unsupported Type: ' . $type);
    }
}
