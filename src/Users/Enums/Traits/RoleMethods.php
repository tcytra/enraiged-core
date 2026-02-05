<?php

namespace Enraiged\Users\Enums\Traits;

trait RoleMethods
{
    /**
     *  Return the expanded attributes of a role.
     *
     *  @param  Roles   $role
     *  @param  int     $rank
     *  @return array
     */
    private function attributes($role, $rank): array
    {
        return [
            'id' => $rank,
            'name' => $role->name,
            'rank' => $rank,
            'value' => $role->value,
        ];
    }

    /**
     *  Determine if this role is greater than or equal to a provided role.
     *
     *  @param  \Enraiged\Users\Enums\Roles  $role
     *  @return bool
     */
    public function atLeast($role): bool
    {
        return $this->role()->rank <= $role->role()->rank;
    }

    /**
     *  Find and return a role by id, if possible.
     *
     *  @param  int     $search
     *  @return self
     */
    public static function find($search): self
    {
        foreach (self::cases() as $each) {
            $role = $each->role();

            if ((preg_match('/^\d+$/', $search) && $role->id == $search)
                || (gettype($search) === 'string' && $role->name == $search)) {
                return $each;
            }
        }

        return null;
    }

    /**
     *  Return an array of role ids.
     *
     *  @return array
     */
    public static function ids(): array
    {
        return collect(self::options())
            ->transform(fn ($option) => $option['id'])
            ->values()
            ->toArray();
    }

    /**
     *  Determine if this role matches a provided role.
     *
     *  @param  \Enraiged\Users\Enums\Role  $role
     *  @return bool
     */
    public function is($role): bool
    {
        return $this === $role;
    }

    /**
     *  Determine if this role does not match a provided role.
     *
     *  @param  \Enraiged\Users\Enums\Role  $role
     *  @return bool
     */
    public function isNot($role): bool
    {
        return $this !== $role;
    }

    /**
     *  Return the lowest ranked role.
     *
     *  @return self
     */
    public static function lowest()
    {
        $role = (object) collect(self::options())->last();

        return self::{$role->name};
    }
}
