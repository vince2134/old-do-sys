{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    {if $var.freeze_flg == true}
    	<tr align="center" valign="top" height="160">
	{else}
		<tr align="center" valign="top">
	{/if}
        <td>
            <table>

<!-- 登録確認メッセージ表示 -->
{if $var.freeze_flg == true}
	        <tr>
                <td>
	<span style="font: bold;"><font size="+1">受注完了しました。<br><br>
	</font></span>
	<table width="100%">
	    <tr>
	        <td align="right">{$form.ok_button.html}　{$form.return_button.html}</td>
	    </tr>
	</table>
			   </td>
           </tr> 
{else}
    {* ヘッダー項目出力&項目出力&データ出力 *} 
    {$var.html}
                <tr>
                    <td>

                    {if $smarty.get.del_flg == true}
                        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
                        <li>発注が取り消されたため、登録できませんでした。</li>
                        </span>
                    {/if}
                    {if $smarty.get.aord_del_flg == true}
                        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
                        <li>受注が削除されたため、チェック完了できませんでした。</li>
                        </span>
                    {/if}
                    {if $smarty.get.add_del_flg == true}
                        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
                        <li>受注が削除されたため、変更できませんでした。</li>
                        </span>
                    {/if}
                    {if $smarty.get.add_flg == true}
                        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
                        <li>既に受注登録は完了しています。</li>
                        </span>
                    {/if}
                        <table width="100%">
                        <tr>
                            <td align="right">{$form.ok_button.html}　{$form.return_button.html}</td>
                        </tr>
                        </table>
                    </td>
                </tr> 
{/if}               
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
