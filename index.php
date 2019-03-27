<?php

require __DIR__ . DS . "src" . DS . "Fingerprint.php";

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('bvdputte/fingerprint', [
    'options' => [
        'disabled' => false
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

// Custom helper functions only needed until https://github.com/getkirby/kirby/issues/1608 is fixed.
// Almost identical to core Kirby css() and js(), but we first check for template specific assets
// and then run the custom css and js component
function fingerprint_css($url, $options = null) {
    if (is_array($url) === true) {
        $links = array_map(function ($url) use ($options) {
            return fingerprint_css($url, $options);
        }, $url);

        return implode(PHP_EOL, $links);
    }

    if (is_string($options) === true) {
        $options = ['media' => $options];
    }

    $kirby = \Kirby\Cms\App::instance();

    if ($url === '@auto') {
        if (!$url = \Kirby\Cms\Url::toTemplateAsset('css/templates', 'css')) {
            return null;
        }
    }

    if ($component = $kirby->component('css')) {
        $url = $component($kirby, $url, $options);
    }

    $url  = \Kirby\Cms\Url::to($url);
    $attr = array_merge((array)$options, [
        'href' => $url,
        'rel'  => 'stylesheet'
    ]);

    return '<link ' . attr($attr) . '>';
}

function fingerprint_js($url, $options = null) {
    if (is_array($url) === true) {
        $scripts = array_map(function ($url) use ($options) {
            return fingerprint_js($url, $options);
        }, $url);

        return implode(PHP_EOL, $scripts);
    }

    if (is_bool($options) === true) {
        $options = ['async' => $options];
    }

    $kirby = \Kirby\Cms\App::instance();

    if ($url === '@auto') {
        if (!$url = \Kirby\Cms\Url::toTemplateAsset('js/templates', 'js')) {
            return null;
        }
    }

    if ($component = $kirby->component('js')) {
        $url = $component($kirby, $url, $options);
    }

    $url  = \Kirby\Cms\Url::to($url);
    $attr = array_merge((array)$options, ['src' => $url]);

    return '<script ' . attr($attr) . '></script>';
}