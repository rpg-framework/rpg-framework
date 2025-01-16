<?php

abstract class model
{

    protected $db;

    protected $where;

    protected $limit;

    protected $order_by;

    public function __construct()
    {
        $this->db = new settings::$driver;
    }

    public function where($name, $operator, $value)
    {
        $this->where = $name." ".$operator." "."'".$value."'";

        return $this;
    }

    public function limit($fields)
    {
        if (is_array($fields))
        {
            $this->limit = implode(",", $fields);
        }
        else
        {
            $this->limit = $fields;
        }

        return $this;
    }

    public function order_by($fields)
    {
        if (is_array($fields))
        {
            $this->order_by = implode(" ", $fields);
        }

        return $this;
    }

    public function select($table, $fields = null)
    {
        if ($fields == null)
        {
            $fields = "*";
        }
        else
        {
            if (is_array($fields))
            {
                $fields = implode(",", $fields);
            }
        }

        $sql = "SELECT $fields FROM $table";

        if ($this->where != null)
        {
            $sql .= " WHERE ".$this->where;
        }

        if ($this->order_by != null)
        {
            $sql .= " ORDER BY ".$this->order_by;
        }

        if ($this->limit != null)
        {
            $sql .= " LIMIT ".$this->limit;
        }

        $query = $this->db->query($sql);

        if ($this->where == null && $this->order_by != null || $this->limit != null)
        {
            $i = 0;
            $result = array();
    
            while($data = $this->db->fetch($query))
            {
                $result[$i] = $data;
                $i++;
            }
            
            return $this->fetch($result);
        }
        else if ($this->where != null)
        {
            return $this->fetch($this->db->fetch($query));
        }
        else
        {
            $i = 0;
            $result = array();
    
            while($data = $this->db->fetch($query))
            {
                $result[$i] = $data;
                $i++;
            }
    
            return $this->fetch($result);
        }
    }

    public function insert($table, $data = array())
    {
        $keys = array_keys($data);
        $vals = array_values($data);

        $bind = array();

        foreach ($vals as $val)
        {
            array_push($bind, "'".$val."'");
        }

        $sql = "INSERT INTO $table (".implode(",", $keys).") VALUES (".implode(",", $bind).")";
        return $this->db->query($sql);
    }

    public function update($table, $data = array())
    {
        $bind = array();

        foreach ($data as $key => $val)
        {
            array_push($bind , $key." = "."'".$val."'");
        }

        $sql = "UPDATE $table SET ".implode(",", $bind);

        if ($this->$where != null)
        {
            $sql .= " WHERE ".$this->$where;
        }

        return $this->db->query($sql);
    }

    public function delete($table)
    {
        $sql = "DELETE FROM $table";

        if ($this->$where != null)
        {
            $sql .= " WHERE ".$this->$where;
        }

        return $this->db->query($sql);
    }

    public function fetchColumn($table, $field = null)
    {
        $sql = "SELECT COUNT(*) FROM $table";

        if ($this->where != null)
        {
            $sql .= " WHERE ".$this->where;
        }

        $query = $this->db->query($sql);
        return $this->db->fetchColumn($query);
    }

    public function fetch($array)
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
