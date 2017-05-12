<?php
namespace app\components;
class Logger {
    public static function curllog($msg) {
    	$fileName = __DIR__ . "/../../logs/curllog.txt";
        if (!file_exists($fileName)) {
            touch($fileName);
            chmod($fileName,0777);
        }

        file_put_contents($fileName , $msg."\n", FILE_APPEND);
        
    }	
}