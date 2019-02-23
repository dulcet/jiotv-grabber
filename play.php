<?php
/*
PROJECT : JIO TV GRABBER
AUTHOR : PYTH@N
EMAIL: python911@protonmail.com
------------------/-/
download play.php file on your pc (make sure apache + php is installed ...
to stream channel run url i.e http://localhost/play.php?c=channel&q=quality
replace channel with channel name i.e dsport and quality with 800 or 1200 or 200 or 600 
most channels will work on 600 & 1200 quality... 

it needs token i have included in file already you dont need to download token ..
unless you know what is token and it works !! download and regenerate keys fir token and replace my github url 
on line 31 i.e : $p= @file_get_constants(yourtoken/");
*/

header("Content-Type: application/vnd.apple.mpegurl");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Expose-Headers: Content-Length,Content-Range");
header("Access-Control-Allow-Headers: Range");
header("Accept-Ranges: bytes");
//// TIME ZONE TELLS API SERVER that user is from india even if you are not from india 
date_default_timezone_set('Asia/Kolkata');
/// this is location where cache files will be stored, cache file contains playable raw links .ts
$cache= (string)date("dHi") . ".txt";


if(!file_exists($cache)){

//// token which will call jio accounts and login as jio user ..
$p= @file_get_contents("https://raw.githubusercontent.com/python9111/jiotv-grabber/master/token.php/");

//// you can choose $p only if you want load channel from tokens only and not from cache it will will use more RAM

file_put_contents($cache, $p);
}
else
{
$p=file_get_contents($cache);

}


if($p!="" && @$_REQUEST["c"]!=""){

//// YOU CAN UPDATE THIS PLAYER if needed , e.g server thinks you are using ANDROID PHONE 
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: ExoPlayerDemo/5.2.0 (Linux;Android 4.4.4) ExoPlayerLib/2.3.0\r\n" 


    ]u
];

$cx = stream_context_create($opts);
//// you can change host i.e sbbsrcdnems05 if you are not getting links from this host.

$hs = file_get_contents("http://sbbsrcdnems05.cdnsrv.jio.com/jiotv.live.cdn.jio.com/" . $_REQUEST["c"] . "/" . $_REQUEST["c"] . "_" . $_REQUEST["q"] . ".m3u8" .  $p,false,$cx);


$hs= @preg_replace("/" . $_REQUEST["c"] . "_" . $_REQUEST["q"] ."-([^.]+\.)ts/", 'http://shdbdcdnems01.cdnsrv.jio.com/jiotv.live.cdn.jio.com/'  . $_REQUEST["c"] . '/' .   $_REQUEST["c"] . '_' . $_REQUEST["q"] . '-\1ts', $hs);
$hs= @preg_replace("/" . $_REQUEST["c"] . "_" . $_REQUEST["q"] ."-([^.]+\.)key/", 'http://shdbdcdnems01.cdnsrv.jio.com/jiotv.live.cdn.jio.com/'  . $_REQUEST["c"] . '/' .   $_REQUEST["c"] . '_' . $_REQUEST["q"] . '-\1key', $hs);


$hs=str_replace("https://tv.media.jio.com/streams_live/" .  $_REQUEST["c"] . "/","",$hs);
$hs = str_replace("https://tv.media.jio.com/streams_hotstar/" . $_REQUEST["c"] . "/","",$hs);

echo $hs;

}

?>
