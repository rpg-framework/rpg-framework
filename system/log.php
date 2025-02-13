<?php

class log
{

    public static function error_handler($error)
    {
        $log = explode("\n", $error);

        $e_all  = explode(": ", $log[0]);
        $e_file = explode(" in ", $e_all[1]);
        $e_line = explode(":", $e_file[1]);

        $e_trace = rtrim($log[1], ":");
        $e_stacks = '["'.implode('","', array_slice($log, 2)).'"]';

        $json  = '{';
        $json .= '"line":'.($e_line[1] ? $e_line[1] : '""').',';
        $json .= '"status":"'.$e_all[0].'",';
        $json .= '"file":"'.$e_line[0].'",';
        $json .= '"message":"'.str_replace('"', '\"', $e_file[0].(
                $e_all[2] ? " ".$e_all[2] : ""
            )
        ).'",';
        $json .= '"'.$e_trace.'":'.str_replace(",}]", "}]", $e_stacks);
        $json .= '}';

        header("Content-Type: application/json");

        echo $json;

        if (settings::$logs == 1)
        {
            return file_put_contents
            (
                settings::$root."/system/logs/error/".settings::$date.".json",
                $json."\n", FILE_APPEND | LOCK_EX
            );
        }
    }

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

        return json_encode($request, JSON_INVALID_UTF8_IGNORE);
    }

    public static function access()
    {
        return file_put_contents
        (
            settings::$root."/system/logs/access/".settings::$date.".json",
            self::request()."\n", FILE_APPEND | LOCK_EX
        );
    }

    public static function access_logs($line = 10, $return = 0)
    {
        $log = file_get_contents
        (
            settings::$root."/system/logs/access/".settings::$date.".json"
        );

        $parse = array_reverse(explode("\n", $log));
        $build = implode(",", array_slice($parse, 1, $line));

        $access_logs = "[".ltrim($build, ",")."]";

        if ($return == 1)
        {
            return self::obj(json_decode($access_logs));
        }
        else
        {
            header("Content-Type: application/json");
            echo $access_logs;
        }
    }

    public static function error_logs($line = 10, $return = 0)
    {
        $log = file_get_contents
        (
            settings::$root."/system/logs/error/".settings::$date.".json"
        );

        $parse = array_reverse(explode("\n", $log));
        $build = implode(",", array_slice($parse, 1, $line));

        $error_logs = "[".ltrim($build, ",")."]";

        if ($return == 1)
        {
            return self::obj(json_decode($error_logs));
        }
        else
        {
            header("Content-Type: application/json");
            echo $error_logs;
        }
    }

    public static function obj($array)
    {
        $data = new stdClass;
        $super = "_";

        foreach ($array as $key => $val)
        {
            $key = $super.$key;
            $data->$key = $val;
        }

        return $data;
    }

}
