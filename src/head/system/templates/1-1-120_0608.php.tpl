{$form.javascript}
{$var.html_header}
<script language="javascript">
{$var.js_data}
</script>

<style TYPE="text/css">
<!--
td.top              {ldelim}border-top: 1px solid #999999;{rdelim}
td.bottom           {ldelim}border-bottom: 1px solid #999999;{rdelim}
td.left             {ldelim}border-left: 1px solid #999999;{rdelim}
td.top_left         {ldelim}border-top: 1px solid #999999; border-left: 1px solid #999999;{rdelim}
td.left_bottom      {ldelim}border-left: 1px solid #999999; border-bottom: 1px solid #999999;{rdelim}
td.top_left_bottom  {ldelim}border-top: 1px solid #999999; border-left: 1px solid #999999; border-bottom: 1px solid #999999;{rdelim}
-->
</style>

<body bgcolor="#D8D0C8" style="overflow-x:hidden">
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

{*+++++++++++++++ エラーメッセージ begin +++++++++++++++*}

{*--------------- エラーメッセージ e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{$form.hidden}

<table>
    <tr>
        <td colspan="3">

<table class="Data_Table" border="1" width="450">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">担当者コード</td>
        <td class="Value">{$var.charge_cd}</td>
    </tr>
    <tr>
        <td class="Title_Purple">スタッフ名</td>
        <td class="Value">{$var.staff_name}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="3">

<table class="Data_Table" border="1" width="450">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">削除権限を付与する</td>
        <td class="Value">{$form.permit_delete.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="3">

<table class="Data_Table" border="1" width="450">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">承認権限を付与する</td>
        <td class="Value">{$form.permit_accept.html}</td>
    </tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

        </td>
    </tr>
    <tr>
        <td valign="top">

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table class="Data_Table" bgcolor="#ffffff">
<col width="17" style="font: bold 15px;">
<col width="17" style="font: bold;">
<col width="17" style="font: bold;">
<col width="180">
<col width="35" align="center">
<col width="35" align="center">
    <tr bgcolor="#555555" style="color: #ffffff; font-weight: bold;">
        <td class="bottom" colspan="4"></td>
        <td class="bottom">表示</td>
        <td class="bottom">入力</td>
    </tr>
    <tr bgcolor="#b0b0f0">
        <td class="top" colspan="4">本部</td>
        <td class="bottom">{$form.permit.h.0.0.0.r.html}</td>
        <td class="bottom">{$form.permit.h.0.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#b0b0f0" rowspan="120"></td>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">売上管理</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.1.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.1.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="21"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">受注取引</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">オンライン受注</td>
        <td>{$form.permit.h.1.1.1.r.html}</td>
        <td>{$form.permit.h.1.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">受注</td>
        <td class="bottom">{$form.permit.h.1.1.2.r.html}</td>
        <td class="bottom">{$form.permit.h.1.1.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">月例清算販売書</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.2.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="4"></td>
        <td class="top_left">ロイヤリティ一覧</td>
        <td>{$form.permit.h.1.2.1.r.html}</td>
        <td>{$form.permit.h.1.2.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">レンタル料一覧</td>
        <td>{$form.permit.h.1.2.2.r.html}</td>
        <td>{$form.permit.h.1.2.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">保険料一覧</td>
        <td>{$form.permit.h.1.2.3.r.html}</td>
        <td>{$form.permit.h.1.2.3.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">代行仕入一覧</td>
        <td class="bottom">{$form.permit.h.1.2.4.r.html}</td>
        <td class="bottom">{$form.permit.h.1.2.4.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">売上取引</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.3.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.3.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom"></td>
        <td class="top_left_bottom">売上入力</td>
        <td class="bottom">{$form.permit.h.1.3.1.r.html}</td>
        <td class="bottom">{$form.permit.h.1.3.1.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">請求管理</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.4.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.4.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="3"></td>
        <td class="top_left">請求データ作成</td>
        <td>{$form.permit.h.1.4.1.r.html}</td>
        <td>{$form.permit.h.1.4.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">請求書一括発行</td>
        <td>{$form.permit.h.1.4.2.r.html}</td>
        <td>{$form.permit.h.1.4.2.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">請求照会</td>
        <td class="bottom">{$form.permit.h.1.4.3.r.html}</td>
        <td class="bottom">{$form.permit.h.1.4.3.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">入金管理</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.5.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.5.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="3"></td>
        <td class="top_left">回収予定一覧</td>
        <td>{$form.permit.h.1.5.1.r.html}</td>
        <td>{$form.permit.h.1.5.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">入金入力</td>
        <td>{$form.permit.h.1.5.2.r.html}</td>
        <td>{$form.permit.h.1.5.2.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">入金照会</td>
        <td class="bottom">{$form.permit.h.1.5.3.r.html}</td>
        <td class="bottom">{$form.permit.h.1.5.3.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">実績管理</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.6.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.6.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">売掛残高一覧</td>
        <td>{$form.permit.h.1.6.1.r.html}</td>
        <td>{$form.permit.h.1.6.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">得意先元帳</td>
        <td class="bottom">{$form.permit.h.1.6.2.r.html}</td>
        <td class="bottom">{$form.permit.h.1.6.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">仕入管理</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.2.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.2.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="10"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">発注取引</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">発注点警告リスト</td>
        <td>{$form.permit.h.2.1.1.r.html}</td>
        <td>{$form.permit.h.2.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">発注</td>
        <td class="bottom">{$form.permit.h.2.1.2.r.html}</td>
        <td class="bottom">{$form.permit.h.2.1.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">仕入取引</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.2.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom"></td>
        <td class="top_left_bottom">仕入</td>
        <td class="bottom">{$form.permit.h.2.2.1.r.html}</td>
        <td class="bottom">{$form.permit.h.2.2.1.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">支払管理</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.3.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.3.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom"></td>
        <td class="top_left_bottom">支払</td>
        <td class="bottom">{$form.permit.h.2.3.1.r.html}</td>
        <td class="bottom">{$form.permit.h.2.3.1.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">実績管理</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.4.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.4.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">買掛残高一覧</td>
        <td>{$form.permit.h.2.4.1.r.html}</td>
        <td>{$form.permit.h.2.4.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">仕入先元帳</td>
        <td class="bottom">{$form.permit.h.2.4.2.r.html}</td>
        <td class="bottom">{$form.permit.h.2.4.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">在庫管理</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.3.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.3.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="11"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">在庫取引</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.3.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.3.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="7"></td>
        <td class="top_left">在庫照会</td>
        <td>{$form.permit.h.3.1.1.r.html}</td>
        <td>{$form.permit.h.3.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">在庫受払照会</td>
        <td>{$form.permit.h.3.1.2.r.html}</td>
        <td>{$form.permit.h.3.1.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">在庫移動入力</td>
        <td>{$form.permit.h.3.1.3.r.html}</td>
        <td>{$form.permit.h.3.1.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">滞留在庫一覧</td>
        <td>{$form.permit.h.3.1.4.r.html}</td>
        <td>{$form.permit.h.3.1.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">在庫調整</td>
        <td>{$form.permit.h.3.1.5.r.html}</td>
        <td>{$form.permit.h.3.1.5.w.html}</td>
    </tr>
    <tr>
        <td class="left">商品組立</td>
        <td>{$form.permit.h.3.1.6.r.html}</td>
        <td>{$form.permit.h.3.1.6.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">商品グループ設定</td>
        <td class="bottom">{$form.permit.h.3.1.7.r.html}</td>
        <td class="bottom">{$form.permit.h.3.1.7.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">棚卸管理</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.3.2.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.3.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">棚卸調査</td>
        <td>{$form.permit.h.3.2.1.r.html}</td>
        <td>{$form.permit.h.3.2.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">棚卸実績一覧</td>
        <td class="bottom">{$form.permit.h.3.2.2.r.html}</td>
        <td class="bottom">{$form.permit.h.3.2.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">更新</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.4.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.4.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="7"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">更新管理</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.4.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.4.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="6"></td>
        <td class="top_left">パッチ表</td>
        <td>{$form.permit.h.4.1.1.r.html}</td>
        <td>{$form.permit.h.4.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">オペレータ入力情報</td>
        <td>{$form.permit.h.4.1.2.r.html}</td>
        <td>{$form.permit.h.4.1.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">日次更新処理</td>
        <td>{$form.permit.h.4.1.3.r.html}</td>
        <td>{$form.permit.h.4.1.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">請求更新処理</td>
        <td>{$form.permit.h.4.1.4.r.html}</td>
        <td>{$form.permit.h.4.1.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">棚卸更新処理</td>
        <td>{$form.permit.h.4.1.5.r.html}</td>
        <td>{$form.permit.h.4.1.5.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">月次更新処理</td>
        <td class="bottom">{$form.permit.h.4.1.6.r.html}</td>
        <td class="bottom">{$form.permit.h.4.1.6.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">データ出力</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.5.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.5.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="28"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">統計情報</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="5"></td>
        <td class="top_left">売上成績</td>
        <td>{$form.permit.h.5.1.1.r.html}</td>
        <td>{$form.permit.h.5.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">契約成績</td>
        <td>{$form.permit.h.5.1.2.r.html}</td>
        <td>{$form.permit.h.5.1.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">商品別契約成績</td>
        <td>{$form.permit.h.5.1.3.r.html}</td>
        <td>{$form.permit.h.5.1.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">得意先別契約成績</td>
        <td>{$form.permit.h.5.1.4.r.html}</td>
        <td>{$form.permit.h.5.1.4.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">売上金額一覧</td>
        <td class="bottom">{$form.permit.h.5.1.5.r.html}</td>
        <td class="bottom">{$form.permit.h.5.1.5.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">売上推移</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.2.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="8"></td>
        <td class="top_left">得意先別</td>
        <td>{$form.permit.h.5.2.1.r.html}</td>
        <td>{$form.permit.h.5.2.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">サービス別</td>
        <td>{$form.permit.h.5.2.2.r.html}</td>
        <td>{$form.permit.h.5.2.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">商品別</td>
        <td>{$form.permit.h.5.2.3.r.html}</td>
        <td>{$form.permit.h.5.2.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">得意先別商品別</td>
        <td>{$form.permit.h.5.2.4.r.html}</td>
        <td>{$form.permit.h.5.2.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">担当者別商品別</td>
        <td>{$form.permit.h.5.2.5.r.html}</td>
        <td>{$form.permit.h.5.2.5.w.html}</td>
    </tr>
    <tr>
        <td class="left">地区別商品別</td>
        <td>{$form.permit.h.5.2.6.r.html}</td>
        <td>{$form.permit.h.5.2.6.w.html}</td>
    </tr>
    <tr>
        <td class="left">業種別得意先別</td>
        <td>{$form.permit.h.5.2.7.r.html}</td>
        <td>{$form.permit.h.5.2.7.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">業種別商品別</td>
        <td class="bottom">{$form.permit.h.5.2.8.r.html}</td>
        <td class="bottom">{$form.permit.h.5.2.8.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">ABC分析</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.3.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.3.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="5"></td>
        <td class="top_left">FC別</td>
        <td>{$form.permit.h.5.3.1.r.html}</td>
        <td>{$form.permit.h.5.3.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">得意先別</td>
        <td>{$form.permit.h.5.3.2.r.html}</td>
        <td>{$form.permit.h.5.3.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">FC別商品別</td>
        <td>{$form.permit.h.5.3.3.r.html}</td>
        <td>{$form.permit.h.5.3.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">業種別</td>
        <td>{$form.permit.h.5.3.4.r.html}</td>
        <td>{$form.permit.h.5.3.4.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">担当者別商品別</td>
        <td class="bottom">{$form.permit.h.5.3.5.r.html}</td>
        <td class="bottom">{$form.permit.h.5.3.5.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">仕入推移</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.4.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.4.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">仕入先別</td>
        <td>{$form.permit.h.5.4.1.r.html}</td>
        <td>{$form.permit.h.5.4.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">仕入先別商品別</td>
        <td class="bottom">{$form.permit.h.5.4.2.r.html}</td>
        <td class="bottom">{$form.permit.h.5.4.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">CSV出力</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.5.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.5.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="3"></td>
        <td class="top_left">マスタデータ</td>
        <td>{$form.permit.h.5.5.1.r.html}</td>
        <td>{$form.permit.h.5.5.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">実績データ</td>
        <td>{$form.permit.h.5.5.2.r.html}</td>
        <td>{$form.permit.h.5.5.2.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">マスタ操作ログ</td>
        <td class="bottom">{$form.permit.h.5.5.3.r.html}</td>
        <td class="bottom">{$form.permit.h.5.5.3.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">マスタ・設定</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.6.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.6.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="37"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">本部管理マスタ</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="4"></td>
        <td class="top_left">業種</td>
        <td>{$form.permit.h.6.1.1.r.html}</td>
        <td>{$form.permit.h.6.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">業態</td>
        <td>{$form.permit.h.6.1.2.r.html}</td>
        <td>{$form.permit.h.6.1.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">施設</td>
        <td>{$form.permit.h.6.1.3.r.html}</td>
        <td>{$form.permit.h.6.1.3.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">サービス</td>
        <td class="bottom">{$form.permit.h.6.1.4.r.html}</td>
        <td class="bottom">{$form.permit.h.6.1.4.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">一部共有マスタ</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.2.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="4"></td>
        <td class="top_left">スタッフ</td>
        <td>{$form.permit.h.6.2.1.r.html}</td>
        <td>{$form.permit.h.6.2.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">商品</td>
        <td>{$form.permit.h.6.2.2.r.html}</td>
        <td>{$form.permit.h.6.2.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">Ｍ区分</td>
        <td>{$form.permit.h.6.2.3.r.html}</td>
        <td>{$form.permit.h.6.2.3.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">製品区分</td>
        <td class="bottom">{$form.permit.h.6.2.4.r.html}</td>
        <td class="bottom">{$form.permit.h.6.2.4.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">個別マスタ</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.3.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.3.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="14"></td>
        <td class="top_left">部署</td>
        <td>{$form.permit.h.6.3.1.r.html}</td>
        <td>{$form.permit.h.6.3.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">倉庫</td>
        <td>{$form.permit.h.6.3.2.r.html}</td>
        <td>{$form.permit.h.6.3.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">地区</td>
        <td>{$form.permit.h.6.3.3.r.html}</td>
        <td>{$form.permit.h.6.3.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">銀行</td>
        <td>{$form.permit.h.6.3.4.r.html}</td>
        <td>{$form.permit.h.6.3.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">製造品</td>
        <td>{$form.permit.h.6.3.5.r.html}</td>
        <td>{$form.permit.h.6.3.5.w.html}</td>
    </tr>
    <tr>
        <td class="left">構成品</td>
        <td>{$form.permit.h.6.3.6.r.html}</td>
        <td>{$form.permit.h.6.3.6.w.html}</td>
    </tr>
    <tr>
        <td class="left">FC区分</td>
        <td>{$form.permit.h.6.3.7.r.html}</td>
        <td>{$form.permit.h.6.3.7.w.html}</td>
    </tr>
    <tr>
        <td class="left">FCグループ</td>
        <td>{$form.permit.h.6.3.8.r.html}</td>
        <td>{$form.permit.h.6.3.8.w.html}</td>
    </tr>
    <tr>
        <td class="left">FC</td>
        <td>{$form.permit.h.6.3.9.r.html}</td>
        <td>{$form.permit.h.6.3.9.w.html}</td>
    </tr>
    <tr>
        <td class="left">得意先</td>
        <td>{$form.permit.h.6.3.10.r.html}</td>
        <td>{$form.permit.h.6.3.10.w.html}</td>
    </tr>
    <tr>
        <td class="left">契約</td>
        <td>{$form.permit.h.6.3.11.r.html}</td>
        <td>{$form.permit.h.6.3.11.w.html}</td>
    </tr>
    <tr>
        <td class="left">仕入先</td>
        <td>{$form.permit.h.6.3.12.r.html}</td>
        <td>{$form.permit.h.6.3.12.w.html}</td>
    </tr>
    <tr>
        <td class="left">直送先</td>
        <td>{$form.permit.h.6.3.13.r.html}</td>
        <td>{$form.permit.h.6.3.13.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">運送業者</td>
        <td class="bottom">{$form.permit.h.6.3.14.r.html}</td>
        <td class="bottom">{$form.permit.h.6.3.14.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">帳票設定</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.4.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.4.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="5"></td>
        <td class="top_left">発注書コメント</td>
        <td>{$form.permit.h.6.4.1.r.html}</td>
        <td>{$form.permit.h.6.4.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">注文書フォーマット</td>
        <td>{$form.permit.h.6.4.2.r.html}</td>
        <td>{$form.permit.h.6.4.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">請求書</td>
        <td>{$form.permit.h.6.4.3.r.html}</td>
        <td>{$form.permit.h.6.4.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">売上伝票</td>
        <td>{$form.permit.h.6.4.4.r.html}</td>
        <td>{$form.permit.h.6.4.4.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">納品書</td>
        <td class="bottom">{$form.permit.h.6.4.5.r.html}</td>
        <td class="bottom">{$form.permit.h.6.4.5.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">システム設定</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.5.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.5.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="5"></td>
        <td class="top_left">本部プロフィール</td>
        <td>{$form.permit.h.6.5.1.r.html}</td>
        <td>{$form.permit.h.6.5.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">買掛残高初期設定</td>
        <td>{$form.permit.h.6.5.2.r.html}</td>
        <td>{$form.permit.h.6.5.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">売掛残高初期設定</td>
        <td>{$form.permit.h.6.5.3.r.html}</td>
        <td>{$form.permit.h.6.5.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">請求残高初期設定</td>
        <td>{$form.permit.h.6.5.4.r.html}</td>
        <td>{$form.permit.h.6.5.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">パスワード変更</td>
        <td class="bottom">{$form.permit.h.6.5.5.r.html}</td>
        <td class="bottom">{$form.permit.h.6.5.5.w.html}</td>
    </tr>
</table>

        </td>
        <td width="10"></td>
        <td valign="top">

<table class="Data_Table" bgcolor="#ffffff">
<col width="17" style="font: bold 15px;">
<col width="17" style="font: bold;">
<col width="17" style="font: bold;">
<col width="180">
<col width="35" align="center">
<col width="35" align="center">
    <tr bgcolor="#555555" style="color: #ffffff; font-weight: bold;">
        <td class="bottom" colspan="4"></td>
        <td class="bottom">表示</td>
        <td class="bottom">入力</td>
    </tr>
    <tr bgcolor="#e5b0f0">
        <td class="top" colspan="4">ＦＣ</td>
        <td class="bottom">{$form.permit.f.0.0.0.r.html}</td>
        <td class="bottom">{$form.permit.f.0.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e5b0f0" rowspan="33"></td>
        <td bgcolor="#f0c7f0" class="top_left" colspan="3">マスタ・設定</td>
        <td bgcolor="#f0c7f0" class="bottom">{$form.permit.f.1.0.0.r.html}</td>
        <td bgcolor="#f0c7f0" class="bottom">{$form.permit.f.1.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#f0c7f0" class="left_bottom" rowspan="32"></td>
        <td bgcolor="#ffdfff" class="top_left" colspan="2">個別マスタ</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.1.0.r.html}</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="left_bottom" rowspan="11"></td>
        <td class="top_left">部署</td>
        <td>{$form.permit.f.1.1.1.r.html}</td>
        <td>{$form.permit.f.1.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">倉庫</td>
        <td>{$form.permit.f.1.1.2.r.html}</td>
        <td>{$form.permit.f.1.1.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">地区</td>
        <td>{$form.permit.f.1.1.3.r.html}</td>
        <td>{$form.permit.f.1.1.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">銀行</td>
        <td>{$form.permit.f.1.1.4.r.html}</td>
        <td>{$form.permit.f.1.1.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">コース</td>
        <td>{$form.permit.f.1.1.5.r.html}</td>
        <td>{$form.permit.f.1.1.5.w.html}</td>
    </tr>
    <tr>
        <td class="left">構成品</td>
        <td>{$form.permit.f.1.1.6.r.html}</td>
        <td>{$form.permit.f.1.1.6.w.html}</td>
    </tr>
    <tr>
        <td class="left">得意先</td>
        <td>{$form.permit.f.1.1.7.r.html}</td>
        <td>{$form.permit.f.1.1.7.w.html}</td>
    </tr>
    <tr>
        <td class="left">契約</td>
        <td>{$form.permit.f.1.1.8.r.html}</td>
        <td>{$form.permit.f.1.1.8.w.html}</td>
    </tr>
    <tr>
        <td class="left">仕入先</td>
        <td>{$form.permit.f.1.1.9.r.html}</td>
        <td>{$form.permit.f.1.1.9.w.html}</td>
    </tr>
    <tr>
        <td class="left">直送先</td>
        <td>{$form.permit.f.1.1.10.r.html}</td>
        <td>{$form.permit.f.1.1.10.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">運送業者</td>
        <td class="bottom">{$form.permit.f.1.1.11.r.html}</td>
        <td class="bottom">{$form.permit.f.1.1.11.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="top_left" colspan="2">一部共有マスタ</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.2.0.r.html}</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="left_bottom" rowspan="4"></td>
        <td class="top_left">スタッフ</td>
        <td>{$form.permit.f.1.2.1.r.html}</td>
        <td>{$form.permit.f.1.2.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">商品</td>
        <td>{$form.permit.f.1.2.2.r.html}</td>
        <td>{$form.permit.f.1.2.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">Ｍ区分</td>
        <td>{$form.permit.f.1.2.3.r.html}</td>
        <td>{$form.permit.f.1.2.3.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">製品区分</td>
        <td class="bottom">{$form.permit.f.1.2.4.r.html}</td>
        <td class="bottom">{$form.permit.f.1.2.4.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="top_left" colspan="2">帳票設定</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.3.0.r.html}</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.3.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="left_bottom" rowspan="3"></td>
        <td class="top_left">発注書コメント</td>
        <td>{$form.permit.f.1.3.1.r.html}</td>
        <td>{$form.permit.f.1.3.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">請求書</td>
        <td>{$form.permit.f.1.3.2.r.html}</td>
        <td>{$form.permit.f.1.3.2.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">売上伝票</td>
        <td class="bottom">{$form.permit.f.1.3.3.r.html}</td>
        <td class="bottom">{$form.permit.f.1.3.3.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="top_left" colspan="2">システム設定</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.4.0.r.html}</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.4.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="left_bottom" rowspan="5"></td>
        <td class="top_left">自社プロフィール</td>
        <td>{$form.permit.f.1.4.1.r.html}</td>
        <td>{$form.permit.f.1.4.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">買掛残高初期設定</td>
        <td>{$form.permit.f.1.4.2.r.html}</td>
        <td>{$form.permit.f.1.4.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">売掛残高初期設定</td>
        <td>{$form.permit.f.1.4.3.r.html}</td>
        <td>{$form.permit.f.1.4.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">請求残高初期設定</td>
        <td>{$form.permit.f.1.4.4.r.html}</td>
        <td>{$form.permit.f.1.4.4.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">パスワード変更</td>
        <td class="bottom">{$form.permit.f.1.4.5.r.html}</td>
        <td class="bottom">{$form.permit.f.1.4.5.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="top_left" colspan="2">本部管理マスタ</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.5.0.r.html}</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.5.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="left_bottom" rowspan="4"></td>
        <td class="top_left">業種</td>
        <td>{$form.permit.f.1.5.1.r.html}</td>
        <td>{$form.permit.f.1.5.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">業態</td>
        <td>{$form.permit.f.1.5.2.r.html}</td>
        <td>{$form.permit.f.1.5.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">施設</td>
        <td>{$form.permit.f.1.5.3.r.html}</td>
        <td>{$form.permit.f.1.5.3.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">売上・更新済一覧</td>
        <td class="bottom">{$form.permit.f.1.5.4.r.html}</td>
        <td class="bottom">{$form.permit.f.1.5.4.w.html}</td>
    </tr>
</table>

    <tr>
        <td colspan="3" align="right">{$form.form_set_button.html}　　{$form.form_print_button.html}　　{$form.form_return_button.html}</td>
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
