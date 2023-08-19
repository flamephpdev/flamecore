<?php

if(!function_exists('useTailwind')) {
     function useTailwind() {
          if(!file_exists($file = root('/public/css/app.css'))) throw new Exception('The built-in appAddCss requires the public file, try run "npm i" then "npm run twdev" or "npm run twbuild"');
          if(!_env('APP_DEV')) {
               return stylesheet('/css/app.css');
          } else {
               $css = file_get_contents($file);
               return "<!-- " . stylesheet('/css/app.css', ' @framework="css:production"') . " -->\n<style @framework=\"css:debug\">{$css}</style>";
          }
     }
}