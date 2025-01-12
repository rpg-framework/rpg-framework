<?php

class log
{

    public function request()
    {
        $response = new stdClass();

        $response->status    = settings::$status;
        $response->time      = settings::$time;
        $response->date      = settings::$date;
        $response->ip        = settings::$ip;
        $response->host      = settings::$scheme."://".settings::$host;
        $response->request   = settings::$method." ".settings::$uri." ".settings::$protocol;
        $response->useragent = settings::$ua;

        return json_encode($response, JSON_INVALID_UTF8_IGNORE || JSON_UNESCAPED_UNICODE);
    }

}