<?php

namespace Starlight\HTTP;

class HTTPS
{
    public function RedirectToHTTPS() {
        if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")
        {
            header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
            exit;
        }
    }
}