<?php

// �ڡ��������ȥ�
$page_title = "���¤�����ޤ���";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML�إå�
$html_header = Html_Header("$page_title");

// HTML�եå�
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
                        ���¤�����ޤ���
                        </span><br>
                        <br>
                        <br>
                        <form name=\"form\">
                        <input type=\"button\" name=\"button\" value=\"�ᡡ��\" onClick=\"javascript:history.back()\"\>
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
