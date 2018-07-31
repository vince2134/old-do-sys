{$var.html_header}

<script language="javascript">
{$var.java_sheet}
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
	<!-- 本部担当者 -->
	{if $form.form_head_staff.error != null}
	    <li>{$form.form_head_staff.error}<br>
	{/if}
	<!-- ユーザ1 -->
	{if $form.form_client.error != null}
	    <li>{$form.form_client.error}<br>
	{/if}
	<!-- ユーザ2 -->
	{if $form.form_client_name2.error != null}
	    <li>{$form.form_client_name2.error}<br>
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
	<!-- 備考(本部) -->
	{if $form.form_h_note.error != null}
	    <li>{$form.form_h_note.error}<br>
	{/if}

	{foreach key=i from=$error_loop_num item=items}
		<!-- 商品分類チェック -->
		{if $form.form_product_id[$i].error != null}
		    <li>{$form.form_product_id[$i].error}<br>
		{/if}

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
		{if $form.form_shop_price[$i].error != null}
		    <li>{$form.form_shop_price[$i].error}<br>
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
		{if $var.comp_msg != NULL}
			<!-- 申請取消・解約取消ボタン押下 -->
			<span style="font: bold;"><font size="+1">{$var.comp_msg}</font></span><br>
		{elseif $var.disp_stat == 6 && $var.online_flg == 't'}
			<!-- 新規申請中 -->
			<span style="font: bold;"><font size="+1">以下の内容で承認しますか？</font></span><br>
		{elseif $var.disp_stat == 2 && $var.online_flg == 't'}
			<!-- 契約済・解約済 -->
			<span style="font: bold;"><font size="+1">以下の内容で変更しますか？</font></span><br>
		{elseif $var.disp_stat == 3 && $var.online_flg == 't'}
			<!-- 解約申請 -->
			<span style="font: bold;"><font size="+1">以下の内容で解約承認・実施しますか？</font></span><br>
		{elseif $var.disp_stat == 4}
			<!-- 解約予定(オンライン・オフライン) -->
			<span style="font: bold;"><font size="+1">以下の内容で解約取消しますか？</font></span><br>
		{elseif $var.disp_stat == 1 && $var.online_flg == 'f'}
			<!-- 新規申請中(オフライン) -->
			<span style="font: bold;"><font size="+1">以下の内容で登録しますか？</font></span><br>
		{* {elseif $var.disp_stat == 2 && $var.online_flg == 'f'} *}
		{elseif $var.disp_stat == 2 && $var.online_flg == 'f' && $var.edit_flg == false}
			<!-- 契約済・解約済(オフライン) -->
			<span style="font: bold;"><font size="+1">以下の内容で変更しますか？</font></span><br>
		{elseif $var.disp_stat == 2 && $var.online_flg == 'f' && $var.edit_flg == true}
			<!-- 契約済・解約済(オフライン) -->
			<span style="font: bold;"><font size="+1">以下の内容で変更しますか？</font></span><br>
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
		<!-- 必須マーク表示判定 -->
		{if $var.online_flg == 'f'}
			<!-- オフライン -->
			<td class="Title_Purple" width="130">ショップ名<font color="#ff0000">※</font></td>
		{else}
			<!-- オンライン -->
			<td class="Title_Purple" width="130">ショップ名</td>
		{/if}
	    <td class="Value" >{$form.form_shop_name.html}</td>
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
		<!-- オンライン判定 -->
		{if $var.online_flg == 't'}
			<!-- オンライン -->
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
		{else}
			<!-- オフライン -->
			<tr>
		        <td class="Title_Purple" width="130">{$form.form_client_link.html}<font color="#ff0000">※</font></td>
		        <td class="Value" colspan="3">{$form.form_client.html}</td>
				<!--<td class="Title_Purple" width="130">ユーザ名2</td>
		        <td class="Value" >{$form.form_client_name2.html}</td>-->
		    </tr>
		{/if}
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
	        <td class="Title_Purple" width="130">レンタル出荷日<font color="#ff0000">※</font></td>
	        <td class="Value">{$form.form_forward_day.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">本部担当者<font color="#ff0000">※</font></td>
	        <td class="Value">{$form.form_head_staff.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">請求月<font color="#ff0000">※</font></td>
	        <td class="Value">{$form.form_claim_day.html} から</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">備考(本部用)</td>
	        <td class="Value">{$form.form_h_note.html}</td>
	    </tr>
	</table>
						{*
    {if $var.disp_stat == 2 && $smarty.session.group_kind == 1 && $var.online_flg == 'f' && $var.comp_flg == null}
        <table width="100%">
            <tr><td align="right">{$form.edit_btn.html}</td></tr>
        <table>
    {/if}
		*}
	<br>

	<!-- ユーザ指定判定 -->
	{if $var.warning != null}
		<!-- 指定なし -->
		<font color="#ff0000"><b>{$var.warning}</b></font>
	{else}
		<!-- データ表示 -->
		<table class="Data_Table" border="1" width="100%">
					<tr align="center" style="font-weight: bold;">

				{if $var.disp_stat == 1 || $var.disp_stat == 5 || $var.disp_stat == 6}
					<!-- レンタルID無し・取消済・新規申請中 -->
						<td class="Title_Purple">No.</td>
						<td class="Title_Purple">状況</td>
						<td class="Title_Purple">商品コード<font color="#ff0000">※</font><br>商品名</td>
						<td class="Title_Purple">数量<font color="#ff0000">※</font></td>
						<td class="Title_Purple">シリアル
						{if $var.comp_flg != true}
							<br>{$form.input_form_btn.html}
						{/if}
						</td>
						<td class="Title_Purple">本部経費単価<font color="#ff0000">※</font>
							<br>ショップ提供単価<font color="#ff0000">※</font></td>
						<td class="Title_Purple">本部経費金額<br>ショップ提供金額</td>
						<!-- 新規申請中(オンライン)or確認画面は削除無し -->
						{if ($var.disp_stat != 6 || $var.online_flg == 'f') && $var.comp_flg != true}
							<td class="Title_Add">削除</td>
						{/if}
					</tr>
				{else}
					<!-- 契約済・解約済(オフライン)　解約申請　解約予定 -->
						<td class="Title_Purple" rowspan="2">No.</td>
						<td class="Title_Purple" rowspan="2">状況</td>
						<td class="Title_Purple" rowspan="2">商品コード<font color="#ff0000">※</font>
							<br>商品名</td>
						<td class="Title_Purple" rowspan="2">数量<font color="#ff0000">※</font></td>
						<td class="Title_Purple" rowspan="2">シリアル
						{if $var.comp_flg != true}
							<br>{$form.input_form_btn.html}
						{/if}
						</td>
						<td class="Title_Purple" rowspan="2">本部経費単価<font color="#ff0000">※</font>
							<br>ショップ提供単価<font color="#ff0000">※</font>
						</td>
						<td class="Title_Purple" rowspan="2">本部経費金額<br>ショップ提供金額</td>
						<td class="Title_Purple" rowspan="2">解約日</td>
						<td class="Title_Purple" colspan="3">解約</td>
						{if $var.online_flg == f && $var.comp_flg != true}
							<td class="Title_Add" rowspan="2">削除</td>
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
		<!-- 確認画面 -->
		{if $var.comp_flg == true}
			<table width="100%">
				<tr>
					<td align="left"><font color="#ff0000"><b>※は必須入力です</b></font></td>
					<!-- 画面表示判定 -->
					{if ($var.disp_stat == 3 || $var.disp_stat == 6) && $var.online_flg == 't'}
						{* 解約申請(本部) 新規申請中(本部) *}
						<td align="right">

						<!-- 申請取消・解約取消ボタン表示 -->
						{if $var.comp_msg != NULL}
							{$form.cancel_ok_btn.html}　　

						<!-- 承認・解約承認ボタン表示 -->
						{else}
							{$form.ok_btn.html}　　
						{/if}

						{$form.back_btn.html}</td>

					{else}
						{*
							レンタルID無し(本部・FC)
							契約済・解約済(本部・FC)
							解約申請(FC)
							解約予定(本部・FC)
							取消済(本部・FC)
							新規申請中(本部・FC)
						*}
						<td align="right">{$form.ok_btn.html}　　{$form.back_btn.html}</td>
					{/if}
				</tr>
			</table>

		<!-- 登録画面 -->
		{else}
			<table width="100%">
				<tr>
					<td align="left"><font color="#ff0000"><b>※は必須入力です</b></font></td>
					<!-- 画面表示判定 -->
					{if ($var.disp_stat == 3 || $var.disp_stat == 6) && $var.online_flg == 't'}
						{*
							解約申請(本部)
							新規申請中(本部)
						*}
						<td align="right">{$form.comp_btn.html}　　{$form.cancel_btn.html}　　{$form.return_btn.html}</td>
					{else}
						{*
							レンタルID無し(本部・FC)
							契約済・解約済(本部・FC)
							解約申請(FC)
							解約予定(本部・FC)
							取消済(本部・FC)
							新規申請中(本部・FC)
						*}
						<td align="right">{$form.comp_btn.html}　　{$form.return_btn.html}</td>
					{/if}
				</tr>
				<tr>
					<td align="left">{$form.add_row_btn.html}</td>
				</tr>
			</table>
		{/if}
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
