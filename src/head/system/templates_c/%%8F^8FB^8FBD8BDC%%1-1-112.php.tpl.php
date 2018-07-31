<?php /* Smarty version 2.6.9, created on 2006-09-15 17:39:18
         compiled from 1-1-112.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>

</script>

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

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
<br><?php endif; ?>
</span>

 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['error_value'] != null): ?><li><?php echo $this->_tpl_vars['var']['error_value']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['rental_txt']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['rental_txt']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['f_goods']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['f_goods']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['money_txt']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['money_txt']['error']; ?>
<br><?php endif; ?>
<?php if ($this->_tpl_vars['form']['num_txt']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['num_txt']['error']; ?>
<br><?php endif; ?>
</span>

<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ショップ名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['shop_txt']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">レンタル先<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['rental_txt']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><a href="#" onClick="return Open_SubWin('../dialog/1-0-210.php',Array('f_goods[code]','f_goods[name]'),500,450);">商品名</a><font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_goods']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">レンタル料<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['money_txt']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">レンタル数<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['num_txt']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['note_txt']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['button']['touroku']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['clear']['html']; ?>
</td>
    </tr>
</table>

        </td>
    <tr>
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

全<b><?php echo $this->_tpl_vars['var']['total_count']['html']; ?>
</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">レンタル先</td>
        <td class="Title_Purple">商品名</td>
        <td class="Title_Purple">レンタル料</td>
        <td class="Title_Purple">レンタル数</td>
        <td class="Title_Purple">レンタル額</td>
        <td class="Title_Purple">備考</td>
        <td class="Title_Purple">変更</td>
        <td class="Title_Purple">削除</td>
    </tr>
<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1"> 
        <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
    <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['i'] == 0 || $this->_tpl_vars['i'] == 1 || $this->_tpl_vars['i'] == 5): ?>
            <td align="left"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php elseif (2 <= $this->_tpl_vars['i'] && $this->_tpl_vars['i'] <= 4): ?>
            <td align="right"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php elseif ($this->_tpl_vars['i'] == 6): ?>
            <td align="center"><a href="1-1-112.php?rental_id=<?php echo $this->_tpl_vars['item']; ?>
">変更</a></td>
            <td align="center"><a href="#" style="color:blue" onClick="javascript: return Dialogue_1('削除します。',<?php echo $this->_tpl_vars['item']; ?>
,'delete_row_id')">削除</a></td>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    </tr>   
<?php endforeach; endif; unset($_from); ?>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['button']['modoru']['html']; ?>
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
