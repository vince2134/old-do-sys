{$var.html_header}

<SCRIPT>
<!--

{literal}
function Change_Data(id) {
	document.forms[0].update_button.value="変更前";
	document.forms[0].branch_id.value=id;
	document.forms[0].submit();
}
{/literal}

{$var.js}

//-->
</SCRIPT>


<body class="bgimg_purple">
<form {$form.attributes}>

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{* -------------------- 画面表示１start -------------------- *}

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* 登録・変更完了メッセージ出力 *}
{if $var.comp_msg != null}
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;"><li>{$var.comp_msg}</span><br><br>
{/if}

{* 完了メッセージ出力 *}
{if $var.mesg!=NULL }
	<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
		<li>{$var.mesg}</li><BR>
	</span>
{/if}

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
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">{$form.branch_cd.label}<font color="#ff0000">※</font></td>
        <td class="Value">{$form.branch_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">{$form.branch_name.label}<font color="#ff0000">※</font></td>
        <td class="Value">{$form.branch_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">{$form.bases_ware_id.label}<font color="#ff0000">※</font></td>
        <td class="Value">{$form.bases_ware_id.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">{$form.note.label}</td>
        <td class="Value">{$form.note.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
    {if $smarty.session.part_permit == 'w'}
        <td style="color: #ff0000; font-weight: bold;">※は必須入力です</td>
        
    {/if}
    </tr>
    <tr>
        <td>{if $var.get_part_id != NULL}{$form.del_button.html}{/if}<td>
        <td align="right">{$form.regist_button.html}　{$form.clear_button.html}</td>
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

全<b>{$var.total_count}</b>件　　{$form.csv_button.html}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">{$form.branch_cd.label}</td>
        <td class="Title_Purple">{$form.branch_name.label}</td>
        <td class="Title_Purple">{$form.bases_ware_id.label}</td>
        <td class="Title_Purple">{$form.note.label}</td>
    </tr>
		{foreach from=$branch_data item=branch_data}
    <tr class="Result1"> 
        <td align="right">{$branch_data.no}</td>
        <td><a href="" OnClick="Javascript:Change_Data({$branch_data.branch_id});return false;">{$branch_data.branch_cd}</a></td>
        <td>{$branch_data.branch_name}</td>
        <td>{$branch_data.ware_name}</td>
        <td>{$branch_data.note}</td>
    </tr>
    {/foreach}
    {$form.hidden}
    </form>
</table>
{*--------------- 画面表示２ e n d ---------------*}

        </td>
    </tr>
</table>

                    </td>   
                </tr>   
            </table>
        </td>   
    </tr>   
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
