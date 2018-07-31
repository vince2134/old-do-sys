
{$var.html_header}

<body background="../../../image/back_purple.png">
<form name="dateForm" method="post">
<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="left">
		<td width="14%" valign="top" lowspan="2">
			<!-- メニュー開始 --> {$var.page_menu} <!-- メニュー終了 -->
		</td>

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border=0  width="100%">
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->


<table width="100%" height="100%">
<tr>
    <td valign="middle" align="center">
    <table border="1" width="900" height="630" bordercolor="#808080" bordercolordark="#808080" cellspacing=0 cellpadding=0 rules=none bgcolor="white">
    <tr>
        <td valign="top" colspan="2">
        <table width="100%" height="60" border="0" bgcolor="#333333">
        <tr>
            <td><font size="8" color="red">work</font><font size="8" color="white">recorder</td>
        </tr>
        </table>
        </td>
    </tr>
    <tr>
        <td>
        <table height="100%" border="0" width="210">
        <tr>
            <td height="50%" align="center" valign="middle">
            <form  {$form.attributes}>
            <center><font color="red">※</font>日付を選択してください</center>
            <table width="150"border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing=0 cellpadding=10 rules="none">
            </tr>
                <td>{$form.year.html}{$form.year.label}</td>
                <td>{$form.month.html}{$form.month.label}</td>
            </tr>
            <tr>
                <td colspan="2" height="50" align="right">{$form.btn.html}</td>
            </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td height="50%"><b></td>
        </tr>
        </table>
        </form>
        </td>
        <td align="center" valign="middle">
        <font size="5"><b>{$smarty.session.year}年{$smarty.session.month}月</b></font>
        <table width="650" height="400" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing=0 cellpadding=10>
        <tr height="20">
        {foreach key=key name=outer item=items from=$youbi}
            {if $key eq 0}
                <td align="center" bgcolor="#FF9933"><font color="red">{$items}</td>
            {elseif $key eq 6}
                <td align="center" bgcolor="#66CCFF"><font color="blue">{$items}</td>
            {else}
                <td align="center"  bgcolor="#cccccc">{$items}</td>
            {/if}
        {/foreach}
        </tr>
        {foreach name=outer item=items from=$dd}
        <tr>
            {foreach key=key item=item from=$items}
                {if $key eq 0}
                    <td align="left" valign="top" bgcolor="#FFFF99"><a href="" style="color:red" ><font size="4">{$item}</font></a></td>
                {elseif $key eq 6}
                    <td align="left" valign="top" bgcolor="#99FFFF"><a href="" style="color:blue"><font size="4">{$item}</font></a></td>
                {else}
                    <td align="left" valign="top" ><a href="" style="color:black"><font size="4">{$item}</font></a></td>
                {/if}
            {/foreach}
        </tr>
        {/foreach}
        </table>
        </td>
    </tr>
    <tr>
        <td valign="bottom" colspan="2">
        <table width="100%" height="20" border="0" bgcolor="#D3D3D3">
        <tr>
            <td>
            </td>
        </tr>
        </table>
        </td>
    </tr>
    </table>
    </td>
</tr>
</table>

<!--******************** 画面表示2終了 *******************-->


					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

{$var.html_footer}
	

