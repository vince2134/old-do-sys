
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*------------------- 外枠開始 --------------------*}
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
        </td>
    </tr>

    <tr align="center">
    

        {*-------------------- 画面表示開始 -------------------*}
        <td valign="top">
        
            <table border=0 >
                <tr>
                    <td>

{*-------------------- 画面表示1開始 -------------------*}
<table class="Data_Table" border="1" width="750" >
<col width="100">
<col width="175">
<col width="100">
<col width="175">
    <tr>
        <td class="Title_Gray" width="100"><b>出力形式</b></td>
        <td class="Value">{$form.f_r_output2.html}</td>
        <td class="Title_Gray"width="100"><b>取引年月</b></td>
        <td class="Value">{$form.f_date_d1.html}</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>部署</b></td>
        <td class="Value">{$form.form_part_1.html}</td>
        <td class="Title_Gray" width="100"><b>担当者</b></td>
        <td class="Value">{$form.form_staff_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>出力項目</b></td>
        <td class="Value" colspan="3">{$form.f_check1.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray" width="100"><b>対象拠点</b></td>
        <td class="Value" colspan="3">{$form.form_cshop_1.html}</td>
    </tr>
</table>
<table width='750'>
    <tr>
        <td align='right'>
            {$form.hyouji.html}　　{$form.kuria.html}
        </td>
    </tr>
</table>
{********************* 画面表示1終了 ********************}

                    <br>
                    </td>
                </tr>


                <tr>
                    <td>

{*-------------------- 画面表示2開始 -------------------*}
<font size="+0.5" color="#555555"><b>【対象拠点：　拠点1】</b></font>
<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Gray"><b>No.</b></td>
        <td class="Title_Gray" width=""><b>部署名</b></td>
        <td class="Title_Gray" width=""><b>担当者名</b></td>
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
        <td align="left" rowspan="4">部署1</td>
        <td align="left">担当者A</td>
        <td align="left">売上金額<br>粗利益額<br>粗利率</td></td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">120,000<br>96,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
    </tr>

    <tr class="Result2">
        <td align="left">担当者B</td>
        <td align="left">売上金額<br>粗利益額<br>粗利率</td></td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">120,000<br>96,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
    </tr>

    <tr class="Result1">
        <td align="left">担当者C</td>
        <td align="left">売上金額<br>粗利益額<br>粗利率</td></td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">120,000<br>96,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
    </tr>

    <tr class="Result3">
        <td align="center"><b>小計</b></td>
        <td align="left"><b>売上金額<br>粗利益額<br>粗利率</td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>360,000<br>288,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
    </tr>

    <tr class="Result1">
        <td align="right" rowspan="4">2</td>
        <td align="left" rowspan="4">部署2</td>
        <td align="left">担当者D</td>
        <td align="left">売上金額<br>粗利益額<br>粗利率</td></td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">120,000<br>96,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
    </tr>

    <tr class="Result2">
        <td align="left">担当者E</td>
        <td align="left">売上金額<br>粗利益額<br>粗利率</td></td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">120,000<br>96,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
    </tr>

    <tr class="Result1">
        <td align="left">担当者F</td>
        <td align="left">売上金額<br>粗利益額<br>粗利率</td></td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
        <td align="right">120,000<br>96,000<br>80%</td>
        <td align="right">10,000<br>8,000<br>80%</td>
    </tr>

    <tr class="Result3">
        <td align="center"><b>小計</b></td>
        <td align="left"><b>売上金額<br>粗利益額<br>粗利率</td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
        <td align="right"><b>360,000<br>288,000<br>80%</b></td>
        <td align="right"><b>30,000<br>24,000<br>80%</b></td>
    </tr>

    <tr class="Result4">
        <td align="left"><b>合計</b></td>
        <td align="left"><b></b></td>
        <td align="left"><b>6人</b></td>
        <td align="left"><b>売上金額<br>粗利益額<br>粗利率</td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
        <td align="right"><b>720,000<br>576,000<br>80%</b></td>
        <td align="right"><b>60,000<br>48,000<br>80%</b></td>
    </tr>

</table>

{********************* 画面表示2終了 ********************}


                    </td>
                </tr>
            </table>
        </td>
        {********************* 画面表示終了 ********************}

    </tr>
</table>
{******************** 外枠終了 *********************}

{$var.html_footer}
    

