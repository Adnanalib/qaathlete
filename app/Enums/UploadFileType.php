<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Image()
 * @method static static File()
 */
final class UploadFileType extends Enum
{
    const Image = 0;
    const File =  1;
}
