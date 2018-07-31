<?php /* Smarty version 2.6.9, created on 2007-01-30 15:55:20
         compiled from 1-2-103.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


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

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">受注番号</td>
        <td class="Value" colspan="3"></td>
    </tr>
    <tr>
        <td class="Title_Pink">受注日時</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_date_a1']['html']; ?>
</td>
        <td class="Title_Pink">希望納期</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Pink">運送業者</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_trans_check']['html'];  echo $this->_tpl_vars['form']['form_trans_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">得意先</td>
        <td class="Value" colspan="3"></td>
    </tr>
    <tr>
        <td class="Title_Pink">直送先</td>
        <td class="Value"></td>
        <td class="Title_Pink">出荷倉庫</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">取引区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['trade_aord_1']['html']; ?>
</td>
        <td class="Title_Pink">担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（得意先宛）</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_textarea']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（本部宛）</td>
        <td class="Value" colspan="3"></td>
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

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">商品コード<br>商品名</td>
        <td class="Title_Pink">受注数</td>
        <td class="Title_Pink">単位</td>
        <td class="Title_Pink">原価単価<br>売上単価</td>
        <td class="Title_Pink">原価金額<br>売上金額</td>
        <td class="Title_Pink">伝票印字</td>
    </tr>
        <tr class="Result1">
        <td align="right">1</td>
        <td>10001000<br>商品A</td>
        <td align="right">100</td>
        <td>個</td>
        <td align="right">100.00<br>125.00</td>
        <td align="right">10,000.00<br>12,500.00</td>
        <td align="center">する</td>
    </tr>
        <tr class="Result1">
        <td align="right">2</td>
        <td>10001001<br>商品B</td>
        <td align="right">40</td>
        <td>個</td>
        <td align="right">100.00<br>125.00</td>
        <td align="right">4,000.00<br>5,000.00</td>
        <td align="center">する</td>
    </tr>
        <tr class="Result1">
        <td align="right">3</td>
        <td>10001002<br>商品C</td>
        <td align="right">150</td>
        <td>個</td>
        <td align="right">100.00<br>125.00</td>
        <td align="right">15,000.00<br>18,750.00</td>
        <td align="center">しない</td>
    </tr>
        <tr class="Result1">
        <td align="right">4</td>
        <td>10001003<br>商品D</td>
        <td align="right">110</td>
        <td>個</td>
        <td align="right">100.00<br>125.00</td>
        <td align="right">11,000.00<br>13,750.00</td>
        <td align="center">する</td>
    </tr>
    <tr class="Result1">
        <td align="right">5</td>
        <td>10001004<br>商品E</td>
        <td align="right">110</td>
        <td>個</td>
        <td align="right">100.00<br>125.00</td>
        <td align="right">11,000.00<br>13,750.00</td>
        <td align="center">する</td>
    </tr>
    <tr class="Result2" align="center">
        <td>合計</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">51,000.00<br>63,750.00</td>
        <td></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['hattyuusho']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['touroku']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['modoru']['html']; ?>
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
