<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ACTIVE()
 * @method static static INACTIVE()
 */
final class SubscriptionStatus extends Enum
{
    const ACTIVE            =   1;
    const INACTIVE          =   2;
}