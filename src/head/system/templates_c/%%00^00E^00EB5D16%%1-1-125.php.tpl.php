<?php /* Smarty version 2.6.14, created on 2007-08-24 13:37:22
         compiled from 1-1-125.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script Language="JavaScript">
<!--
<?php echo $this->_tpl_vars['var']['js']; ?>

-->
</script>
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
</span>

<table><tr><td>

<table class="Data_Table" border="1" width="650">
<col width="140" style="font-weight: bold;">
<col>
<col width="140" style="font-weight: bold;">
<col>
    <?php if ($_SESSION['group_kind'] == '1'): ?>
    <tr>
        <td class="Title_Purple">����åץ�����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_cd']['html']; ?>
</td>
        <td class="Title_Purple">����å�̾</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
    <tr>
        <td class="Title_Purple">ô���ԥ�����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charge_cd']['html']; ?>
</td>
        <td class="Title_Purple">�����å�̾</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�������</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_del_compe']['html']; ?>
</td>
        <td class="Title_Purple">��ǧ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_accept_compe']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan=>�߿�����</td>
        <td class="Value" colspan=3><?php echo $this->_tpl_vars['form']['form_staff_state']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">������Ϳ</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_compe_invest']['html']; ?>
</td>
    </tr>


</table>
    <tr><td align=right><?php echo $this->_tpl_vars['form']['csv_btn']['html']; ?>
����<?php echo $this->_tpl_vars['form']['clear_btn']['html']; ?>
<br></td></tr>
</table>
<br>

                                        </td>
                                </tr>
                                <tr>
                                        <td>




                                        </td>
                                </tr>
                        </table>
                </td>
        </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
