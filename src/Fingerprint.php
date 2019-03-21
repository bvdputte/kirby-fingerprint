<?php

namespace bvdputte;
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
}