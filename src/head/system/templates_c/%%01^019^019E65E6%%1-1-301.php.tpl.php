<?php /* Smarty version 2.6.14, created on 2009-12-25 14:13:50
         compiled from 1-1-301.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			 <?php echo $this->_tpl_vars['var']['page_header']; ?>
 		</td>
	</tr>

	<tr align="center">
	

				<td valign="top">

			<table border="0">
				<tr>
					<td>

	<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
	<?php if ($this->_tpl_vars['var']['fin_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['fin_msg']; ?>
<br><?php endif; ?>
	</span>
 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['var']['head_cd_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['head_cd_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_head_cd']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_head_cd']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_comp_name']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_comp_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_rep_name']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_rep_name']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_post_no']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_post_no']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_address1']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_address1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_capital_money']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_capital_money']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_tel']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_tel']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['tel_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['tel_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['fax_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['fax_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['email_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['email_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['url_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['url_err']; ?>
<br>
    <?php endif; ?>
                <?php if ($this->_tpl_vars['form']['form_tax_rate_new']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_tax_rate_new']['error']; ?>
<br>
    <?php endif; ?>
                <?php if ($this->_tpl_vars['form']['form_tax_change_day_new']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_tax_change_day_new']['error']; ?>
<br>
    <?php elseif ($this->_tpl_vars['var']['rday_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['rday_err']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_close_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_close_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_cname']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_cname']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_pay_month']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_pay_month']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_pay_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_pay_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_close_month']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_close_month']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_ware']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_ware']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_abcd_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_abcd_day']['error']; ?>
<br>
    <?php endif; ?>
    </span><br>
<font size="+0.5" color="#555555"><b>【自社情報】</b></font>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table class="Data_Table" border="1" width="810">
<col width="125">
<col width="280">
<col width="125">
<col width="280">
	<tr>
		<td class="Title_Purple"><b>本部コード<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_head_cd']['html']; ?>
</td>
		<td class="Title_Purple" align="center" colspan="2"><b>社印</b></td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>社名<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_comp_name']['html']; ?>
</td>
		<td class="Value" rowspan="4" colspan="2">
			<table align="center">
			<tr>
				<td>
                    <table width="60" height="60" align="center" style="background-image: url(<?php echo $this->_tpl_vars['var']['path_shain']; ?>
);background-repeat:no-repeat; cellspacing="0" cellpadding="0" border="0">
                        <tr><td><br></td></tr>
                    </table>
				</td>
				<td valign="top"><br>
				</td>
			</tr>
			</table>
			<table align="center">
			<tr>
								<td colspan="2"><?php echo $this->_tpl_vars['form']['button']['change_stamp']['html']; ?>
　<?php echo $this->_tpl_vars['form']['button']['delete_stamp']['html']; ?>
</td>
			</tr>
			</table>
			</td>
		</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>社名2</b></td>
	 	<td class="Value"><?php echo $this->_tpl_vars['form']['form_comp_name2']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>社名<br>(フリガナ)</b></td>
	 	<td class="Value"><?php echo $this->_tpl_vars['form']['form_comp_read']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>社名2<br>(フリガナ)</b></td>
	 	<td class="Value"><?php echo $this->_tpl_vars['form']['form_comp_read2']['html']; ?>
</td>
	</tr>

	<tr>
        <td class="Title_Purple"><b>略称<font color="#ff0000">※</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cname']['html']; ?>
</td>
        <td class="Title_Purple"><b>略称<br>(フリガナ)</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cread']['html']; ?>
</td>
    </tr>

	<tr>
		<td class="Title_Purple"width="100"><b>郵便番号<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_post_no']['html']; ?>
　<?php echo $this->_tpl_vars['form']['button']['input_button']['html']; ?>
</td>
	</tr>

    <tr>
        <td class="Title_Purple"><b>住所1<font color="#ff0000">※</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address1']['html']; ?>
</td>
        <td class="Title_Purple"><b>住所2</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>住所3<br>(ビル名・他)</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address3']['html']; ?>
</td>
        <td class="Title_Purple"><b>住所2<br>(フリガナ)</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address_read']['html']; ?>
</td>
    </tr>

	<tr>
		<td class="Title_Purple" width="130"><b>資本金</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_capital_money']['html']; ?>
万円</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>TEL<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
		<td class="Title_Purple"><b>FAX</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_fax']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>Email</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_email']['html']; ?>
</td>
		<td class="Title_Purple"><b>URL</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_url']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>代表者氏名<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_rep_name']['html']; ?>
</td>
		<td class="Title_Purple"><b>代表者役職</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_represe']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>代表者携帯</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_represent_cell']['html']; ?>
</td>
		<td class="Title_Purple"><b>直通TEL</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_tel']['html']; ?>
</td>
	</tr>


</table>
<br>
<font size="+0.5" color="#555555"><b>【消費税設定】</b></font>
<table class="Data_Table" border="1" width="810">
<col width="125">
<col width="280">
<col width="125">
<col width="280">
	<tr>
		<td class="Title_Purple"><b>旧消費税率</b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_tax_rate_old']['html']; ?>
 %</td>
	</tr>
	<tr>
		<td class="Title_Purple" style="color: blue; font-weight: bold">現消費税率</td>
		<td class="Value" style="color: blue; font-weight: bold"><?php echo $this->_tpl_vars['form']['form_tax_rate_now']['html']; ?>
 %</td>
		<td class="Title_Purple" style="color: blue; font-weight: bold">現税率切替日</td>
		<td class="Value" style="color: blue; font-weight: bold"><?php echo $this->_tpl_vars['form']['form_tax_change_day_now']['html']; ?>
</td>
	</tr>
	<tr>
		<td class="Value" colspan="4"><?php echo $this->_tpl_vars['form']['form_tax_setup_flg']['html']; ?>
 新消費税率を設定する
            <span style="color: #ff0000; font-weight: bold; font-size:12px;">　
            チェックをつけた場合、下記の項目は必須入力になります
            </span>
        </td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>新消費税率</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_tax_rate_new']['html']; ?>
 %</td>
		<td class="Title_Purple"><b>新税率切替日</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_tax_change_day_new']['html']; ?>
</td>
	</tr>

</table>
<br>
<font size="+0.5" color="#555555"><b>【環境設定】</b></font>
<table class="Data_Table" border="1" width="810">
<col width="125">
<col width="280">
<col width="125">
<col width="280">
	<tr>
		<td class="Title_Purple"><b>締日<font color="#ff0000">※</font></b></td>
		<td class="Value">
			<?php echo $this->_tpl_vars['form']['form_close_day']['html']; ?>

		</td>
		<td class="Title_Purple"><b>支払日<font color="#ff0000">※</font></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_pay_month']['html']; ?>
の<?php echo $this->_tpl_vars['form']['form_pay_day']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>決算月</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_cutoff_month']['html']; ?>
月 <?php echo $this->_tpl_vars['form']['form_cutoff_day']['html']; ?>
日</td>
		<td class="Title_Purple"><b>ABCD巡回基準日</b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['form_abcd_day']['html']; ?>
<br> をA週の日曜日とする</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>請求書番号設定<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_claim_num']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>金額まるめ区分<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_coax']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>消費税端数区分<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['from_fraction_div']['html']; ?>
</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>基本倉庫<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
	</tr>

</table>
<table width="810">
	<tr>
		<td align="left">
			<b><font color="#ff0000">※は必須入力です</font></b>
		</td>
		<td align="right">
			<?php echo $this->_tpl_vars['form']['button']['entry_button']['html']; ?>

		</td>
	</tr>
</table>

					<br>
					</td>
				</tr>

			</table>
		</td>
		
	</tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
