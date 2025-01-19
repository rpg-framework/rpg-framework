<?php

class route
{

    public static function app()
    {
        require settings::$root."/app/base/controller.php";

        $get = stripos(settings::$uri, "?");

        if ($get == true)
        {
            $params = explode("?", settings::$uri);
            $param = explode("&", security::xss_protection($params[1]));

            self::set($param);

            $url = explode("/", $params[0]);

            if (is_file(settings::$root."/app/controllers/".$url[1].".php"))
            {
                require settings::$root."/app/controllers/".$url[1].".php";
                call_user_func([new $url[1], "run"]);
            }
            else if ($params[0] == "/")
            {
                if (is_file(settings::$root."/app/controllers/".settings::$index.".php"))
                {
                    require settings::$root."/app/controllers/".settings::$index.".php";
                    call_user_func([new settings::$index, "run"]);
                }
                else
                {
                    self::welcome();
                }
            }
            else
            {
                self::error();
            }
        }
        else
        {
            $url = explode("/", settings::$uri);

            if (is_file(settings::$root."/app/controllers/".$url[1].".php"))
            {
                require settings::$root."/app/controllers/".$url[1].".php";
                call_user_func([new $url[1], "run"]);
            }
            else if (settings::$uri == "/")
            {
                if (is_file(settings::$root."/app/controllers/".settings::$index.".php"))
                {
                    require settings::$root."/app/controllers/".settings::$index.".php";
                    call_user_func([new settings::$index, "run"]);
                }
                else
                {
                    self::welcome();
                }
            }
            else
            {
                self::error();
            }
        }
        
    }

    public static function set($param = array())
    {
        unset($_GET);
    
        if (count($param) > 0)
        {
            foreach ($param as $value)
            {
                $x = explode("=", $value);
                $_GET[$x[0]] = $x[1];
            }
        }
    }

    public static function welcome()
    {
        echo file_get_contents(settings::$root."/system/templates/index.html");
    }

    public static function error()
    {
        if (is_file(settings::$root."/app/controllers/".settings::$error.".php"))
        {
            require settings::$root."/app/controllers/".settings::$error.".php";
            call_user_func([new settings::$error, "run"]);
        }
        else
        {
            echo file_get_contents(settings::$root."/system/templates/404.html");
        }
    }

}