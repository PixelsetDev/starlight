<?php

/**
 * Starlight XSS class.
 *
 * @author Lewis Milburn <lewis@pixelset.dev>
 * @license Apache-2.0
 * @version 1
 */

namespace Starlight\Security;

class XXS
{
    public function Escape($Text): string
    {
        return htmlspecialchars($Text);
    }
}