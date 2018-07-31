<?php /* Smarty version 2.6.14, created on 2010-04-05 15:58:09
         compiled from 1-6-133.php.tpl */ ?>
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
<col width="80" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">出力形式</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_r_output2']['html']; ?>
</td>
        <td class="Title_Gray">取引年月</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_date_d1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Gray">部署</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_part_1']['html']; ?>
</td>
        <td class="Title_Gray">担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_1']['html']; ?>
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

<table class="List_Table" border="1" width="750">
    <tr align="center">
        <td class="Title_Gray" width="80"><b>取引年月</b></td>
        <td class="Value" width="150">2005-01 〜 2005-12</td>
        <td class="Title_Gray" width="80"><b>部署</b></td>
        <td class="Value">部署1</td>
        <td class="Title_Gray" width="80"><b>担当者</b></td>
        <td class="Value">担当者1</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
<col align="right">
<col>
<col span="21" align="right">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center" rowspan="2">No.</td>
        <td class="Title_Gray" align="center" rowspan="2">得意先</td>
        <td class="Title_Gray" align="center" colspan="4">新規</td>
        <td class="Title_Gray" align="center" colspan="4">増設</td>
        <td class="Title_Gray" align="center" colspan="4">減額</td>
        <td class="Title_Gray" align="center" colspan="4">キャンセル</td>
        <td class="Title_Gray" align="center" colspan="4">変更</td>
        <td class="Title_Gray" align="center" rowspan="2">総合計</td>
    </tr>
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">件数</td>
        <td class="Title_Gray" align="center">回数/月</td>
        <td class="Title_Gray" align="center">合計</td>
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">件数</td>
        <td class="Title_Gray" align="center">回数/月</td>
        <td class="Title_Gray" align="center">合計</td>
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">件数</td>
        <td class="Title_Gray" align="center">回数/月</td>
        <td class="Title_Gray" align="center">合計</td>
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">件数</td>
        <td class="Title_Gray" align="center">回数/月</td>
        <td class="Title_Gray" align="center">合計</td>
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">件数</td>
        <td class="Title_Gray" align="center">回数/月</td>
        <td class="Title_Gray" align="center">合計</td>
    </tr>
    <tr class="Result1">
        <td>1</td>
        <td>得意先1</td>
        <td>5,000</td>
        <td>2</td>
        <td>1</td>
        <td>10,000</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">10,000</td>
    </tr>
    <tr class="Result1">
        <td rowspan="2">2</td>
        <td rowspan="2">得意先2</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td>4,500</td>
        <td>7</td>
        <td>1</td>
        <td>31,500</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">31,500</td>
    </tr>
    <tr class="Result1">
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td>-500</td>
        <td>2</td>
        <td>1</td>
        <td>-1,000</td>
        <td class="Result2">-1,000</td>
    </tr>
    <tr class="Result1">
        <td>5</td>
        <td>得意先5</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result1">
        <td>6</td>
        <td>得意先6</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result1">
        <td>7</td>
        <td>得意先7</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result1">
        <td>8</td>
        <td>得意先8</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result1">
        <td>9</td>
        <td>得意先9</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result1">
        <td>10</td>
        <td>得意先10</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result2" style="font-weight: bold;">
        <td>合計</td>
        <td></td>
        <td></td>
        <td>2</td>
        <td></td>
        <td>10,000</td>
        <td></td>
        <td>7</td>
        <td></td>
        <td>31,500</td>
        <td></td>
        <td>0</td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td>2</td>
        <td></td>
        <td>-1,000</td>
        <td>40,500</td>
    </tr>
</table>
<br><br>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="750">
    <tr align="center">
        <td class="Title_Gray" width="80"><b>取引年月</b></td>
        <td class="Value" width="150">2005-01 〜 2005-12</td>
        <td class="Title_Gray" width="80"><b>部署</b></td>
        <td class="Value">部署1</td>
        <td class="Title_Gray" width="80"><b>担当者</b></td>
        <td class="Value">担当者2</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
<col align="right">
<col>
<col span="21" align="right">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center" rowspan="2">No.</td>
        <td class="Title_Gray" align="center" rowspan="2">得意先</td>
        <td class="Title_Gray" align="center" colspan="4">新規</td>
        <td class="Title_Gray" align="center" colspan="4">増設</td>
        <td class="Title_Gray" align="center" colspan="4">減額</td>
        <td class="Title_Gray" align="center" colspan="4">キャンセル</td>
        <td class="Title_Gray" align="center" colspan="4">変更</td>
        <td class="Title_Gray" align="center" rowspan="2">総合計</td>
    </tr>
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">件数</td>
        <td class="Title_Gray" align="center">回数/月</td>
        <td class="Title_Gray" align="center">合計</td>
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">件数</td>
        <td class="Title_Gray" align="center">回数/月</td>
        <td class="Title_Gray" align="center">合計</td>
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">件数</td>
        <td class="Title_Gray" align="center">回数/月</td>
        <td class="Title_Gray" align="center">合計</td>
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">件数</td>
        <td class="Title_Gray" align="center">回数/月</td>
        <td class="Title_Gray" align="center">合計</td>
        <td class="Title_Gray" align="center">単価</td>
        <td class="Title_Gray" align="center">件数</td>
        <td class="Title_Gray" align="center">回数/月</td>
        <td class="Title_Gray" align="center">合計</td>
    </tr>
    <tr class="Result1">
        <td>1</td>
        <td>得意先1</td>
        <td>5,000</td>
        <td>2</td>
        <td>1</td>
        <td>10,000</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">10,000</td>
    </tr>
    <tr class="Result1">
        <td rowspan="2">2</td>
        <td rowspan="2">得意先2</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td>4,500</td>
        <td>7</td>
        <td>1</td>
        <td>31,500</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">31,500</td>
    </tr>
    <tr class="Result1">
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td>-500</td>
        <td>2</td>
        <td>1</td>
        <td>-1,000</td>
        <td class="Result2">-1,000</td>
    </tr>
    <tr class="Result1">
        <td>5</td>
        <td>得意先5</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result1">
        <td>6</td>
        <td>得意先6</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result1">
        <td>7</td>
        <td>得意先7</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result1">
        <td>8</td>
        <td>得意先8</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result1">
        <td>9</td>
        <td>得意先9</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result1">
        <td>10</td>
        <td>得意先10</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td class="Result2">0</td>
    </tr>
    <tr class="Result2" style="font-weight: bold;">
        <td>合計</td>
        <td></td>
        <td></td>
        <td>2</td>
        <td></td>
        <td>10,000</td>
        <td></td>
        <td>7</td>
        <td></td>
        <td>31,500</td>
        <td></td>
        <td>0</td>
        <td></td>
        <td>0</td>
        <td></td>
        <td></td>
        <td></td>
        <td>0</td>
        <td></td>
        <td>2</td>
        <td></td>
        <td>-1,000</td>
        <td>40,500</td>
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
