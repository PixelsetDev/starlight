<?php

/**
 * Starlight XSS class.
 *
 * @author Lewis Milburn <lewis@pixelset.dev>
 * @license Apache-2.0
 * @version 1
 */

namespace Starlight\Security;

class XSS
{
    public function escape($text): string
    {
        return htmlspecialchars($text);
    }
}
