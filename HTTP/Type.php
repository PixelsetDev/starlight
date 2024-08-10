<?php

namespace Starlight\HTTP;

class Type
{
    public function json(): void {
        header("Content-type: application/json; charset=utf-8");
    }
}