<?php /* Smarty version 2.6.14, created on 2010-04-05 15:58:11
         compiled from 1-6-143.php.tpl */ ?>
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



<table width="250">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">取引年月</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_date_c1']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['hyouji43']['html']; ?>
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

<table>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">【取引年月：2006-01】</span><br>

<table class="List_Table" border="1" width="100%">
<col align="right">
<col>
<col span="6" align="right">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>
        <td class="Title_Gray" align="center" colspan="2">得意先</td>
        <td class="Title_Gray" align="center">原価</td>
        <td class="Title_Gray" align="center">売上</td>
        <td class="Title_Gray" align="center">ロイヤリティ</td>
        <td class="Title_Gray" align="center">財務用売上</td>
        <td class="Title_Gray" align="center">利益</td>
    </tr>
    <tr class="Result1">
        <td rowspan="3">1</td>
        <td rowspan="3">本部売上</td>
        <td>FC1</td>
        <td>3,000</td>
        <td>3,000</td>
        <td></td>
        <td>3,300</td>
        <td>300</td>
    </tr>
    <tr class="Result2">
        <td>FC2</td>
        <td>250</td>
        <td>300</td>
        <td></td>
        <td>300</td>
        <td>50</td>
    </tr>
    <tr class="Result1">
        <td>FC3</td>
        <td>500</td>
        <td>600</td>
        <td></td>
        <td>600</td>
        <td>100</td>
    </tr>
    <tr class="Result2">
        <td>2</td>
        <td>直営売上</td>
        <td></td>
        <td>480</td>
        <td>600</td>
        <td></td>
        <td>600</td>
        <td>120</td>
    </tr>
    <tr class="Result1">
        <td rowspan="3">3</td>
        <td rowspan="3">直営<br>代行料</td>
        <td>トイザラス</td>
        <td>0</td>
        <td></td>
        <td>100</td>
        <td>100</td>
        <td>100</td>
    </tr>
    <tr class="Result2">
        <td>ダイナム</td>
        <td>0</td>
        <td></td>
        <td>25</td>
        <td>25</td>
        <td>25</td>
    </tr>
    <tr class="Result1">
        <td>十光関係</td>
        <td>0</td>
        <td></td>
        <td>10</td>
        <td>10</td>
        <td>10</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>合計</td>
        <td colspan="2"></td>
        <td>4,230</td>
        <td>4,800</td>
        <td>135</td>
        <td>4,935</td>
        <td>705</td>
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
