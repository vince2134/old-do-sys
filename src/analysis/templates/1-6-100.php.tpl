
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


<table  class="Data_Table" border="1" width="750" >

    <tr>
        <td class="Title_Gray" width="100"><b>出力形式</b></td>
        <td class="Value">{$form.f_r_output2.html}</td>
        <td class="Title_Gray" width="100"><b>出力範囲</b></td>
        <td class="Value">{$form.f_radio12.html}</td>
    </tr>

    <tr>
        <td class="Title_Gray"width="100"><b>取引年月</b></td>
        <td class="Value">{$form.f_date_d1.html}</td>
        <td class="Title_Gray" width="100"><b>サービス名</b></td>
        <td class="Value">{$form.form_serv_1.html}</td>
        
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>対象拠点</b></td>
        <td class="Value" colspan="3">{$form.form_cshop_1.html}</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>出力項目</b></td>
        <td class="Value" colspan="3">{$form.f_check3.html}</td>
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
        <td class="Title_Gray"><b>サービス名</b></td>
        <td class="Title_Gray" width=""></td>
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
        <td align="right">1</td>
        <td align="left">サービス1</td>
        <td align="left">売上数<br>売上金額<br>粗利益額</td>
        <td align="right">1<br>10,000<br>6,000</td>
        <td align="right">2<br>10,000<br>6,000</td>
        <td align="right">3<br>10,000<br>6,000</td>
        <td align="right">4<br>10,000<br>6,000</td>
        <td align="right">5<br>10,000<br>6,000</td>
        <td align="right">6<br>10,000<br>6,000</td>
        <td align="right">7<br>10,000<br>6,000</td>
        <td align="right">8<br>10,000<br>6,000</td>
        <td align="right">9<br>10,000<br>6,000</td>
        <td align="right">10<br>10,000<br>6,000</td>
        <td align="right">11<br>10,000<br>6,000</td>
        <td align="right">12<br>10,000<br>6,000</td>
        <td align="right">78<br>120,000<br>72,000</td>
        <td align="right">6.5<br>10,000<br>6,000</td>
    </tr>

    <tr class="Result2">
        <td align="right">2</td>
        <td align="left">サービス2</td>
        <td align="left">売上数<br>売上金額<br>粗利益額</td>
        <td align="right">1<br>10,000<br>6,000</td>
        <td align="right">2<br>10,000<br>6,000</td>
        <td align="right">3<br>10,000<br>6,000</td>
        <td align="right">4<br>10,000<br>6,000</td>
        <td align="right">5<br>10,000<br>6,000</td>
        <td align="right">6<br>10,000<br>6,000</td>
        <td align="right">7<br>10,000<br>6,000</td>
        <td align="right">8<br>10,000<br>6,000</td>
        <td align="right">9<br>10,000<br>6,000</td>
        <td align="right">10<br>10,000<br>6,000</td>
        <td align="right">11<br>10,000<br>6,000</td>
        <td align="right">12<br>10,000<br>6,000</td>
        <td align="right">78<br>120,000<br>72,000</td>
        <td align="right">6.5<br>10,000<br>6,000</td>
    </tr>

    <tr class="Result1">
        <td align="right">3</td>
        <td align="left">サービス3</td>
        <td align="left">売上数<br>売上金額<br>粗利益額</td>
        <td align="right">1<br>10,000<br>6,000</td>
        <td align="right">2<br>10,000<br>6,000</td>
        <td align="right">3<br>10,000<br>6,000</td>
        <td align="right">4<br>10,000<br>6,000</td>
        <td align="right">5<br>10,000<br>6,000</td>
        <td align="right">6<br>10,000<br>6,000</td>
        <td align="right">7<br>10,000<br>6,000</td>
        <td align="right">8<br>10,000<br>6,000</td>
        <td align="right">9<br>10,000<br>6,000</td>
        <td align="right">10<br>10,000<br>6,000</td>
        <td align="right">11<br>10,000<br>6,000</td>
        <td align="right">12<br>10,000<br>6,000</td>
        <td align="right">78<br>120,000<br>72,000</td>
        <td align="right">6.5<br>10,000<br>6,000</td>
    </tr>

    <tr class="Result2">
        <td align="right">4</td>
        <td align="left">サービス4</td>
        <td align="left">売上数<br>売上金額<br>粗利益額</td>
        <td align="right">1<br>10,000<br>6,000</td>
        <td align="right">2<br>10,000<br>6,000</td>
        <td align="right">3<br>10,000<br>6,000</td>
        <td align="right">4<br>10,000<br>6,000</td>
        <td align="right">5<br>10,000<br>6,000</td>
        <td align="right">6<br>10,000<br>6,000</td>
        <td align="right">7<br>10,000<br>6,000</td>
        <td align="right">8<br>10,000<br>6,000</td>
        <td align="right">9<br>10,000<br>6,000</td>
        <td align="right">10<br>10,000<br>6,000</td>
        <td align="right">11<br>10,000<br>6,000</td>
        <td align="right">12<br>10,000<br>6,000</td>
        <td align="right">78<br>120,000<br>72,000</td>
        <td align="right">6.5<br>10,000<br>6,000</td>
    </tr>

    <tr class="Result1">
        <td align="right">5</td>
        <td align="left">サービス5</td>
        <td align="left">売上数<br>売上金額<br>粗利益額</td>
        <td align="right">1<br>10,000<br>6,000</td>
        <td align="right">2<br>10,000<br>6,000</td>
        <td align="right">3<br>10,000<br>6,000</td>
        <td align="right">4<br>10,000<br>6,000</td>
        <td align="right">5<br>10,000<br>6,000</td>
        <td align="right">6<br>10,000<br>6,000</td>
        <td align="right">7<br>10,000<br>6,000</td>
        <td align="right">8<br>10,000<br>6,000</td>
        <td align="right">9<br>10,000<br>6,000</td>
        <td align="right">10<br>10,000<br>6,000</td>
        <td align="right">11<br>10,000<br>6,000</td>
        <td align="right">12<br>10,000<br>6,000</td>
        <td align="right">78<br>120,000<br>72,000</td>
        <td align="right">6.5<br>10,000<br>6,000</td>
    </tr>

    <tr class="Result2">
        <td align="right">6</td>
        <td align="left">サービス6</td>
        <td align="left">売上数<br>売上金額<br>粗利益額</td>
        <td align="right">1<br>10,000<br>6,000</td>
        <td align="right">2<br>10,000<br>6,000</td>
        <td align="right">3<br>10,000<br>6,000</td>
        <td align="right">4<br>10,000<br>6,000</td>
        <td align="right">5<br>10,000<br>6,000</td>
        <td align="right">6<br>10,000<br>6,000</td>
        <td align="right">7<br>10,000<br>6,000</td>
        <td align="right">8<br>10,000<br>6,000</td>
        <td align="right">9<br>10,000<br>6,000</td>
        <td align="right">10<br>10,000<br>6,000</td>
        <td align="right">11<br>10,000<br>6,000</td>
        <td align="right">12<br>10,000<br>6,000</td>
        <td align="right">78<br>120,000<br>72,000</td>
        <td align="right">6.5<br>10,000<br>6,000</td>
    </tr>

    <tr class="Result1">
        <td align="right">7</td>
        <td align="left">サービス7</td>
        <td align="left">売上数<br>売上金額<br>粗利益額</td>
        <td align="right">1<br>10,000<br>6,000</td>
        <td align="right">2<br>10,000<br>6,000</td>
        <td align="right">3<br>10,000<br>6,000</td>
        <td align="right">4<br>10,000<br>6,000</td>
        <td align="right">5<br>10,000<br>6,000</td>
        <td align="right">6<br>10,000<br>6,000</td>
        <td align="right">7<br>10,000<br>6,000</td>
        <td align="right">8<br>10,000<br>6,000</td>
        <td align="right">9<br>10,000<br>6,000</td>
        <td align="right">10<br>10,000<br>6,000</td>
        <td align="right">11<br>10,000<br>6,000</td>
        <td align="right">12<br>10,000<br>6,000</td>
        <td align="right">78<br>120,000<br>72,000</td>
        <td align="right">6.5<br>10,000<br>6,000</td>
    </tr>

    <tr class="Result2">
        <td align="right">8</td>
        <td align="left">サービス8</td>
        <td align="left">売上数<br>売上金額<br>粗利益額</td>
        <td align="right">1<br>10,000<br>6,000</td>
        <td align="right">2<br>10,000<br>6,000</td>
        <td align="right">3<br>10,000<br>6,000</td>
        <td align="right">4<br>10,000<br>6,000</td>
        <td align="right">5<br>10,000<br>6,000</td>
        <td align="right">6<br>10,000<br>6,000</td>
        <td align="right">7<br>10,000<br>6,000</td>
        <td align="right">8<br>10,000<br>6,000</td>
        <td align="right">9<br>10,000<br>6,000</td>
        <td align="right">10<br>10,000<br>6,000</td>
        <td align="right">11<br>10,000<br>6,000</td>
        <td align="right">12<br>10,000<br>6,000</td>
        <td align="right">78<br>120,000<br>72,000</td>
        <td align="right">6.5<br>10,000<br>6,000</td>
    </tr>

    <tr class="Result1">
        <td align="right">9</td>
        <td align="left">サービス9</td>
        <td align="left">売上数<br>売上金額<br>粗利益額</td>
        <td align="right">1<br>10,000<br>6,000</td>
        <td align="right">2<br>10,000<br>6,000</td>
        <td align="right">3<br>10,000<br>6,000</td>
        <td align="right">4<br>10,000<br>6,000</td>
        <td align="right">5<br>10,000<br>6,000</td>
        <td align="right">6<br>10,000<br>6,000</td>
        <td align="right">7<br>10,000<br>6,000</td>
        <td align="right">8<br>10,000<br>6,000</td>
        <td align="right">9<br>10,000<br>6,000</td>
        <td align="right">10<br>10,000<br>6,000</td>
        <td align="right">11<br>10,000<br>6,000</td>
        <td align="right">12<br>10,000<br>6,000</td>
        <td align="right">78<br>120,000<br>72,000</td>
        <td align="right">6.5<br>10,000<br>6,000</td>
    </tr>

    <tr class="Result2">
        <td align="right">10</td>
        <td align="left">サービス10</td>
        <td align="left">売上数<br>売上金額<br>粗利益額</td>
        <td align="right">1<br>10,000<br>6,000</td>
        <td align="right">2<br>10,000<br>6,000</td>
        <td align="right">3<br>10,000<br>6,000</td>
        <td align="right">4<br>10,000<br>6,000</td>
        <td align="right">5<br>10,000<br>6,000</td>
        <td align="right">6<br>10,000<br>6,000</td>
        <td align="right">7<br>10,000<br>6,000</td>
        <td align="right">8<br>10,000<br>6,000</td>
        <td align="right">9<br>10,000<br>6,000</td>
        <td align="right">10<br>10,000<br>6,000</td>
        <td align="right">11<br>10,000<br>6,000</td>
        <td align="right">12<br>10,000<br>6,000</td>
        <td align="right">78<br>120,000<br>72,000</td>
        <td align="right">6.5<br>10,000<br>6,000</td>
    </tr>

    <tr class="Result3">
        <td align="left"><b>合計</b></td>
        <td align="left"><b>10サービス</b></td>
        <td align="left"><b>売上数<br>売上金額<br>粗利益額</b></td>
        <td align="right"><b>10<br>100,000<br>60,000</b></td>
        <td align="right"><b>20<br>100,000<br>60,000</b></td>
        <td align="right"><b>30<br>100,000<br>60,000</b></td>
        <td align="right"><b>40<br>100,000<br>60,000</b></td>
        <td align="right"><b>50<br>100,000<br>60,000</b></td>
        <td align="right"><b>60<br>100,000<br>60,000</b></td>
        <td align="right"><b>70<br>100,000<br>60,000</b></td>
        <td align="right"><b>80<br>100,000<br>60,000</b></td>
        <td align="right"><b>90<br>100,000<br>60,000</b></td>
        <td align="right"><b>100<br>100,000<br>60,000</b></td>
        <td align="right"><b>110<br>100,000<br>60,000</b></td>
        <td align="right"><b>120<br>100,000<br>60,000</b></td>
        <td align="right"><b>780<br>1200,000<br>720,000</b></td>
        <td align="right"><b>65<br>100,000<br>60,000</b></td>
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
    

