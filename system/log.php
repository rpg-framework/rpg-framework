<?php

class log
{

    public static function request()
    {
        $request = new stdClass;

        $request->status    = settings::$status;
        $request->time      = settings::$time;
        $request->date      = settings::$date;
        $request->ip        = settings::$ip;
        $request->host      = settings::$scheme."://".settings::$host;
        $request->request   = settings::$method." ".settings::$uri." ".settings::$protocol;
        $request->useragent = settings::$ua;

        return json_encode($request, JSON_INVALID_UTF8_IGNORE || JSON_FORCE_OBJECT);
    }

    public static function access()
    {
        return file_put_contents
        (
            settings::$root."/system/logs/access_logs-".settings::$date.".json",
            self::request()."\n", FILE_APPEND | LOCK_EX
        );
    }

    public static function access_logs($line = 10)
    {
        $log = file_get_contents
        (
            settings::$root."/system/logs/access_logs-".settings::$date.".json"
        );

        $parse = array_reverse(explode("\n", $log));
        $build = implode(",", array_slice($parse, 0, $line + 2));

        $access_logs = "[".ltrim($build, ",")."]";
        header("Content-Type: application/json");

        echo $access_logs;
    }

}