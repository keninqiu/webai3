<?php
namespace app\components;
	class CurlUtil {
        public static function get_bearer($url,$bearer) {
            $authorization = "Authorization: Bearer $bearer";
         // create curl resource
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            // set url
            curl_setopt($ch, CURLOPT_URL, $url);

            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_USERAGENT,     "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // $output contains the output string
            $output = curl_exec($ch);

            // close curl resource to free up system resources
            curl_close($ch);
            return $output;
        }

        public static function get($url) {
         // create curl resource
            $ch = curl_init();

            // set url
            curl_setopt($ch, CURLOPT_URL, $url);

            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:19.0) Gecko/20100101 Firefox/19.0");            
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // $output contains the output string
            $output = curl_exec($ch);

            // close curl resource to free up system resources
            curl_close($ch);
            return $output;
        }

        public static function raw($string) {
           ob_start();
           passthru("$string");
           $var = ob_get_contents();
           ob_end_clean(); //Use this instead of ob_flush()
           return $var;
        }
    }