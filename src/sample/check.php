<?php

//コンフィグファイル
$config_file = "../../../demo/amenity/config/config.php";

//DB関数ファイル
$db_fnc     = "../../../demo/amenity/function/db.fnc";

//.htaccess
$htaccess   = "../../../demo/.htaccess";

//ファイル参照
$config = shell_exec("more $config_file | grep \"g_db_name\"");
$db     = shell_exec("head -55 $db_fnc");
$ht_ac  = shell_exec("cat $htaccess");

//正式DB名
$db_name = "amenity_demo_new";
//コンフィグDB名
$db_con_name = explode('"',$config);
if($db_name == $db_con_name[1]){
    $db_diff = "<br><font color=\"red\">参照先DBは正当です。</font>";
}else{
    $db_diff = "<br><font color=\"red\">不正なDBを参照しています。</font>";
}

//dbの改行などを置換
$db = str_replace("\n", "<br>",$db);
$db = str_replace("<hr>", "<br>", $db);
$db = str_replace("    ", "　　", $db);
$db = str_replace("\t", "　　", $db);
$db = str_replace("/*", "<b><font color=\"red\">/*<br>", $db);
$db = str_replace("*/", "*/</font></b><br>", $db);

//htaccessの改行を置換
$ht_ac = str_replace("\n", "<br>", $ht_ac);
$ht_ac = str_replace("#", "<font color=\"red\">#</font>", $ht_ac);

$check_man = $_SERVER["REMOTE_ADDR"];

print "移行手順<br>";
print "<br>";
print "1.バックアップ<br>";
print "<br>";
print "2.dataディレクトリは既存のものを使用<br>";
print "<br>";
print"■デモ用<br>";
print "<br>";
print "��.接続DBの変更 <br>";
print "<br>";
print "config/config.php <br>";
print "参照先DB名　：　<b><font color=\"red\">".$config."</font></b>";
print $db_diff."<br>";
print "<br>";
print "<br>";
print "<hr>";
print "��.帳票などで使用するDBを変更<br>";
print "function/db.fnc<br>";
print "<br>";
print "<hr>";
print "��.SQLに失敗してもデバッグしないように変更<br>";
print "function/db.fnc<br>";
print "<font color=\"red\">※赤く表示されている部分はコメントアウトです。正当な場所をコメントアウトしているか確認してください。</font><br>";
print "DB関数　：<br>".$db;
print "<hr>";
print "��.htaccessの確認<br>";
print "<font color=\"red\">※＃がある部分はコメントアウトです。</font><br>";
print $ht_ac;
print "<hr>";
print "<a href=check_man.php>チェック実施確認</a>";

shell_exec("date >> check.txt");
shell_exec("echo $check_man >> check.txt");

?>
