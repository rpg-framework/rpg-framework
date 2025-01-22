<?php

class index extends controller
{

    public function main()
    {
        $data = new stdClass;

        $data->title = "RPG Framework";
        $data->application = "rpg";
        $data->version = "1.0";

        $data->phpver = phpversion();
        $data->software = $_SERVER["SERVER_SOFTWARE"];

        $this->view("index", $data);
    }

}