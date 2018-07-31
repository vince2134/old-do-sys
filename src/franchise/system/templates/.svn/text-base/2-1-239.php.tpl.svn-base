{$var.html_header}

<body class="bgimg_purple">
<form name="dateForm" method="post">
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

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
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

{$form.hidden}

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="3">行<br>No.</td>
        <td class="Title_Purple" rowspan="3">依頼日</td>
		<td class="Title_Purple" rowspan="3">得意先</td>
		<td class="Title_Purple" rowspan="3">代行委託料<br>(税抜)</td>
		<td class="Title_Purple" rowspan="3">受託状況</td>
        <td class="Title_Purple" rowspan="3">順路</td>
        <td class="Title_Purple" colspan="10">巡回内容</td>
        <td class="Title_Purple" rowspan="3">巡回日<br>（基準日）</td>
        <td class="Title_Purple" rowspan="3">巡回担当<br>（売上）</td>
        <td class="Title_Purple" rowspan="3">備考</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">販売区分</td>
        <td class="Title_Purple">サービス名</td>
        <td class="Title_Purple">アイテム</td>
        <td class="Title_Purple" rowspan="2">数量</td>
        <td class="Title_Purple" colspan="2">金額</td>
        <td class="Title_Purple" colspan="2">消耗品</td>
        <td class="Title_Purple" colspan="2">本体商品</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">営業原価<br>売上単価</td>
        <td class="Title_Purple">原価合計<br>売上合計</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">数量</td>
    </tr>
{foreach from=$disp_data key=i item=item}
    {*行の色指定*}
	{if $disp_data.$i[19] == 1}
		{*依頼中のデータ*}
		<tr class="Result6">
    {elseif $disp_data.$i[100] == true}
        <tr class="Result2">
    {else}
        <tr class="Result1">
    {/if}
    {* 一行目か、契約が変更した場合に以下の行表示 *}
    {if $disp_data.$i[101] != NULL}
        {* 行No. *}
        <td align="right" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[0]}</td>
        {* 依頼日 *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[1]}</td>
		{* 得意先 *}
        <td align="center" rowspan="{$disp_data.$i[101]}"><a href="#" onClick="javascript:return Submit_Page2('./2-1-240.php?&client_id={$disp_data.$i[35]}&contract_id={$disp_data.$i[34]}');">{$disp_data.$i[37]}</a></td>
		{* 受託料 *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[18]}</td>
		{* 受託状況 *}
		{if $disp_data.$i[19] == 1}
			<td align="center" rowspan="{$disp_data.$i[101]}">依頼中</td>
		{else}
			<td align="center" rowspan="{$disp_data.$i[101]}">受託済</td>
		{/if}
        {* 順路 *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[2]}</td>
    {* データが存在しない場合 *}
    {elseif $var.early_flg == true}
        {* 行No. *}
        <td align="right">　</td>
        {* 依頼日*}
        <td align="center">　</td>
		{* 得意先*}
        <td align="center">　</td>
		{* 受託料*}
        <td align="center">　</td>
		{* 受託状況*}
        <td align="center">　</td>
        {* 順路 *}
        <td align="center">　</td>
    {/if}


    {* 2009-09-22 hashimoto-y 値引きフラグ*}
    {if $disp_data.$i[43] === 't'}
        {* 販売区分 *}
        <td align="center" style="color: red">{$disp_data.$i[3]}</td>
        {* サービス名・サービス印字 *}
        <td align="left" style="color: red">{$disp_data.$i[4]} {$disp_data.$i[5]}</td>
        {* アイテム・アイテム印字 *}
        <td align="left" style="color: red">{$disp_data.$i[6]}{$disp_data.$i[7]}</td>
        {* 数量 *}
        {if $disp_data.$i[8] == 't' && $disp_data.$i[9] != NULL}
            <td align="center" style="color: red">一式<br>{$disp_data.$i[9]}</td>
        {elseif $disp_data.$i[8] == 't' && $disp_data.$i[9] == NULL}
            <td align="center" style="color: red">一式</td>
        {elseif $disp_data.$i[8] != 't' && $disp_data.$i[9] != NULL}
            <td align="right" style="color: red">{$disp_data.$i[9]}</td>
        {/if}
        {* 営業原価・売上単価 *}
        <td align="right" style="color: red">{$disp_data.$i[10]}<br>{$disp_data.$i[11]}</td>
        {* 営業金額・売上金額 *}
        <td align="right" style="color: red">{$disp_data.$i[12]}<br>{$disp_data.$i[13]}</td>
        {* 消耗品 *}
        <td align="left" style="color: red">{$disp_data.$i[14]}</td>
        {* 消耗品数量 *}
        <td align="right" style="color: red">{$disp_data.$i[15]}</td>
        {* 本体商品 *}
        <td align="left" style="color: red">{$disp_data.$i[16]}</td>
        {* 本体商品数量 *}
        <td align="right" style="color: red">{$disp_data.$i[17]}</td>
    {else}
        {* 販売区分 *}
        <td align="center">{$disp_data.$i[3]}</td>
        {* サービス名・サービス印字 *}
        <td align="left">{$disp_data.$i[4]} {$disp_data.$i[5]}</td>
        {* アイテム・アイテム印字 *}
        <td align="left">{$disp_data.$i[6]}{$disp_data.$i[7]}</td>
        {* 数量 *}
        {if $disp_data.$i[8] == 't' && $disp_data.$i[9] != NULL}
            <td align="center">一式<br>{$disp_data.$i[9]}</td>
        {elseif $disp_data.$i[8] == 't' && $disp_data.$i[9] == NULL}
            <td align="center">一式</td>
        {elseif $disp_data.$i[8] != 't' && $disp_data.$i[9] != NULL}
            <td align="right">{$disp_data.$i[9]}</td>
        {/if}
        {* 営業原価・売上単価 *}
        <td align="right">{$disp_data.$i[10]}<br>{$disp_data.$i[11]}</td>
        {* 営業金額・売上金額 *}
        <td align="right">{$disp_data.$i[12]}<br>{$disp_data.$i[13]}</td>
        {* 消耗品 *}
        <td align="left">{$disp_data.$i[14]}</td>
        {* 消耗品数量 *}
        <td align="right">{$disp_data.$i[15]}</td>
        {* 本体商品 *}
        <td align="left">{$disp_data.$i[16]}</td>
        {* 本体商品数量 *}
        <td align="right">{$disp_data.$i[17]}</td>
    {/if}


    {* 一行目か、契約が変更した場合に以下の行表示 *}
    {if $disp_data.$i[101] != NULL}
        {* 巡回日 *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$round_data[$i]}</td>
        {* 巡回担当・売上率 *}
        <td align="left" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[29]}{$disp_data.$i[30]}{$disp_data.$i[31]}{$disp_data.$i[32]}</td>
        {* 備考 *}
        <td align="left" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[33]}</td>
    {* データが存在しない場合 *}
    {elseif $var.early_flg == true}
        {* 巡回日 *}
        <td align="center">　</td>
        {* 巡回担当・売上率 *}
        <td align="left">　</td>
        {* 備考 *}
        <td align="left">　</td>
    {/if}
    </tr>
{/foreach}
</table>

<table align="right">
    <tr>
        <td>
            {* 予定明細から遷移した場合は戻るボタン表示 *}
            {if $smarty.get.get_flg != NULL}
                　　{$form.form_back.html}</td>
            {/if}
        </td>
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
