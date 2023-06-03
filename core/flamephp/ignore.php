<?php

namespace Cache\Views\Flame;
// '#flame-engine.ignore:start', '#flame-engine.ignore:end'

use Core\Base\Base;

class FlameIgnores extends Base {

     private string $start;
     private string $end;
     private string $nextLineIgnore;
     private array $ignores = array();
     
     public function __construct($start, $end, $nextLineIgnore) {
          $this->start = $start;
          $this->end = $end;
          $this->nextLineIgnore =  $nextLineIgnore;
     }

     public function createAndIgnoreHTML($html): string {
          $html = $this->nextLineIgnores($html);
          $data_parsed = FlameParser::parse($html, $this->start, $this->end);
          foreach($data_parsed as $i => $content) {
               $obj = $this->createMapObject($content, $i);
               $html = str_replace($obj->real, $obj->__obj_gen_id, $html);
          }

          return $html;
     }

     public function nextLineIgnores($html) {
          $data = explode("\n", $html);
          foreach($data as $line => $content) {
               if(str_contains($content, $this->nextLineIgnore)){
                    if(isset($data[$line+1])) {
                         $obj = $this->createMapObject($data[$line+1], 3, true, $data[$line]);
                         $html = str_replace($obj->real, $obj->__obj_gen_id, $html);
                    }
               }
          }
          return $html;
     }

     private function createMapObject($content, $hashKey, $isNextLineIgnore = false, $lineBefore = NULL) {
          if(!$isNextLineIgnore) $_replace = $this->start . $content . $this->end;
          else {
               $_replace = $lineBefore . "\n" . $content;
          }

          $obj_gen_id_created = '$FLAME-IGNORE-CONTENT-GHASH<' . randomString(15 * ($hashKey + 1)) . '>?FLAME-ENDIGNORE;';

          $obj = (object) array(
               'real' => $_replace,
               'generated' => "<?php /* FlameEngine-Ignore-Applied */ ?>\n" . $content,
               '__obj_gen_id' => $obj_gen_id_created,
          );

          $this->ignores[] = $obj;

          return $obj;
     }

     public function getRealContent($html) {
          foreach($this->ignores as $obj) {
               $html = str_replace($obj->__obj_gen_id, $obj->generated, $html);
          }
          return $html;
     }

}