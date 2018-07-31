
{$var.html_header}
<script language="javascript">
{$var.code_value}
{$var.contract}
 </script>
<body bgcolor="#D8D0C8" onLoad="Check_Button2({$var.check_which}); WindowSizeChange();">
<form name="referer" method="post">

<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%">

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
		
			<table border="0" width="100%">
				<tr>
					<td>

</form>
<!---------------------- 画面表示1開始 ---------------------><!-->
<form {$form.attributes}>
{* エラーメッセージ出力 *} 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">

    {if $var.client_cd_err != null}
    <li>{$var.client_cd_err}<br>
    {/if}
    {if $form.form_client.error != null}
    <li>{$form.form_client.error}<br>
    {/if}
    {if $form.form_client_name.error != null}
        <li>{$form.form_client_name.error}<br>
    {/if}
    {if $form.form_client_cname.error != null}
        <li>{$form.form_client_cname.error}<br>
    {/if}
    {if $form.form_post.error != null}
        <li>{$form.form_post.error}<br>
    {/if}
    {if $form.form_address1.error != null}
        <li>{$form.form_address1.error}<br>
    {/if}
    {if $form.form_area_id.error != null}
        <li>{$form.form_area_id.error}<br>
    {/if}
    {if $form.form_tel.error != null}
        <li>{$form.form_tel.error != null}<br>
    {/if}
    {if $form.form_fax.error != null}
        <li>{$form.form_fax.error}<br>
    {/if}
    {if $form.form_rep_name.error != null}
        <li>{$form.form_rep_name.error}<br>
    {/if}
    {if $form.form_trade_stime1.error != null || 
        $form.form_trade_etime1.error != null || 
        $form.form_trade_stime2.error != null || 
        $form.form_trade_etime2.error != null}
        <li>営業時間は半角数字のみです。<br>
    {/if}
    {if $var.claim_err != null}
        <li>{$var.claim_err}<br>
    {/if}
    {if $var.intro_act_err != null}
        <li>{$var.intro_act_err}<br>
    {/if}
    {if $form.form_account.error != null}
        <li>{$form.form_account.error}<br>
    {/if}
    {if $form.form_cshop.error != null}
        <li>{$form.form_cshop.error}<br>
    {/if}
    {if $var.close_err != null}
        <li>{$var.close_err}<br>
    {/if}
    {if $var.c_staff_err != null}
        <li>{$var.c_staff_err}<br>
    {/if}
    {if $form.form_close.error != null}
        <li>{$form.form_close.error}<br>
    {/if}
    {if $form.form_pay_m.error != null}
        <li>{$form.form_pay_m.error}<br>
    {/if}
    {if $form.form_pay_d.error != null}
        <li>{$form.form_pay_d.error}<bt>
    {/if}
    {if $form.form_cont_s_day.error != null}
        <li>{$form.form_cont_s_day.error}<br>
    {elseif $var.sday_err != null}
        <li>{$var.sday_err}<br>
    {/if}
    {if $form.form_cont_peri.error != null}
        <li>{$form.form_cont_peri.error}<br>
    {/if}
    {if $form.form_cont_r_day.error != null}
        <li>{$form.form_cont_r_day.error}<br>
    {elseif $var.rday_err != null}
        <li>{$var.rday_err}<br>
    {elseif $var.sday_rday_err != null}
        <li>{$var.sday_rday_err}<br>
    {/if}
    {if $form.form_deliver_note.error != null}
        <li>{$form.form_deliver_note.error}<br>
    {/if}
    </span><br>
{$form.hidden}
<table class="Data_Table" border="1" width="750">
<col width="130">
<col width="235">
<col width="130">

	<tr>
		<td class="Title_Purple"><b>得意先コード<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_client.html}</td>
		<td class="Title_Purple"><b>取引中</b></td>
		<td class="Value">{$form.form_state.html}</td>
	</tr>


	<tr>
		<td class="Title_Purple"><b>得意先名<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3">{$form.form_client_name.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>得意先名(フリガナ)</b></td>
		<td class="Value" colspan="3">{$form.form_client_read.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>略称<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3">{$form.form_client_cname.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>郵便番号<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3">{$form.form_post.html}　　{$form.button.input_button.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>住所1<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3">{$form.form_address1.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>住所2</b></td>
		<td class="Value" colspan="3">{$form.form_address2.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>住所(フリガナ)</b></td>
		<td class="Value" colspan="3">{$form.form_address_read.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>地区<font color="#ff0000">※</font></b></td>
		<td class="Value" colspan="3">{$form.form_area_id.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>TEL<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_tel.html}</td>
		<td class="Title_Purple"><b>FAX<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_fax.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>代表者氏名<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_rep_name.html}</td>
		<td class="Title_Purple"><b>ご担当者1</b></td>
		<td class="Value">{$form.form_charger1.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>ご担当者2</b></td>
		<td class="Value">{$form.form_charger2.html}</td>
		<td class="Title_Purple"><b>ご担当者3</b></td>
		<td class="Value">{$form.form_charger3.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>ご担当者4</b></td>
		<td class="Value">{$form.form_charger4.html}</td>
		<td class="Title_Purple"><b>ご担当者5</b></td>
		<td class="Value">{$form.form_charger5.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>営業時間</b></td>
		<td class="Value" colspan="3">{$form.form_trade_stime1.html} 〜 {$form.form_trade_etime1.html} <br>{$form.form_trade_stime2.html} 〜 {$form.form_trade_etime2.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>休日</b></td>
		<td class="Value" colspan="3">{$form.form_holiday.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>業種</b></td>
		<td class="Value">{$form.form_btype.html}</td>
		<td class="Title_Purple"><b>業態</b></td>
		<td class="Value">{$form.form_b_struct.html}</td>
	</tr>
</table>
<br>

<table class="Data_Table" border="1" width="750">
	<tr>
		<td class="Title_Purple" width="130">
			<b><a href="#" onClick="return Open_SubWin('../dialog/1-0-250.php',Array('form_claim[cd1]','form_claim[cd2]','form_claim[name]'), 500, 450);">請求先</a></b>
		</td>
		<td class="Value">{$form.form_claim.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130">
			<b><a href="#" onClick="return Open_SubWin('../dialog/1-0-208.php', Array('form_intro_act[cd]', 'form_intro_act[name]'), 500, 450);">紹介口座先</a></b>
		</td>
		<td class="Value">{$form.form_intro_act.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>口座料<br>(口座名義ごと)</b></td>
		<td class="Value">{$form.form_account.html}</td>
	</tr>
</table>
<br>

<table class="Data_Table" border="1" width="750">
	<tr>
		<td class="Title_Purple"  width="130"><b>担当支店<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_cshop.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"  width="130"><b>契約担当１</b></td>
		<td class="Value">{$form.form_c_staff_id1.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>契約担当２</b></td>
		<td class="Value">{$form.form_c_staff_id2.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>巡回担当１</b></td>
		<td class="Value">{$form.form_d_staff_id1.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>巡回担当２</b></td>
		<td class="Value">{$form.form_d_staff_id2.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>巡回担当３</b></td>
		<td class="Value">{$form.form_d_staff_id3.html}</td>
	</tr>
</table>
<br>
<table class="Data_Table" border="1" width="750">
	
	<tr>
		<td class="Title_Purple" width="130"><b>回収条件</b></td>
		<td class="Value" colspan="3">{$form.form_col_terms.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>与信限度</b></td>
		<td class="Value">{$form.form_cledit_limit.html}万円</td>
		<td class="Title_Purple" width="130"><b>資本金</b></td>
		<td class="Value">{$form.form_capital.html}万円</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>取引区分</b></td>
		<td class="Value">{$form.form_work.html}</td>
		<td class="Title_Purple" width="130"><b>締日<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_close.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>支払日<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_pay_m.html}ヵ月後の{$form.form_pay_d.html}日</td>
		<td class="Title_Purple" width="130"><b>支払方法</b></td>
		<td class="Value">{$form.form_pay_way.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>振込銀行</b></td>
		<td class="Value" colspan="3">{$form.form_bank.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>振込名義</b></td>
		<td class="Value">{$form.form_pay_name.html}</td>
		<td class="Title_Purple" width="130"><b>口座名義</b></td>
		<td class="Value">{$form.form_account_name.html}</td>
	</tr>


</table>
<br>
<table class="Data_Table" border="1" width="750">

	<tr>
		<td class="Title_Purple" width="130"><b>契約年月日</b></td>
		<td class="Value">{$form.form_cont_s_day.html}</td>
		<td class="Title_Purple" width="130"><b>契約終了日</b></td>
		<td class="Value">{$form.form_cont_e_day.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>契約期間</b></td>
		<td class="Value">{$form.form_cont_peri.html}年</td>
		<td class="Title_Purple" width="130"><b>更新日</b></td>
		<td class="Value">{$form.form_cont_r_day.html}</td>
	</tr>
	
</table>
<br>
<table class="Data_Table" border="1" width="750">

	<tr>
		<td class="Title_Purple" width="130"><b>伝票発行<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_slip_out.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>納品書コメント</b></td>
		<td class="Value">{$form.form_deliver_note.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>請求書発行<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.form_claim_out.html}</td>
	</tr>

</table>
<br>
<table class="Data_Table" border="1" width="750">

	<tr>
		<td class="Title_Purple" width="130"><b>金額<font color="#ff0000">※</font></b></td>
		<td class="Title_Purple" width="130"><b>まるめ区分</b></td>
		<td class="Value">{$form.form_coax.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" rowspan="3" width="130"><b>消費税<font color="#ff0000">※</font></b></td>
		<td class="Title_Purple" width="130"><b>課税区分</b></td>
		<td class="Value">{$form.form_tax_io.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>課税単位</b></td>
		<td class="Value">{$form.form_tax_div.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>端数区分</b></td>
		<td class="Value">{$form.form_tax_franct.html}</td>
	</tr>

</table>
<br>
<table class="Data_Table" border="1" width="750">

	<tr>
		<td class="Title_Purple" width="130"><b>設備情報等・その他</b></td>
		<td class="Value">{$form.form_note.html}</td>
	</tr>

</table>
<table width="750">
	<tr>
		<td align="left">
			<b><font color="#ff0000">※は必須入力です</font></b>
		</td>
		<td align="right">
			{$form.button.entry_button.html}　　{$form.button.res_button.html}　　{$form.button.back_button.html}
		</td>
	</tr>
</table>
<!--******************** 画面表示1終了 *******************-->

					<br>
					</td>
                    <td valign="bottom">
                        <fieldset>
                        <legend><font size="+0.5" color="#555555"><b>【登録済み】</b></font></legend>
                        <iframe src="../dialog/1-0-250-1.php" name="goods" width="700" height="1230" SCROLLING="auto">
                        この部分はインラインフレームを使用しています。
                        </iframe>
                        </fieldset>
                    </td>
				</tr>

			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

{$var.html_footer}
	
