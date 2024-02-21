<?php

namespace Gounsch;

class Role
{

    private function role(?User $user = new User()): string
    {
        if ('admin' === $user->getUser() && $user->isKnown()) {
            return 'ROLE_ADMIN';
        } elseif ($user->isKnown()) {
            return 'ROLE_USER';
        } else {
            return 'ROLE_UNKNOWN';
        }
    }

    public static function __callStatic(string $name, array $arguments): mixed
    {
        $self = new self();

        $method = lcfirst(str_replace('get', '', $name));

        return $self->{$method}(...$arguments);
    }
}
