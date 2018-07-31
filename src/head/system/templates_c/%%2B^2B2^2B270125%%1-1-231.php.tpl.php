<?php /* Smarty version 2.6.14, created on 2009-12-24 20:20:48
         compiled from 1-1-231.php.tpl */ ?>
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

<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
<br><?php endif; ?>
</span>

 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['form_serv_cd']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_serv_cd']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_serv_name']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_serv_name']['error']; ?>
<br><?php endif; ?>
</span>

<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">サービスコード<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_serv_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">サービス名<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_serv_name']['html']; ?>
</td>
    </tr>
	<tr>
        <td class="Title_Purple">課税区分<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tax_div']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">承認</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_accept']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td style="font-weight: bold; color: #ff0000;">※は必須入力です</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['entry_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
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

全 <b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b> 件　<?php echo $this->_tpl_vars['form']['csv_button']['html']; ?>
</td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">サービスコード</td>
        <td class="Title_Purple">サービス名</td>
		<td class="Title_Purple">課税区分</td>
        <td class="Title_Purple">備考</td>
        <td class="Title_Purple">承認</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1"> 
        <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
        <td align="left"><a href="1-1-231.php?serv_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</a></td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == '1'): ?><td align="center">○</td>
        <?php else: ?><td align="center" style="color: #ff0000;">×</td>
        <?php endif; ?>
    </tr>   
    <?php endforeach; endif; unset($_from); ?>
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
