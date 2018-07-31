<?php /* Smarty version 2.6.14, created on 2010-04-05 16:00:16
         compiled from 1-6-121.php.tpl */ ?>
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



<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">出力形式</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_r_output2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">取引年月</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_date_d1']['html']; ?>
</td>
        <td class="Title_Gray">出力内容</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_radio67']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">仕入先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text6']['html']; ?>
</td>
        <td class="Title_Gray">仕入先名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text15']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">商品コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text8']['html']; ?>
</td>
        <td class="Title_Gray">商品名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text30']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">Ｍ区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_goods_1']['html']; ?>
</td>
        <td class="Title_Gray">製品区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_product_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">出力項目</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_check18']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['hyouji']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['kuria']['html']; ?>
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

<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="3">
<col span="14" align="right">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>
        <td class="Title_Gray" align="center">仕入先名</td>
        <td class="Title_Gray" align="center">商品名</td>
        <td class="Title_Gray" align="center"></td>
        <td class="Title_Gray" align="center">2005年1月</td>
        <td class="Title_Gray" align="center">2005年2月</td>
        <td class="Title_Gray" align="center">2005年3月</td>
        <td class="Title_Gray" align="center">2005年4月</td>
        <td class="Title_Gray" align="center">2005年5月</td>
        <td class="Title_Gray" align="center">2005年6月</td>
        <td class="Title_Gray" align="center">2005年7月</td>
        <td class="Title_Gray" align="center">2005年8月</td>
        <td class="Title_Gray" align="center">2005年9月</td>
        <td class="Title_Gray" align="center">2005年10月</td>
        <td class="Title_Gray" align="center">2005年11月</td>
        <td class="Title_Gray" align="center">2005年12月</td>
        <td class="Title_Gray" align="center">月合計</td>
        <td class="Title_Gray" align="center">月平均</td>
    </tr>
    <tr class="Result1">
        <td rowspan="4">1</td>
        <td rowspan="4">仕入先1</td>
        <td>商品A</td>
        <td>仕入数<br>仕入金額<br>支払額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result2">
        <td>商品B</td>
        <td>仕入数<br>仕入金額<br>支払額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result1">
        <td>商品C</td>
        <td>仕入数<br>仕入金額<br>支払額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td align="center" colspan="2">小計</td>
        <td>3<br>30,000<br>18,000</td>
        <td>6<br>30,000<br>18,000</td>
        <td>9<br>30,000<br>18,000</td>
        <td>12<br>30,000<br>18,000</td>
        <td>15<br>30,000<br>18,000</td>
        <td>18<br>30,000<br>18,000</td>
        <td>21<br>30,000<br>18,000</td>
        <td>24<br>30,000<br>18,000</td>
        <td>27<br>30,000<br>18,000</td>
        <td>30<br>30,000<br>18,000</td>
        <td>33<br>30,000<br>18,000</td>
        <td>36<br>30,000<br>18,000</td>
        <td>234<br>360,000<br>216,000</td>
        <td>19.5<br>30,000<br>18,000</td>
    </tr>
    <tr class="Result1">
        <td rowspan="4">2</td>
        <td rowspan="4">仕入先2</td>
        <td>商品D</td>
        <td>仕入数<br>仕入金額<br>支払額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result2">
        <td>商品E</td>
        <td>仕入数<br>仕入金額<br>支払額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result1">
        <td>商品F</td>
        <td>仕入数<br>仕入金額<br>支払額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td align="center" colspan="2">小計</td>
        <td>3<br>30,000<br>18,000</td>
        <td>6<br>30,000<br>18,000</td>
        <td>9<br>30,000<br>18,000</td>
        <td>12<br>30,000<br>18,000</td>
        <td>15<br>30,000<br>18,000</td>
        <td>18<br>30,000<br>18,000</td>
        <td>21<br>30,000<br>18,000</td>
        <td>24<br>30,000<br>18,000</td>
        <td>27<br>30,000<br>18,000</td>
        <td>30<br>30,000<br>18,000</td>
        <td>33<br>30,000<br>18,000</td>
        <td>36<br>30,000<br>18,000</td>
        <td>234<br>360,000<br>216,000</td>
        <td>19.5<br>30,000<br>18,000</td>
    </tr>
    <tr class="Result4" style="font-weight: bold;">
        <td>合計</td>
        <td>2店舗</td>
        <td colspan="2">　</td>
        <td>6<br>30,000<br>18,000</td>
        <td>12<br>30,000<br>18,000</td>
        <td>18<br>30,000<br>18,000</td>
        <td>24<br>30,000<br>18,000</td>
        <td>30<br>30,000<br>18,000</td>
        <td>36<br>30,000<br>18,000</td>
        <td>42<br>30,000<br>18,000</td>
        <td>48<br>30,000<br>18,000</td>
        <td>54<br>30,000<br>18,000</td>
        <td>60<br>30,000<br>18,000</td>
        <td>66<br>30,000<br>18,000</td>
        <td>72<br>30,000<br>18,000</td>
        <td>468<br>360,000<br>216,000</td>
        <td>39<br>30,000<br>18,000</td>
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
