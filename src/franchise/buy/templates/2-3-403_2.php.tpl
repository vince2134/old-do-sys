
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

        {*-------------------- 画面表示開始 -------------------*}
    <tr align="center">
        <td valign="top">
            <table>
                <tr>
                    <td>

{*-------------------- 画面表示1開始 -------------------*}
<table>
    <tr>
        <td>


<table  class="Data_Table" border="1" width="400" >
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue"><b>出力形式</b></td>
        <td class="Value" colspan="3">{$form.f_r_output23.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue"><b>取引期間<font color="red">※</font></b></td>
        <td class="Value" colspan="3">{$form.f_date_d1.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue"><b><a href="#" onClick="return Open_SubWin('../dialog/2-0-208.php',Array('f_layer[code]','f_layer[name]'),500,450);">仕入先</a><font color="red">※</font></b></td>
        <td class="Value" colspan="3">{$form.f_layer.html}</td>
    </tr>
</table>

        </td>
        <td rowspan="2" valign="top" align="right">

<table>
<col span="8" width="90" style="color: #525552;">
    <tr>
        <td>21：掛仕入</td>
        <td>23：掛返品</td>
        <td>24：掛値引</td>
        <td></td>
    </tr>
    <tr>
        <td>71：現金仕入</td>
        <td>73：現金返品</td>
        <td>74：現金値引</td>
        <td></td>
    </tr>
    <tr>
        <td>41：現金支払</td>
        <td>43：振込支払</td>
        <td>44：手形支払</td>
        <td>45：相殺</td>
    </tr>
    <tr>
        <td>46：支払調整</td>
        <td>47：その他支払</td>
        <td></td>
        <td></td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td align="left"><b><font color="red">※は必須入力です</font></b> </td>
        <td align='right'>{$form.hyouji28.html}　　{$form.kuria.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
<br>
{********************* 画面表示1終了 ********************}

                    </td>
                </tr>
                <tr>
                    <td>

{*-------------------- 画面表示2開始 -------------------*}
<table width="100%">
    <tr>
        <td>
        </td>
    </tr>
    <tr>
        <td>


<table width="100%">
    <tr valign="top">
        <td colspan="2">000024 - 0001　<span style="font: 20px;">ｴｺ･ｸﾘｴｲﾃｨﾌﾞ･ｼﾞｬﾊﾟﾝ</span></td>
    </tr>
    <tr>
         <td>
            <table class="List_Table" border="1" align="left" width="350">
                <tr align="center">
                    <td class="Title_Pink" width="60"><b>締日</b></td>
                    <td class="Value"  width="60" align="center">25日</td>
                    <td class="Title_Pink" width="60"><b>支払日</b></td>
                    <td class="Value" align="center">1ヶ月後の25日</td>
                </tr>
            </table>
         </td>
        <td>
            <table class="List_Table" border="1" align="right"width="400">
                <tr align="center">
                    <td class="Type" width="120"><b>分割請求額<br>(1/20)</b></td>
                    <td class="Value" width="120" align="right">10,500</td>
                    <td class="Type" width="120"><b>分割請求額<br>(残高)</b></td>
                    <td class="Value"  width="120" align="right">4,800</td>
                </tr>
            </table>
         </td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>


<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Blue" width="30"><b>年</b></td>
        <td class="Title_Blue" width="50"><b>月日</b></td>
        <td class="Title_Blue" width=""><b>伝票No</b></td>
        <td class="Title_Blue" width="60"><b>取区</b></td>
        <td class="Title_Blue" width=""><b>商品名<b></td>
        <td class="Title_Blue" width=""><b>数量<b></td>
        <td class="Title_Blue" width=""><b>単価<b></td>
        <td class="Title_Blue" width=""><b>仕入</b></td>
        <td class="Title_Blue" width=""><b>消費税</b></td>
        <td class="Title_Blue" width=""><b>仕入(税込)</b></td>
        <td class="Title_Blue" width=""><b>決済</b></td>
        <td class="Title_Blue" width=""><b>残高</b></td>
    </tr>   
    <tr class="Result1">
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right"></td>
        <td align="right">前月繰越残高</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">1,200</td>
    </tr>
    <tr class="Result2">
        <td align="center">2005</td>
        <td align="center">03-01</td>
        <td align="left">00008051</td>
        <td align="center">71</td>
        <td align="left">商品A</td>
        <td align="right">1</td>
        <td align="right">100.00</td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>

    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="left">商品B</td>
        <td align="right">2</td>
        <td align="right">1,000.00</td>
        <td align="right">2,000</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right">伝票合計</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">105</td>
        <td align="right">2,205</td>
        <td align="right"></td>
        <td align="right">3,405</td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left">00005000</td>
        <td align="center">41</td>
        <td align="left">支払(現金)</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">2,205</td>
        <td align="right">1,200</td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center">03-08</td>
        <td align="left">00008052</td>
        <td align="center">71</td>
        <td align="left">商品A</td>
        <td align="right">1</td>
        <td align="right">100.00</td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>

    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="left">商品B</td>
        <td align="right">2</td>
        <td align="right">1,000.00</td>
        <td align="right">2,000</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right">伝票合計</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">105</td>
        <td align="right">2,205</td>
        <td align="right"></td>
        <td align="right">3,405</td>
    </tr>

    <tr class="Result1">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left">00005001</td>
        <td align="center">41</td>
        <td align="left">支払(現金)</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">2,205</td>
        <td align="right">1,200</td>
    </tr>

    <tr class="Result3">
        <td align="left"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"></td>
        <td align="right"><b>3月計</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">4,200</td>
        <td align="right">210</td>
        <td align="right">4,410</td>
        <td align="right">4,410</td>
        <td align="right">1,200</td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right"></td>
        <td align="right">前月繰越残高</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">1,200</td>
    </tr>

    <tr class="Result2">
        <td align="center"></td>
        <td align="center">04-01</td>
        <td align="left">00008053</td>
        <td align="center">71</td>
        <td align="left">商品A</td>
        <td align="right">1</td>
        <td align="right">100.00</td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>

    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="left">商品B</td>
        <td align="right">2</td>
        <td align="right">1,000.00</td>
        <td align="right">2,000</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right">伝票合計</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">105</td>
        <td align="right">2,205</td>
        <td align="right"></td>
        <td align="right">3,405</td>
    </tr>

    <tr class="Result1">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left">00005002</td>
        <td align="center">41</td>
        <td align="left">支払(現金)</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">2,000</td>
        <td align="right">1,405</td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center">04-08</td>
        <td align="left">00008054</td>
        <td align="center">71</td>
        <td align="left">商品A</td>
        <td align="right">1</td>
        <td align="right">100.00</td>
        <td align="right">100</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="left">商品B</td>
        <td align="right">2</td>
        <td align="right">1,000.00</td>
        <td align="right">2,000</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="Result2">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="right">伝票合計</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">105</td>
        <td align="right">2,205</td>
        <td align="right"></td>
        <td align="right">3,610</td>
    </tr>
    <tr class="Result1">
        <td align="center"></td>
        <td align="center"></td>
        <td align="left">00005001</td>
        <td align="center">41</td>
        <td align="left">支払(現金)</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">2,000</td>
        <td align="right">1,610</td>
    </tr>
    <tr class="Result3">
        <td align="left"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"></td>
        <td align="right"><b>4月計</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">4,200</td>
        <td align="right">210</td>
        <td align="right">4,410</td>
        <td align="right">4,000</td>
        <td align="right">1,610</td>
    </tr>

    <tr class="Result4" align="center">
        <td align="left"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"><b></b></td>
        <td align="right"><b>仕入先計</b></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">8,400</td>
        <td align="right">420</td>
        <td align="right">8,820</td>
        <td align="right">8,410</td>
        <td align="right">1,610</td>
    </tr>


</table>


{$var.html_page2}


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
    

