<?php

// If you create a class/php file named page in the Controllers directory (for example: localhost/page), 
// this file will be loaded automatically and the run function will be executed.
class index extends controller
{

    // For model
    protected $blogs;

    public function run()
    {
        // Model usage
        $this->blogs = $this->model("blogs");
        $array = $this->blogs->all();
        
        // Use of embedded functions
        self::dump($array);

        // OR

        $object = new stdClass;
        $object->carousel = $this->blogs->carousel("0"); // :) Others

        $this->dump($object);

        // -----

        // Array usage
        $data["title"] = ucwords($array["title"]);
        $data["base_url"] = settings::$scheme."://".settings::$host;

        // OR

        // Object usage
        $data = new stdClass;
        $data->title = ucwords($object->title);
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
