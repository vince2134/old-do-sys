<?php /* Smarty version 2.6.14, created on 2009-12-26 12:22:56
         compiled from 2-1-239.php.tpl */ ?>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="3">��<br>No.</td>
        <td class="Title_Purple" rowspan="3">������</td>
		<td class="Title_Purple" rowspan="3">������</td>
		<td class="Title_Purple" rowspan="3">��԰�����<br>(��ȴ)</td>
		<td class="Title_Purple" rowspan="3">��������</td>
        <td class="Title_Purple" rowspan="3">��ϩ</td>
        <td class="Title_Purple" colspan="10">�������</td>
        <td class="Title_Purple" rowspan="3">�����<br>�ʴ������</td>
        <td class="Title_Purple" rowspan="3">���ô��<br>������</td>
        <td class="Title_Purple" rowspan="3">����</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">�����ʬ</td>
        <td class="Title_Purple">�����ӥ�̾</td>
        <td class="Title_Purple">�����ƥ�</td>
        <td class="Title_Purple" rowspan="2">����</td>
        <td class="Title_Purple" colspan="2">���</td>
        <td class="Title_Purple" colspan="2">������</td>
        <td class="Title_Purple" colspan="2">���ξ���</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">̾��</td>
        <td class="Title_Purple">̾��</td>
        <td class="Title_Purple">�Ķȸ���<br>���ñ��</td>
        <td class="Title_Purple">�������<br>�����</td>
        <td class="Title_Purple">̾��</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">̾��</td>
        <td class="Title_Purple">����</td>
    </tr>
<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    	<?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][19] == 1): ?>
				<tr class="Result6">
    <?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][100] == true): ?>
        <tr class="Result2">
    <?php else: ?>
        <tr class="Result1">
    <?php endif; ?>
        <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101] != NULL): ?>
                <td align="right" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0]; ?>
</td>
                <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][1]; ?>
</td>
		        <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><a href="#" onClick="javascript:return Submit_Page2('./2-1-240.php?&client_id=<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][35]; ?>
&contract_id=<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][34]; ?>
');"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][37]; ?>
</a></td>
		        <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][18]; ?>
</td>
				<?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][19] == 1): ?>
			<td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
">������</td>
		<?php else: ?>
			<td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
">������</td>
		<?php endif; ?>
                <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][2]; ?>
</td>
        <?php elseif ($this->_tpl_vars['var']['early_flg'] == true): ?>
                <td align="right">��</td>
                <td align="center">��</td>
		        <td align="center">��</td>
		        <td align="center">��</td>
		        <td align="center">��</td>
                <td align="center">��</td>
    <?php endif; ?>


        <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][43] === 't'): ?>
                <td align="center" style="color: red"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][3]; ?>
</td>
                <td align="left" style="color: red"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][4]; ?>
 <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][5]; ?>
</td>
                <td align="left" style="color: red"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][6];  echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][7]; ?>
</td>
                <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] == 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] != NULL): ?>
            <td align="center" style="color: red">�켰<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9]; ?>
</td>
        <?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] == 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] == NULL): ?>
            <td align="center" style="color: red">�켰</td>
        <?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] != 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] != NULL): ?>
            <td align="right" style="color: red"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9]; ?>
</td>
        <?php endif; ?>
                <td align="right" style="color: red"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][10]; ?>
<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][11]; ?>
</td>
                <td align="right" style="color: red"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][12]; ?>
<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][13]; ?>
</td>
                <td align="left" style="color: red"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][14]; ?>
</td>
                <td align="right" style="color: red"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][15]; ?>
</td>
                <td align="left" style="color: red"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][16]; ?>
</td>
                <td align="right" style="color: red"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][17]; ?>
</td>
    <?php else: ?>
                <td align="center"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][3]; ?>
</td>
                <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][4]; ?>
 <?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][5]; ?>
</td>
                <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][6];  echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][7]; ?>
</td>
                <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] == 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] != NULL): ?>
            <td align="center">�켰<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9]; ?>
</td>
        <?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] == 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] == NULL): ?>
            <td align="center">�켰</td>
        <?php elseif ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8] != 't' && $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9] != NULL): ?>
            <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9]; ?>
</td>
        <?php endif; ?>
                <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][10]; ?>
<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][11]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][12]; ?>
<br><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][13]; ?>
</td>
                <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][14]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][15]; ?>
</td>
                <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][16]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][17]; ?>
</td>
    <?php endif; ?>


        <?php if ($this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101] != NULL): ?>
                <td align="center" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['round_data'][$this->_tpl_vars['i']]; ?>
</td>
                <td align="left" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][29];  echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][30];  echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][31];  echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][32]; ?>
</td>
                <td align="left" rowspan="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][101]; ?>
"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][33]; ?>
</td>
        <?php elseif ($this->_tpl_vars['var']['early_flg'] == true): ?>
                <td align="center">��</td>
                <td align="left">��</td>
                <td align="left">��</td>
    <?php endif; ?>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<table align="right">
    <tr>
        <td>
                        <?php if ($_GET['get_flg'] != NULL): ?>
                ����<?php echo $this->_tpl_vars['form']['form_back']['html']; ?>
</td>
            <?php endif; ?>
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
