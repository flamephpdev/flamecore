<?php

namespace Console\Application;

use Core\Framework\Console\Color\Color;
use Core\Framework\Console\Color\ForegroundColor;
use function Console\Log;

class Main extends Base {

     public function __construct() {
          Log('The class is constructed ;)');
     }

     /**
      * @method Main
      * Should be named as the class short name!
      */
     public function Main():void {
          $created = [];
          $text = str_split("Welcome to the Console Application! Build something beautiful ;)");
          foreach($text as $char) {
               $created[] = Color::Foreground($char, ForegroundColor::random());
               echo implode('', $created) . "\r";
               usleep(50000);
          }
          Log("\nFor more information visit: https://flamephp.mrtn.vip/docs/console/");
     }

}