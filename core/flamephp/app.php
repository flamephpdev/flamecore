<?php

namespace Cache\Views\Flame;

use Core\Base\Base;
use Exception;

class FlameRender extends Base {

     public static $store_dir = CACHE . '/views';
     private static $ez_tags = [ '{{', '}}', '*', '!', '--' ];
     public static $views_dir = ROOT . '/views';
     private static $view__autorender_file = '.view.{ext}';
     private static array $custom_replace = [];

     public static function boot():void {
          $config = config('view');
          if(isset($config['ez-tags'])) self::$ez_tags = $config['ez-tags'];
          if(isset($config['view-folder'])) self::$views_dir = $config['view-folder'];
          if(isset($config['replace-tags-to'])) self::$custom_replace = $config['replace-tags-to'];
          if(isset($config['view-render-file-ext'])) self::$view__autorender_file = $config['view-render-file-ext'];
     }

     public static function include(string $file){
          // Render start time
          $genTime = microtime(true);

          // Get the file extension and check if parser is enabled
          $filedata = FileData::get($file, self::$views_dir, self::$view__autorender_file, self::$store_dir);
          // is parser enabled
          $renderFile = $filedata['renderFile'];
          // the file path
          $view_file = $filedata['view_file'];
          // the cached file path
          $cached_file = $filedata['cached_file'];
          // the file extension
          $file_ext = $filedata['file_ext'];

          // is the parser is required to reParse the file or just parse if not exits curretly
          if(!file_exists($cached_file) || (_env('APP_DEV',false) && _env('RERE_VIEWS',false))) {
               // check if the view file is not exists
               if(!file_exists($view_file)){
                    $ex = new Exception();
                    $trace = $ex->getTrace();
                    $final_call = $trace[1];
                    if(str_starts_with($view_file, self::$views_dir)) $view_file_path = str_replace(self::$views_dir, '{VIEWS_DIR}', $view_file);
                    if(str_starts_with($view_file, core('template/views'))) $view_file_path = str_replace(core('template/views'), '{TEMPLATES_DIR}', $view_file);
    
                    throw new Exception('Trying to import a non-existing file (' . $view_file_path . ')');
               }

               // get the content of the file
               $view_data = file_get_contents($view_file);

               $hash = hash('XXH3', $view_data);
               
               // create the cached file's storage path
               createPath(dirname($cached_file));

               $is_static = false;

               // is required to render the file
               if($renderFile) {
                    $checkHash = new FlameFileHash($hash);
                    if($checkHash->isValid()) return $checkHash->getFile();

                    $st = '@static';
                    if(str_starts_with($view_data, $st)){
                         $is_static = true;
                         $view_data = substr($view_data, strlen($st));
                         $nl = "\n";
                         if(str_starts_with($view_data, $nl)) $view_data = substr($view_data, strlen($nl));
                    }
                    // while the file has an extend tag
                    while(str_starts_with($view_data, '@extends(')) {
                         $view_data = FlameExtend::extended($view_data, self::$views_dir, self::$view__autorender_file, self::$store_dir);
                    }

                    $view_data_real = $view_data;

                    $ignore = new FlameIgnores(
                         '#flame-engine.ignore:start',
                         '#flame-engine.ignore:end',
                         '#flame-engine.ignore:next-line'
                    );
                    $view_data = $ignore->createAndIgnoreHTML($view_data);

                    $view_data = FlameParser::auto_tags($view_data, self::$custom_replace);

                    $view_data = FlameParser::inline_operators($view_data, self::$ez_tags);
               
                    // create a new flame operation parser
                    $fo = new FlameOperations;
                    // add the full source
                    $fo->addFullSource($view_data);
                    // configure
                    $fo->configureParser('@','(',')');
                    // parse
                    $fo->parseFile();
                    // get the parsed content string
                    $view_data = $fo->getParsed();

                    // now parse back the ignored content
                    $view_data = $ignore->getRealContent($view_data);

                    $view_data = file_get_contents(__DIR__ . '/view_header.template.php') . $view_data;

                    // add some information about the parsed file
                    $view_data .= "<?php\nFlameView('::end-file-flameEngine.BackState::');\n/*\nGenerated at: " . date('Y-m-d H:i:s') .  "\nMD5 File Hash: " . md5($view_data_real) . "\nRender Time: " . microtime(true) - $genTime . "s\nFlame Engine ALPHA v0.1\n*/\n?>";
               }

               if($is_static) {
                    ob_start();
                    eval('?>' . $view_data);
                    $view_data = ob_get_contents();
                    ob_end_clean();
               }
               // save the file data
               file_put_contents($cached_file, $view_data);

               FlameFileHash::addFile($hash, $cached_file);
          }

          return $cached_file;
     }

     public static function textParser(string $text, array $variable_pack = array(), bool $eval = false, bool $cache_evald_data = false) {
          $textHash = md5($text);
          createPath(cache('/intimeParser/'));
          $cfile = cache('/intimeParser' . startStrSlash($textHash . '.text-content.php'));
          $varPack = '';
          if(!empty($variable_pack)) {
               $varPack = "<?php\n";
               foreach($variable_pack as $var => $val) {
                    $varPack .= '$' . $var . '=' . var_export($val,true) . ';';
               }
               $varPack .= "\n?>";
          }

          if(file_exists($cfile)) {
               $data = require $cfile;
               $data = $varPack . $data;
               if($eval) $data = self::eval($varPack . $data, $cache_evald_data);
               return $data;
          }

          $ignore = new FlameIgnores(
               '#flame-engine.ignore:start',
               '#flame-engine.ignore:end',
               '#flame-engine.ignore:next-line'
          );
          $text = $ignore->createAndIgnoreHTML($text);

          $text = FlameParser::auto_tags($text, self::$custom_replace);

          $text = FlameParser::inline_operators($text, self::$ez_tags);
     
          // create a new flame operation parser
          $fo = new FlameOperations;
          // add the full source
          $fo->addFullSource($text);
          // configure
          $fo->configureParser('@','(',')');
          // parse
          $fo->parseFile();
          // get the parsed content string
          $text = $fo->getParsed();

          // now parse back the ignored content
          $text = $ignore->getRealContent($text);

          file_put_contents($cfile, "<?php\nreturn " . var_export($text, true) . ";");

          $data = $varpack . $text;
          if($eval) $data = self::eval($varPack . $data, $cache_evald_data);
          return $data;
     }

     public static function eval(string $data, bool $cache_evald_data = false) {
          if($cache_evald_data) {
               $cfile = cache('/intimeParser' . startStrSlash(md5($data) . '.text-data-eval.php'));
               if(file_exists($cfile)) return require $cfile;
          }
          ob_start();
          eval('?>' . $data);
          $content = ob_get_contents();
          ob_end_clean();
          if($cache_evald_data) file_put_contents($cfile, "<?php\nreturn " . var_export($content, true) . ";");
          return $content;
     }

}