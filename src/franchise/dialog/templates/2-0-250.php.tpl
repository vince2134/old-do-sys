{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="document.dateForm.form_client_name.focus();">
<form {$form.attributes}>

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%">

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}

{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="250" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">{if $var.display == "2-409" || $var.display == "2-405"}����{else}����{/if}�襳����</td>
        <td class="Value">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">{if $var.display == "2-409" || $var.display == "2-405"}����{else}����{/if}��̾���եꥬ��</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
    {if $var.display == "2-405" || $var.display == "2-409"}
    <tr>
        <td class="Title_Purple">��ԥ���</td>
        <td class="Value">{$form.form_bank_kana.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����̾��</td>
        <td class="Value">{$form.form_account_name.html}</td>
    </tr>
    {/if}
    <tr>
        <td class="Title_Purple">�϶�</td>
        <td class="Value">{$form.form_area_id.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_state.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ɽ����</td>
        <td class="Value">{$form.form_turn.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_button.show_button.html}����{$form.form_button.close_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$form.hidden}

<table width="100%">
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1" width="450">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">{if $var.display == "2-409" || $var.display == "2-405"}����{else}����{/if}�襳����<br>{if $var.display == "2-409" || $var.display == "2-405"}����{else}����{/if}��̾</td>
        <td class="Title_Purple">ά��</td>
        <td class="Title_Purple">�϶�</td>
        <td class="Title_Purple">����</td>
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right" width="30">
            {if $smarty.post.form_show_page != 2 && $smarty.post.f_page1 != ""}
                {$smarty.post.f_page1*100+$j-99}
            {else if}
            ��  {$j+1}  
            {/if}   
        </td>               
        <td>
            {$row[$j][0]}-{$row[$j][1]}<br>
            {if $row[$j][5] == 'true'}
				<!-- ��Ƚ�� -->
				{if $var.display == 5}
					<!-- ����ޥ��� -->
					<a href="#" onClick="returnValue=Array({$return_data[$j]});window.close();">{$row[$j][2]}</a>
				{elseif $var.display == "2-409" || $var.display == "2-405"}
					<!-- �������� -->
					<a href="#" onClick="returnValue=Array({$return_data[$j]});window.close();">{$row[$j][2]}</a>
				{elseif $var.display == "3"}
					<a href="#" onClick="returnValue=Array({$return_data[$j]});window.close();">{$row[$j][2]}</a>
				{else}
            		<a href="#" onClick="returnValue=Array('{$row[$j][0]}','{$row[$j][1]}','{$return_data[$j]}');window.close();">{$row[$j][2]}</a>
				{/if}
            {else}
            {$row[$j][2]}
            {/if}
        </td>
        </td>
        <td>{$row[$j][3]}</td>
        <td align="center">{$row[$j][4]}</td>
        <td align="center">{$row[$j][8]}</td>
    </tr>
    {/foreach}
</table>
{$var.html_page2}

        </td>
    </tr>
</table>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- ����ƥ���� e n d ---------------*}

</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
