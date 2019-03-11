<?php

namespace bvdputte;
use Kirby\Cms\App;
use Kirby\Cms\Url;

class Fingerprint
{
    public static function addHash($path)
    {
        if ( ! file_exists($path) || count($pathinfo = pathinfo($path)) < 4) {
            return $path;
        }
    
        $basename = $pathinfo['filename'] . '.' . md5_file($path) . '.' . $pathinfo['extension'];
    
        if ($pathinfo['dirname'] === '.') {
            return $filename;
        }
    
        return $pathinfo['dirname'] . DS . $basename;
    }

    private static function toTemplateAsset(string $assetPath, string $extension)
    {
        $kirby = App::instance();
        $page  = $kirby->site()->page();
        $path  = $assetPath . '/' . $page->template() . '.' . $extension;
        $file  = $kirby->root('assets') . '/' . $path;

        return file_exists($file) === true ? $file : null;
    }

    // Re-write the `css()`-helper
    // kirby/config/helpers.php
    public static function css($url, $options = null)
    {
        if (is_array($url) === true) {
            $links = array_map(function ($url) use ($options) {
                return self::css($url, $options);
            }, $url);
            return implode(PHP_EOL, $links);
        }

        if (is_string($options) === true) {
            $options = ['media' => $options];
        }

        $kirby = App::instance();

        if ($component = $kirby->component('css')) {
            $url = $component($kirby, $url, $options);
        }

        if ($url === '@auto') {
            if (!$url = self::toTemplateAsset('css/templates', 'css')) {
                return null;
            }
        }

        $url  = Url::to(self::addHash($url));
        $attr = array_merge((array)$options, [
            'href' => $url,
            'rel'  => 'stylesheet'
        ]);

        return '<link ' . attr($attr) . '>';
    }

    // Re-write the `js()`-helper
    // kirby/config/helpers.php
    public static function js($url, $options = null)
    {
        if (is_array($url) === true) {
            $scripts = array_map(function ($url) use ($options) {
                return self::js($url, $options);
            }, $url);
            return implode(PHP_EOL, $scripts);
        }

        if (is_bool($options) === true) {
            $options = ['async' => $options];
        }

        $kirby = App::instance();

        if ($component = $kirby->component('js')) {
            $url = $component($kirby, $url, $options);
        }

        if ($url === '@auto') {
            if (!$url = self::toTemplateAsset('js/templates', 'js')) {
                return null;
            }
        }

        $url  = Url::to(self::addHash($url));
        $attr = array_merge((array)$options, ['src' => $url]);

        return '<script ' . attr($attr) . '></script>';
    }
}