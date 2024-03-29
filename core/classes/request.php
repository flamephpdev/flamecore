<?php

namespace Core\App;

use Core\App\Response;
use Core\App\Storage\Files;
use Core\Framework\Console\Color\Color;
use Core\Framework\Console\Color\ForegroundColor;

class Request {

    private static string $method = 'get';

    public static array $data = [];
    private static array $data_valid = [];
    private static array $data_errors = [];
    public static array $files = [];

    public static function response(){
        return new Response(new self);
    }

    public static function wantsJson(){
        $headers = getallheaders();
        return $headers['Accept'] == 'application/json';
    }

    public static function headers(){
        return getallheaders();
    }

    public static function method(){
        return self::$method;
    }

    public static function catch(){
        self::$method = strtolower($_SERVER['REQUEST_METHOD']);
        self::$files = Files::getUploads();
        if(self::$method != 'get'){
            if(!empty($_POST)){
                self::$data = $_POST;
            } else {
                $json = file_get_contents('php://input');
                if(isJson($json)){
                    self::$data = json_decode($json,true);
                }
            }
            if(self::$method == 'post' && isset(self::$data['_method'])){
                self::$data['_method'] = strtolower(self::$data['_method']);
                if(in_array(self::$data['_method'], ['get', 'post', 'put', 'delete'])){
                    self::$method = self::$data['_method'];
                    unset(self::$data['_method']);
                }
            }
        }
        if(_env('APP_DEV')) self::consoleRequest();
    }

    public function validate(Validation $v){
        if($v->is_valid(self::$data)){
            self::$data_valid = $v->getvalid();
            return $this;
        }
        self::$data_errors = $v->geterrors();
        return $this;
    }

    public function getValid(){
        return self::$data_valid;
    }

    public function uri(){
        return urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );
    }

    public function rawData(){
        return self::$data;
    }

    public function getErrors(){
        return self::$data_errors;
    }

    public function is_valid(){
        if(empty(self::$data_errors)){
            return true;
        } else {
            return false;
        }
    }

    public function has($key){
        if(!in_array($key,['password','pw','pass']) && isset(static::$data[$key])) return static::$data[$key];
    }

    private static function consoleRequest() {
        require_once core('/app/console/color-enum.php');
        require_once core('/app/console/console-colors.php');
        $method_color = NULL;
        switch(self::$method) {
            case 'get':
                $method_color = ForegroundColor::GREEN;
            break;
            case 'post':
                $method_color = ForegroundColor::YELLOW;
            break;
            case 'put':
                $method_color = ForegroundColor::LIGHT_BLUE;
            break;
            case 'delete':
                $method_color = ForegroundColor::LIGHT_RED;
            break;
            default:
                $method_color = ForegroundColor::DEFAULT;
            break;
        }
        $request_string = "[" . 
        Color::Foreground(
            strtoupper(self::$method),
            $method_color
        ) . "] " . urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );
        // error_log($request_string);
    }

}