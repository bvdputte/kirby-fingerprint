<?php

require __DIR__ . "/src/Fingerprint.php";

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('bvdputte/fingerprint', [
    'options' => [
        'disabled' => false,
        'parameter' => false
    ],
    'components' => [
        'css' => function ($kirby, $url, $options) {
            if ($url === '@auto') {
                $url = \Kirby\Cms\Url::toTemplateAsset('css/templates', 'css');
            }
            return bvdputte\Fingerprint::addHash($url);
        },
        'js' => function ($kirby, $url, $options) {
            if ($url === '@auto') {
                $url = \Kirby\Cms\Url::toTemplateAsset('js/templates', 'js');
            }
            return bvdputte\Fingerprint::addHash($url);
        },
    ]
]);
