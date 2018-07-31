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
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>
<table class="Data_Table" border="1" width="655" height="33">
    <tr>
        <td class="Title_Purple" width="90"><b>{$form.form_client_link.html}</b></td>
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Purple" width="90"><b>取引状態</b></td>
        <td class="Value" width="100">{$var.state}</td>
        <td class="Title_Purple" width="90"><b>取引区分</b></td>
        <td class="Value" width="100">{$var.trade_name}</td>
    </tr>
</table>

        </td>
        <td>

&nbsp;&nbsp;

        </td>
        <td>

<table class="Data_Table" border="1" width="380" height="33">
    <tr>
        <td class="Title_Purple" width="80"><b>ご紹介口座</b></td>
        <td class="Value" width="300">{$var.ac_name}</td>  
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<br style="font-size: 4px;">
{$var.html_g}

        </td>
    </tr>
</table>
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
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="3">行<br>No.</td>
        <td class="Title_Purple" rowspan="3">契約状態</td>
        <td class="Title_Purple" rowspan="3">契約日</td>
		<!-- 直営判定 -->
		{if $smarty.session.group_kind == '2'}
      <td class="Title_Purple" colspan="4">代行</td>
		{/if}
        <td class="Title_Purple" rowspan="3">順路</td>
        <td class="Title_Purple" colspan="10">巡回内容</td>
        <td class="Title_Purple" rowspan="3" colspan="2">ご紹介料</td>
        <td class="Title_Purple" rowspan="3">前受相殺額</td>
        <td class="Title_Purple" rowspan="3">巡回日<br>（基準日）</td>
        <td class="Title_Purple" rowspan="3">巡回担当<br>（売上）</td>
        <td class="Title_Purple" rowspan="3">変更<br><br>複写追加</td>
        <td class="Title_Purple" rowspan="3">備考</td>
        <td class="Title_Purple" rowspan="3">変更履歴</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
		{if $smarty.session.group_kind == '2'}
			<td class="Title_Purple" rowspan="2">依頼日</td>
			<td class="Title_Purple" rowspan="2">代行先</td>
			<td class="Title_Purple" rowspan="2">代行委託料<br>(税抜)</td>
			<td class="Title_Purple" rowspan="2">状況</td>
		{/if}

        <td class="Title_Purple" rowspan="2">販売区分</td>
        <td class="Title_Purple" rowspan="2">サービス名</td>
        <td class="Title_Purple" rowspan="2">アイテム</td>
        <td class="Title_Purple" rowspan="2">数量</td>
        <td class="Title_Purple" colspan="2">金額</td>
        <td class="Title_Purple" colspan="2">消耗品</td>
        <td class="Title_Purple" colspan="2">本体商品</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">営業原価<br>売上単価</td>
        <td class="Title_Purple">原価合計<br>売上合計</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">数量</td>
    </tr>
{foreach from=$disp_data key=i item=item}
    {*行の色指定*}
	{if $disp_data.$i[38] != NULL}
		{*受託データ行*}
		<tr class="Result6">
    {elseif $disp_data.$i[100] == true}
		{*緑*}
        <tr class="Result2">
	{else}
		{*しろ*}
        <tr class="Result1">
    {/if}
    {* 一行目か、契約が変更した場合に以下の行表示 *}
    {if $disp_data.$i[101] != NULL}
        <td align="right" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[0]}</td>  {* 行No. *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[45]}</td>{* 契約状態 *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[1]}</td> {* 契約日 *}
		<!-- 直営判定 -->
		{if $smarty.session.group_kind == '2'}
			{* 依頼日 *}
	        <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[39]}</td>
			{* 代行先 *}
	        <td align="left" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[42]}{if $disp_data.$i[38] != NULL}-{/if}{$disp_data.$i[43]}<br>{$disp_data.$i[38]}</td>
			{* 代行依頼料 *}
	        <td align="right" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[48]}</td>
			{* 代行状況 *}

			{if $disp_data.$i[38] == NULL}
				{* 契約区分が通常 *}
				<td align="center" rowspan="{$disp_data.$i[101]}"></td>
			{elseif $disp_data.$i[41] == '1'}
				<td align="center" rowspan="{$disp_data.$i[101]}">依頼中</td>
			{elseif $disp_data.$i[41] == '2' && $disp_data.$i[38] != NULL}
	        	<td align="center" rowspan="{$disp_data.$i[101]}">受託済</td>
			{/if}

		{/if}
        {* 順路 *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[2]}</td>
    {* データが存在しない場合 *}
    {elseif $var.early_flg == true}
        <td align="right"></td> {* 行No. *}
        <td align="right"></td> {* 契約状態 *}
        <td align="center"></td>{* 契約日*}

		<!-- 直営判定 -->
		{if $smarty.session.group_kind == '2'}
	        <td align="center"></td>{* 依頼日*}
	        <td align="center"></td>{* 代行先*}
	        <td align="center"></td>{* 代行依頼料*}
	        <td align="center"></td>{* 代行状況*}
		{/if}

        
        <td align="center"></td>{* 順路 *}
    {/if}

    {* aoyama-n 2009-09-24 *}
    {* 値引商品は赤字で表示 *}
    {if $disp_data.$i[54] === 't'}
        <td align="center" style="color: red;">{$disp_data.$i[3]}</td>{* 販売区分 *}
        <td align="left" style="color: red;">{$disp_data.$i[4]} {$disp_data.$i[5]}</td>{* サービス名・サービス印字 *}
        <td align="left" style="color: red;">{$disp_data.$i[6]} {$disp_data.$i[7]}</td>{* アイテム・アイテム印字 *}

        {* 数量 *}
        {if $disp_data.$i[8] == 't' && $disp_data.$i[9] != NULL}
            <td align="center" style="color: red;">一式<br>{$disp_data.$i[9]}</td>
        {elseif $disp_data.$i[8] == 't' && $disp_data.$i[9] == NULL}
            <td align="center" style="color: red;">一式</td>
        {elseif $disp_data.$i[8] != 't' && $disp_data.$i[9] != NULL}
            <td align="right" style="color: red;">{$disp_data.$i[9]}</td>
        {else}
            <td align="right"> </td>
        {/if}
        <td align="right" style="color: red;">{$disp_data.$i[10]}<br>{$disp_data.$i[11]}</td>{* 営業原価・売上単価 *}
        <td align="right" style="color: red;">{$disp_data.$i[12]}<br>{$disp_data.$i[13]}</td>{* 営業金額・売上金額 *}
        <td align="left" style="color: red;">{$disp_data.$i[14]}</td>  {* 消耗品 *}
        <td align="right" style="color: red;">{$disp_data.$i[15]}</td> {* 消耗品数量 *}
        <td align="left" style="color: red;">{$disp_data.$i[16]}</td>  {* 本体商品 *}
        <td align="right" style="color: red;">{$disp_data.$i[17]}</td> {* 本体商品数量 *}
    {else}
        <td align="center">{$disp_data.$i[3]}</td>{* 販売区分 *}
        <td align="left">{$disp_data.$i[4]} {$disp_data.$i[5]}</td>{* サービス名・サービス印字 *}
        <td align="left">{$disp_data.$i[6]} {$disp_data.$i[7]}</td>{* アイテム・アイテム印字 *}

        {* 数量 *}
        {if $disp_data.$i[8] == 't' && $disp_data.$i[9] != NULL}
            <td align="center">一式<br>{$disp_data.$i[9]}</td>
        {elseif $disp_data.$i[8] == 't' && $disp_data.$i[9] == NULL}
            <td align="center">一式</td>
        {elseif $disp_data.$i[8] != 't' && $disp_data.$i[9] != NULL}
            <td align="right">{$disp_data.$i[9]}</td>
        {else}
            <td align="right"> </td>
        {/if}
        <td align="right">{$disp_data.$i[10]}<br>{$disp_data.$i[11]}</td>{* 営業原価・売上単価 *}
        <td align="right">{$disp_data.$i[12]}<br>{$disp_data.$i[13]}</td>{* 営業金額・売上金額 *}
        <td align="left">{$disp_data.$i[14]}</td>  {* 消耗品 *}
        <td align="right">{$disp_data.$i[15]}</td> {* 消耗品数量 *}
        <td align="left">{$disp_data.$i[16]}</td>  {* 本体商品 *}
        <td align="right">{$disp_data.$i[17]}</td> {* 本体商品数量 *}
    {/if}
        
		{if $disp_data.$i[101] != NULL}
    <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[46]}</td>
		{/if}
    <td align="right" width="20">{$disp_data.$i[47]}</td> {* 紹介料 *}
    <td align="right">{$disp_data.$i[53]}</td> {* 前受相殺額 *}
    {* 一行目か、契約が変更した場合に以下の行表示 *}
    {if $disp_data.$i[101] != NULL}
        {* 巡回日 *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$round_data[$i]}</td>
        {* 巡回担当・売上率 *}
        <td align="left" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[29]}{$disp_data.$i[30]}{$disp_data.$i[31]}{$disp_data.$i[32]}</td>
        {* 変更・複写追加 *}
        <td align="center" rowspan="{$disp_data.$i[101]}"><a href="#" onClick="javascript:return Submit_Page2('./2-1-104.php?flg=chg&client_id={$disp_data.$i[35]}&contract_id={$disp_data.$i[34]}&return_flg=true&get_flg={$var.get_flg}');">変更</a><br><br><a href="#" onClick="javascript:return Submit_Page2('./2-1-104.php?flg=copy&client_id={$disp_data.$i[35]}&contract_id={$disp_data.$i[34]}&return_flg=true&get_flg={$var.get_flg}');">複写追加</a></td>
        {* 備考 *}
        <td align="left" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[33]}</td>
        <td align="left" rowspan="{$disp_data.$i[101]}">
		{foreach from=$disp_data.$i.history key=key item=val}
			{if $val.work_time != NULL}
				{$key+1}回前：
				{$val.work_time}
				{$val.staff_name}
				<br>
			{/if}
		{/foreach}
				
				
				
				</td>
    {* データが存在しない場合 *}
    {elseif $var.early_flg == true}
        {* 巡回日 *}
        <td align="center"></td>
        {* 巡回担当・売上率 *}
        <td align="left"></td>
        {* 変更・複写追加 *}
        <td align="center"></td>
        {* 備考 *}
        <td align="left"></td>
        <td align="left"></td>
    {/if}

    </tr>
{/foreach}
</table>

<table align="right">
    <tr>
        <td>
            {$form.form_insert.html}　　{$form.form_back.html}
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
