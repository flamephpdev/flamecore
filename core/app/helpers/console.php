<?php

if(!function_exists('console')) {
     $GLOBALS['@console']['console'] = NULL;
     $GLOBALS['@console']['consoles'] = [];
     function console($do = NULL, $value = NULL) {
          if($do == '@Set') {
               $GLOBALS['@console']['console'] = $value;
               $GLOBALS['@console']['consoles'][] = $value;
          } else if($do == '@Switch') {
               $GLOBALS['@console']['console'] = $GLOBALS['@console']['consoles'][$value];
          } else if($do == '@Delete') {
               unset($GLOBALS['@console']['consoles'][$value]);
               return true;
          }
          return $GLOBALS['@console']['console'];
     }
}