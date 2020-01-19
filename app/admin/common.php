<?php

if (!function_exists('unCamelize'))
{
    /**
     * 驼峰法转下划线
     * @param $camelCaps
     * @param string $separator
     * @return string
     */
    function unCamelize($camelCaps,$separator='_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}