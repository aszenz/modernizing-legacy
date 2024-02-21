<?php

namespace Gounsch;

class Role
{

    /**
     * @deprecated Use $user->getRole()
     */
    public static function getRole(?User $user = new User()): string
    {
        return $user->getRole();
    }
}
