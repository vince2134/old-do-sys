<?php /* Smarty version 2.6.9, created on 2006-08-24 13:34:56
         compiled from kaku-m_add_row.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table width="100%" height="90%" class="M_Table">

            <tr align="center" height="60">
                <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
        </tr>
    
            <tr align="center" valign="top">
                <td>
                        <table>
                                <tr>
                                        <td>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['input_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['input_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['date_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['date_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['trade_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['trade_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['paymon_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['paymon_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['payfee_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['payfee_err']; ?>
<br>
<?php endif; ?>

</span>




<table width="500">
    <tr>
        <td>

        </td>
    </tr>
</table>
<br>

                                        </td>
                                </tr>
                                <tr>
                                        <td>

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
        <tr align="center" style="font-weight: bold;">
                <td class="Title_Blue" width="">No.</td>
                <td class="Title_Blue" width="300">������<font color="red">��</font></td>
                <td class="Title_Blue" width="155">��ʧ��<font color="red">��</font></td>
                <td class="Title_Blue" width="160">�����ʬ<font color="red">��</font></td>
                <td class="Title_Blue" width="160">�������</td>
                <td class="Title_Blue" width="120">��ʧ���<font color="red">��</font></td>
                <td class="Title_Blue" width="120">�����</td>
                <td class="Title_Blue" width="300">����</td>
                <td class="Title_Blue" width="">��<br>
                ��<a href="#" onClick="javascript:Button_Submit_1('add_row_flg', '#', 'true');">�ɲ�</a>��</td>
        </tr>
        <?php echo $this->_tpl_vars['var']['html']; ?>

        <tr class="Result2" style="font-weight: bold;">
                <td colspan=2>���</td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">401,745</td>
                <td align="right">0</td>
                <td></td>
                <td></td>
        </tr>
</table>
        <?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%">
        <tr>
                <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
                <td align="right"><?php echo $this->_tpl_vars['form']['money4']['html']; ?>
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

