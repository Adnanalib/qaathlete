<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TeamMemberStatus extends Enum
{
    const INVITATION_SENT               =   1;
    const INVITATION_ACCEPTED           =   2;
}
