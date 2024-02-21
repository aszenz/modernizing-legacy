<?php

namespace Gounsch;

class User
{
    private $email = null;

    public function __construct()
    {
        global $email;
        $this->email = $email;
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
}