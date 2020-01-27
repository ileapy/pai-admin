<?php


namespace learn\services;


use think\route\Url;

class UrlService
{
    public static function build(string $url = '', array $vars = [])
    {
        $url = new Url($url,$vars);
        return $url->build();
    }
}