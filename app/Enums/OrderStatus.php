<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const PENDING           =   1;
    const IN_REVIEW         =   2;
    const COMPLETE          =   3;
}
