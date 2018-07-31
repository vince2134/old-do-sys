
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{*------------------- 外枠開始 --------------------*}
<table width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
        </td>
    </tr>


        {*-------------------- 画面表示開始 -------------------*}
    <tr align="center">
        <td>
        
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
        <td class="Title_Pink"><b>出力形式</b></td>
        <td class="Value">{$form.f_r_output23.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink"><b>取引期間<font color="red">※</font></b></td>
        <td class="Value">{$form.f_date_d1.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink"><b><a href="#" onClick="return Open_SubWin('../dialog/2-0-250.php',Array('f_customer[code1]','f_customer[code2]','f_customer[name]'),500,450);">得意先</a><font color="red">※</font></b></td>
        <td class="Value" colspan="3">{$form.f_customer.html}</td>
    </tr>

</table>

        </td>
        <td rowspan="2" valign="top" align="right">
<table>
<col span="8" width="90" style="color: #525552;">
    <tr>
        <td>11：掛売上</td>
        <td>12：掛返品</td>
        <td>13：掛値引</td>
        <td></td>
    </tr>
    <tr>
        <td>61：現金売上</td>
        <td>62：現金返品</td>
        <td>63：現金値引</td>
        <td></td>
    </tr>
    <tr>
        <td>70：割賦売上</td>
        <td>71：直取</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>31：現金入金</td>
        <td>32：振込入金</td>
        <td>33：手形入金</td>
        <td>34：相殺</td>
    </tr>
    <tr>
        <td>35：手数料</td>
        <td>36：入金調整</td>
        <td>37：その他入金</td>
        <td></td>
    </tr>
</table></td>
    </tr>
    <tr>
        <td>

<table width='100%'>
    <tr>
        <td align="left"><b><font color="red">※は必須入力です</font></b></td>
        <td align='right'>{$form.hyouji20.html}　　{$form.kuria.html}</td>
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
<table width="100%" border="0">
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
                    <td class="Value" align="center">翌月の20日</td>
                </tr>
            </table>
         </td>
         <td>
            <table class="List_Table" border="1" align="right"width="400">
                <tr align="">
                    <td class="Type" width="110"><b>割賦売掛残高</b></td>
                    <td class="Value" width="" align="right" colspan="3">5,250 / 10,500 (取引日：2005-02-10)</td>
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
        <td class="Title_Pink" width=""><b>年</b></td>
        <td class="Title_Pink" width=""><b>月日</b></td>
        <td class="Title_Pink" width=""><b>伝票No.</b></td>
        <td class="Title_Pink" width=""><b>取区</b></td>
        <td class="Title_Pink" width=""><b>商品名</b></td>
        <td class="Title_Pink" width=""><b>数量</b></td>
        <td class="Title_Pink" width=""><b>単価</b></td>
        <td class="Title_Pink" width=""><b>売上</b></td>
        <td class="Title_Pink" width=""><b>消費税</b></td>
        <td class="Title_Pink" width=""><b>売上(税込)</b></td>
        <td class="Title_Pink" width=""><b>入金</b></td>
        <td class="Title_Pink" width=""><b>残高</b></td>
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
        <td align="center">61</td>
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
        <td align="center">31</td>
        <td align="left">入金(現金)</td>
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
        <td align="center">61</td>
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
        <td align="center">31</td>
        <td align="left">入金(現金)</td>
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
        <td align="center">61</td>
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
        <td align="center">31</td>
        <td align="left">入金(現金)</td>
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
        <td align="center">61</td>
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
        <td align="right"><b>得意先計</b></td>
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
    

