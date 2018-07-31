<?php /* Smarty version 2.6.14, created on 2010-04-05 15:53:40
         compiled from 1-4-107.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8" >
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
<ul style="margin-left: 16px;">
<?php if ($this->_tpl_vars['form']['err_illegal_verify']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_illegal_verify']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error0'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error0']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error1'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error1']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error2'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error2']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_error3'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_error3']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_move_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_move_day']['error']; ?>
<br>
<?php endif; ?>
</ul>
</span>

 
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['insert_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['insert_msg']; ?>
<br>
<?php endif; ?>
<li>売買に関係ない移動の場合に使用して下さい。
<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow" width="100">移動日<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_move_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow" width="100">移動元倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_org_move']['html']; ?>

        <?php if ($this->_tpl_vars['var']['warning1'] != null): ?>
            <font color="#ff0000"><b><?php echo $this->_tpl_vars['var']['warning1']; ?>
</b></font>
        <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td class="Title_Yellow" width="100">移動先倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_move']['html']; ?>

        <?php if ($this->_tpl_vars['var']['warning2'] != null): ?>
            <font color="#ff0000"><b><?php echo $this->_tpl_vars['var']['warning2']; ?>
</b></font>
        <?php endif; ?>
        </td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_set_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
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

<table width="100%">
    <tr>
        <td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Yellow" colspan="2">移動元</td>
        <td class="Title_Yellow" colspan="2"><img src="../../../image/arrow.gif"></td>
        <td class="Title_Yellow" colspan="2">移動先</td>
        <td class="Title_Yellow" rowspan="2">行<br>（<?php echo $this->_tpl_vars['form']['add_row_link']['html']; ?>
）</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">倉庫名<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">在庫数<br>（引当数）</td>
        <td class="Title_Yellow">移動数<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">単位</td>
        <td class="Title_Yellow">倉庫名<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">在庫数<br>（引当数）</td>
    </tr>
    <?php echo $this->_tpl_vars['var']['html']; ?>

</table>

<A NAME="foot"></A>
<table border="0" width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_move_button']['html']; ?>
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
