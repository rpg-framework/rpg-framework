<?php

class rpg
{

    public function __construct()
    {
        self::start();
    }

    public static function start()
    {
        ob_start();
    }

    public static function view($name, $data = null)
    {
        if (is_array($data) && is_file(settings::$root.'/app/views/'.$name.'.php'))
        {
            extract($data);
            require settings::$root.'/app/views/'.$name.'.php';
        }
        else if (is_file(settings::$root."/app/views/".$name.".html") && is_array($data) || is_object($data))
        {
            $file = file_get_contents(settings::$root."/app/views/".$name.".html");

            foreach($data as $content => $value)
            {
                if (is_array($value) || is_object($value))
                {
                    foreach($value as $key => $val)
                    {
                        $file = str_replace("{{".$key."}}", $val, $file);
                    }
                }
                else
                {
                    $file = str_replace("{{".$content."}}", $value, $file);
                }
            }

            echo $file;
        }
        else if (is_file(settings::$root."/app/views/".$name.".html") && $data == null)
        {
            echo file_get_contents(settings::$root."/app/views/".$name.".html");
        }
    }

    public static function model($name)
    {
        if (is_file(settings::$root.'/app/models/'.$name.'.php'))
        {
            require settings::$root.'/app/models/'.$name.'.php';
            return new $name;
        }
    }

    public static function module($name)
    {
        if (is_file(settings::$root.'/system/modules/'.$name.'.php'))
        {
            require settings::$root.'/system/modules/'.$name.'.php';
            return new $name;
        }
    }

    public static function dump($array = array())
    {
        header("Content-Type: text/plain; charset=UTF-8");
        print_r($array);
        die();
    }

    public static function segment($no)
    {
        $uri = explode("/", settings::$uri);

        if ($no < count($uri))
        {
            return $uri[$no];
        }
        else
        {
            return null;
        }
    }

    public static function input($name = null)
    {
        if ($name != null)
        {
            return $_POST[$name];
        }
        else
        {
            return $_POST;
        }
    }

    public static function redirect($url)
    {
        return header("Location: ".settings::$scheme."://".settings::$host.$url);
    }

    public static function close()
    {
        ob_end_flush();
    }

    public function __destruct()
    {
        self::close();
    }

}
