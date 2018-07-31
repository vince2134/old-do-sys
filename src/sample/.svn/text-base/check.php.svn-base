<?php

//¥³¥ó¥Õ¥£¥°¥Õ¥¡¥¤¥ë
$config_file = "../../../demo/amenity/config/config.php";

//DB´Ø¿ô¥Õ¥¡¥¤¥ë
$db_fnc     = "../../../demo/amenity/function/db.fnc";

//.htaccess
$htaccess   = "../../../demo/.htaccess";

//¥Õ¥¡¥¤¥ë»²¾È
$config = shell_exec("more $config_file | grep \"g_db_name\"");
$db     = shell_exec("head -55 $db_fnc");
$ht_ac  = shell_exec("cat $htaccess");

//Àµ¼°DBÌ¾
$db_name = "amenity_demo_new";
//¥³¥ó¥Õ¥£¥°DBÌ¾
$db_con_name = explode('"',$config);
if($db_name == $db_con_name[1]){
    $db_diff = "<br><font color=\"red\">»²¾ÈÀèDB¤ÏÀµÅö¤Ç¤¹¡£</font>";
}else{
    $db_diff = "<br><font color=\"red\">ÉÔÀµ¤ÊDB¤ò»²¾È¤·¤Æ¤¤¤Þ¤¹¡£</font>";
}

//db¤Î²þ¹Ô¤Ê¤É¤òÃÖ´¹
$db = str_replace("\n", "<br>",$db);
$db = str_replace("<hr>", "<br>", $db);
$db = str_replace("    ", "¡¡¡¡", $db);
$db = str_replace("\t", "¡¡¡¡", $db);
$db = str_replace("/*", "<b><font color=\"red\">/*<br>", $db);
$db = str_replace("*/", "*/</font></b><br>", $db);

//htaccess¤Î²þ¹Ô¤òÃÖ´¹
$ht_ac = str_replace("\n", "<br>", $ht_ac);
$ht_ac = str_replace("#", "<font color=\"red\">#</font>", $ht_ac);

$check_man = $_SERVER["REMOTE_ADDR"];

print "°Ü¹Ô¼ê½ç<br>";
print "<br>";
print "1.¥Ð¥Ã¥¯¥¢¥Ã¥×<br>";
print "<br>";
print "2.data¥Ç¥£¥ì¥¯¥È¥ê¤Ï´ûÂ¸¤Î¤â¤Î¤ò»ÈÍÑ<br>";
print "<br>";
print"¢£¥Ç¥âÍÑ<br>";
print "<br>";
print "­¡.ÀÜÂ³DB¤ÎÊÑ¹¹ <br>";
print "<br>";
print "config/config.php <br>";
print "»²¾ÈÀèDBÌ¾¡¡¡§¡¡<b><font color=\"red\">".$config."</font></b>";
print $db_diff."<br>";
print "<br>";
print "<br>";
print "<hr>";
print "­¢.Ä¢É¼¤Ê¤É¤Ç»ÈÍÑ¤¹¤ëDB¤òÊÑ¹¹<br>";
print "function/db.fnc<br>";
print "<br>";
print "<hr>";
print "­£.SQL¤Ë¼ºÇÔ¤·¤Æ¤â¥Ç¥Ð¥Ã¥°¤·¤Ê¤¤¤è¤¦¤ËÊÑ¹¹<br>";
print "function/db.fnc<br>";
print "<font color=\"red\">¢¨ÀÖ¤¯É½¼¨¤µ¤ì¤Æ¤¤¤ëÉôÊ¬¤Ï¥³¥á¥ó¥È¥¢¥¦¥È¤Ç¤¹¡£ÀµÅö¤Ê¾ì½ê¤ò¥³¥á¥ó¥È¥¢¥¦¥È¤·¤Æ¤¤¤ë¤«³ÎÇ§¤·¤Æ¤¯¤À¤µ¤¤¡£</font><br>";
print "DB´Ø¿ô¡¡¡§<br>".$db;
print "<hr>";
print "­¤.htaccess¤Î³ÎÇ§<br>";
print "<font color=\"red\">¢¨¡ô¤¬¤¢¤ëÉôÊ¬¤Ï¥³¥á¥ó¥È¥¢¥¦¥È¤Ç¤¹¡£</font><br>";
print $ht_ac;
print "<hr>";
print "<a href=check_man.php>¥Á¥§¥Ã¥¯¼Â»Ü³ÎÇ§</a>";

shell_exec("date >> check.txt");
shell_exec("echo $check_man >> check.txt");

?>
