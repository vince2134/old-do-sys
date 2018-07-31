<?php /* Smarty version 2.6.9, created on 2006-05-23 12:52:33
         compiled from 2-6-143.php.tpl */ ?>

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

<table  class="Data_Table" border="1" width="450" >

    <tr>
        <td class="Title_Gray" width="100"><b>出力形式</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_r_output']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Gray"width="100"><b>取引年月</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_date_c1']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>対象拠点</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_cshop_1']['html']; ?>
</td>
    </tr>

</table>
<table width='450'>
    <tr>
        <td align='right'>
            <?php echo $this->_tpl_vars['form']['hyouji44']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['kuria']['html']; ?>

        </td>
    </tr>
</table>

                    <br>
                    </td>
                </tr>


                <tr>
                    <td>

<font size="+0.5" color="#555555"><b>【取引年月：2006-01　拠点1】</b></font>
<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Gray"><b>No.</b></td>
        <td class="Title_Gray" width=""><b>得意先</b></td>
        <td class="Title_Gray" width=""><b>原価</b></td>
        <td class="Title_Gray" width=""><b>口座料(原価)</b></td>
        <td class="Title_Gray" width=""><b>売上</b></td>
        <td class="Title_Gray" width=""><b>ロイヤリティ</b></td>
        <td class="Title_Gray" width=""><b>利益</b></td>
    </tr>

    <tr class="Result1">
        <td align="right">1</td>
        <td align="left">得意先1</td>
        <td align="right">50</td>
        <td align="right"></td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right">50</td>
    </tr>

    <tr class="Result2">
        <td align="right">2</td>
        <td align="left">得意先2</td>
        <td align="right">50</td>
        <td align="right"></td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right">50</td>
    </tr>

    <tr class="Result1">
        <td align="right">3</td>
        <td align="left">得意先3</td>
        <td align="right">50</td>
        <td align="right"></td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right">50</td>
    </tr>

    <tr class="Result2">
        <td align="right">4</td>
        <td align="left">得意先4</td>
        <td align="right">50</td>
        <td align="right"></td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right">50</td>
    </tr>

    <tr class="Result1">
        <td align="right">5</td>
        <td align="left">得意先5</td>
        <td align="right">50</td>
        <td align="right"></td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right">50</td>
    </tr>

    <tr class="Result2">
        <td align="right">6</td>
        <td align="left">トイザらす</td>
        <td align="right">40</td>
        <td align="right"></td>
        <td align="right">80</td>
        <td align="right"></td>
        <td align="right">40</td>
    </tr>

    <tr class="Result1">
        <td align="right">7</td>
        <td align="left">スイット導入先</td>
        <td align="right">1,300</td>
        <td align="right"></td>
        <td align="right">3,000</td>
        <td align="right"></td>
        <td align="right">1,700</td>
    </tr>

    <tr class="Result2">
        <td align="right">8</td>
        <td align="left">トイザラス</td>
        <td align="right">900</td>
        <td align="right"></td>
        <td align="right">1,000</td>
        <td align="right">100</td>
        <td align="right"></td>
    </tr>

    <tr class="Result3">
        <td align="right"><b>合計</b></td>
        <td align="left"></td>
        <td align="right"><b>2,490</b></td>
        <td align="right"></td>
        <td align="right"><b>4,580</b></td>
        <td align="right"><b>100</b></td>
        <td align="right"><b>1,990</b></td>
    </tr>

</table>



                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

    
