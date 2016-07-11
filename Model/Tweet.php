<?php
  class Tweet {
    var $name;
    var $screen_name;
    var $profile_image;
    var $content;
    var $retweet_cnt;

    function Tweet($name, $screen_name, $profile_image, $content, $retweet_cnt){
      $this->name = $name;
      $this->screen_name = $screen_name;
      $this->profile_image = $profile_image;
      $this->content = $content;
      $this->retweet_cnt = $retweet_cnt;
    }

    function toString(){
      foreach (get_object_vars($this) as $prop => $val) {
          echo "\t$prop = $val\n";
      }
    }
    
  }
?>
