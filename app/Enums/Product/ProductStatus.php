<?php

namespace App\Enums\Product;

use BenSampo\Enum\Enum;

final class ProductStatus extends Enum
{
    const ACTIVE =   'active';
    const INACTIVE =   'inactive';
    const DISCONTINUED=   'discontinued';
    const OUTOFSTOCK = 'out-of-stock';
}
