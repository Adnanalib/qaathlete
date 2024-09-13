<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static USER()
 * @method static static COACH()
 * @method static static ATHLETE()
 */
final class UserType extends Enum
{
    const USER          =   1;
    const COACH         =   2;
    const ATHLETE       =   3;
}
