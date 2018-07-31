<?php /* Smarty version 2.6.9, created on 2006-05-12 14:01:03
         compiled from 1-6-141.php.tpl */ ?>
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



<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="650">
<col width="120" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">ショップコード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_code_a1']['html']; ?>
</td>
        <td class="Title_Gray">ショップ名</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['f_text15']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">顧客区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_rank_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">SV</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_staff_1']['html']; ?>
</td>
        <td class="Title_Gray">担当者1</td>
        <td class="Value" ><?php echo $this->_tpl_vars['form']['form_staff_2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">表示順</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['analysis_radio1']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['button']['hyouji']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['kuria']['html']; ?>
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
<col span="5">
<col span="3" align="right">
<col align="center">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>
        <td class="Title_Gray" align="center">顧客名</td>
        <td class="Title_Gray" align="center">顧客区分</td>
        <td class="Title_Gray" align="center">SV</td>
        <td class="Title_Gray" align="center">担当者</td>
        <td class="Title_Gray" align="center">商品名</td>
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">数量</td>
        <td class="Title_Gray" align="center">合計</td>
        <td class="Title_Gray" align="center">最終設定日</td>
    </tr>
    <tr class="Result1">
        <td rowspan="5">1</td>
        <td rowspan="5">顧客A</td>
        <td rowspan="5">区分1</td>
        <td>SV1</td>
        <td>担当A</td>
        <td>商品1</td>
        <td>1,000</td>
        <td>1</td>
        <td>1,000</td>
        <td>2005-04-01</td>
    </tr>
    <tr class="Result2">
        <td>SV1</td>
        <td>担当A</td>
        <td>商品2</td>
        <td>300</td>
        <td>3</td>
        <td>900</td>
        <td>2005-04-01</td>
    </tr>
    <tr class="Result1">
        <td>SV1</td>
        <td>担当B</td>
        <td>商品3</td>
        <td>700</td>
        <td>2</td>
        <td>1,400</td>
        <td>2005-04-01</td>
    </tr>
    <tr class="Result2">
        <td>SV1</td>
        <td>担当B</td>
        <td>商品4</td>
        <td>400</td>
        <td>4</td>
        <td>1,600</td>
        <td>2005-04-01</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>小計</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td>4,900</td>
        <td></td>
    </tr>
    <tr class="Result1">
        <td rowspan="2">2</td>
        <td rowspan="2">顧客B</td>
        <td rowspan="2">区分2</td>
        <td>SV2</td>
        <td>担当A</td>
        <td>商品5</td>
        <td>1,500</td>
        <td>1</td>
        <td>1,500</td>
        <td>2005-04-02</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>小計</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td>1,500</td>
        <td></td>
    </tr>
    <tr class="Result1">
        <td rowspan="5">3</td>
        <td rowspan="5">顧客C</td>
        <td rowspan="5">区分3</td>
        <td>SV3</td>
        <td>担当A</td>
        <td>商品1</td>
        <td>200</td>
        <td>7</td>
        <td>1,400</td>
        <td>2005-04-03</td>
    </tr>
    <tr class="Result2">
        <td>SV3</td>
        <td>担当B</td>
        <td>商品2</td>
        <td>400</td>
        <td>5</td>
        <td>2,000</td>
        <td>2005-04-03</td>
    </tr>
    <tr class="Result1">
        <td>SV3</td>
        <td>担当C</td>
        <td>商品3</td>
        <td>600</td>
        <td>3</td>
        <td>1,800</td>
        <td>2005-04-03</td>
    </tr>
    <tr class="Result2">
        <td>SV3</td>
        <td>担当D</td>
        <td>商品4</td>
        <td>800</td>
        <td>4</td>
        <td>800</td>
        <td>2005-04-03</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>小計</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td>6,000</td>
        <td></td>
    </tr>
    <tr class="Result4" style="font-weight: bold;">
        <td>合計</td>
        <td>3顧客</td>
        <td></td>
        <td></td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td>12,400</td>
        <td></td>
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
