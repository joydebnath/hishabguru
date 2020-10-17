<?php

namespace App\Services\Setting;

use Exception;

class ProfileSettingFactory
{
    public static function getFactory($type): SettingUpdatable
    {
        if ($type === 'personal-details') {
            return new PersonalDetails();
        } elseif ($type === 'contact-details') {
            return new PersonalContactDetails();
        }
        throw new Exception('Unsupported Type: ' . $type);
    }
}
