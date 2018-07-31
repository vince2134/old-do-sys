<?php /* Smarty version 2.6.9, created on 2006-05-23 11:04:03
         compiled from 2-6-107.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
             <?php echo $this->_tpl_vars['var']['page_header']; ?>
         </td>
    </tr>

    <tr align="center">
    

                <td valign="top">
        
            <table border=0 >
                <tr>
                    <td>

<table  class="Data_Table" border="1" width="700" >

    <tr>
        <td class="Title_Gray" width="100"><b>出力形式</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_r_output2']['html']; ?>
</td>
        <td class="Title_Gray" width="100"><b>出力範囲</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_radio12']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Gray"width="100"><b>取引年月</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_date_d1']['html']; ?>
</td>
        <td class="Title_Gray" width="100"><b>出力内容</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_radio67']['html']; ?>
</td>
    </tr>

        <tr>
        <td class="Title_Gray" width="100"><b>業種</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_btype_1']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>商品コード</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text8']['html']; ?>
</td>
        <td class="Title_Gray" width="100"><b>商品名</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text30']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>Ｍ区分</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_goods_1']['html']; ?>
</td>
        <td class="Title_Gray" width="100"><b>製品区分</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_product_1']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>対象拠点</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_cshop_1']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>出力項目</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_check3']['html']; ?>
</td>
    </tr>

</table>
<table width='700'>
    <tr>
        <td align='right'>
            <?php echo $this->_tpl_vars['form']['hyouji']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['kuria']['html']; ?>

        </td>
    </tr>
</table>

                    <br>
                    </td>
                </tr>


                <tr>
                    <td>

<font size="+0.5" color="#555555"><b>【対象拠点：　拠点1】</b></font>
<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Gray"><b>No.</b></td>
        <td class="Title_Gray" width=""><b>業種名</b></td>
        <td class="Title_Gray" width=""><b>商品名</b></td>
        <td class="Title_Gray" width=""><b></b></td>
        <td class="Title_Gray" width=""><b>2005年1月</b></td>
        <td class="Title_Gray" width=""><b>2005年2月</b></td>
        <td class="Title_Gray" width=""><b>2005年3月</b></td>
        <td class="Title_Gray" width=""><b>2005年4月</b></td>
        <td class="Title_Gray" width=""><b>2005年5月</b></td>
        <td class="Title_Gray" width=""><b>2005年6月</b></td>
        <td class="Title_Gray" width=""><b>2005年7月</b></td>
        <td class="Title_Gray" width=""><b>2005年8月</b></td>
        <td class="Title_Gray" width=""><b>2005年9月</b></td>
        <td class="Title_Gray" width=""><b>2005年10月</b></td>
        <td class="Title_Gray" width=""><b>2005年11月</b></td>
        <td class="Title_Gray" width=""><b>2005年12月</b></td>
        <td class="Title_Gray" width=""><b>月合計</b></td>
        <td class="Title_Gray" width=""><b>月平均</b></td>
    </tr>

    <tr class="Result1">
        <td align="right" rowspan="4">1</td>
        <td align="left" rowspan="4">業種A</td>
        <td align="left">商品1</td>
        <td align="left">売上金額</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">120,000</td>
        <td align="right">10,000</td>
    </tr>

    <tr class="Result2">
        <td align="left">商品2</td>
        <td align="left">売上金額</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">120,000</td>
        <td align="right">10,000</td>
    </tr>

    <tr class="Result1">
        <td align="left">商品3</td>
        <td align="left">売上金額</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">120,000</td>
        <td align="right">10,000</td>
    </tr>

    <tr class="Result3">
        <td align="center" colspan="2"><b>小計</b></td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>360,000</td>
        <td align="right"><b>30,000</td>
    </tr>

    <tr class="Result1">
        <td align="right" rowspan="4">2</td>
        <td align="left" rowspan="4">業種B</td>
        <td align="left">商品4</td>
        <td align="left">売上金額</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">120,000</td>
        <td align="right">10,000</td>
    </tr>

    <tr class="Result2">
        <td align="left">商品5</td>
        <td align="left">売上金額</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">120,000</td>
        <td align="right">10,000</td>
    </tr>

    <tr class="Result1">
        <td align="left">商品6</td>
        <td align="left">売上金額</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">120,000</td>
        <td align="right">10,000</td>
    </tr>

    <tr class="Result3">
        <td align="center" colspan="2"><b>小計</b></td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>30,000</td>
        <td align="right"><b>360,000</td>
        <td align="right"><b>30,000</td>
    </tr>

    <tr class="Result4">
        <td align="left"><b>合計</b></td>
        <td align="left"><b>2業種</b></td>
        <td align="right" colspan="2"><b>　</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>60,000</b></td>
        <td align="right"><b>720,000</b></td>
        <td align="right"><b>60,000</b></td>
    </tr>

</table>



                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

    
