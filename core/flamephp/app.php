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
          $config = require config('view');
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
               
               // create the cached file's storage path
               createPath(dirname($cached_file));

               $is_static = false;

               // is required to render the file
               if($renderFile) {
                    $st = '@static';
                    if(str_starts_with($view_data, $st)){
                         $is_static = true;
                         $view_data = substr($view_data, strlen($st));
                         $nl = "\n";
                         if(str_starts_with($view_data, $nl)) $view_data = substr($view_data, strlen($nl));
                    }
                    // while the file has an extend tag
                    while(str_starts_with($view_data, '@extends:')) {
                         $view_data = FlameExtend::extended($view_data, self::$views_dir, self::$view__autorender_file, self::$store_dir);
                    }

                    $view_data_real = $view_data;

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

                    // add some information about the parsed file
                    $view_data .= "<?php\n/*\nGenerated at: " . date('Y-m-d H:i:s') .  "\nMD5 File Hash: " . md5($view_data_real) . "\nRender Time: " . microtime(true) - $genTime . "s\nFlame Engine ALPHA v0.1\n*/\n?>";
               }

               if($is_static) {
                    ob_start();
                    eval('?>' . $view_data);
                    $view_data = ob_get_contents();
                    ob_end_clean();
               }
               // save the file data
               file_put_contents($cached_file, $view_data);
          }

          return $cached_file;
     }

}