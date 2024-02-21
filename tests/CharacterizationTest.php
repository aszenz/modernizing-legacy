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
        $email = 'admin@example.com';
        $user = new User($email);
        self::assertEquals('ROLE_ADMIN', $user->getRole());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_Role_role_returns_user_for_other_user() 
    {
        define('KNOWN_DOMAINS', ['example.com']);
        $email = 'foo@example.com';
        $user = new User($email);
        self::assertEquals('ROLE_USER', $user->getRole());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_Role_role_returns_unknown_for_not_known_user() 
    {
        define('KNOWN_DOMAINS', ['example.com']);
        $email = 'foo@bar.com';
        $user = new User($email);
        self::assertEquals('ROLE_UNKNOWN', $user->getRole());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_User_domain_for_user_without_global_constant() 
    {
        $email = 'foo@bar.com';
        $user = new User($email, ['bar.com']);
        self::assertEquals('ROLE_USER', $user->getRole());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_User_domain_for_admin_without_global_constant() 
    {
        $email = 'admin@bar.com';
        $user = new User($email, ['bar.com']);
        self::assertEquals('ROLE_ADMIN', $user->getRole());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_User_domain_for_uknown_without_global_constant() 
    {
        $email = 'admin@bar.com';
        $user = new User($email, ['zar.com']);
        self::assertEquals('ROLE_UNKNOWN', $user->getRole());
    }
}