<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MONTH()
 * @method static static YEAR()
 * @method static static LIFETIME()
 */
final class SubscriptionInterval extends Enum
{
    const MONTH             =   1;
    const YEAR              =   2;
    const LIFETIME          =   3;
}
