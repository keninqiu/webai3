<?php
namespace app\components;
class Logger {

	public static function logToFile($fileName,$msg) {
        if (!file_exists($fileName)) {
            touch($fileName);
            chmod($fileName,0777);
        }

        file_put_contents($fileName , $msg."\n", FILE_APPEND);
	}

	public static function log($msg) {
    	$fileName = __DIR__ . "/../../logs/log.txt";
    	self::logToFile($fileName,$msg);
	}

    public static function curllog($msg) {
    	$fileName = __DIR__ . "/../../logs/curllog.txt";
    	self::logToFile($fileName,$msg);
        
    }	
}