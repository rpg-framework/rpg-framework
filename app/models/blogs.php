<?php

class blogs extends model
{

  public function get_post($url) // $url == how-to-use-rpg-framework
  {
      // SELECT * FROM blogs WHERE url = 'how-to-use-rpg-framework'
      return $this->where("url", "=", $url)->select("blogs");
  }

  public function all()
  {
      // SELECT * FROM blogs
      return $this->select("blogs");
  }

  public function carousel($slider) // $slider == 1
  {
      // SELECT * FROM blogs WHERE slider = 1 ORDER_BY created_at DESC LIMIT 3
      return $this->where("slider", "=", $slider)->order_by(["created_at", "DESC"])->limit("3")->select("blogs");
  }

}
