<?php

namespace Enraiged\Profiles\Enums;

use Enraiged\Enums\Traits\StaticMethods;

enum Genders: string
{
    use StaticMethods;

    case Female = 'Female';
    case Male = 'Male';
}
