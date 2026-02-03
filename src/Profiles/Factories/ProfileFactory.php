<?php

namespace Enraiged\Profiles\Factories;

use Enraiged\Profiles\Enums\Genders;
use Enraiged\Profiles\Enums\Salutations;
use Enraiged\Profiles\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProfileFactory extends Factory
{
    /** @var  string  The name of the factory's corresponding model. */
    protected $model = Profile::class;

    /**
     *  Define the model's default state.
     *
     *  @return array
     */
    public function definition()
    {
        $salut = Salutations::random();

        $gender = Salutations::isFeminine($salut)
            ? Genders::Female
            : Genders::Male;

        return [
            'alias' => $this->alias(),
            'birthdate' => (mt_rand(0, 1) === 0) // 50% of the time
                ? $this->birthdate()
                : null,
            'first_name' => $this->faker->firstName(lcfirst($gender->name)),
            'last_name' => $this->faker->lastName(),
            'gender' => (mt_rand(0, 10) === 0) // 10% of the time
                ? $gender->name
                : null,
            'salut' => (mt_rand(0, 5) === 0) // 20% of the time
                ? $salut->name
                : null,
        ];
    }

    /**
     *  Derive a 'unique' alias.
     *
     *  @return string
     */
    protected function alias()
    {
        $base = (mt_rand(0, 2) === 0)
            ? ucwords($this->faker->word)
            : $this->faker->word;

        return (mt_rand(0, 2) === 0)
            ? $base.(mt_rand(0, 2) === 0 ? mt_rand(1, 255) : ucwords($this->faker->word))
            : null;
    }

    /**
     *  Derive a date of birth.
     *
     *  @return string
     */
    protected function birthdate()
    {
        return $this->faker
            ->dateTimeBetween(Carbon::now()->subYears(75), Carbon::now()->subYears(16))
            ->format('Y-m-d');
    }
}
