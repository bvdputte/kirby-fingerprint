<?php

require __DIR__ . DS . "src" . DS . "Fingerprint.php";

Kirby::plugin('bvdputte/fingerprint', [
    'fileMethods' => [
        'fingerprint' => function () {
            return bvdputte\Fingerprint::addHash($this->root());
        }
    ]
]);

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
if (! function_exists("fingerprint")) {
    function fingerprint($path)
    {
        return bvdputte\Fingerprint::addHash($path);
    }
}