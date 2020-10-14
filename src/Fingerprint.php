<?php

namespace bvdputte;
use Kirby\Cms\App;
use Kirby\Http\Url;

class Fingerprint
{
    public static function addHash($path)
    {
        if (Url::isAbsolute($path)) {
            $path = Url::path($path);
        }

        if ( ! file_exists($path) || count($pathinfo = pathinfo($path)) < 4) {
            return $path;
        }

        if(option('bvdputte.fingerprint.disabled')) {
            $basename = $pathinfo['filename'] . '.' . $pathinfo['extension'];
        } else {
            if(option('bvdputte.fingerprint.parameter')) {
                $basename = $pathinfo['filename'] . '.' . $pathinfo['extension'] . '?v=' . md5_file($path);
            } else {
                $basename = $pathinfo['filename'] . '.' .  md5_file($path) . '.' . $pathinfo['extension'];
            }
        }

        if ($pathinfo['dirname'] === '.') {
            return $filename;
        }

        return $pathinfo['dirname'] . DS . $basename;
    }
}
