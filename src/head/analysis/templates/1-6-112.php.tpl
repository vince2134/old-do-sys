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
<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Gray">出力形式</td>
        <td class="Value">{$form.f_r_output2.html}</td>
        <td class="Title_Gray">出力金額</td>
        <td class="Value">{$form.f_radio13.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray">取引年月</td>
        <td class="Value" colspan="3">{$form.f_date_d1.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray">ショップコード</td>
        <td class="Value">{$form.f_code_a1.html}</td>
        <td class="Title_Gray">ショップ名</td>
        <td class="Value" width="220">{$form.f_text15.html}</td>
    </tr>
    <tr>
        <td class="Title_Gray">顧客区分</td>
        <td class="Value" colspan="3">{$form.form_rank_1.html}</td>
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

<span style="font: bold 15px; color: #555555;">【取引年月：2005-01 〜 2005-12】</span><br>

<table class="List_Table" border="1" width="100%">
<col align="right">
<col span="2">
<col span="4" align="right">
<col align="center">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">No.</td>
        <td class="Title_Gray" align="center">FC名</td>
        <td class="Title_Gray" align="center">顧客区分</td>
        <td class="Title_Gray" align="center">売上金額</td>
        <td class="Title_Gray" align="center">構成比</td>
        <td class="Title_Gray" align="center">累積金額</td>
        <td class="Title_Gray" align="center">累積構成比</td>
        <td class="Title_Gray" align="center">区分</td>
    </tr>
    <tr class="Result1">
        <td>1</td>
        <td>FC5</td>
        <td>区分5</td>
        <td>3,500</td>
        <td>34.70%</td>
        <td>3,500</td>
        <td>34.70%</td>
        <td rowspan="2">A<br>(0%〜70%)</td>
    </tr>
    <tr class="Result2">
        <td>2</td>
        <td>FC2</td>
        <td>区分2</td>
        <td>3,210</td>
        <td>31.80%</td>
        <td>6,710</td>
        <td>66.50%</td>
    </tr>
    <tr class="Result1">
        <td>3</td>
        <td>FC1</td>
        <td>区分1</td>
        <td>1,520</td>
        <td>15.10%</td>
        <td>8,230</td>
        <td>81.60%</td>
        <td rowspan="2">B<br>(70%〜90%)</td>
    </tr>
    <tr class="Result2">
        <td>4</td>
        <td>FC4</td>
        <td>区分4</td>
        <td>720</td>
        <td>7.10%</td>
        <td>8,950</td>
        <td>88.70%</td>
    </tr>
    <tr class="Result1">
        <td>5</td>
        <td>FC7</td>
        <td>区分7</td>
        <td>320</td>
        <td>3.20%</td>
        <td>9,270</td>
        <td>91.90%</td>
        <td rowspan="4">C<br>(90%〜100%)</td>
    </tr>
    <tr class="Result2">
        <td>6</td>
        <td>FC3</td>
        <td>区分3</td>
        <td>260</td>
        <td>2.60%</td>
        <td>9,530</td>
        <td>94.40%</td>
    </tr>
    <tr class="Result1">
        <td>7</td>
        <td>FC6</td>
        <td>区分6</td>
        <td>210</td>
        <td>2.10%</td>
        <td>9,740</td>
        <td>96.50%</td>
    </tr>
    <tr class="Result2">
        <td>8</td>
        <td>その他</td>
        <td>区分8</td>
        <td>350</td>
        <td>3.50%</td>
        <td>10,090</td>
        <td>100%</td>
    </tr>
    <tr class="Result3" style="font-weight: bold;">
        <td>合計</td>
        <td>10店舗</td>
        <td></td>
        <td>10,090</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td align="center">-</td>
        <td></td>
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
