<?php /* Smarty version 2.6.14, created on 2010-04-05 16:11:12
         compiled from 2-2-415.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<style TYPE="text/css">
<!--
.required {
    font-weight: bold;
    color: #ff0000;
    }
-->
</style>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table height="90%" class="M_Table">

        <tr align="center" height="60">
        <td colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['errors'] != null): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">
    <?php $_from = $this->_tpl_vars['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['errors']):
?>
    <li><?php echo $this->_tpl_vars['errors']; ?>
</li><br>
    <?php endforeach; endif; unset($_from); ?>
    </ul>
</span>
<?php endif; ?>

<table>
    <tr>
        <td>

<table class="Table_Search" border="1" width="400">
    <col width=" 80px" style="font-weight: bold;">
    <tr>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
<span class="required">��</span></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">���״���<span class="required">��</span></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_count_day']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><span class="required">����ɬ�����ϤǤ�</span></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_display']['html']; ?>
����<?php echo $this->_tpl_vars['form']['form_clear']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['var']['post_flg'] == true && $this->_tpl_vars['var']['err_flg'] != true): ?>

<table>
    <tr>
        <td>��<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>��</td>
    </tr>
    <tr>
        <td>

<table class="List_Table" width="100%" border="1">
    <col span="5">
    <col span="3" width="90px">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">����</td>
        <td class="Title_Pink">��ɼ�ֹ�</td>
        <td class="Title_Pink">�����ʬ</td>
        <td class="Title_Pink">����̾</td>
        <td class="Title_Pink">������</td>
        <td class="Title_Pink">�����껦��</td>
        <td class="Title_Pink">������Ĺ�</td>
    </tr>
    <?php echo $this->_tpl_vars['html']['html_l']; ?>

    <?php echo $this->_tpl_vars['html']['html_g']; ?>

</table>

        </td>
    </tr>
    <tr>
        <td>��<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>��</td>
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
