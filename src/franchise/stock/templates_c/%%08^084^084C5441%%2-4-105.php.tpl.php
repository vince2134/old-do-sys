<?php /* Smarty version 2.6.14, created on 2010-05-13 14:31:42
         compiled from 2-4-105.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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
<?php if ($this->_tpl_vars['var']['error'] != null):  echo $this->_tpl_vars['var']['error']; ?>
<br><?php endif; ?>
</span>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="600">
<col width="110" style="font-weight: bold;">
<col width="190">
<col width="110" style="font-weight: bold;">
<col>
        <?php if ($this->_tpl_vars['var']['get_goods_id'] == NULL && $this->_tpl_vars['var']['get_ware_id'] == NULL): ?>
        <tr>
            <td class="Title_Yellow"><b>取扱期間</b></td>
            <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_hand_day']['html']; ?>
</td>
        </tr>
        <tr>
            <td class="Title_Yellow"><b>倉庫</b></td>
            <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>
</td>
        </tr>
        <tr>
            <td class="Title_Yellow"><b>商品コード</b></td>
            <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
            <td class="Title_Yellow"><b>商品名</b></td>
            <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
        </tr>
        <tr>
            <td class="Title_Yellow"><b>商品分類</b></td>
            <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_product']['html']; ?>
</td>
                        <td class="Title_Yellow"><b>出力形式</b></td>
            <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
        </tr>
    <?php else: ?>
                <tr>
            <td class="Title_Yellow">取扱期間</td>
            <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_hand_day']['html']; ?>
</td>
        </tr>
    <?php endif; ?>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['show_button']['html']; ?>
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


<?php if ($this->_tpl_vars['var']['display_flg'] == true): ?>

<table width="100%">
    <tr>
        <td>

<span style="font: bold 16px; color: #555555;">
【取扱期間：
<?php if ($this->_tpl_vars['var']['error'] == null && ( $this->_tpl_vars['var']['hand_start'] != NULL || $this->_tpl_vars['var']['hand_end'] != NULL )):  echo $this->_tpl_vars['var']['hand_start']; ?>
 〜 <?php echo $this->_tpl_vars['var']['hand_end']; ?>

<?php else: ?>指定無し<?php endif; ?>
】
</span><br>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">倉庫</td>
        <td class="Title_Yellow">商品分類</td>
        <td class="Title_Yellow">商品コード<br>商品名</td>
        <td class="Title_Yellow">前残在庫</td>
        <td class="Title_Yellow">入庫数</td>
        <td class="Title_Yellow">出庫数</td>
        <td class="Title_Yellow">現在庫数</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
        <?php if ($this->_tpl_vars['j'] == 0 || $this->_tpl_vars['j']%2 == 0): ?>
        <tr class="Result1">
    <?php else: ?>
                <tr class="Result2">
    <?php endif; ?>
        <td align="right">
        <?php if ($_POST['show_button'] == "表　示"): ?>
            <?php echo $this->_tpl_vars['j']+1; ?>

        <?php elseif ($_POST['f_page1'] != null): ?>
            <?php echo $_POST['f_page1']*100+$this->_tpl_vars['j']-99; ?>

        <?php else: ?>
            <?php echo $this->_tpl_vars['j']+1; ?>

        <?php endif; ?>
        </td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
</td>
                <?php if ($this->_tpl_vars['var']['get_goods_id'] == NULL && $this->_tpl_vars['var']['get_ware_id'] == NULL): ?>
                        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
<br><a href="2-4-113.php?ware_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
&goods_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
&cshop_id=<?php echo $this->_tpl_vars['var']['cshop']; ?>
&start=<?php echo $this->_tpl_vars['var']['hand_start']; ?>
&end=<?php echo $this->_tpl_vars['var']['hand_end']; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</a></td>
        <?php elseif ($this->_tpl_vars['var']['get_goods_id'] != NULL && $this->_tpl_vars['var']['get_ware_id'] == NULL): ?>
                        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
<br><a href="2-4-113.php?ware_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
&goods_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
&cshop_id=<?php echo $this->_tpl_vars['var']['cshop']; ?>
&start=<?php echo $this->_tpl_vars['var']['hand_start']; ?>
&end=<?php echo $this->_tpl_vars['var']['hand_end']; ?>
&trans_flg=1""><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</a></td>
        <?php elseif ($this->_tpl_vars['var']['get_goods_id'] != NULL && $this->_tpl_vars['var']['get_ware_id'] != NULL): ?>
                        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
<br><a href="2-4-113.php?ware_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
&goods_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
&cshop_id=<?php echo $this->_tpl_vars['var']['cshop']; ?>
&start=<?php echo $this->_tpl_vars['var']['hand_start']; ?>
&end=<?php echo $this->_tpl_vars['var']['hand_end']; ?>
&trans_flg=2""><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>
</a></td>
        <?php endif; ?>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


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
