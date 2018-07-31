<?php /* Smarty version 2.6.14, created on 2007-10-11 10:51:05
         compiled from 1-6-106.php.tpl */ ?>
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



<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">出力形式</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_r_output2']['html']; ?>
</td>
        <td class="Title_Gray">出力範囲</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_radio12']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">取引年月</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_date_d1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray" >業種</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_btype_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">ショップコード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_code_a1']['html']; ?>
</td>
        <td class="Title_Gray">ショップ名</td>
        <td class="Value" width="220"><?php echo $this->_tpl_vars['form']['f_text15']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">顧客区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_rank_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="TitleGray">出力項目</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_check1']['html']; ?>
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
<col span="4">
<col span="14" align="right">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>
        <td class="Title_Gray" align="center">業種名</td>
        <td class="Title_Gray" align="center">FC名</td>
        <td class="Title_Gray" align="center">顧客区分</td>
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
        <td rowspan="4">業種A</td>
        <td>FC1</td>
        <td>区分1</td>
        <td>売上金額</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>120,000</td>
        <td>10,000</td>
    </tr>
    <tr class="Result2">
        <td>FC2</td>
        <td>区分2</td>
        <td>売上金額</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>120,000</td>
        <td>10,000</td>
    </tr>
    <tr class="Result1">
        <td>FC3</td>
        <td>区分3</td>
        <td>売上金額</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>120,000</td>
        <td>10,000</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td align="center" colspan="3">小計</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>360,000</td>
        <td>30,000</td>
    </tr>
    <tr class="Result1">
        <td rowspan="4">2</td>
        <td rowspan="4">業種B</td>
        <td>FC4</td>
        <td>区分4</td>
        <td>売上金額</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>120,000</td>
        <td>10,000</td>
    </tr>
    <tr class="Result2">
        <td>FC5</td>
        <td>区分5</td>
        <td>売上金額</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>120,000</td>
        <td>10,000</td>
    </tr>
    <tr class="Result1">
        <td>FC6</td>
        <td>区分6</td>
        <td>売上金額</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>10,000</td>
        <td>120,000</td>
        <td>10,000</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td align="center" colspan="3">小計</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>30,000</td>
        <td>360,000</td>
        <td>30,000</td>
    </tr>
    <tr class="Result4" style="font-weight: bold;">
        <td>合計</td>
        <td>2業種</td>
        <td colspan="3"></td>
        <td>60,000</td>
        <td>60,000</td>
        <td>60,000</td>
        <td>60,000</td>
        <td>60,000</td>
        <td>60,000</td>
        <td>60,000</td>
        <td>60,000</td>
        <td>60,000</td>
        <td>60,000</td>
        <td>60,000</td>
        <td>60,000</td>
        <td>720,000</td>
        <td>60,000</td>
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
