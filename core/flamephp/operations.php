<?php

namespace Cache\Views\Flame;

use Core\Base\Base;

class FlameOperations extends Base {

     private string $page = '';
     private string $readStart;
     private string $startTag;
     private string $endTag;

     /** Private parsed data */
     private array $parser = array();

     private array $no_read_tags = array(
          "'" => "'",
          '/*' => '*/',
          '"' => '"',
          '`' => '`',
          '<?php' => '?>',
     );

     private array $operators = array(
          'if',
          'elseif',
          'endif',
          'for',
          'foreach',
          'while',
          'break',
     );

     private array $endless_operators = array(
          'case',
          'default',
          'break',
          'else',
     );

     private array $cannot_start_with_at = array(
          'end'
     );

     public function addFullSource($htpp /** Hyper Text Pre-Processor */){
          $this->page = $htpp;
          return $this;
     }

     public function configureParser($readStart, $startTag, $endTag){
          $this->readStart = $readStart;
          $this->startTag = $startTag;
          $this->endTag = $endTag;
     }

     private function parser($content, $start, $end){
          $x = explode($start, $content);
          unset($x[0]);
          if($x) {
               $y = [];
               foreach($x as $data){
                    $z = explode($end, $data);
                    if($z[0] && !str_starts_with($z[0], 'end')){
                         $y[] = $z[0];
                    }
               }
               return $y;
          }
          return [...$x];
     }

     public function parseFile(){
          $__default_content_editable = $this->page;
          $_parsed = array();
          $arr = $this->parser(
               $this->page,
               $this->readStart,
               $this->endTag,
          );

          //dd($arr);

          foreach($arr as $source){
               $_created = $this->readStart;

               $started = false;
               $started_text_or_comment = false;
               $started_value = '';
               $counted_start_bracket = 0;
               $counted_end_bracket = 0;

               $_start_pos = strpos(
                    $__default_content_editable, $source
               );
               $__currentPos = $_start_pos;
               
               if(substr(
                    $__default_content_editable,
                    $_start_pos,
                    3
               ) !== 'end') {
                    while(!$started || $counted_start_bracket != $counted_end_bracket){
                         $currentChar = substr(
                              $__default_content_editable,
                              $__currentPos,
                              1
                         );
     
                         if(!$started && $currentChar == $this->startTag){
                              $started = true;
                         }
                         
                         if(in_array($currentChar, array_keys($this->no_read_tags))){
                              $started_text_or_comment = true;
                              $started_value = $currentChar;
                         }
     
                         if($started_text_or_comment && $currentChar == $this->no_read_tags[$started_value]){
                              $started_text_or_comment = false;
                         }
     
                         if(!$started_text_or_comment){
                              if($currentChar == $this->startTag) $counted_start_bracket++;
                              if($currentChar == $this->endTag) $counted_end_bracket++;
                         }
     
                         $_created .= $currentChar;
     
                         $__currentPos++;
                    }

                    $char_before = substr(
                         $__default_content_editable,
                         $__currentPos - strlen($_created) - 1,
                         1
                    );

                    $char_after = substr(
                         $__default_content_editable,
                         $__currentPos,
                         1
                    );
     
                    $psxid = md5($_created);

                    $__data__tag_ = substr($_created, 1);

                    $php_syntax = "<?php ";

                    $end = '';

                    $tag = explode('(', substr($_created, 1))[0];
                    
                    if(in_array($tag, $this->operators)) $php_syntax .= $__data__tag_ . ':';
                    else $php_syntax .= 'echo ' . $__data__tag_;

                    $php_syntax .= ' ?>';

                    if($char_before != '#') {
                         if($char_after == ':') $_created .= ':';
                         $__default_content_editable = str_replace($_created, $php_syntax, $__default_content_editable);
                         $endTagName = '@end' . $tag;
                         
                         if(str_contains($__default_content_editable, $endTagName)) {
                              $php_syntax_endTag = "<?php " . substr($endTagName, 1) . " ?>";
                              $__default_content_editable = str_replace($endTagName, $php_syntax_endTag, $__default_content_editable);
                         }
                    } else $__default_content_editable = rem_inx($__default_content_editable, $__currentPos - strlen($_created) - 1);
                    
               }
          }

          $this->page = $__default_content_editable;
     }

     public function getParsed(){
          return $this->page;
     }

}