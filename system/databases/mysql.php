<?php

class mysql
{

    protected $cursor;

    public function __construct()
    {
        $config = "host=".settings::$db_host.";dbname=".settings::$db_name.";charset=utf8";
        $this->cursor = new PDO(settings::$driver.":".$config, settings::$db_user, settings::$db_pass);

        $this->cursor->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->cursor->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->cursor->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function query($sql)
    {
        return $this->cursor->query($sql);
    }

    public function prepare($sql)
    {
        return $this->cursor->prepare($sql);
    }

    public function bind(PDOStatement $query, $param, $value, $type = null)
    {
        if (is_null($type))
        {
            switch (true)
            {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        return $query->bindValue($param, $value, $type);
    }

    public function auto_bind(PDOStatement $query, $data = array())
    {
        $keys = array_keys($data);
        $vals = array_values($data);

        for ($i = 0; $i < count($keys); $i++)
        {
            $this->bind($query, ":$keys[$i]", $vals[$i]);
        }
    }

    public function execute(PDOStatement $query)
    {
        return $query->execute();
    }

    public function fetch(PDOStatement $query)
    {
        return $query->fetch();
    }

    public function fetchColumn(PDOStatement $query)
    {
        return $query->fetchColumn();
    }

    public function __destruct()
    {
        $this->cursor = null;
    }

}