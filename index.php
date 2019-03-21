<?php

require __DIR__ . DS . "src" . DS . "Fingerprint.php";

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('bvdputte/fingerprint', [
    'components' => [
        'css' => function ($kirby, $url, $options) {
            return bvdputte\Fingerprint::addHash($url);
        },
        'js' => function ($kirby, $url, $options) {
            return bvdputte\Fingerprint::addHash($url);
        },
    ]
]);