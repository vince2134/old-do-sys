<?php

// ページタイトル
$page_title = "権限がありません";

// 環境設定ファイル
require_once("ENV_local.php");

// HTMLヘッダ
$html_header = Html_Header("$page_title");

// HTMLフッタ
$html_footer = Html_Footer();


echo "

$html_header

<body onload=\"document.form.button.focus()\">

<table width=\"90%\" height=\"90%\" align=\"center\">
    <tr>
        <td align=\"center\" valign=\"middle\">

            <table width=\"480\" height=\"350\">
                <tr align=\"center\" valign=\"middle\">
                    <td>
                        <span style=\"font: bold 18px; color: #ff0000;\">
                        権限がありません
                        </span><br>
                        <br>
                        <br>
                        <form name=\"form\">
                        <input type=\"button\" name=\"button\" value=\"戻　る\" onClick=\"javascript:history.back()\"\>
                        </form>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
                        
$html_footer

";

?>
