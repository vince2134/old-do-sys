{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="Form_Set(); Onload_Focus();">

<script language="javascript">
{$html.js}
</script>

<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%">

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* エラーメッセージ *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $form.err_client_cd1.error != null}
    <li>{$form.err_client_cd1.error}<br>
{/if}
</ul>
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="170" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">表示件数</td>
        <td class="Value">{$form.form_range.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">検索方法</td>
        <td class="Value">{$form.form_method.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ショップコード 上6桁<font color="#ff0000;" id="required">※</font></td>
        <td class="Value"><span id="method1"></span></td>
    </tr>
    <tr>
        <td class="Title_Purple">ショップコード 下4桁</td>
        <td class="Value"><span id="method2"></span></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.show_button.html}　{$form.clear_button.html}　{$form.close_button.html}{*　{$form.form_test.html}*}</td>
    </tr>
</table>

        </td>
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
        <td>

{$html.html_page}
{$html.html_l}
{$html.html_page2}

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
