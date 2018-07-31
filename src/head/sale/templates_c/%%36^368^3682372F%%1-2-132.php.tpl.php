<?php /* Smarty version 2.6.14, created on 2009-12-26 13:37:56
         compiled from 1-2-132.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['java_sheet']; ?>

 </script>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
<!-- 不正判定 -->
<?php if ($this->_tpl_vars['var']['injust_msg'] == true): ?>
			    	<tr align="center" valign="top" height="160">
	        <td>
	            <table>
	                <tr>
	                    <td>
	<span style="font: bold;"><font size="+1">以下の操作により、処理に失敗しました。<br><br>・他のユーザが先に処理を行った<br>・ブラウザの戻るボタンが押された<br><br></font></span>
	
	<table width="100%">
	    <tr>
	        <td align="right">
			<?php echo $this->_tpl_vars['form']['disp_btn']['html']; ?>
</td>
	    </tr>
	</table>

<?php else: ?>

	    	    <tr align="center" valign="top">
	        <td>
	            <table>
	                <tr>
	                    <td>
	
		<!-- エラー表示 -->
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
	<!-- レンタル番号 -->
	<?php if ($this->_tpl_vars['var']['error_msg'] != null): ?>
	    <li><?php echo $this->_tpl_vars['var']['error_msg']; ?>
<br>
	<?php endif; ?>
	<!-- 商品選択チェック -->
	<?php if ($this->_tpl_vars['var']['goods_error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['var']['goods_error']; ?>
<br>
	<?php endif; ?>
	<!-- レンタル申込日 -->
	<?php if ($this->_tpl_vars['form']['form_rental_day']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_rental_day']['error']; ?>
<br>
	<?php endif; ?>
	<!-- レンタル出荷日 -->
	<?php if ($this->_tpl_vars['form']['form_forward_day']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_forward_day']['error']; ?>
<br>
	<?php endif; ?>
	<!-- 申請担当者 -->
	<?php if ($this->_tpl_vars['form']['form_app_staff']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_app_staff']['error']; ?>
<br>
	<?php endif; ?>
	<!-- 巡回担当者 -->
	<?php if ($this->_tpl_vars['form']['form_round_staff']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_round_staff']['error']; ?>
<br>
	<?php endif; ?>
	<!-- 本部担当者 -->
	<?php if ($this->_tpl_vars['form']['form_head_staff']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_head_staff']['error']; ?>
<br>
	<?php endif; ?>
	<!-- ユーザ1 -->
	<?php if ($this->_tpl_vars['form']['form_client']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_client']['error']; ?>
<br>
	<?php endif; ?>
	<!-- ユーザ2 -->
	<?php if ($this->_tpl_vars['form']['form_client_name2']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_client_name2']['error']; ?>
<br>
	<?php endif; ?>
	<!-- 請求月 -->
	<?php if ($this->_tpl_vars['form']['form_claim_day']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_claim_day']['error']; ?>
<br>
	<?php endif; ?>
	<!-- 郵便番号 -->
	<?php if ($this->_tpl_vars['form']['form_post']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_post']['error']; ?>
<br>
	<?php endif; ?>
	<!-- 住所1 -->
	<?php if ($this->_tpl_vars['form']['form_add1']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_add1']['error']; ?>
<br>
	<?php endif; ?>
	<!-- TEL -->
	<?php if ($this->_tpl_vars['form']['form_tel']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_tel']['error']; ?>
<br>
	<?php endif; ?>
	<!-- 備考 -->
	<?php if ($this->_tpl_vars['form']['form_note']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_note']['error']; ?>
<br>
	<?php endif; ?>
	<!-- 備考(本部) -->
	<?php if ($this->_tpl_vars['form']['form_h_note']['error'] != null): ?>
	    <li><?php echo $this->_tpl_vars['form']['form_h_note']['error']; ?>
<br>
	<?php endif; ?>

	<?php $_from = $this->_tpl_vars['error_loop_num']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
		<!-- 商品分類チェック -->
		<?php if ($this->_tpl_vars['form']['form_product_id'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_product_id'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>

		<!-- 商品チェック -->
		<?php if ($this->_tpl_vars['form']['form_goods_cd'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_goods_cd'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- 数量 -->
		<?php if ($this->_tpl_vars['form']['form_num'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_num'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- シリアル -->
		<?php $_from = $this->_tpl_vars['error_loop_num2'][$this->_tpl_vars['i']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
			<?php if ($this->_tpl_vars['form']['form_serial'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['error'] != null): ?>
			    <li><?php echo $this->_tpl_vars['form']['form_serial'][$this->_tpl_vars['i']][$this->_tpl_vars['j']]['error']; ?>
<br>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		<!-- シリアル入力欄 -->
		<?php if ($this->_tpl_vars['form']['form_goods_cname'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_goods_cname'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- レンタル単価 -->
		<?php if ($this->_tpl_vars['form']['form_rental_price'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_rental_price'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- ユーザ単価 -->
		<?php if ($this->_tpl_vars['form']['form_shop_price'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_shop_price'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- 解約数 -->
		<?php if ($this->_tpl_vars['form']['form_renew_num'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_renew_num'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- 実施日 -->
		<?php if ($this->_tpl_vars['form']['form_exec_day'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_exec_day'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
		<!-- 解約チェック -->
		<?php if ($this->_tpl_vars['form']['form_calcel1'][$this->_tpl_vars['i']]['error'] != null): ?>
		    <li><?php echo $this->_tpl_vars['form']['form_calcel1'][$this->_tpl_vars['i']]['error']; ?>
<br>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>

	</span>
	
		<!-- 確認画面判定 -->
	<?php if ($this->_tpl_vars['var']['comp_flg'] != null): ?>
		<!-- 画面表示判定 -->
		<?php if ($this->_tpl_vars['var']['comp_msg'] != NULL): ?>
			<!-- 申請取消・解約取消ボタン押下 -->
			<span style="font: bold;"><font size="+1"><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
</font></span><br>
		<?php elseif ($this->_tpl_vars['var']['disp_stat'] == 6 && $this->_tpl_vars['var']['online_flg'] == 't'): ?>
			<!-- 新規申請中 -->
			<span style="font: bold;"><font size="+1">以下の内容で承認しますか？</font></span><br>
		<?php elseif ($this->_tpl_vars['var']['disp_stat'] == 2 && $this->_tpl_vars['var']['online_flg'] == 't'): ?>
			<!-- 契約済・解約済 -->
			<span style="font: bold;"><font size="+1">以下の内容で変更しますか？</font></span><br>
		<?php elseif ($this->_tpl_vars['var']['disp_stat'] == 3 && $this->_tpl_vars['var']['online_flg'] == 't'): ?>
			<!-- 解約申請 -->
			<span style="font: bold;"><font size="+1">以下の内容で解約承認・実施しますか？</font></span><br>
		<?php elseif ($this->_tpl_vars['var']['disp_stat'] == 4): ?>
			<!-- 解約予定(オンライン・オフライン) -->
			<span style="font: bold;"><font size="+1">以下の内容で解約取消しますか？</font></span><br>
		<?php elseif ($this->_tpl_vars['var']['disp_stat'] == 1 && $this->_tpl_vars['var']['online_flg'] == 'f'): ?>
			<!-- 新規申請中(オフライン) -->
			<span style="font: bold;"><font size="+1">以下の内容で登録しますか？</font></span><br>
				<?php elseif ($this->_tpl_vars['var']['disp_stat'] == 2 && $this->_tpl_vars['var']['online_flg'] == 'f' && $this->_tpl_vars['var']['edit_flg'] == false): ?>
			<!-- 契約済・解約済(オフライン) -->
			<span style="font: bold;"><font size="+1">以下の内容で変更しますか？</font></span><br>
		<?php elseif ($this->_tpl_vars['var']['disp_stat'] == 2 && $this->_tpl_vars['var']['online_flg'] == 'f' && $this->_tpl_vars['var']['edit_flg'] == true): ?>
			<!-- 契約済・解約済(オフライン) -->
			<span style="font: bold;"><font size="+1">以下の内容で変更しますか？</font></span><br>
		<?php endif; ?>
	<?php endif; ?>
	<?php echo $this->_tpl_vars['form']['hidden']; ?>

	<table width="100%">
	    <tr>
	        <td>

	<table class="Data_Table" border="1" width="600">
	<col width="120" style="font-weight: bold;">
	<tr>
	    <td class="Title_Purple" width="130"><?php echo $this->_tpl_vars['form']['online_flg']['label']; ?>
</td>
	    <td class="Value" ><?php echo $this->_tpl_vars['form']['online_flg']['html']; ?>
</td>
	</tr>
	<tr>
	    <td class="Title_Purple" width="130">レンタル番号</td>
	    <td class="Value" ><?php echo $this->_tpl_vars['form']['form_rental_no']['html']; ?>
</td>
	</tr>
	<tr>
		<!-- 必須マーク表示判定 -->
		<?php if ($this->_tpl_vars['var']['online_flg'] == 'f'): ?>
			<!-- オフライン -->
			<td class="Title_Purple" width="130">ショップ名<font color="#ff0000">※</font></td>
		<?php else: ?>
			<!-- オンライン -->
			<td class="Title_Purple" width="130">ショップ名</td>
		<?php endif; ?>
	    <td class="Value" ><?php echo $this->_tpl_vars['form']['form_shop_name']['html']; ?>
</td>
	</tr>
	</table>
	<br>
	<table class="Data_Table" border="1" width="900">
	<col width="120" style="font-weight: bold;">
	<col>
	<col width="120" style="font-weight: bold;">
	    <tr>
	        <td class="Title_Purple" width="130">レンタル申込日<font color="#ff0000">※</font></td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_rental_day']['html']; ?>
</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">申請担当者<font color="#ff0000">※</font></td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_app_staff']['html']; ?>
</td>
			<td class="Title_Purple" width="130">巡回担当者<font color="#ff0000">※</font></td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_round_staff']['html']; ?>
</td>
	    </tr>
		<!-- オンライン判定 -->
		<?php if ($this->_tpl_vars['var']['online_flg'] == 't'): ?>
			<!-- オンライン -->
			<tr>
		        <td class="Title_Purple" width="130">
				<!-- ユーザリンク表示判定 -->
				<?php if ($this->_tpl_vars['var']['comp_flg'] == true): ?>
					<!-- 確認画面 -->
				    ユーザ名
				<?php else: ?>
					<!-- 登録画面 -->
				    <?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>

				<?php endif; ?>
				<font color="#ff0000">※</font></td>
		        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
		    </tr>
		<?php else: ?>
			<!-- オフライン -->
			<tr>
		        <td class="Title_Purple" width="130"><?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
<font color="#ff0000">※</font></td>
		        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
				<!--<td class="Title_Purple" width="130">ユーザ名2</td>
		        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_client_name2']['html']; ?>
</td>-->
		    </tr>
		<?php endif; ?>
		<tr>
	        <td class="Title_Purple" width="130">郵便番号<font color="#ff0000">※</font></td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_post']['html']; ?>

			<!-- 自動入力ボタン表示判定 -->
			<?php if ($this->_tpl_vars['var']['comp_flg'] != true): ?>
				<!-- 確認画面は非表示 -->
			    　　<?php echo $this->_tpl_vars['form']['input_auto']['html']; ?>

			<?php endif; ?>
			</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">住所1<font color="#ff0000">※</font></td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_add1']['html']; ?>
</td>
	        <td class="Title_Purple" width="130">住所2</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_add2']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">住所3<br>(ビル名・他)</td>
	        <td class="Value" colspan=><?php echo $this->_tpl_vars['form']['form_add3']['html']; ?>
</td>
	        <td class="Title_Purple" width="130">住所2<br>(フリガナ)</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_add_read']['html']; ?>
</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">ユーザTEL</td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">備考</td>
	        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
	    </tr>
	</table>
	<br>

	<table class="Data_Table" border="1" width="900">
	<col width="120" style="font-weight: bold;">
	<col>
	    <tr>
	        <td class="Title_Purple" width="130">レンタル出荷日<font color="#ff0000">※</font></td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_forward_day']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">本部担当者<font color="#ff0000">※</font></td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_head_staff']['html']; ?>
</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">請求月<font color="#ff0000">※</font></td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_day']['html']; ?>
 から</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">備考(本部用)</td>
	        <td class="Value"><?php echo $this->_tpl_vars['form']['form_h_note']['html']; ?>
</td>
	    </tr>
	</table>
							<br>

	<!-- ユーザ指定判定 -->
	<?php if ($this->_tpl_vars['var']['warning'] != null): ?>
		<!-- 指定なし -->
		<font color="#ff0000"><b><?php echo $this->_tpl_vars['var']['warning']; ?>
</b></font>
	<?php else: ?>
		<!-- データ表示 -->
		<table class="Data_Table" border="1" width="100%">
					<tr align="center" style="font-weight: bold;">

				<?php if ($this->_tpl_vars['var']['disp_stat'] == 1 || $this->_tpl_vars['var']['disp_stat'] == 5 || $this->_tpl_vars['var']['disp_stat'] == 6): ?>
					<!-- レンタルID無し・取消済・新規申請中 -->
						<td class="Title_Purple">No.</td>
						<td class="Title_Purple">状況</td>
						<td class="Title_Purple">商品コード<font color="#ff0000">※</font><br>商品名</td>
						<td class="Title_Purple">数量<font color="#ff0000">※</font></td>
						<td class="Title_Purple">シリアル
						<?php if ($this->_tpl_vars['var']['comp_flg'] != true): ?>
							<br><?php echo $this->_tpl_vars['form']['input_form_btn']['html']; ?>

						<?php endif; ?>
						</td>
						<td class="Title_Purple">本部経費単価<font color="#ff0000">※</font>
							<br>ショップ提供単価<font color="#ff0000">※</font></td>
						<td class="Title_Purple">本部経費金額<br>ショップ提供金額</td>
						<!-- 新規申請中(オンライン)or確認画面は削除無し -->
						<?php if (( $this->_tpl_vars['var']['disp_stat'] != 6 || $this->_tpl_vars['var']['online_flg'] == 'f' ) && $this->_tpl_vars['var']['comp_flg'] != true): ?>
							<td class="Title_Add">削除</td>
						<?php endif; ?>
					</tr>
				<?php else: ?>
					<!-- 契約済・解約済(オフライン)　解約申請　解約予定 -->
						<td class="Title_Purple" rowspan="2">No.</td>
						<td class="Title_Purple" rowspan="2">状況</td>
						<td class="Title_Purple" rowspan="2">商品コード<font color="#ff0000">※</font>
							<br>商品名</td>
						<td class="Title_Purple" rowspan="2">数量<font color="#ff0000">※</font></td>
						<td class="Title_Purple" rowspan="2">シリアル
						<?php if ($this->_tpl_vars['var']['comp_flg'] != true): ?>
							<br><?php echo $this->_tpl_vars['form']['input_form_btn']['html']; ?>

						<?php endif; ?>
						</td>
						<td class="Title_Purple" rowspan="2">本部経費単価<font color="#ff0000">※</font>
							<br>ショップ提供単価<font color="#ff0000">※</font>
						</td>
						<td class="Title_Purple" rowspan="2">本部経費金額<br>ショップ提供金額</td>
						<td class="Title_Purple" rowspan="2">解約日</td>
						<td class="Title_Purple" colspan="3">解約</td>
						<?php if ($this->_tpl_vars['var']['online_flg'] == f && $this->_tpl_vars['var']['comp_flg'] != true): ?>
							<td class="Title_Add" rowspan="2">削除</td>
						<?php endif; ?>

					</tr>
					<tr align="center" style="font-weight: bold;">
						<td class="Title_Purple">解約数</td>
						<td class="Title_Purple">解約理由</td>
						<td class="Title_Purple">実施日</td>
					</tr>
				<?php endif; ?>
		    
			<?php echo $this->_tpl_vars['var']['html']; ?>

		</table>

		<A NAME="foot"></A>
		<!-- 確認画面 -->
		<?php if ($this->_tpl_vars['var']['comp_flg'] == true): ?>
			<table width="100%">
				<tr>
					<td align="left"><font color="#ff0000"><b>※は必須入力です</b></font></td>
					<!-- 画面表示判定 -->
					<?php if (( $this->_tpl_vars['var']['disp_stat'] == 3 || $this->_tpl_vars['var']['disp_stat'] == 6 ) && $this->_tpl_vars['var']['online_flg'] == 't'): ?>
												<td align="right">

						<!-- 申請取消・解約取消ボタン表示 -->
						<?php if ($this->_tpl_vars['var']['comp_msg'] != NULL): ?>
							<?php echo $this->_tpl_vars['form']['cancel_ok_btn']['html']; ?>
　　

						<!-- 承認・解約承認ボタン表示 -->
						<?php else: ?>
							<?php echo $this->_tpl_vars['form']['ok_btn']['html']; ?>
　　
						<?php endif; ?>

						<?php echo $this->_tpl_vars['form']['back_btn']['html']; ?>
</td>

					<?php else: ?>
												<td align="right"><?php echo $this->_tpl_vars['form']['ok_btn']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['back_btn']['html']; ?>
</td>
					<?php endif; ?>
				</tr>
			</table>

		<!-- 登録画面 -->
		<?php else: ?>
			<table width="100%">
				<tr>
					<td align="left"><font color="#ff0000"><b>※は必須入力です</b></font></td>
					<!-- 画面表示判定 -->
					<?php if (( $this->_tpl_vars['var']['disp_stat'] == 3 || $this->_tpl_vars['var']['disp_stat'] == 6 ) && $this->_tpl_vars['var']['online_flg'] == 't'): ?>
												<td align="right"><?php echo $this->_tpl_vars['form']['comp_btn']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['cancel_btn']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['return_btn']['html']; ?>
</td>
					<?php else: ?>
												<td align="right"><?php echo $this->_tpl_vars['form']['comp_btn']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['return_btn']['html']; ?>
</td>
					<?php endif; ?>
				</tr>
				<tr>
					<td align="left"><?php echo $this->_tpl_vars['form']['add_row_btn']['html']; ?>
</td>
				</tr>
			</table>
		<?php endif; ?>
	<?php endif; ?>
	        </td>
	    </tr>
	</table>
<?php endif; ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
