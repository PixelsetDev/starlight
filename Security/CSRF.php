<?php

/**
 * Starlight Cross-site request forgery class.
 *
 * @author Lewis Milburn <lewis@pixelset.dev>
 * @license Apache-2.0
 * @version 1
 */

namespace Starlight\Security;

class CSRF
{
    public function set(): string
    {
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(50));
        }
        return '<input type="hidden" name="csrf" value="'.$_SESSION['csrf'].'">';
    }

    public function check(): bool
    {
        if (!isset($_SESSION['csrf']) || !isset($_POST['csrf'])) {
            return false;
        }
        if ($_SESSION['csrf'] != $_POST['csrf']) {
            return false;
        }

        return true;
    }
}