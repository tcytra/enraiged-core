<?php

namespace Enraiged\Profiles\Enums;

use Enraiged\Enums\Traits\StaticMethods;

enum Salutations: string
{
    use StaticMethods;

    case Dr = 'Doctor';
    case Hon = 'Honorable';
    case Miss = 'Miss';
    case Mr = 'Mr';
    case Mrs = 'Mrs';
    case Ms = 'Ms';
    case Prof = 'Professor';

    /**
     *  Return the available feminine salutations.
     *
     *  @return array
     */
    public static function feminine(): array
    {
        return collect(Salutations::cases())
            ->filter(fn ($enum)
                => in_array($enum->name, [
                    Salutations::Dr->name,
                    Salutations::Hon->name,
                    Salutations::Miss->name,
                    Salutations::Mrs->name,
                    Salutations::Ms->name,
                    Salutations::Prof->name,
                ]))
            ->toArray();
    }

    /**
     *  Return the available masculine salutations.
     *
     *  @return array
     */
    public static function masculine(): array
    {
        return collect(Salutations::cases())
            ->filter(fn ($enum)
                => in_array($enum->name, [
                    Salutations::Dr->name,
                    Salutations::Hon->name,
                    Salutations::Mr->name,
                    Salutations::Prof->name,
                ]))
            ->toArray();
    }

    /**
     *  Determine whether a provided salutation is feminine.
     *
     *  @param  \Enraiged\Profiles\Enums\Salutations $salutation
     *  @return bool
     */
    public static function isFeminine(Salutations $salutation): bool
    {
        $salutations = collect(Salutations::Feminine())
            ->transform(fn ($salutation) => $salutation->name)
            ->toArray();

        return in_array($salutation->name, $salutations);
    }

    /**
     *  Determine whether a provided salutation is feminine.
     *
     *  @param  \Enraiged\Profiles\Enums\Salutations $salutation
     *  @return bool
     */
    public static function isMasculine(Salutations $salutation): bool
    {
        $salutations = collect(Salutations::Masculine())
            ->transform(fn ($salutation) => $salutation->name)
            ->toArray();

        return in_array($salutation->name, $salutations);
    }
}
