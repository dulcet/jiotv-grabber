<?php

/*
PROJECT : JIO TV GRABBER
AUTHOR : PYTH@N
EMAIL: python911@protonmail.com
-----------------
JIOTV TOKEN USED IN play.php TO GENERATE sessions and key for JIOtv streams can be streamed on localhost
you can generate your own token and replace $jctBASE = "yoirtoken" ssoToken works as login auth key or signin token and user gets auth with jio streaming server.
you can use this on localhost - 
NOTE: its for personal use DO NOT SELL , USE FOR COMMERICIAL USE
*/


$jctBase = "cutibeau2ic";

$ssoToken = "AQIC5wM2LY4SfczEZE2fGevb0t17TAm-G9kAMvxhtxL4oGU.*AAJTSQACMDIAAlNLABQtMTkwNjA5MTA1OTI5NDc0NTI1MgACUzEAAjQ4*";

function tokformat($str)
{
$str= base64_encode(md5($str,true));

return str_replace("\n","",str_replace("\r","",str_replace("/","_",str_replace("+","-",str_replace("=","",$str)))));

}


function generateJct($st, $pxe) 
{
 global $jctBase;
 return trim(tokformat($jctBase . $st . $pxe));
}

function generatePxe() {
return time() + 6000000;
}

function generateSt() {
global $ssoToken;
return tokformat($ssoToken);
}

function generateToken() {
$st = generateSt();
$pxe = generatePxe();
$jct = generateJct($st, $pxe);

return "?jct=" . $jct . "&pxe=" . $pxe . "&st=" . $st;
}

echo generateToken();

?>
