<?php /* Smarty version 2.6.14, created on 2010-12-09 16:37:36
         compiled from 1-1-306.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

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


 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_close_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_close_day']['error']; ?>
<br>
    <?php endif; ?>   
    <?php if ($this->_tpl_vars['form']['form_set_error']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_set_error']['error']; ?>
<br>
    <?php endif; ?>   
    <?php if ($this->_tpl_vars['var']['add_msg'] != null): ?>
        <b><font color="blue"><li><?php echo $this->_tpl_vars['var']['add_msg']; ?>
</font></b><br>
    <?php endif; ?>   
    </span>

<table width="350">
    <tr>    
        <td>
<div style="text-align: left; font: bold; color: #3300ff;">
    ���ܻĹ�������ϳ���������Ͽ�塢����γ������ˣ��������Ǥ�դ�����Ǥ��ޤ���
</div>
<div style="text-align: left; font: bold; color: #3300ff;">
    ��������ʤ��˼������塢���⡢��������ʧ���ˤ���ꤷ����硢��ưŪ�˥�������ꤵ��ޤ���
</div>

<table border="1" class="Data_Table" width="100%">
<col width="80" style="font-weight: bold;">
    <tr>    
        <td class="Title_Purple">����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state_radio']['html']; ?>
</td>
    </tr>
    <tr>    
        <td class="Title_Purple">��ݻĹ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_zandaka_radio']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>    
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
</td>
    </tr>   
</table>

        </td>
    </tr>
</table><br>

                    </td>
                </tr>
                <tr>
                    <td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<?php if ($_POST['show_button_flg'] == true): ?>
<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
    <tr>
        <td class="Title_Purple" width="120"><b>�Ĺ�ܹ�ǯ����<font color="#ff0000">��</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_close_day']['html']; ?>
</td>
    </tr>
</table>
<br>

��<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>��<br>
<table class="List_Table" border="2" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">�����襳����</td>
        <td class="Title_Purple">������̾1</td>
        <td class="Title_Purple">������̾2</td>
        <td class="Title_Purple">��ݻĹ�</td>
        <td class="Title_Purple">�Ĺ�ܹ���</td>
    </tr>
    <?php $_from = $this->_tpl_vars['show_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][1]; ?>
-<?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][4]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_init_cbln'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td><?php echo $this->_tpl_vars['show_data'][$this->_tpl_vars['i']][7]; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <tr class="Result3" style="font-weight: bold;" align="right">
        <td colspan="4">�Ĺ���</td>
        <td><?php echo $this->_tpl_vars['form']['static_sum']['html']; ?>
</td>
        <td></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
</td>
    </tr>
</table>

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
