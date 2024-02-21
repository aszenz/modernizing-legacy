<?php

namespace Gounsch\Test;

use Gounsch\Role;
use Gounsch\User;
use PHPUnit\Framework\TestCase;

class CharacterizationTest extends TestCase
{
    public function test_getUser_returns_username() 
    {
        global $email;
        $email = 'greatuser@example.com';
        $user = new User();
        self::assertEquals('greatuser', $user->getUser());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_User_isKnown_returns_1_for_known_domains() 
    {
        define('KNOWN_DOMAINS', ['example.com']);
        global $email;
        $email = 'greatuser@example.com';
        $user = new User();
        self::assertEquals('1', $user->isKnown());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_User_isKnown_returns_empty_for_unknown_domains() 
    {
        define('KNOWN_DOMAINS', ['example.com']);
        global $email;
        $email = 'greatuser@foo.com';
        $user = new User();
        self::assertEquals('', $user->isKnown());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_Role_role_returns_admin_for_admin_user() 
    {
        define('KNOWN_DOMAINS', ['example.com']);
        global $email;
        $email = 'admin@example.com';
        self::assertEquals('ROLE_ADMIN', Role::getRole());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_Role_role_returns_user_for_other_user() 
    {
        define('KNOWN_DOMAINS', ['example.com']);
        global $email;
        $email = 'foo@example.com';
        self::assertEquals('ROLE_USER', Role::getRole());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_Role_role_returns_unknown_for_not_known_user() 
    {
        define('KNOWN_DOMAINS', ['example.com']);
        global $email;
        $email = 'foo@bar.com';
        self::assertEquals('ROLE_UNKNOWN', Role::getRole());
    }

}