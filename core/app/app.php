<?php

namespace Core\Framework;

use Core\App\Session;
use Tools\THEN;

class Framework {

    private static $runType = null;

    public static function load($type = 'web', ...$args){
        self::$runType = $type;
        self::loadFiles();
        runtimeLog('Framework assets loaded successfully');
        if(self::$runType == 'web') return self::loadWeb(...$args);
        else if(self::$runType == 'console') return self::loadConsole(...$args);
        echo "Failed to load framework, the specified run type [$type] is not supported";
    }

    public static function isWeb(){
        return self::$runType == 'web';
    }

    public static function isConsole(){
        return self::$runType == 'console';
    }

    private static function loadWeb(){
        // include the database if it's required
        if(_env('USE_DB', false)) require CORE . '/database/loader.php';

        // load controller classes
        self::loadAll(ROOT . '/app/Controllers');

        // boot all the classes that has that functionality
        self::bootClasses();

        require core('applock.generator.php');

        if(file_exists(ROOT . '/app/app.php')) require ROOT . '/app/app.php';

        Session::SingleUse('framework.url.previous', urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        // return a simple then statement, that runs after that function

        runtimeLog('WebApp loaded successfully');
        return new THEN();
    }

    private static function loadConsole($dev = false, $argv = []){
        // Console Settings
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        require CORE . '/devtools/load/loader.php';
        \DEV\DEVLoader::load();

        if($dev) {
            $dev = \Dev\DEVLoader::createApp();
            $dev->initialize($argv);
            $dev->config([]);
            define('DEV', $dev);
        }

        // the database is automatically loaded from the DEVLoader
        // so we need to check if it using it or not
        if(!$dev && _env('USE_DB', false)) require CORE . '/database/loader.php';

        require_once path(__DIR__. '/console/color-enum.php');
        require_once path(__DIR__. '/console/console-colors.php');
        loadDirFiles(__DIR__ . '/console/tools');

        // boot all the classes that has that functionality
        self::bootClasses();

        require core('applock.generator.php');

        // return a simple then statement, that runs after that function
        console(
            do: '@Set', 
            value: new Console()
        );
        return console();
    }

    private static function loadAll($dir){
        $_files = array();
        if(is_dir($dir)){
            $files = getDirContents($dir);
            if(is_array($files)){
                foreach($files as $file){
                    if(str_ends_with($file, '.php')) {
                        $_files[] = $file;
                        require $file;
                    }
                }
            }
        }
        return $_files;
    }

    private static function bootClasses(){
        // get all the classes
        foreach( get_declared_classes() as $class ){
            // create a reflection to that class
            $reflected = new \ReflectionClass( $class );
            // and check if it's a framework base class
            if( $reflected->isSubclassOf( 'Core\Base\Base' ) && !$reflected->isAbstract() ){
                // create a class instance without constructor
                $instance = $reflected->newInstanceWithoutConstructor();
                if(method_exists($instance,'classBooter')) {
                    // call it without arguments and boot it
                    call_user_func(array($instance, 'classBooter'),$instance);
                }
            }
        }
    }

    private static function loadFiles(): void {
        $cache = CACHE . '/framework/@flame/@app/root/core/app/load-files.php';
        if(file_exists($cache) && !_env('APP_DEV')) {
            try {
                foreach(require $cache as $file) require $file;
            } catch(Exception $e) {
                echo "Failed to pre-load framework files, please delete the /core/cache folder and restart.";
                exit;
            }
            return;
        }
        // get the required directories to load
        $load_dir_files = require __DIR__ . '/dirs.php';

        $files = array();

        // foreach all the dirs
        foreach($load_dir_files as $dir){
            // if it's a dir
            if(is_dir(CORE . $dir)){
                // scan all the files inside that dir
                $scanFiles = scandir(CORE . $dir);
                // if the dir has files, loop through all the files, and if it's a php file, require it
                if(!empty($scanFiles)) foreach($scanFiles as $file) if(str_ends_with($file ,'.php') && !str_ends_with($file ,'.template.php')) {
                    $r = CORE . $dir . $file;
                    require $r;
                    $files[] = $r;
                }
            }
        }
        // load models
        $files = array_merge($files, self::loadAll(ROOT . '/app/Models'));
        $files = array_merge($files, self::loadAll(ROOT . '/app/Tools'));
        $files[] = __DIR__ . '/settings.php';
        require __DIR__ . '/settings.php';
        createPath(dirname($cache));
        $cached = var_export($files, true);
        $cached = str_replace("'" . str_replace('\\', '\\\\', ROOT), "ROOT . '", $cached);
        file_put_contents($cache, "<?php\n// Framework Autoload Files\n// Auto Generated by OpenFrameworkPhp/FlameCore/V" . VERSION . "\nreturn " . $cached . ";");
    }
}
