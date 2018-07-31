{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">


<table width="100%" height="90%" class="M_table">


    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>

    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<input type="button" value="自動引落データ作成" onclick="javascript:location='1-2-309.php'">
<input type="button" value="振替結果アップロード" style="color: #ff0000;" onclick="javascript:location='1-2-407.php'">
<input type="button" value="振替結果照会" onclick="javascript:location='1-2-407_1.php'">
<br><br><br>
<br>
<table class="List_Table" border="1" width="400">
<col width="120" style="font-weight: bold;">
    <tr style="font-weight: bold;">
        <td class="Title_Pink">振替結果ファイル</td>
        <td class="Value"><input type="file"></td>
    </tr>
</table>
<table width="400">
    <tr>
        <td align="right"><input type="button" value="アップロード"></td>
    </tr>
</table>

<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="100%">
    <tr>

    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- 画面表示２ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
