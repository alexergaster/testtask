<?php

class ServerInfo
{
    public static function getHost() : string
    {
        return $_SERVER['HTTP_HOST'];
    }
    public static function getAddr() : string
    {
        return $_SERVER['REMOTE_ADDR'];
    }
    public static function isPostMethod() : bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}