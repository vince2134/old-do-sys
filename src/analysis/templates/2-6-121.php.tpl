
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
<table class="Data_Table" border="1" width="650" >

    <tr>
        <td class="Title_Gray" width="100"><b>出力形式</b></td>
        <td class="Value" colspan="3">{$form.f_r_output2.html}</td>
    </tr>

    <tr>
        <td class="Title_Gray"width="100"><b>取引年月</b></td>
        <td class="Value">{$form.f_date_d1.html}</td>
        <td class="Title_Gray" width="100"><b>出力内容</b></td>
        <td class="Value">{$form.f_radio67.html}</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>仕入先コード</b></td>
        <td class="Value">{$form.f_text6.html}</td>
        <td class="Title_Gray" width="100"><b>仕入先名</b></td>
        <td class="Value">{$form.f_text15.html}</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>商品コード</b></td>
        <td class="Value">{$form.f_text8.html}</td>
        <td class="Title_Gray" width="100"><b>商品名</b></td>
        <td class="Value">{$form.f_text30.html}</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>Ｍ区分</b></td>
        <td class="Value">{$form.form_g_goods_1.html}</td>
        <td class="Title_Gray" width="100"><b>製品区分</b></td>
        <td class="Value">{$form.form_product_1.html}</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>対象拠点</b></td>
        <td class="Value" colspan="3">{$form.form_cshop_1.html}</td>
    </tr>

    <tr>
        <td class="Title_Gray" width="100"><b>出力項目</b></td>
        <td class="Value" colspan="3">{$form.f_check18.html}</td>
    </tr>

</table>
<table width='650'>
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
        <td class="Title_Gray" width=""><b>仕入先名</b></td>
        <td class="Title_Gray" width=""><b>商品名</b></td>
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
        <td align="left" rowspan="4">仕入先1</td>
        <td align="left">商品A</td>
        <td align="left">仕入数<br>仕入金額<br>支払額</td></td>
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
        <td align="left">商品B</td>
        <td align="left">仕入数<br>仕入金額<br>支払額</td></td>
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
        <td align="left">商品C</td>
        <td align="left">仕入数<br>仕入金額<br>支払額</td></td>
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
        <td align="center" colspan="2"><b>小計</b></td>
        <td align="right"><b>3<br>30,000<br>18,000</td>
        <td align="right"><b>6<br>30,000<br>18,000</td>
        <td align="right"><b>9<br>30,000<br>18,000</td>
        <td align="right"><b>12<br>30,000<br>18,000</td>
        <td align="right"><b>15<br>30,000<br>18,000</td>
        <td align="right"><b>18<br>30,000<br>18,000</td>
        <td align="right"><b>21<br>30,000<br>18,000</td>
        <td align="right"><b>24<br>30,000<br>18,000</td>
        <td align="right"><b>27<br>30,000<br>18,000</td>
        <td align="right"><b>30<br>30,000<br>18,000</td>
        <td align="right"><b>33<br>30,000<br>18,000</td>
        <td align="right"><b>36<br>30,000<br>18,000</td>
        <td align="right"><b>234<br>360,000<br>216,000</td>
        <td align="right"><b>19.5<br>30,000<br>18,000</td>
    </tr>

    <tr class="Result1">
        <td align="right" rowspan="4">2</td>
        <td align="left" rowspan="4">仕入先2</td>
        <td align="left">商品D</td>
        <td align="left">仕入数<br>仕入金額<br>支払額</td></td>
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
        <td align="left">商品E</td>
        <td align="left">仕入数<br>仕入金額<br>支払額</td></td>
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
        <td align="left">商品F</td>
        <td align="left">仕入数<br>仕入金額<br>支払額</td></td>
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
        <td align="center" colspan="2"><b>小計</b></td>
        <td align="right"><b>3<br>30,000<br>18,000</td>
        <td align="right"><b>6<br>30,000<br>18,000</td>
        <td align="right"><b>9<br>30,000<br>18,000</td>
        <td align="right"><b>12<br>30,000<br>18,000</td>
        <td align="right"><b>15<br>30,000<br>18,000</td>
        <td align="right"><b>18<br>30,000<br>18,000</td>
        <td align="right"><b>21<br>30,000<br>18,000</td>
        <td align="right"><b>24<br>30,000<br>18,000</td>
        <td align="right"><b>27<br>30,000<br>18,000</td>
        <td align="right"><b>30<br>30,000<br>18,000</td>
        <td align="right"><b>33<br>30,000<br>18,000</td>
        <td align="right"><b>36<br>30,000<br>18,000</td>
        <td align="right"><b>234<br>360,000<br>216,000</td>
        <td align="right"><b>19.5<br>30,000<br>18,000</td>
    </tr>

    <tr class="Result4">
        <td align="left"><b>合計</b></td>
        <td align="left"><b>2店舗</b></td>
        <td align="left" colspan="2"><b>　</b></td>
        <td align="right"><b>6<br>30,000<br>18,000</b></td>
        <td align="right"><b>12<br>30,000<br>18,000</b></td>
        <td align="right"><b>18<br>30,000<br>18,000</b></td>
        <td align="right"><b>24<br>30,000<br>18,000</b></td>
        <td align="right"><b>30<br>30,000<br>18,000</b></td>
        <td align="right"><b>36<br>30,000<br>18,000</b></td>
        <td align="right"><b>42<br>30,000<br>18,000</b></td>
        <td align="right"><b>48<br>30,000<br>18,000</b></td>
        <td align="right"><b>54<br>30,000<br>18,000</b></td>
        <td align="right"><b>60<br>30,000<br>18,000</b></td>
        <td align="right"><b>66<br>30,000<br>18,000</b></td>
        <td align="right"><b>72<br>30,000<br>18,000</b></td>
        <td align="right"><b>468<br>360,000<br>216,000</b></td>
        <td align="right"><b>39<br>30,000<br>18,000</b></td>
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
    

