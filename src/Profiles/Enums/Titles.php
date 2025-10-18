<?php

namespace Enraiged\Profiles\Enums;

use Enraiged\Enums\Traits\StaticMethods;

enum Titles: string
{
    use StaticMethods;

    case Esq = 'Esq';
    case Jr = 'Jr';
    case MD = 'MD';
    case PhD = 'PhD';
}
