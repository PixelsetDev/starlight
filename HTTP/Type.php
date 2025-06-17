<?php

namespace Starlight\HTTP;

class Type
{
    public function json(): void {
        header("Content-type: application/json; charset=utf-8");
    }
    
    public function csv(): void {
        header("Content-type: text/csv; charset=utf-8");
    }
}
