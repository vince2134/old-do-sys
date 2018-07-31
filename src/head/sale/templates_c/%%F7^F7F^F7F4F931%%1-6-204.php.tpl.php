<?php /* Smarty version 2.6.9, created on 2006-12-01 14:30:11
         compiled from 1-6-204.php.tpl */ ?>
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



<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">取引年月<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['f_date_c1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Pink">ショップコード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_code_a1']['html']; ?>
</td>
        <td class="Title_Pink">ショップ名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text15']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['hyouji']['html']; ?>
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

<span style="font: bold 14px; color: #555555;">【取引年月：2006-01】</span><br>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">ショップ名</td>
        <td class="Title_Pink">売上金額<br>(ロイヤリティ対象外)</td>
        <td class="Title_Pink">売上金額<br>(ロイヤリティ対象)</td>
        <td class="Title_Pink">総計</td>
        <td class="Title_Pink">ロイヤリティ額</td>
    </tr>
        <tr class="Result1">
        <td align="right">1</td>
        <td>FC1</td>
        <td align="right">10,000</td>
        <td align="right">10,000</td>
        <td align="right">20,000</td>
        <td align="right">600.00</td>
    </tr>
        <tr class="Result2">
        <td align="right" rowspan="3">2</td>
        <td>FC2</td>
        <td align="right">20,000</td>
        <td align="right">20,000</td>
        <td align="right">40,000</td>
        <td align="right">1,200.00</td>
    </tr>
        <tr class="Result2">
        <td>FC3</td>
        <td align="right">30,000</td>
        <td align="right">30,000</td>
        <td align="right">60,000</td>
        <td align="right">1,800.00</td>
    </tr>
        <tr class="Result2">
        <td>FC4</td>
        <td align="right">40,000</td>
        <td align="right">40,000</td>
        <td align="right">80,000</td>
        <td align="right">2,400.00</td>
    </tr>
        <tr class="Result1">
        <td align="right" rowspan="2">3</td>
        <td>FC5</td>
        <td align="right">50,000</td>
        <td align="right">50,000</td>
        <td align="right">100,000</td>
        <td align="right">3,000</td>
    </tr>
        <tr class="Result1">
        <td>FC6</td>
        <td align="right">60,000</td>
        <td align="right">60,000</td>
        <td align="right">120,000</td>
        <td align="right">3,600.00</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>合計</td>
        <td align="center">10社</td>
        <td align="right">550,000</td>
        <td align="right">550,000</td>
        <td align="right">1,100.000.00</td>
        <td align="right">33,000</td>
    </tr>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


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
