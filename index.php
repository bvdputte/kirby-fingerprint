<?php

require __DIR__ . DS . "src" . DS . "Fingerprint.php";

/*
    A little Kirby helper functions
*/
if (! function_exists("cssfingerprint")) {
    function cssfingerprint($url, $options = null)
    {
        return bvdputte\Fingerprint::css($url, $options = null);
    }
}
if (! function_exists("jsfingerprint")) {
    function jsfingerprint($url, $options = null)
    {
        return bvdputte\Fingerprint::js($url, $options = null);
    }
}