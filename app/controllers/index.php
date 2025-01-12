<?php

class index extends controller
{

    public function run()
    {
        //echo "Welcome to the Home Page";

        $data["title"] = "Welcome to the Home Page";
        $data["base_url"] = settings::$scheme."://".settings::$host;

        // PHP
        //$this->render("parts/header", $data);

        // HTML
        $this->view("parts/header", $data);
    }

}
