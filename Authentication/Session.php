<?php

namespace Starlight\Session;

class Session
{
    public function Start(): void
    {
        session_start();
    }

    public function Login(String $uniqueValue): void
    {
        $_SESSION['starlight_token'] = password_hash($uniqueValue, PASSWORD_BCRYPT);
    }

    public function Verify(String $uniqueValue): bool
    {
        return password_verify($uniqueValue, $_SESSION['starlight_token']);
    }

    public function End(String $uniqueValue): void
    {
        unset($_SESSION[$uniqueValue]);
        unset($_SESSION['starlight_token']);
        session_unset();
        session_destroy();
    }
}