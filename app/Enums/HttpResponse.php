<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class HttpResponse extends Enum
{
    const SUCCESS               =   200;
    const SERVER                =   500;
    const VALIDATION            =   400;
    const UNAUTHORIZED          =   403;
    const NOT_FOUND             =   404;
}
