
{$var.html_header}
<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*------------------- 外枠開始 --------------------*}
<table border=0 width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
        </td>
    </tr>

    <tr align="center">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

{*-------------------- エラー表示開始 -------------------*}
{if $errors!=NULL }
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
		{foreach from=$errors item=errors}
		<li>{$errors}</li><BR>
		{/foreach}
	</span>
{/if}
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

{*-------------------- 画面表示1開始 -------------------*}
                    </td>
                </tr>


                <tr>
                    <td>
{********************* 画面表示2終了 ********************}


                    </td>
                </tr>
            </table>
        </td>
        {********************* 画面表示終了 ********************}

    </tr>
</table>
{******************** 外枠終了 *********************}
{$var.html_footer}
