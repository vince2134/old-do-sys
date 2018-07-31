{$form.javascript}
{$var.html_header}

<body class="bgimg_purple">
<form {$form.attributes}>

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

{* 巡回担当者が指定されていない時のメッセージ *}
{if $var.staff_select_msg != null}
    <span style="color: #0000ff; font-weight: bold; line-height: 120%;">
    <li>{$var.staff_select_msg}</li>
    </span><br>
{/if}
{* 半角/全角スペースエラー *}
{if $var.err_msg1 != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 120%;">
    <li>{$var.err_msg1}</li>
    </span><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{if $smarty.post.form_submit_btn != null && $var.form_err_flg != true}
<table width="100%">
    <tr>
        <td align="center">
<span style="font: bold 16px; color: #555555;">{$var.submit_state}が完了しました。</span><br><br>
{$form.form_ok_btn.html}　　{$form.form_return_btn.html}
        </td>
    </tr>
</table>
<br><br>
{/if}

<table width="400">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">巡回担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{$form.hidden}

{* スタッフの指定がある場合のみ表示 *}
{if $var.staff_select_msg == null}

<table>
    <tr>
        <td>

{* ABCD週 *}
<span style="font: bold 16px; color: #555555;">【ABCD週】</span>
<span style="color: #ff0000; font-weight: bold;">{if $var.submit_state == null}※各巡回コースのコース名を入力して下さい。{/if}</span><br>
<table class="List_Table" border="1" width="1000">
<col width="*" bgcolor="#ffdde7">
<col width="140" bgcolor="#ffffff" span="5">
<col width="140" bgcolor="#99ffff">
    {foreach key=i from=$ary_disp_data[0] item=week}
    <tr height=25 bgcolor="#828180">
        <td colspan="7"><span style="font: bold 15px; color: #ffffff;">【{if $i == 0}A{elseif $i == 1}B{elseif $i == 2}C{elseif $i == 3}D{/if}週】</span></td>
    </tr>
    <tr align="center" bgcolor="#cccccc" style="font-weight: bold;" height="20">
        <td bgcolor="#ffbbc3" style="color: #ff0000;">日</td>
        <td>月</td>
        <td>火</td>
        <td>水</td>
        <td>木</td>
        <td>金</td>
        <td bgcolor="#66ccff" style="color: #0000ff;">土</td>
    </tr>
    <tr>
        {foreach key=j from=$form.form_course_name[0][$i] item=course_form}
        <td>{$form.form_course_name[0][$i][$j].html}</td>
        {/foreach}
    </tr>
    <tr valign="top" style="padding: 3px;">
        {foreach key=k from=$week item=day}
        <td style="line-height: 120%;">
            {foreach key=l from=$day item=client}
            {$client[1]} <a href="./2-1-115.php?client_id={$client[0]}">{$client[2]}</a><br>
            {/foreach}
            {if count($day) == 0}<br>{/if}
        </td>
        {/foreach}
    </tr>
    {/foreach}
</table>
<br><br>

        </td>
    </tr>
    <tr>
        <td>

{* 月例（日付） *}
<span style="font: bold 16px; color: #555555;">【月例（日付）】</span>
<span style="color: #ff0000; font-weight: bold;">{if $var.submit_state == null}※各巡回コースのコース名を入力して下さい。{/if}</span><br>
<table class="List_Table" border="1">
<col width="140" span="7">
    {foreach key=i from=$ary_disp_data[1] item=week}
    {if $i != 4}
    <tr align="center" style="font-weight: bold;" height="20">
        <td bgcolor="#cccccc">{$i*7+1}</td>
        <td bgcolor="#cccccc">{$i*7+2}</td>
        <td bgcolor="#cccccc">{$i*7+3}</td>
        <td bgcolor="#cccccc">{$i*7+4}</td>
        <td bgcolor="#cccccc">{$i*7+5}</td>
        <td bgcolor="#cccccc">{$i*7+6}</td>
        <td bgcolor="#cccccc">{$i*7+7}</td>
    </tr>
    <tr>
        {foreach key=j from=$form.form_course_name[1][$i] item=course_form}
        <td bgcolor="#ffffff">{$form.form_course_name[1][$i][$j].html}</td>
        {/foreach}
    </tr>
    <tr valign="top" style="padding: 3px;">
        {foreach key=k from=$week item=day}
        <td bgcolor="#ffffff" style="line-height: 120%;">
            {foreach key=l from=$day item=client}
            {$client[1]} <a href="./2-1-115.php?client_id={$client[0]}">{$client[2]}</a><br>
            {/foreach}
            {if count($day) == 0}<br>{/if}
        </td>
        {/foreach}
    </tr>
    {else}
    <tr align="center" style="font-weight: bold;" height="20">
        <td bgcolor="#cccccc">月末</td>
        <td rowspan="3" colspan="6"></td>
    </tr>
    <tr>
        <td bgcolor="#ffffff">{$form.form_course_name[1][4][0].html}</td>
    </tr>
    <tr valign="top" style="padding: 3px;">
        <td bgcolor="#ffffff" style="line-height: 120%;">
            {foreach key=m from=$week[0] item=client}
            {$client[1]} <a href="./2-1-115.php?client_id={$client[0]}">{$client[2]}</a><br>
            {/foreach}
            {if count($item[0]) == 0}<br>{/if}
        </td>
    </tr>
    {/if}
    {/foreach}
</table>
<br><br>

        </td>
    </tr>
    <tr>
        <td>

{* 月例（曜日） *}
<span style="font: bold 16px; color: #555555;">【月例（曜日）】</span>
<span style="color: #ff0000; font-weight: bold;">{if $var.submit_state == null}※各巡回コースのコース名を入力して下さい。{/if}</span><br>
<table class="List_Table" border="1" width="1000">
<col width="120" bgcolor="#ffdde7">
<col width="140" bgcolor="#ffffff" span="5">
<col width="140" bgcolor="#99ffff">
    {foreach key=i from=$ary_disp_data[2] item=week}
    <tr height=25 bgcolor="#828180">
        <td colspan="7"><span style="font: bold 15px; color: #ffffff;">【第{$i+1}週】</span></td>
    </tr>
    <tr align="center" bgcolor="#cccccc" style="font-weight: bold;" height="20">
        <td bgcolor="#ffbbc3" style="color: #ff0000;">日</td>
        <td>月</td>
        <td>火</td>
        <td>水</td>
        <td>木</td>
        <td>金</td>
        <td bgcolor="#66ccff" style="color: #0000ff;">土</td>
    </tr>
    <tr>
        {foreach key=j from=$form.form_course_name[2][$i] item=course_form}
        <td>{$form.form_course_name[2][$i][$j].html}</td>
        {/foreach}
    </tr>
    <tr valign="top" style="padding: 3px;">
        {foreach key=k from=$week item=day}
        <td style="line-height: 120%;">
            {foreach key=l from=$day item=client}
            {$client[1]} <a href="./2-1-115.php?client_id={$client[0]}">{$client[2]}</a><br>
            {/foreach}
            {if count($day) == 0}<br>{/if}
        </td>
        {/foreach}
    </tr>
    {/foreach}
</table>
<br>

        </td>
    </tr>
    <tr>
        <td>

{*{if $smarty.post.form_submit_btn == null}*}
{if ($var.form_err_flg != true || $var.staff_select_msg == null) && $var.touroku_ok_flg != true}
<table align="right">
    <tr>
        <td>{$form.form_submit_btn.html}</td>
    </tr>
</table>
{/if}

        </td>
    </tr>
</table>

{/if}
{*--------------- 画面表示２ e n d ---------------*}

        </td>
    </tr>
</table>

                    </td>   
                </tr>   
            </table>
        </td>   
    </tr>   
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
