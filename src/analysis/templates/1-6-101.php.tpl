{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">出力形式</td>
        <td class="Value">{$form.f_r_output2.html}</td>
        <td class="Title_Gray">出力範囲</td>
        <td class="Value">{$form.f_radio12.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray">取引年月</td>
        <td class="Value">{$form.f_date_d1.html}</td>
        <td class="Title_Gray">出力内容</td>
        <td class="Value">{$form.f_radio67.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray">商品コード</td>
        <td class="Value">{$form.f_text8.html}</td>
        <td class="Title_Gray">商品名</td>
        <td class="Value">{$form.f_text30.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray">Ｍ区分</td>
        <td class="Value">{$form.form_g_goods_1.html}</td>
        <td class="Title_Gray">製品区分</td>
        <td class="Value">{$form.form_product_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray">出力項目</td>
        <td class="Value" colspan="3">{$form.f_check3.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.hyouji.html}　　{$form.kuria.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="2">
<col span="14" align="right">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>
        <td class="Title_Gray" align="center">商品名</td>
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
        <td>1</td>
        <td>商品1</td>
        <td>売上数<br>売上金額<br>粗利益額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result2">
        <td>2</td>
        <td>商品2</td>
        <td>売上数<br>売上金額<br>粗利益額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result1">
        <td>3</td>
        <td>商品3</td>
        <td>売上数<br>売上金額<br>粗利益額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result2">
        <td>4</td>
        <td>商品4</td>
        <td>売上数<br>売上金額<br>粗利益額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result1">
        <td>5</td>
        <td>商品5</td>
        <td>売上数<br>売上金額<br>粗利益額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result2">
        <td>6</td>
        <td>商品6</td>
        <td>売上数<br>売上金額<br>粗利益額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result1">
        <td>7</td>
        <td>商品7</td>
        <td>売上数<br>売上金額<br>粗利益額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result2">
        <td>8</td>
        <td>商品8</td>
        <td>売上数<br>売上金額<br>粗利益額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result1">
        <td>9</td>
        <td>商品9</td>
        <td>売上数<br>売上金額<br>粗利益額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result2">
        <td>10</td>
        <td>商品10</td>
        <td>売上数<br>売上金額<br>粗利益額</td>
        <td>1<br>10,000<br>6,000</td>
        <td>2<br>10,000<br>6,000</td>
        <td>3<br>10,000<br>6,000</td>
        <td>4<br>10,000<br>6,000</td>
        <td>5<br>10,000<br>6,000</td>
        <td>6<br>10,000<br>6,000</td>
        <td>7<br>10,000<br>6,000</td>
        <td>8<br>10,000<br>6,000</td>
        <td>9<br>10,000<br>6,000</td>
        <td>10<br>10,000<br>6,000</td>
        <td>11<br>10,000<br>6,000</td>
        <td>12<br>10,000<br>6,000</td>
        <td>78<br>120,000<br>72,000</td>
        <td>6.5<br>10,000<br>6,000</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>合計</b></td>
        <td>10商品</b></td>
        <td>売上数<br>売上金額<br>粗利益額</b></td>
        <td>10<br>100,000<br>60,000</td>
        <td>20<br>100,000<br>60,000</td>
        <td>30<br>100,000<br>60,000</td>
        <td>40<br>100,000<br>60,000</td>
        <td>50<br>100,000<br>60,000</td>
        <td>60<br>100,000<br>60,000</td>
        <td>70<br>100,000<br>60,000</td>
        <td>80<br>100,000<br>60,000</td>
        <td>90<br>100,000<br>60,000</td>
        <td>100<br>100,000<br>60,000</td>
        <td>110<br>100,000<br>60,000</td>
        <td>120<br>100,000<br>60,000</td>
        <td>780<br>1200,000<br>720,000</td>
        <td>65<br>100,000<br>60,000</td>
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- 画面表示２ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
