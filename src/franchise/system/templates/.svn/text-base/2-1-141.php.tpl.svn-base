{$var.html_header}

<script language="javascript">
{$var.java_sheet}

{literal}
function h_column_disabled(f_obj) {

    if(f_obj.value == "3" ){
			//営業原価
			document.dateForm.elements["form_trade_price[1][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[1][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[2][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[2][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[3][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[3][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[4][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[4][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[5][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[5][2]"].readOnly = true;
		}
		

}
{/literal}


 </script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

<!-- 不正判定 -->
{if $var.injust_msg == true}
		{*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
	    	<tr align="center" valign="top" height="160">
	        <td>
	            <table>
	                <tr>
	                    <td>
	<span style="font: bold;"><font size="+1">以下の操作により、処理に失敗しました。<br><br>・他のユーザが先に処理を行った<br>・ブラウザの戻るボタンが押された<br><br></font></span>
	
	<table width="100%">
	    <tr>
	        <td align="right">
			{$form.disp_btn.html}</td>
	    </tr>
	</table>

{else}

	    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
	    <tr align="center" valign="top">
	        <td>
	            <table>
	                <tr>
	                    <td>
{*
	<!-- エラー表示 -->
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
	{foreach from=$form.errors item=item}
		<li>{$item}<br>
	{/foreach}
	</span>
*}
	{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
	<!-- エラー表示 -->
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
	<!-- レンタル番号 -->
	{if $var.error_msg != null}
	    <li>{$var.error_msg}<br>
	{/if}
	<!-- ユーザ -->
	{if $var.error_msg2 != null}
	    <li>{$var.error_msg2}<br>
	{/if}
	<!-- 商品選択チェック -->
	{if $var.goods_error != null}
	    <li>{$var.goods_error}<br>
	{/if}
	<!-- レンタル申込日 -->
	{if $form.form_rental_day.error != null}
	    <li>{$form.form_rental_day.error}<br>
	{/if}
	<!-- レンタル出荷日 -->
	{if $form.form_forward_day.error != null}
	    <li>{$form.form_forward_day.error}<br>
	{/if}
	<!-- 申請担当者 -->
	{if $form.form_app_staff.error != null}
	    <li>{$form.form_app_staff.error}<br>
	{/if}
	<!-- 巡回担当者 -->
	{if $form.form_round_staff.error != null}
	    <li>{$form.form_round_staff.error}<br>
	{/if}
	<!-- 請求月 -->
	{if $form.form_claim_day.error != null}
	    <li>{$form.form_claim_day.error}<br>
	{/if}
	<!-- 郵便番号 -->
	{if $form.form_post.error != null}
	    <li>{$form.form_post.error}<br>
	{/if}
	<!-- 住所1 -->
	{if $form.form_add1.error != null}
	    <li>{$form.form_add1.error}<br>
	{/if}
	<!-- TEL -->
	{if $form.form_tel.error != null}
	    <li>{$form.form_tel.error}<br>
	{/if}
	<!-- 備考 -->
	{if $form.form_note.error != null}
	    <li>{$form.form_note.error}<br>
	{/if}

	{foreach key=i from=$error_loop_num item=items}
		<!-- 商品チェック -->
		{if $form.form_goods_cd[$i].error != null}
		    <li>{$form.form_goods_cd[$i].error}<br>
		{/if}
		<!-- 数量 -->
		{if $form.form_num[$i].error != null}
		    <li>{$form.form_num[$i].error}<br>
		{/if}
		<!-- シリアル -->
		{foreach key=j from=$error_loop_num2[$i] item=items}
			{if $form.form_serial[$i][$j].error != null}
			    <li>{$form.form_serial[$i][$j].error}<br>
			{/if}
		{/foreach}
		<!-- シリアル入力欄 -->
		{if $form.form_goods_cname[$i].error != null}
		    <li>{$form.form_goods_cname[$i].error}<br>
		{/if}
		<!-- レンタル単価 -->
		{if $form.form_rental_price[$i].error != null}
		    <li>{$form.form_rental_price[$i].error}<br>
		{/if}
		<!-- ユーザ単価 -->
		{if $form.form_user_price[$i].error != null}
		    <li>{$form.form_user_price[$i].error}<br>
		{/if}
		<!-- 解約数 -->
		{if $form.form_renew_num[$i].error != null}
		    <li>{$form.form_renew_num[$i].error}<br>
		{/if}
		<!-- 実施日 -->
		{if $form.form_exec_day[$i].error != null}
		    <li>{$form.form_exec_day[$i].error}<br>
		{/if}
		<!-- 解約チェック -->
		{if $form.form_calcel1[$i].error != null}
		    <li>{$form.form_calcel1[$i].error}<br>
		{/if}
	{/foreach}

	</span>
	{*--------------- メッセージ類 e n d ---------------*}

	{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
	<!-- 確認画面判定 -->
	{if $var.comp_flg != null}
		<!-- 画面表示判定 -->
		{if $var.disp_stat == 1 || $var.disp_stat == 5 || $var.disp_stat == 6}
			<!-- レンタルID無し・取消済・新規申請中 -->
			<span style="font: bold;"><font size="+1">以下の内容で登録しますか？</font></span><br>
		{elseif ($var.disp_stat == 2 && $var.stat_flg == false) || $var.online_flg == "f" }
			<!-- 契約済・解約済(解約済のみ) -->
			<span style="font: bold;"><font size="+1">以下の内容で変更しますか？</font></span><br>
		{else}
			<!-- 契約済・解約済　解約申請　解約予定 -->
			<span style="font: bold;"><font size="+1">以下の内容で変更申請しますか？</font></span><br>
		{/if}
	{/if}
	{$form.hidden}
	<table width="100%">
	    <tr>
	        <td>

	<table class="Data_Table" border="1" width="600">
	<col width="120" style="font-weight: bold;">
	<tr>
	    <td class="Title_Purple" width="130">{$form.online_flg.label}</td>
	    <td class="Value" >{$form.online_flg.html}</td>
	</tr>
	<tr>
	    <td class="Title_Purple" width="130">レンタル番号</td>
	    <td class="Value" >{$form.form_rental_no.html}</td>
	</tr>
	<tr>
	    <td class="Title_Purple" width="130">ショップ名</td>
	    <td class="Value" >{$var.shop_name}</td>
	</tr>
	</table>
	<br>
	<table class="Data_Table" border="1" width="900">
	<col width="120" style="font-weight: bold;">
	<col>
	<col width="120" style="font-weight: bold;">
	    <tr>
	        <td class="Title_Purple" width="130">レンタル申込日<font color="#ff0000">※</font></td>
	        <td class="Value" colspan="3">{$form.form_rental_day.html}</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">申請担当者<font color="#ff0000">※</font></td>
	        <td class="Value">{$form.form_app_staff.html}</td>
			<td class="Title_Purple" width="130">巡回担当者<font color="#ff0000">※</font></td>
	        <td class="Value">{$form.form_round_staff.html}</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">
			<!-- ユーザリンク表示判定 -->
			{if $var.comp_flg == true}
				<!-- 確認画面 -->
			    ユーザ名
			{else}
				<!-- 登録画面 -->
			    {$form.form_client_link.html}
			{/if}
			<font color="#ff0000">※</font></td>
	        <td class="Value" colspan="3">{$form.form_client.html}</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">郵便番号<font color="#ff0000">※</font></td>
	        <td class="Value" colspan="3">{$form.form_post.html}
			<!-- 自動入力ボタン表示判定 -->
			{if $var.comp_flg != true}
				<!-- 確認画面は非表示 -->
			    　　{$form.input_auto.html}
			{/if}
			</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">住所1<font color="#ff0000">※</font></td>
	        <td class="Value">{$form.form_add1.html}</td>
	        <td class="Title_Purple" width="130">住所2</td>
	        <td class="Value">{$form.form_add2.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">住所3<br>(ビル名・他)</td>
	        <td class="Value" colspan=>{$form.form_add3.html}</td>
	        <td class="Title_Purple" width="130">住所2<br>(フリガナ)</td>
	        <td class="Value">{$form.form_add_read.html}</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">ユーザTEL</td>
	        <td class="Value" colspan="3">{$form.form_tel.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">備考</td>
	        <td class="Value" colspan="3">{$form.form_note.html}</td>
	    </tr>
	</table>
	<br>

	<table class="Data_Table" border="1" width="900">
	<col width="120" style="font-weight: bold;">
	<col>
	    <tr>
	        <td class="Title_Purple" width="130">レンタル出荷日</td>
	        <td class="Value">{$form.form_forward_day.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">本部担当者</td>
	        <td class="Value">{$form.form_head_staff.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">請求月</td>
	        <td class="Value">{$form.form_claim_day.html}
			<!-- 契約済・解約済　解約申請　解約予定のみ表示 -->
			{if $var.disp_stat == 2 || $var.disp_stat == 3 || $var.disp_stat == 4}
				 から
			{/if}
			</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">備考(本部用)</td>
	        <td class="Value">{$form.form_h_note.html}</td>
	    </tr>
	</table>
	<br>

	<!-- 画面表示判定 -->
	{if $var.disp_stat == 2 || $var.disp_stat == 3 || $var.disp_stat == 4}
	<table border="0" width="900">
	<tr>
		<td align="right" width=900><b><font color="blue"><li>オンラインの解約は本部承認後に実施されます。</font></b></td>
	</tr>
	</table>

	{/if}

	<!-- ユーザ指定判定 -->
	{if $var.warning != null}
		<!-- 指定なし -->
		<font color="#ff0000"><b>{$var.warning}</b></font>
	{else}
		<!-- データ表示 -->
		<table class="Data_Table" border="1" width="100%">
				<!-- 画面表示判定 -->
				{if $var.disp_stat == 1 || $var.disp_stat == 5 || $var.disp_stat == 6}
					<!-- レンタルID無し・取消済・新規申請中 -->
					<tr align="center" style="font-weight: bold;">
						<td class="Title_Purple">No.</td>
						<td class="Title_Purple">商品コード<font color="#ff0000">※</font><br>商品名</td>
						<td class="Title_Purple">数量<font color="#ff0000">※</font></td>
						<td class="Title_Purple">シリアル
						{if $var.comp_flg != true}
							<br>{$form.input_form_btn.html}
						{/if}
						</td>
						<td class="Title_Purple">レンタル単価<font color="#ff0000">※</font><br>ユーザ提供単価<font color="#ff0000">※</font></td>
						<td class="Title_Purple">レンタル金額<br>ユーザ提供金額</td>
						<!-- 新規申請中or確認画面は削除無し -->
						{if $var.disp_stat != 6 && $var.comp_flg != true}
							<td class="Title_Add">削除</td>
						{/if}
					</tr>
				{else}
					<!-- 契約済・解約済　解約申請　解約予定 -->
					<tr align="center" style="font-weight: bold;">
						<td class="Title_Purple" rowspan="2">No.</td>
						<td class="Title_Purple" rowspan="2">状況</td>
						<td class="Title_Purple" rowspan="2">商品コード<font color="#ff0000">※</font><br>商品名</td>
						<td class="Title_Purple" rowspan="2">数量<font color="#ff0000">※</font></td>
						<td class="Title_Purple" rowspan="2">シリアル
						{if $var.comp_flg != true}
							<br>{$form.input_form_btn.html}
						{/if}
						</td>
						<td class="Title_Purple" rowspan="2">レンタル単価<font color="#ff0000">※</font><br>ユーザ提供単価<font color="#ff0000">※</font></td>
						<td class="Title_Purple" rowspan="2">レンタル金額<br>ユーザ提供金額</td>
						<td class="Title_Purple" rowspan="2">解約日</td>
						<td class="Title_Purple" colspan="3">解約</td>
					{if $var.online_flg == f && $var.comp_flg != true}
						<td class="Title_Purple" rowspan="2">削除</td>
					{/if}
					</tr>
					<tr align="center" style="font-weight: bold;">
						<td class="Title_Purple">解約数</td>
						<td class="Title_Purple">解約理由</td>
						<td class="Title_Purple">実施日</td>
					</tr>

				{/if}
			
			{$var.html}
		</table>


		<A NAME="foot"></A>
		<table width="100%">
		{if $var.comp_flg == true}
		<!-- 確認画面 -->
				<tr>
					<td align="left"><font color="#ff0000"><b>※は必須入力です</b></font></td>
					<td align="right">{$form.ok_btn.html}　　{$form.back_btn.html}</td>
				</tr>
		{else}
		<!-- 登録画面 -->
				<tr>
					<td align="left"><font color="#ff0000"><b>※は必須入力です</b></font></td>
					<td align="right">{$form.comp_btn.html}　　{$form.return_btn.html}</td>
				</tr>
				<tr>
					<td align="left">{$form.add_row_btn.html}</td>
				</tr>
		{/if}
		</table>
	{/if}
	        </td>
	    </tr>
	</table>
{/if}
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
