<?php

namespace Enraiged\Geo\Factories;

use Enraiged\Geo\Models\Address;
use Enraiged\Geo\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /** @var  string  The name of the factory's corresponding model. */
    protected $model = Address::class;

    /**
     *  Define the model's default state.
     *
     *  @return array
     */
    public function definition()
    {
        $country = Country::inRandomOrder()->first();
        $region = $country->regions()->inRandomOrder()->first();

        return [
            'country_id' => $country->id,
            'region_id' => (mt_rand(0, 1) === 0)
                ? $region->id
                : null,
        ];
    }
}
