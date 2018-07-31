{$var.html_header}

<body bgcolor="#D8D0C8">
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

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="850">
<col width="110" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">出力形式</td>
        <td class="Value">{$form.form_output_type.html}</td>
        <td class="Title_Purple">表示件数</td>
        <td class="Value">{$form.form_show_page.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">得意先コード</td>
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Purple">得意先名・略称</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
{*直営以外のショップでは表示しない*}
    {if $smarty.session.group_kind == '2'}
    <tr>
        <td class="Title_Purple">代行業者コード</td>
        <td class="Value">{$form.form_trust.html}</td>
        <td class="Title_Purple">代行業者名・略称</td>
        <td class="Value">{$form.form_trust_name.html}</td>
    </tr>
    {/if}
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value">{$form.form_area_id.html}</td>
        <td class="Title_Purple">TEL</td>
        <td class="Value">{$form.form_tel.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">契約担当者1</td>
        <td class="Value">{$form.form_c_staff_id1.html}</td>
        <td class="Title_Purple">巡回担当者</td>
        <td class="Value">{$form.form_con_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">契約状態</td>
        <td class="Value" colspan="3">{$form.form_state.html}</td>
{*
        <td class="Title_Purple">表示順</td>
        <td class="Value" colspan="3">{$form.form_turn.html}</td>
*}
    </tr>
</table>

<table width="850" >
    <tr>
        <td align="right">{$form.form_button.show_button.html}　　{$form.form_button.clear_button.html}</td>
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
{$form.hidden}

{if $var.display_flg == true}
<table width="100%">
    <tr>
        <td>

{*
{if $smarty.post.form_show_page == 2 && $smarty.post.form_button.show_button == "表　示"}
    {if $var.state_type != null}
        契約状態　：　{$var.state_type}<br>全{$var.match_count}件
    {else}
        全{$var.match_count}件
    {/if}        
{else}
    {if $var.state_type != null}
    契約状態　：　{$var.state_type}
    {/if}
    {$var.html_page}
{/if}
*}

{if $smarty.post.form_show_page != 2 }
{$var.html_page}
{else}
全<b>{$var.match_count}</b>件
{/if}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_area"}</td>
        <td class="Title_Purple">TEL</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_staff_cd"}</td>
        <td class="Title_Purple">契約状態</td>
        <td class="Title_Purple">巡回担当者</td>
{*直営以外のショップでは表示しない*}
    {if $smarty.session.group_kind == '2'}
        <td class="Title_Purple">代行先コード<br>代行先名</td>
    {/if}
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">
            {*表示ボタンが押下された場合NOを1からカウント*}
            {if $smarty.post.form_button.show_button == "表　示"}
                {$j+1}
            {*契約状態変更によってページが減った場合*}
            {elseif $var.page_change == true}
                {$smarty.post.f_page1*100+$j-199}
            {elseif $smarty.post.form_show_page != 2 && $smarty.post.f_page1 != ""}
                {$smarty.post.f_page1*100+$j-99}
            {else if}
                {$j+1}
            {/if}
        </td>               
        <td>
            {$row[$j].client_cd1}-{$row[$j].client_cd2}<br>
            <a href="2-1-115.php?client_id={$row[$j].client_id}&get_flg=con">{$row[$j].client_name}</a></td>
        </td>
        <td>{$row[$j].client_cname}</td>
        <td>{$row[$j].area_name}</td>
        <td>{$row[$j].tel}</td>
        <td>{$row[$j].charge_cd}<br>{$row[$j].staff_name}</td>
        <td>{$row[$j].state}</td>
        <td>{$row[$j].staff2}</td>
{*直営以外のショップでは表示しない*}
    {if $smarty.session.group_kind == '2'}
        <td>{$row[$j].trust}</td>
    {/if}
    </tr>
    {/foreach}
</table>
{if $smarty.post.form_show_page != 2 }
{$var.html_page2}
{/if}

        </td>
    </tr>
</table>

{/if}
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
