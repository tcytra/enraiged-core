<?php

namespace Enraiged\Geo\Enums;

use Enraiged\Enums\Traits\StaticMethods;

enum TimezoneIdentifier: int
{
    use StaticMethods;

    case AFRICA = 1;
    case AMERICA = 2;
    case ANTARCTICA = 4;
    case ARCTIC = 8;
    case ASIA = 16;
    case ATLANTIC = 32;
    case AUSTRALIA = 64;
    case EUROPE = 128;
    case INDIAN = 256;
    case PACIFIC = 512;
    case UTC = 1024;
}
