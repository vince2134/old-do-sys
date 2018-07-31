<?php /* Smarty version 2.6.9, created on 2006-05-23 11:25:57
         compiled from 2-6-113.php.tpl */ ?>

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
        
            <table border=0>
                <tr>
                    <td>

<table class="Data_Table" border="1" width="650" >

    <tr>
        <td class="Title_Gray" width="100"><b>出力形式</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_r_output2']['html']; ?>
</td>
        <td class="Title_Gray" width="100"><b>出力金額</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_radio13']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>取引年月</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_date_d1']['html']; ?>
</td>
        <td class="Title_Gray"width="110"><b>業種</b></td>
        <td class="Value" width="200"><?php echo $this->_tpl_vars['form']['form_btype_1']['html']; ?>
</td>
    </tr>
    
    <tr>
        <td class="Title_Gray" width="100"><b>対象拠点</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_cshop_1']['html']; ?>
</td>
    </tr>

</table>
<table width='650'>
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

<font size="+0.5" color="#555555"><b>【取引年月：2005-01 〜 2005-12　拠点1】</b></font>
<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Gray"><b>No.</b></td>
        <td class="Title_Gray" width=""><b>業種名</b></td>
        <td class="Title_Gray" width=""><b>金額</b></td>
        <td class="Title_Gray" width=""><b>構成比</b></td>
        <td class="Title_Gray" width=""><b>累積金額</b></td>
        <td class="Title_Gray" width=""><b>累積構成比</b></td>
        <td class="Title_Gray" width=""><b>区分</b></td>
    </tr>

    <tr class="Result1">
        <td align="right">1</td>
        <td align="left">業種5</td>
        <td align="right">3,500</td>
        <td align="right">34.70%</td></td>
        <td align="right">3,500</td>
        <td align="right">34.70%</td>
        <td align="center" rowspan="2">A<br>(0%〜70%)</td>
    </tr>

    <tr class="Result2">
        <td align="right">2</td>
        <td align="left">業種2</td>
        <td align="right">3,210</td>
        <td align="right">31.80%</td></td>
        <td align="right">6,710</td>
        <td align="right">66.50%</td>
    </tr>

    <tr class="Result1">
        <td align="right">3</td>
        <td align="left">業種1</td>
        <td align="right">1,520</td>
        <td align="right">15.10%</td></td>
        <td align="right">8,230</td>
        <td align="right">81.60%</td>
        <td align="center" rowspan="2">B<br>(70%〜90%)</td>
    </tr>

    <tr class="Result2">
        <td align="right">4</td>
        <td align="left">業種4</td>
        <td align="right">720</td>
        <td align="right">7.10%</td></td>
        <td align="right">8,950</td>
        <td align="right">88.70%</td>
    </tr>

    <tr class="Result1">
        <td align="right">5</td>
        <td align="left">業種7</td>
        <td align="right">320</td>
        <td align="right">3.20%</td></td>
        <td align="right">9,270</td>
        <td align="right">91.90%</td>
        <td align="center" rowspan="4">C<br>(90%〜100%)</td>
    </tr>

    <tr class="Result2">
        <td align="right">6</td>
        <td align="left">業種3</td>
        <td align="right">260</td>
        <td align="right">2.60%</td></td>
        <td align="right">9,530</td>
        <td align="right">94.40%</td>
    </tr>

    <tr class="Result1">
        <td align="right">7</td>
        <td align="left">業種6</td>
        <td align="right">210</td>
        <td align="right">2.10%</td></td>
        <td align="right">9,740</td>
        <td align="right">96.50%</td>
    </tr>

    <tr class="Result2">
        <td align="right">8</td>
        <td align="left">その他</td>
        <td align="right">350</td>
        <td align="right">3.50%</td></td>
        <td align="right">10,090</td>
        <td align="right">100%</td>
    </tr>

    <tr class="Result3">
        <td align="right"><b>合計</b></td>
        <td align="left"><b>10店舗</b></td>
        <td align="right"><b>10,090</b></td>
        <td align="center"><b>-</b></td></td>
        <td align="center"><b>-</b></td>
        <td align="center"><b>-</b></td>
        <td align="center"></td>
    </tr>

</table>



                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

    
