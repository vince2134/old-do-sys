{$form.javascript}
{$var.html_header}

<body class="bgimg_purple">
<form {$form.attributes}>

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ �إå��� begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- �إå��� e n d ---------------*}

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}

{* ���ô���Ԥ����ꤵ��Ƥ��ʤ����Υ�å����� *}
{if $var.staff_select_msg != null}
    <span style="color: #0000ff; font-weight: bold; line-height: 120%;">
    <li>{$var.staff_select_msg}</li>
    </span><br>
{/if}
{* Ⱦ��/���ѥ��ڡ������顼 *}
{if $var.err_msg1 != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 120%;">
    <li>{$var.err_msg1}</li>
    </span><br>
{/if}
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{if $smarty.post.form_submit_btn != null && $var.form_err_flg != true}
<table width="100%">
    <tr>
        <td align="center">
<span style="font: bold 16px; color: #555555;">{$var.submit_state}����λ���ޤ�����</span><br><br>
{$form.form_ok_btn.html}����{$form.form_return_btn.html}
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
        <td class="Title_Purple">���ô����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$form.hidden}

{* �����åդλ��꤬������Τ�ɽ�� *}
{if $var.staff_select_msg == null}

<table>
    <tr>
        <td>

{* ABCD�� *}
<span style="font: bold 16px; color: #555555;">��ABCD����</span>
<span style="color: #ff0000; font-weight: bold;">{if $var.submit_state == null}���ƽ�󥳡����Υ�����̾�����Ϥ��Ʋ�������{/if}</span><br>
<table class="List_Table" border="1" width="1000">
<col width="*" bgcolor="#ffdde7">
<col width="140" bgcolor="#ffffff" span="5">
<col width="140" bgcolor="#99ffff">
    {foreach key=i from=$ary_disp_data[0] item=week}
    <tr height=25 bgcolor="#828180">
        <td colspan="7"><span style="font: bold 15px; color: #ffffff;">��{if $i == 0}A{elseif $i == 1}B{elseif $i == 2}C{elseif $i == 3}D{/if}����</span></td>
    </tr>
    <tr align="center" bgcolor="#cccccc" style="font-weight: bold;" height="20">
        <td bgcolor="#ffbbc3" style="color: #ff0000;">��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td bgcolor="#66ccff" style="color: #0000ff;">��</td>
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

{* ��������ա� *}
<span style="font: bold 16px; color: #555555;">�ڷ�������աˡ�</span>
<span style="color: #ff0000; font-weight: bold;">{if $var.submit_state == null}���ƽ�󥳡����Υ�����̾�����Ϥ��Ʋ�������{/if}</span><br>
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
        <td bgcolor="#cccccc">����</td>
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

{* ����������� *}
<span style="font: bold 16px; color: #555555;">�ڷ���������ˡ�</span>
<span style="color: #ff0000; font-weight: bold;">{if $var.submit_state == null}���ƽ�󥳡����Υ�����̾�����Ϥ��Ʋ�������{/if}</span><br>
<table class="List_Table" border="1" width="1000">
<col width="120" bgcolor="#ffdde7">
<col width="140" bgcolor="#ffffff" span="5">
<col width="140" bgcolor="#99ffff">
    {foreach key=i from=$ary_disp_data[2] item=week}
    <tr height=25 bgcolor="#828180">
        <td colspan="7"><span style="font: bold 15px; color: #ffffff;">����{$i+1}����</span></td>
    </tr>
    <tr align="center" bgcolor="#cccccc" style="font-weight: bold;" height="20">
        <td bgcolor="#ffbbc3" style="color: #ff0000;">��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td bgcolor="#66ccff" style="color: #0000ff;">��</td>
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
{*--------------- ����ɽ���� e n d ---------------*}

        </td>
    </tr>
</table>

                    </td>   
                </tr>   
            </table>
        </td>   
    </tr>   
    {*--------------- ����ƥ���� e n d ---------------*}

</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
