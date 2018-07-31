{$var.html_header}
<SCRIPT LANGUAGE='javascript' SRC='estimate.js'></SCRIPT>
<BODY>
<form {$form.attributes}>

{$form.javascript}
{$form.hidden}
{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width='100%' height='90%' class='M_table' border='0'>

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align='center' height='60'>
        <td width='100%' colspan='2' valign='top'>{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align='center' valign='top'>
        <td>
            <table>
                <tr>
                    <td>
<br>
{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{*--------------- メッセージ類 e n d ---------------*}
<table width='600' border='0'>
    <tr>
        <td align='CENTER'>
{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
    <table class='Data_Table' border='1' width='100%'>
    <col width='100' style='font-weight: bold'>
    <col >
    <col width='100' style='font-weight: bold'>
        <tr>
            <td class='Title_Pink'>仕入先</td>
            <td class='Value' colspan='3'>
                {$pay_data[10]}-{$pay_data[11]}　{$pay_data[9]}</td>
        </tr>
        <tr>
            <td class='Title_Pink'>仕入締日</td>
            <td class='Value'>{$close_day}</td>                
            <td class='Title_Pink'>支払予定日</td>
            <td class='Value'>{$pay_data[8]}</td>                
        </tr>
    </table>
{*--------------- 画面表示１ e n d ---------------*}
        </td>
    </tr>
</table>
<br>
                    </td>
                </tr>
                <tr>
                    <td>

<table width='100%' border='0'>
    <tr>
        <td align='CENTER'>
{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table class='List_Table' width='100%' border='1'>
    <tr>
    <td class='Title_Pink' align='CENTER'><b>前回支払残高</b></td>
    <td class='Title_Pink' align='CENTER'><b>当月支払額</b></td>
    <td class='Title_Pink' align='CENTER'><b>繰越残高額</b></td>
    <td class='Title_Pink' align='CENTER'><b>当月仕入額</b></td>
    <td class='Title_Pink' align='CENTER'><b>消費税額</b></td>
    <td class='Title_Pink' align='CENTER'><b>税込仕入額</b></td>
    <td class='Title_Pink' align='CENTER'><b>当月支払残高</b></td>
    <td class='Title_Pink' align='CENTER'><b>今回の支払額</b></td>
    </tr>
    <tr>
            <td class='Value' align='RIGHT'>{$pay_data[0]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[1]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[2]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[3]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[4]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[5]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[6]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[7]}</td>                
    </tr>
</table>
<br>
<br>
{*----- 一覧データ -----*}
<table class='List_Table' width='100%' border='1'>
<tr>
    <td class='Title_Pink' align='CENTER'><b>月日</b></td>
    <td class='Title_Pink' align='CENTER'><b>伝票番号</b></td>
    <td class='Title_Pink' align='CENTER'><b>取引区分</b></td>
    <td class='Title_Pink' align='CENTER' width='300'><b>商品名</b></td>
    <td class='Title_Pink' align='CENTER' width='40'><b>数量</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>単価</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>金額</b></td>
    <td class='Title_Pink' align='CENTER' width='40'><b>税区分</b></td>
    <td class='Title_Pink' align='CENTER' width='80'><b>ロイヤリティ</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>支払</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>残高</b></td>
</tr>
{* -----　繰越額　----- *}
<tr class='Result1'>
    <td></td>
    <td></td>
    <td></td>
    <td align='RIGHT'>繰越</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td align='RIGHT'>{$pay_data[0]}</td> {*--前回買掛残高--*}
</tr>
{*---   明細データ表示させる  ---*}
{foreach from=$detail_data key='row' item='data' name='list' }
<tr class='Result1'>
    <td align='CENTER'>{$data[0]}</td>
    <td align='CENTER'>{$data[1]}</td>
    <td >{$data[2]}</td>
    <td >{$data[3]}</td>
    <td align='RIGHT'>{$data[4]}</td>
    <td align='RIGHT'>{$data[5]}</td>
    <td align='RIGHT'>{$data[6]}</td>
    <td align='CENTER'>{$data[7]}</td>
    <td align='CENTER'>{$data[9]}</td>
    <td align='RIGHT'>{$data[8]}</td>
    <td align='RIGHT'></td>
</tr>
{/foreach}
{* ----　課税単位が「締日単位」の場合　---- *}
{if $tax_div == '1' }
    <tr class='Result1'>
        <td></td>
        <td></td>
        <td></td>
        <td align='RIGHT'>消費税金額</td>
        <td></td>
        <td></td>
        <td align='RIGHT'>{$pay_data[4]}</td> {*--消費税額--*}
        <td></td>
        <td align='RIGHT'></td> 
        <td align='RIGHT'></td> 
        <td align='RIGHT'></td> 
    </tr>
{/if}
{* -----　計　----- *}
    <tr class='Result1'>
        <td></td>
        <td></td>
        <td></td>
        <td align='RIGHT'>計</td>
        <td></td>
        <td></td>
        <td align='RIGHT'>{$pay_data[5]}</td> {*--今回仕入額(税込)--*}
        <td></td>
        <td></td>
        <td align='RIGHT'>{$pay_data[1]}</td> {*--今回支払額--*}
        <td align='RIGHT'>{$pay_data[6]}</td> {*--今回買掛残高--*}
    </tr>
</table>
{*--------------- 画面表示２ e n d ---------------*}
        </td>
    </tr>
    <tr>
        <td align='RIGHT'>{$form.btn_back.html}</td>
    </tr>
</table>
        </td>
    </tr>
</table>
        </td>
    </tr>
{*--------------- コンテンツ部 e n d ---------------*}
</table>
</form>
{*--------------- 外枠 e n d ---------------*}
{$var.html_footer}
