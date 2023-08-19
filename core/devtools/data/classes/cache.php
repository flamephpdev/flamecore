<?php

namespace DEV;

use Cache\Views\Flame\FlameRender;
use Core\App\Config\Config;
use Routing\Route;

class Cache extends ClassROOT {

    public static function modify($args){
        $args = self::mkprops($args,true);
        if(isset($args[0]) && !isset($args[1])) {
            if($args[0] == 'clear'){
                if(is_dir(cache('/'))) deleteDir(cache('/'));
                headerPrintBg('Cache cleared', true);
                return;
            } else if($args[0] == 'mails'){
                return self::mails();
            } else if($args[0] == 'make'){
                return self::make();
            }
        }
        headerPrintBg('Unknow command "' . $args[0] . '"', true);
    }

    private static function mails(){
        $mailsdir = CACHE . '/xmail-demo/';
        if(is_dir($mailsdir)){
            headerPrintBg('Mailbox 📮', true);
            foreach(scanDirectory($mailsdir) as $i => $file){
                if(str_ends_with($file, '.php')){
                    $mail = require $mailsdir . $file;
                    _e();
                    _e('Mail');
                    _e('From: ' . $mail[0]);
                    _e('To: ' . $mail[1]);
                    _e('Subject: ' . $mail[2]);
                    _e('Body: ' . $mail[3]);
                    _e('Sent at: ' . $mail['sent_at']);
                }
            }
        } else {
            _e('No Mails Found');
        }
    }

    private static function make() {
        info("Caching...");
        Config::cache();
        success("Config cached");
        $dirs = getDirContents(
            root('/views')
        );
        ob_start();
        foreach($dirs as $file) {
            if(!is_dir($file)) {
                $file = str_replace(
                        path(root('/views/')), '',
                        str_replace(
                            [
                                '.flame.php',
                                '.flame.js',
                                '.flame.css'
                            ], 
                            ['', '.js', '.css'],
                            path($file)
                        )
                );
                FlameRender::include($file);
            }
        }
        ob_get_clean();
        success("Views cached");
        Route::load();
        success("Routes cached");
    }

}