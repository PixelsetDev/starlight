<?php

namespace Starlight\Authentication;

class Session
{
    public function start(): void
    {
        session_start();
    }

    public function login(String $uniqueValue): void
    {
        $_SESSION['starlight_token'] = password_hash($uniqueValue, PASSWORD_BCRYPT);
    }

    public function verify(String $uniqueValue): bool
    {
        return password_verify($uniqueValue, $_SESSION['starlight_token']);
    }

    public function end(String $uniqueValue): void
    {
        unset($_SESSION[$uniqueValue]);
        unset($_SESSION['starlight_token']);
        session_unset();
        session_destroy();
    }
}