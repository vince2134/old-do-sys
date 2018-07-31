<?php /* Smarty version 2.6.14, created on 2010-05-13 15:16:37
         compiled from 2-1-215.php.tpl */ ?>
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



<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">仕入先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">仕入先名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_area_id']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state_type']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="300">
    <tr>
        <td class="Title_Purple" width="80"><b>出力形式</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2">

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_button']['show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_button']['clear_button']['html']; ?>
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


<?php if ($this->_tpl_vars['var']['display_flg'] == true): ?>

<table width="100%">
    <tr>
        <td>

全<b><?php echo $this->_tpl_vars['var']['match_count']; ?>
</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">仕入先コード<br>仕入先名</td>
        <td class="Title_Purple">地区</td>
        <td class="Title_Purple">TEL</td>
        <td class="Title_Purple">状態</td>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1"> 
        <td align="right">
            <?php if ($_POST['f_page1'] != null): ?>
                <?php echo $_POST['f_page1']*10+$this->_tpl_vars['j']-9; ?>

            <?php else: ?>
            　  <?php echo $this->_tpl_vars['j']+1; ?>

            <?php endif; ?>
        </td>               
        <td>
            <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
<br>
            <a href="2-1-216.php?client_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</a></td>
        </td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
        <td align="center">
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == 1): ?>
            取引中
        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == 2): ?>
            解約・休止中
        <?php elseif ($this->_tpl_vars['row'][$this->_tpl_vars['j']][5] == 3): ?>
            解約
        <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
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
