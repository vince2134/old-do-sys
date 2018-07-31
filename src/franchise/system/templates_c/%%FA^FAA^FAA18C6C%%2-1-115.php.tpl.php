<?php /* Smarty version 2.6.14, created on 2009-12-26 12:28:47
         compiled from 2-1-115.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<body class="bgimg_purple">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<table>
    <tr>
        <td>
<table class="Data_Table" border="1" width="655" height="33">
    <tr>
        <td class="Title_Purple" width="90"><b><?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
        <td class="Title_Purple" width="90"><b>取引状態</b></td>
        <td class="Value" width="100"><?php echo $this->_tpl_vars['var']['state']; ?>
</td>
        <td class="Title_Purple" width="90"><b>取引区分</b></td>
        <td class="Value" width="100"><?php echo $this->_tpl_vars['var']['trade_name']; ?>
</td>
    </tr>
</table>

        </td>
        <td>

&nbsp;&nbsp;

        </td>
        <td>

<table class="Data_Table" border="1" width="380" height="33">
    <tr>
        <td class="Title_Purple" width="80"><b>ご紹介口座</b></td>
        <td class="Value" width="300"><?php echo $this->_tpl_vars['var']['ac_name']; ?>
</td>  
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<br style="font-size: 4px;">
<?php echo $this->_tpl_vars['var']['html_g']; ?>


        </td>
    </tr>
</table>

                    </td>
                </tr>
                <tr>
                    <td>


<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="3">行<br>No.</td>
        <td class="Title_Purple" rowspan="3">契約状態</td>
        <td class="Title_Purple" rowspan="3">契約日</td>
		<!-- 直営判定 -->
		<?php if ($_SESSION['group_kind'] == '2'): ?>
      <td class="Title_Purple" colspan="4">代行</td>
		<?php endif; ?>
        <td class="Title_Purple" rowspan="3">順路</td>
        <td class="Title_Purple" colspan="10">巡回内容</td>
        <td class="Title_Purple" rowspan="3" colspan="2">ご紹介料</td>
        <td class="Title_Purple" rowspan="3">前受相殺額</td>
        <td class="Title_Purple" rowspan="3">巡回日<br>（基準日）</td>
        <td class="Title_Purple" rowspan="3">巡回担当<br>（売上）</td>
        <td class="Title_Purple" rowspan="3">変更<br><br>複写追加</td>
        <td class="Title_Purple" rowspan="3">備考</td>
        <td class="Title_Purple" rowspan="3">変更履歴</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
		<?php if ($_SESSION['group_kind'] == '2'): ?>
			<td class="Title_Purple" rowspan="2">依頼日</td>
			<td class="Title_Purple" rowspan="2">代行先</td>
			<td class="Title_Purple" rowspan="2">代行委託料<br>(税抜)</td>
			<td class="Title_Purple" rowspan="2">状況</td>
		<?php endif; ?>

        <td class="Title_Purple" rowspan="2">販売区分</td>
        <td class="Title_Purple" rowspan="2">サービス名</td>
        <td class="Title_Purple" rowspan="2">アイテム</td>
        <td class="Title_Purple" rowspan="2">数量</td>
        <td class="Title_Purple" colspan="2">金額</td>
        <td class="Title_Purple" colspan="2">消耗品</td>
        <td class="Title_Purple" colspan="2">本体商品</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">営業原価<br>売上単価</td>
        <td class="Title_Purple">原価合計<br>売上合計</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">数量</td>
    </tr>
<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    	<?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][38] != NULL): ?>
				<tr class="Result6">
    <?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][100] == true): ?>
		        <tr class="Result2">
	<?php else: ?>
		        <tr class="Result1">
    <?php endif; ?>
        <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101] != NULL): ?>
        <td align="right" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0]; ?>
</td>          <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][45]; ?>
</td>        <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][1]; ?>
</td> 		<!-- 直営判定 -->
		<?php if ($_SESSION['group_kind'] == '2'): ?>
				        <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][39]; ?>
</td>
				        <td align="left" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][42];  if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][38] != NULL): ?>-<?php endif;  echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][43]; ?>
<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][38]; ?>
</td>
				        <td align="right" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][48]; ?>
</td>
			
			<?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][38] == NULL): ?>
								<td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"></td>
			<?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][41] == '1'): ?>
				<td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
">依頼中</td>
			<?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][41] == '2' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][38] != NULL): ?>
	        	<td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
">受託済</td>
			<?php endif; ?>

		<?php endif; ?>
                <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][2]; ?>
</td>
        <?php elseif ($this->_tpl_vars['var']['early_flg'] == true): ?>
        <td align="right"></td>         <td align="right"></td>         <td align="center"></td>
		<!-- 直営判定 -->
		<?php if ($_SESSION['group_kind'] == '2'): ?>
	        <td align="center"></td>	        <td align="center"></td>	        <td align="center"></td>	        <td align="center"></td>		<?php endif; ?>

        
        <td align="center"></td>    <?php endif; ?>

            <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][54] === 't'): ?>
        <td align="center" style="color: red;"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][3]; ?>
</td>        <td align="left" style="color: red;"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][4]; ?>
 <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][5]; ?>
</td>        <td align="left" style="color: red;"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][6]; ?>
 <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][7]; ?>
</td>
                <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] == 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] != NULL): ?>
            <td align="center" style="color: red;">一式<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9]; ?>
</td>
        <?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] == 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] == NULL): ?>
            <td align="center" style="color: red;">一式</td>
        <?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] != 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] != NULL): ?>
            <td align="right" style="color: red;"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9]; ?>
</td>
        <?php else: ?>
            <td align="right"> </td>
        <?php endif; ?>
        <td align="right" style="color: red;"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][10]; ?>
<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][11]; ?>
</td>        <td align="right" style="color: red;"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][12]; ?>
<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][13]; ?>
</td>        <td align="left" style="color: red;"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][14]; ?>
</td>          <td align="right" style="color: red;"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][15]; ?>
</td>         <td align="left" style="color: red;"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][16]; ?>
</td>          <td align="right" style="color: red;"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][17]; ?>
</td>     <?php else: ?>
        <td align="center"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][3]; ?>
</td>        <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][4]; ?>
 <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][5]; ?>
</td>        <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][6]; ?>
 <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][7]; ?>
</td>
                <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] == 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] != NULL): ?>
            <td align="center">一式<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9]; ?>
</td>
        <?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] == 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] == NULL): ?>
            <td align="center">一式</td>
        <?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] != 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] != NULL): ?>
            <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9]; ?>
</td>
        <?php else: ?>
            <td align="right"> </td>
        <?php endif; ?>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][10]; ?>
<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][11]; ?>
</td>        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][12]; ?>
<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][13]; ?>
</td>        <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][14]; ?>
</td>          <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][15]; ?>
</td>         <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][16]; ?>
</td>          <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][17]; ?>
</td>     <?php endif; ?>
        
		<?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101] != NULL): ?>
    <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][46]; ?>
</td>
		<?php endif; ?>
    <td align="right" width="20"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][47]; ?>
</td>     <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][53]; ?>
</td>         <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101] != NULL): ?>
                <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['round_data'][$this->_tpl_vars['i']]; ?>
</td>
                <td align="left" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][29];  echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][30];  echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][31];  echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][32]; ?>
</td>
                <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><a href="#" onClick="javascript:return Submit_Page2('./2-1-104.php?flg=chg&client_id=<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][35]; ?>
&contract_id=<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][34]; ?>
&return_flg=true&get_flg=<?php echo $this->_tpl_vars['var']['get_flg']; ?>
');">変更</a><br><br><a href="#" onClick="javascript:return Submit_Page2('./2-1-104.php?flg=copy&client_id=<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][35]; ?>
&contract_id=<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][34]; ?>
&return_flg=true&get_flg=<?php echo $this->_tpl_vars['var']['get_flg']; ?>
');">複写追加</a></td>
                <td align="left" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][33]; ?>
</td>
        <td align="left" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
">
		<?php $_from = $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']]['history']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val']):
?>
			<?php if ($this->_tpl_vars['val']['work_time'] != NULL): ?>
				<?php echo $this->_tpl_vars['key']+1; ?>
回前：
				<?php echo $this->_tpl_vars['val']['work_time']; ?>

				<?php echo $this->_tpl_vars['val']['staff_name']; ?>

				<br>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
				
				
				
				</td>
        <?php elseif ($this->_tpl_vars['var']['early_flg'] == true): ?>
                <td align="center"></td>
                <td align="left"></td>
                <td align="center"></td>
                <td align="left"></td>
        <td align="left"></td>
    <?php endif; ?>

    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<table align="right">
    <tr>
        <td>
            <?php echo $this->_tpl_vars['form']['form_insert']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_back']['html']; ?>

        </td>
    </tr>
</table>

        </td>
    </tr>
</table>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
