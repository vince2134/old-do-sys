
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="referer" method="post">

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
</form>
{*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
<form {$form.attributes}>
			{*+++++++++++++++ �إå��� begin +++++++++++++++*} {$var.page_header} {*--------------- �إå��� e n d ---------------*}
		</td>
	</tr>

	<tr align="center">
	

		{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
		<td valign="top">

			<table border="0">
				<tr>
					<td>

{if $smarty.post.form_search_button != "�����ե������ɽ��" && $smarty.post.form_button.show_button != "ɽ����"}
    {$form.form_search_button.html}
{else}
<table width="650">
    <tr>
        <td>

        <table class="Data_Table" border="1" width="350">
	        <tr>
		        <td class="Title_Purple" width="110"><b>���ʥ�����</b></td>
		        <td class="Value">{$form.form_make_goods_cd.html}</td>
	        </tr>
	        <tr>
		        <td class="Title_Purple" width="110"><b>��¤��̾</b></td>
		        <td class="Value">{$form.form_make_goods_name.html}</td>
	        </tr>
        </table>

        </td>
        <td valign="bottom">

        <table class="Data_Table" border="1" width="300">
	        <tr>
		        <td class="Title_Purple" width="110"><b>���Ϸ���</b></td>
		        <td class="Value">{$form.form_output_type.html}</td>
	        </tr>
        </table>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">
        <table width=''>
	        <tr>
		        <td align="right">{$form.form_button.show_button.html}����{$form.form_button.clear_button.html}</td>
	        </tr>
        </table>
        </td>
    </tr>
</table>
{/if}

<br>
{*--------------- ����ɽ���� e n d ---------------*}

					</td>
				</tr>

				<tr>
					<td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
	<tr>
		<td width="50%" align="left">��<b>{$var.search_num}</b>��</td>
	</tr>
</table>

<table class="List_Table" border="1" width="450">
	<tr align="center">
		<td class="Title_Purple" width=""><b>No.</b></td>
		<td class="Title_Purple" width=""><b>���ʥ�����</b></td>
		<td class="Title_Purple" width=""><b>��¤��̾</b></td>
	</tr>
        {foreach from=$make_goods_data key=i item=items}
	<tr class="Result1">
		<td align="right">
                {if $smarty.post.f_page1 != null}
                {$smarty.post.f_page1*100+$i-99}
                {else if}
                {$i+1}  
                {/if}   
                </td>
                {foreach from=$items key=j item=item}
                {if $j == 0}
		<td align="left">{$item}</a></td>
                {elseif $j == 1}
		<td align="left"><a href="1-1-224.php?goods_id={$item}">
                {elseif $j == 2}
                {$item}</a></td>
                {/if}
                {/foreach}
	</tr>
        {/foreach}

</table>
{$var.html_page2}

{*--------------- ����ɽ���� e n d ---------------*}

					</td>
				</tr>
			</table>
		</td>
		{*--------------- ����ƥ���� e n d ---------------*}

	</tr>
</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
	

