<?php

class init
{

    public function __construct()
    {
        self::directory_access();
    }

    public static function directory_access()
    {
        $access_log = settings::$root."/system/logs/access/".settings::$date.".json";
        $error_log = settings::$root."/system/logs/error/".settings::$date.".json";

        if (!is_writable(dirname($access_log)) || !is_writable(dirname($error_log)))
        {
            $result = json_encode
            ([
                "status"  => "error",
                "path"    => settings::$root."/system/logs",
                "message" => "Logs directory is not writable!"
            ]);

            header("Content-Type: application/json");
            echo $result;
            die();
        }
    }

}