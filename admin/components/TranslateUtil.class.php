<?php
namespace app\components;

class TranslateUtil {
/*
[[["Neutrogena Ultra Sheer SPF 60","Neutrogena Ultra Sheer SPF 60",null,null,3],[null,null,"Neutrogena Ultra Sheer SPF 60"]],null,"en",null,null,[["Neutrogena Ultra Sheer SPF 60",null,[["Neutrogena Ultra Sheer SPF 60",0,true,false],["露得清超薄纱SPF 60",0,true,false]],[[0,29]],"Neutrogena Ultra Sheer SPF 60",0,0]],0.21560706,null,[["en"],null,[0.21560706],["en"]]]

["Neutrogena Ultra Sheer SPF 60","Neutrogena Ultra Sheer SPF 60",null,null,3],[null,null,"Neutrogena Ultra Sheer SPF 60"]],null,"en",null,null,[["Neutrogena Ultra Sheer SPF 60",null,[["Neutrogena Ultra Sheer SPF 60",0,true,false],["露得清超薄纱SPF 60",0,true,false]],[[0,29]],"Neutrogena Ultra Sheer SPF 60",0,0]],0.21560706,null,[["en"],null,[0.21560706],["en"]
*/	


	public static function toChinese($string) {
		//$string = rawurlencode($string);
		$string = preg_replace("/\"/","\\\"",$string);
		$url = "curl 'https://www.bing.com/translator/api/Translate/TranslateArray?from=-&to=zh-CHS' -H 'Cookie: mtstkn=ZMzR03fq929JDevxivmlfLHxa4M6ckB6NW9WCE8grhSWc%2FZTiX3n8eWXsCDIjLP8; MUID=38E4E39790A96E1A2A1CE91794A96DE8; _EDGE_S=SID=0642B306F1436B1B05A7B986F0C76AA8; MUIDB=38E4E39790A96E1A2A1CE91794A96DE8; MicrosoftApplicationsTelemetryDeviceId=bb297537-482a-ff9a-f545-70f014fa93bb; MicrosoftApplicationsTelemetryFirstLaunchTime=1494554224434; WLS=TS=63630150750; SRCHD=AF=NOFORM; SRCHUID=V=2&GUID=451DB768C7324505AD4024D83FAA3805; SRCHUSR=DOB=20170512; _SS=SID=0642B306F1436B1B05A7B986F0C76AA8; srcLang=-; smru_list=; sourceDia=en-US; destLang=zh-CHS; dmru_list=en%2Czh-CHS; destDia=zh-CN' -H 'Origin: https://www.bing.com' -H 'Accept-Encoding: gzip, deflate, br' -H 'Accept-Language: en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36' -H 'Content-Type: application/json; charset=UTF-8' -H 'Accept: application/json, text/javascript, */*; q=0.01' -H 'Referer: https://www.bing.com/translator' -H 'X-Requested-With: XMLHttpRequest' -H 'Connection: keep-alive' --data-binary '[{\"id\":-1018245542,\"text\":\"$string\"}]' --compressed";
		$result = CurlUtil::raw($url);
		Logger::curllog("url====$url");
		Logger::curllog("result in toChinese====$result");

		$result = json_decode($result,true);
		$retString = "";
		if($result) {
			$result = $result["items"];
			if($result) {
				$result = $result[0];
				if($result) {
					$retString = $result["text"];
				}					
			}			
		}
		//Logger::curllog("retString====$retString");
		//$retString = urldecode($retString);
		return $retString;
	}
}

