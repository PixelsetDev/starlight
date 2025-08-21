<?php

/**
 * Starlight Response.
 *
 * @author Lewis Milburn <lewis@pixelset.dev>
 * @license Apache-2.0
 * @version 2
 */

namespace Starlight\HTTP;

use JetBrains\PhpStorm\NoReturn;

class Response
{
    public function http200(): void { $this->Response('200'); }
    public function http201(): void { $this->Response('201'); }
    public function http202(): void { $this->Response('202'); }
    public function http204(): void { $this->Response('204'); }
    public function http400(): void { $this->Response('400'); }
    public function http401(): void { $this->Response('401'); }
    public function http402(): void { $this->Response('402'); }
    public function http403(): void { $this->Response('403'); }
    public function http404(): void { $this->Response('404'); }
    public function http405(): void { $this->Response('405'); }
    public function http406(): void { $this->Response('406'); }
    public function http407(): void { $this->Response('407'); }
    public function http408(): void { $this->Response('408'); }
    public function http409(): void { $this->Response('409'); }
    public function http410(): void { $this->Response('410'); }
    public function http500(): void { $this->Response('500'); }
    public function http501(): void { $this->Response('501'); }
    public function http503(): void { $this->Response('503'); }

    #[NoReturn]
    public function response($response): void
    {
        http_response_code($response);
        exit;
    }
}
