<?php /* Smarty version 2.6.14, created on 2010-04-05 15:54:11
         compiled from 1-4-104.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>

</script>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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
<?php if ($this->_tpl_vars['var']['error_value'] != null): ?><li><?php echo $this->_tpl_vars['var']['error_value']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['g_name']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['g_name']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['note']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['note']['error']; ?>
<br><?php endif; ?>
</span>
<br>

<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">グループ名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['g_select']['html']; ?>
　<?php echo $this->_tpl_vars['form']['button']['display']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['delete']['html']; ?>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">グループ名<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['g_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">コメント<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['note']['html']; ?>
</td>
    </tr>
</table>
<br>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">商品コード<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">商品名</td>
        <td class="Title_Yellow">行<br>（<a href="#" title="入力欄を一行追加します。" onClick="javascript:insert_row('insert_row_flg')">追加</a>）</td>
    </tr>
    <?php echo $this->_tpl_vars['var']['html_row']; ?>

</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['button']['touroku']['html']; ?>
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
