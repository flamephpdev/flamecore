<?php

namespace Cache\Views\Flame;

class FlameParser {

     public static function parse($data, $start_tag, $end_tag,?array $nsw = NULL) {
          $arr = [];
          while(1){
               $parsed = string_between($data, $start_tag, $end_tag);
               if(!$parsed)
                    break;
               $np_poz = strpos($data, $start_tag)-1;
               $strposition = strpos($data, $end_tag);
               if(substr($data, $np_poz, 1) != '#'){
                    if(!is_null($nsw)){
                         if(!self::str_starts_with_array($parsed,$nsw)){
                         array_push($arr,$parsed);
                         }
                    } else {
                         array_push($arr,$parsed);
                    }
               } else {
                    $data = rem_inx($data,$np_poz);
               }
               $nextString = substr($data, $strposition+1, strlen($data));
               $data = $nextString;
          }
          return $arr;
     }

     private static function str_starts_with_array($str,$needle){
          $sw = false;
          foreach($needle as $n){
              if(str_starts_with($str,$n)) $sw = true;
          }
          return $sw;
     }

     public static function auto_tags($data, $custom_replace){
          if(!empty($custom_replace)){
               foreach($custom_replace as $r => $rto){
                    while(str_contains($data,$r)){
                         $np_poz = strpos($data, $r)-1;
                         if(substr($data, $np_poz, 1) != '#'){
                              $data = str_replace_first($r,'<?php ' . $rto . ' ?>',$data);
                         } else {
                              $data = rem_inx($data,$np_poz);
                         }
                    }
               }
          }
          return $data;
     }

     public static function inline_operators($view_data, $ez_tags){
          $data = $view_data;
          $arr = self::parse($data, $ez_tags[0], $ez_tags[1]);
          runtimeLog('VIEW: inline operators: ' . implode(', ',$arr));
          foreach($arr as $data){
               if(str_starts_with($data, $ez_tags[2])){
                    $replace_to = substr($data, strlen($ez_tags[2]));
               } else if(str_starts_with($data, $ez_tags[3])){
                    $replace_to = 'echo htmlspecialchars(' . substr($data, strlen($ez_tags[3])) . ')';
               } else if(str_starts_with($data, $ez_tags[4])){
                    $replace_to = '/*' . substr($data, strlen($ez_tags[4])) . '*/';
               } else {
                    $replace_to = 'echo ' . $data;
               }
     
               $replace_to = "<?php {$replace_to} ?>";
               
               $view_data = str_replace($ez_tags[0] . $data . $ez_tags[1],$replace_to,$view_data);
          }
          return $view_data;
     }

}