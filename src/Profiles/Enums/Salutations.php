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
    case Professor = 'Professor';

    /**
     *  Return the available feminine salutations.
     *
     *  @return array
     */
    public static function FeminineSalutations(): array
    {
        return collect(Salutations::cases())
            ->filter(fn ($enum)
                => in_array($enum->name, [
                    Salutations::Dr->name,
                    Salutations::Hon->name,
                    Salutations::Miss->name,
                    Salutations::Mrs->name,
                    Salutations::Ms->name,
                    Salutations::Professor->name,
                ]))
            ->toArray();
    }

    /**
     *  Return the available masculine salutations.
     *
     *  @return array
     */
    public static function MasculineSalutations(): array
    {
        return collect(Salutations::cases())
            ->filter(fn ($enum)
                => in_array($enum->name, [
                    Salutations::Dr->name,
                    Salutations::Hon->name,
                    Salutations::Mr->name,
                    Salutations::Professor->name,
                ]))
            ->toArray();
    }

    /**
     *  Determine whether a provided salutation is feminine.
     *
     *  @param  \Enraiged\Profiles\Enums\Salutations $salutation
     *  @return bool
     */
    public static function SalutationIsFeminine(Salutations $salutation): bool
    {
        $salutations = collect(Salutations::FeminineSalutations())
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
    public static function SalutationIsMasculine(Salutations $salutation): bool
    {
        $salutations = collect(Salutations::MasculineSalutations())
            ->transform(fn ($salutation) => $salutation->name)
            ->toArray();

        return in_array($salutation->name, $salutations);
    }
}
