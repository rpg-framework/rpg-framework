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

        return json_encode($request, JSON_INVALID_UTF8_IGNORE || JSON_UNESCAPED_UNICODE);
    }

    public static function access()
    {
        return file_put_contents
        (
            settings::$root."/system/logs/access_logs-".settings::$date.".json",
            "\n".self::request().",", FILE_APPEND | LOCK_EX
        );
    }

    public static function access_logs()
    {
        $log = file_get_contents
        (
            settings::$root."/system/logs/access_logs-".settings::$date.".json"
        );

        $access_logs = "[".rtrim($log, ",")."\n]";
        header("Content-Type: application/json");

        echo $access_logs;
    }

}