<?php

// 環境設定ファイル指定
require_once("ENV_local.php");

// DB接続設定
$db_con = Db_Connect();

$num    = $_POST["num"];
$page   = $_SERVER["PHP_SELF"]."#".$num;

$select  = "<select name=\"num\">";
for ($i=0; $i<100; $i++){
$selected = ($_POST["num"] == $i) ? " selected" : null;
$select .= "<option value=\"$i\"$selected>$i</option>";
}
$select .= "</select>行目に";

for ($i=0; $i<100; $i++){
$text .= "<A Name=\"$i\"><input type=\"text\" name=\"text$i\" value=\"$i\"><br></A>";
}

$html  = "
<html>
<head>
</head>
<body onload=\"document.form.text$num.focus()\">
<form name=\"form\" action=\"$page\" method=\"post\">
$select
<input type=\"submit\" name=\"submit\" value=\"フォーカス\"><hr>
$text
</form>
</body>
</html>
";

print $html;
?>
