<?php

// If you create a class/php file named page in the Controllers directory (for example: localhost/page), 
// this file will be loaded automatically and the run function will be executed.
class index extends controller
{

    public function run()
    {
        // Use of embedded functions
        self::dump($array);

        // OR

        $this->dump($object);

        // -----

        // Array usage
        $data["title"] = "Welcome to the Home Page";
        $data["base_url"] = settings::$scheme."://".settings::$host;

        // OR

        // Object usage
        $data = new stdClass;
        $data->title = "Welcome to the Home Page";
        $data->base_url = settings::$scheme."://".settings::$host;

        // The file views/parts/header.php or views/parts/header.html is required.
        $this->view("parts/header", $data);

        // OR

        // Display of fixed html pages.
        $this->view("parts/alert");

        // -----

        // Home Page
        $this->view("parts/header", $data);
        $this->view("pages/index", $index);
        $this->view("parts/footer", $whatever);
    }

}
