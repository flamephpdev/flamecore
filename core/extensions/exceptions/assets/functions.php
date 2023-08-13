<?php

// check if fatal error

use Core\Framework\Console\Color\BackgroundColor;
use Core\Framework\Console\Color\Color;
use Core\Framework\Console\Color\ForegroundColor;
use Core\Framework\Framework;

function check_for_error($code, $text, $file, $line) {
    check_for_fatal();
}

function check_for_fatal()
{
    if($error = error_get_last()){
        if(class_exists('\Core\Cache\View')){
            if(str_starts_with($error['file'],\Core\Cache\View::$store_dir)){
                $error['file'] = str_replace(\Core\Cache\View::$store_dir,ROOT . '/views',$error['file']);
            }
        }

        if(class_exists('App\Errors\Log\RunLog')){
            \App\Errors\Log\RunLog::add('FATAL ERROR! EXIT');
            \App\Errors\Log\RunLog::write();
        }

        if ( $error["type"] != E_WARNING && $error['type'] != 8192 ){
            log_error($error["type"], $error["message"], $error["file"], $error["line"]);
        }
    }
}

function display_error(Exception $e){
    if(!_env('APP_DEV',false)){
        require __DIR__ . '/../edata/server_error_public.php';
        exit;
    }

    if(Framework::isWeb() && getallheaders()['Accept'] != 'application/json'){
        echo "<!--\n";
        var_dump($e);
        echo "-->\n";
    }
    
    $type = get_class( $e );
    $eline = $e->getLine();
    $file = $e->getFile();
    $file_data = "";
    $current_line = 0;
    $handle = fopen($file, "r");
    $lines = "";
    $minline = $eline - 4;
    $maxline = $eline + 7;

    if ($handle && Framework::isWeb()) {
        while (($line = fgets($handle)) !== false && $current_line <= $maxline) {
            //$code .= $line;
            $current_line++;
            if($current_line >= $minline){
                if($current_line != $eline){
                    $file_data .= '<span>' . highlightText($line) . "</span>";
                    //dd($file_data);
                    $lines .= '&nbsp;&nbsp;' . $current_line . "&nbsp;\n";
                } else {
                    $file_data .= '<div class="data-error"><span style="margin-left:10px;">' . htmlentities($line) . '</span></div>';
                    $lines .= '<span class="error-dot"><span style="color:red;">&#x25CF;</span>&nbsp;' . $current_line . "&nbsp;</span>\n";
                }
            }
        }
        fclose($handle);
    } else {
        $file_data = '';
        while (($line = fgets($handle)) !== false && $current_line <= $maxline) {
            //$code .= $line;
            $current_line++;
            if($current_line >= $minline){
                $spaces_count = 7 - strlen(strval($current_line));
                if($current_line == $eline) $spaces_count -= 3;
                
                if($current_line != $eline){
                    $file_data .= str_repeat(' ', $spaces_count) . $current_line . ' | ' . $line;
                } else {
                    $file_data .= str_repeat(' ', $spaces_count) . Color::Foreground('⬤  ' . $current_line, ForegroundColor::LIGHT_RED) . ' | ' . Color::Background(str_replace("\n", "", $line), BackgroundColor::LIGHT_RED) . Color::Background('', BackgroundColor::LIGHT_GREEN) . Color::Background("❗\n", BackgroundColor::DEFAULT);
                }
            }
        }
        fclose($handle);
    }
    $message = $e->getMessage();
    require __DIR__ . '/../edata/index.php';
}

function log_error( $num, $str, $file, $line, $context = null ){
    $e = new ErrorException( $str, 0, $num, $file, $line );
    if(!_env('APP_DEV',false)){
        $message = date('Y-m-d H:i:s') . "\nType: " . get_class( $e ) . "; Message: {$e->getMessage()};\nFile: {$e->getFile()}; Line: {$e->getLine()};\n";
        $message .= 'Requested: ' . urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) . "\n";
        $logdir = CORE . "/logs/";
        if(!is_dir($logdir)) mkdir($logdir);
        $logfile = $logdir . date('Y-m-d') . '.log'; 
        file_put_contents($logfile, $message . PHP_EOL, FILE_APPEND );
    }
    display_error($e);
    exit;
}

// highlight the text in the error
function highlightText($text){
    $text = highlight_string("<?php " . $text, true);
    $text = preg_replace("|^\\<code\\>\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>|", "", $text, 1);
    $text = preg_replace("|\\</code\\>\$|", "", $text, 1);
    $text = trim($text);
    $text = preg_replace("|\\</span\\>\$|", "", $text, 1); 
    $text = trim($text);
    $text = preg_replace("|^(\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>)(&lt;\\?php&nbsp;)(.*?)(\\</span\\>)|", "\$1\$3\$4", $text);  // remove custom added "<?php "

    return $text;
}