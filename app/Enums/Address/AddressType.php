<?php

namespace App\Enums\Address;

use BenSampo\Enum\Enum;

final class AddressType extends Enum
{
    const BILLING =   'billing';
    const SHIPPING =   'shipping';
    const HOME =   'home';
    const MAIN =   'main';
    const HQ = 'headquarter';
    const BRANCH = 'branch';
}
