<?php

/**
 * Starlight Response.
 *
 * @author Lewis Milburn <lewis@pixelset.dev>
 * @license Apache-2.0
 * @version 1
 */

namespace Starlight\HTTP;

class Response
{
    public function HTTP200() { $this->Response('200'); }
    public function HTTP201() { $this->Response('201'); }
    public function HTTP202() { $this->Response('202'); }
    public function HTTP400() { $this->Response('400'); }
    public function HTTP401() { $this->Response('401'); }
    public function HTTP402() { $this->Response('402'); }
    public function HTTP403() { $this->Response('403'); }
    public function HTTP404() { $this->Response('404'); }
    public function HTTP405() { $this->Response('405'); }
    public function HTTP406() { $this->Response('406'); }
    public function HTTP407() { $this->Response('407'); }
    public function HTTP408() { $this->Response('408'); }
    public function HTTP409() { $this->Response('409'); }
    public function HTTP410() { $this->Response('410'); }
    public function HTTP500() { $this->Response('500'); }
    public function HTTP501() { $this->Response('501'); }
    public function HTTP503() { $this->Response('503'); }

    public function Response($code): void
    {
        http_response_code($code);
        exit;
    }
}