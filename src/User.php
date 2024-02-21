<?php

namespace Gounsch;

class User
{
    private $email = null;
    private $knownDomains = null;

    public function __construct(
        ?string $userEmail = null,
        ?array $knownDomains = null
    )
    {
        if(null !== $userEmail) {
            $this->email = $userEmail;
        }
        else {
            global $email;
            $this->email = $email;
        }
        // NOTE: DIDN't assign constant here, because it maybe undefined at this point in time 
        // and could break old code that initialized user and later defined KNOWN_DOMAINS when calling isKnown() function
        $this->knownDomains = $knownDomains;
    }

    public function getUser(): string
    {
        return explode('@', $this->email)[0];
    }

    public function isKnown(): string
    {
        $domain = explode('@', $this->email)[1];

        if (in_array($domain, $this->knownDomains ?? KNOWN_DOMAINS)) {
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