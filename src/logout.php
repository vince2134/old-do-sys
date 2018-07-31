<?php
$page_title="ログアウト";

// 環境設定ファイル読み込み
require_once("ENV_local.php");

// セッションを破棄する
session_start();
session_unset();
session_destroy();

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header("$page_title");

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

//HTML****************************************/

echo "

$html_header

<body>
<style type='text/css'>
table{
    color: #ffffff;
}
a{
    color: #ffffff;
}
</style>

<!---------------------- 画面タイトルテーブル --------------------->

<table border='0' width='90%' height='90%' align='center'>
<tr><td valign='middle' align='center'>

   <table border='0' width='480' height='350'>
    <tr bgcolor='#213B82' align='center' valign='middle'>
     <td>
        <font size='5'><b>正常にログアウトしました</b></font><br><br><br>
        <img src='".IMAGE_DIR."do_amenity3.gif'><br><br><br>
		<a href='".LOGIN_PAGE."'>もう一度ログインする場合は<br>ここをクリックしてください</a>
     </td>
    </tr>
   </table>

</td></tr></table>

$html_footer
";
?>
