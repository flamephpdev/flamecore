<?php

namespace Cache\Views\Flame;

use Core\Base\Base;
use Exception;

class FlameExtend extends Base {

     public static function extended($data, $views_dir, $view__autorender_file, $store_dir){
          if(str_starts_with($data, '@extends:') && str_contains($data, ';')){
               $created = '';

               $data = explode(';', $data, 2);
               $extend = trim(str_replace('@extends:', '', $data[0]));
               $data = $data[1];

               $e_view_fdata = FileData::get($extend, $views_dir, $view__autorender_file, $store_dir);
               
               $extended_view_file = file_get_contents($e_view_fdata['view_file']);
               if(str_contains($extended_view_file, '@section:') && str_contains($extended_view_file, ';')){
                    $sections = self::getsections($extended_view_file);
                    foreach($sections as $name){
                         $yield_content = self::getsectioncontent($name, $data);
                         if(is_null($yield_content) && str_starts_with($name, '!')) throw new Exception('No section found with "' . $name . '" name');
                         $extended_view_file = str_replace('@section:' . $name . ';', $yield_content, $extended_view_file);
                    }
                    $data = $extended_view_file;
               }
          }
          // otherwise just return the view data
          return $data;
     }

     private static function getsections($view_data){
          $arr = FlameParser::parse($view_data,'@section:',';');
          $section_names = [];
  
          while(!empty($arr)){
               foreach($arr as $k => $data){
                    $section_names[] = $data;
                    $view_data = str_replace('@section:' . $data . ';', '', $view_data);
               }
               $arr = FlameParser::parse($view_data,'@section:',';');
          }
          return $section_names;
     }

     private static function getsectioncontent($name, $view_data){
          $yieldstart = '@yield:' . $name . ';';
          $yieldend = '@endyield:' . $name . ';';

          $arr = FlameParser::parse($view_data, $yieldstart, $yieldend);
          $section_content = NULL;
  
          while(!empty($arr)){
               foreach($arr as $k => $data){
                    return $data;
               }
          }
          return $section_content;
     }

}