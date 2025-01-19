<?php

class security
{

    public static function xss_protection($data)
    {
        return str_replace(['"', "'", "<", ">", '\\', "/"], '', $data);
    }

}