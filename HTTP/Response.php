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
    public function HTTP200(): void { $this->Response('200'); }
    public function HTTP201(): void { $this->Response('201'); }
    public function HTTP202(): void { $this->Response('202'); }
    public function HTTP400(): void { $this->Response('400'); }
    public function HTTP401(): void { $this->Response('401'); }
    public function HTTP402(): void { $this->Response('402'); }
    public function HTTP403(): void { $this->Response('403'); }
    public function HTTP404(): void { $this->Response('404'); }
    public function HTTP405(): void { $this->Response('405'); }
    public function HTTP406(): void { $this->Response('406'); }
    public function HTTP407(): void { $this->Response('407'); }
    public function HTTP408(): void { $this->Response('408'); }
    public function HTTP409(): void { $this->Response('409'); }
    public function HTTP410(): void { $this->Response('410'); }
    public function HTTP500(): void { $this->Response('500'); }
    public function HTTP501(): void { $this->Response('501'); }
    public function HTTP503(): void { $this->Response('503'); }
    public function JsonResponse(): void {
        header("Content-type: application/json; charset=utf-8");
    }

    public function Response($response): void
    {
        http_response_code($response);
        exit;
    }
}
