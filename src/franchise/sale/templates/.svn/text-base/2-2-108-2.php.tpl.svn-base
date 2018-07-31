
{$var.html_header}
<script>{$var.js}</script>
<body bgcolor="#D8D0C8" >
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

{*-------------------- 画面表示1開始 -------------------*}

<table class="List_Table" border="1" >
<col width="20">
<col width="80">
<col width="80">
<col width="250">
<col width="100">
	<tr align="center">
		<td class="Title_Pink"><b>No.</b></td>
		<td class="Title_Pink"><b>受注番号</b></td>
        <td class="Title_Pink"><b>巡回予定日</b></td>
		<td class="Title_Pink"><b>得意先</b></td>
		<td class="Title_Pink"><b>巡回担当者</b></td>
	</tr>

    {foreach from=$demo_data item=item key=i}
    <tr>
        <td class="Value" align="right">{$i+1}</b></td>
        <td class="Value"><a href="2-2-106.php">{$demo_data[$i][0]}</a></td>
        <td class="Value" align="center">{$demo_data[$i][1]}</td>
        <td class="Value">{$demo_data[$i][2]}</td>
        <td class="Value">{$demo_data[$i][3]}</td>
    </tr>
    {/foreach}

</table>

<br>

<table width="550" border="0">
    <tr align="center">
        <td align="center"><img src="../../../image/yajirusi.png"></td>
    </tr>   
</table>

<br>

<table class="List_Table" border="1" align="center">
<col width="100">
<col width="300">
    <tr>
        <td class="Title_Pink" ><b>巡回予定日</b></td>
        <td class="Value">{$form.f_date_b1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink" ><b>巡回担当者</b></td>
        <td class="Value">{$form.form_staff_2.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink" width="100"><b>訂正理由<font color="red">※</font></b></td>
        <td class="Value">{$form.f_text30.html}</td>
    </tr>
</table>
<table align="center">
<col width="400">
    <tr>
		<td align="left"><b><font color="red">※は必須入力です</font></b></td>
    </td>
	<tr>
		<td align='right'>
			{$form.collective.html}　　{$form.kuria.html}
		</td>
	</tr>
</table>


{********************* 画面表示1終了 ********************}

					<br>
					</td>
				</tr>


				<tr>
					<td>

{*-------------------- 画面表示2開始 -------------------*}


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
