<?php

if(!function_exists('useTailwind')) {
     function useTailwind() {
          if(!file_exists(root('/public/css/app.css'))) throw new Exception('The built-in appAddCss requires the public file, try run "npm i" then "npm run twdev" or "npm run twbuild"');
          return stylesheet('/css/app.css');
     }
}