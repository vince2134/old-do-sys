<?php /* Smarty version 2.6.9, created on 2006-12-28 15:02:24
         compiled from 2-5-105_2.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table height="90%" class="M_Table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

    <?php if ($this->_tpl_vars['form']['form_end_day']['error'] != null): ?>
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li><?php echo $this->_tpl_vars['form']['form_end_day']['error']; ?>
<br>
        </span>
    <?php endif; ?>

<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Green">出力形式</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_output_radio']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Green">集計期間</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['update_time']; ?>
 〜 <?php echo $this->_tpl_vars['form']['form_end_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Green">担当者</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_staff_select']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr align="right">
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
</td>
    </tr>
    <tr>
        <td style="color: #0000ff; font-weight: bold;"><li>対象となる伝票は、前回月次締日より後の日次更新未実施の伝票です。</li></td>
    </tr>
</table>

        </tr>
    </td>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<table>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">【売上・入金】</span>
<table class="List_Table" border="1" width="1300">
    <tr align="center" style="font-weight: bold;">
        <td rowspan="2" class="Title_Green">担当者名</td>
        <td colspan="8" class="Title_Green">日次累計</td>
        <td rowspan="2" class="Title_Green"></td>
        <td colspan="8" class="Title_Green">月次累計</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">現金<br>売上</td>
        <td class="Title_Green">掛<br>売上</td>
        <td class="Title_Green">売上<br>合計</td>
        <td class="Title_Green">現金<br>入金</td>
        <td class="Title_Green">振込<br>入金</td>
        <td class="Title_Green">入金<br>手数料</td>
        <td class="Title_Green">入金<br>合計</td>
        <td class="Title_Green">現金<br>合計</td>
        <td class="Title_Green">現金<br>売上</td>
        <td class="Title_Green">掛<br>売上</td>
        <td class="Title_Green">売上<br>合計</td>
        <td class="Title_Green">現金<br>入金</td>
        <td class="Title_Green">振込<br>入金</td>
        <td class="Title_Green">入金<br>手数料</td>
        <td class="Title_Green">入金<br>合計</td>
        <td class="Title_Green">現金<br>合計</td>
    </tr>
    <?php echo $this->_tpl_vars['var']['html_1']; ?>

</table>
<br><br>

<span style="font: bold 15px; color: #555555;">【仕入・支払】</span>
<table class="List_Table" border="1" width="1300">
    <tr align="center" style="font-weight: bold;">
        <td rowspan="2" class="Title_Green">担当者名</td>
        <td colspan="8" class="Title_Green">日次累計</td>
        <td rowspan="2" class="Title_Green"></td>
        <td colspan="8" class="Title_Green">月次累計</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">現金<br>仕入</td>
        <td class="Title_Green">掛<br>仕入</td>
        <td class="Title_Green">仕入<br>合計</td>
        <td class="Title_Green">現金<br>支払</td>
        <td class="Title_Green">振込<br>支払</td>
        <td class="Title_Green">支払<br>手数料</td>
        <td class="Title_Green">支払<br>合計</td>
        <td class="Title_Green">現金<br>合計</td>
        <td class="Title_Green">現金<br>仕入</td>
        <td class="Title_Green">掛<br>仕入</td>
        <td class="Title_Green">仕入<br>合計</td>
        <td class="Title_Green">現金<br>支払</td>
        <td class="Title_Green">振込<br>支払</td>
        <td class="Title_Green">支払<br>手数料</td>
        <td class="Title_Green">支払<br>合計</td>
        <td class="Title_Green">現金<br>合計</td>
    </tr>
    <?php echo $this->_tpl_vars['var']['html_2']; ?>

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
