<?php

namespace Gounsch;

class User
{
    private $email = null;

    public function __construct(?string $userEmail = null)
    {
        if(null !== $userEmail) {
            $this->email = $userEmail;
        }
        else {
            global $email;
            $this->email = $email;
        }
    }

    public function getUser(): string
    {
        return explode('@', $this->email)[0];
    }

    public function isKnown(): string
    {
        $domain = explode('@', $this->email)[1];

        if (in_array($domain, KNOWN_DOMAINS)) {
            return true;
        } else {
            return false;
        }
    }

    public function getRole(): string
    {
        if ('admin' === $this->getUser() && $this->isKnown()) {
            return 'ROLE_ADMIN';
        } elseif ($this->isKnown()) {
            return 'ROLE_USER';
        } else {
            return 'ROLE_UNKNOWN';
        }
    }
}