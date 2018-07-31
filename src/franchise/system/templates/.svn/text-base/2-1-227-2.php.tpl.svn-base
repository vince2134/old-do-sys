{$var.html_header}

<body bgcolor="#D8D0C8">
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
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="400">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">担当者</td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.show_button.html}　　{$form.clear_button.html}</td>
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
{$form.hidden}

<table width="100%">
    <tr>
        <td>

<span style="font: bold 16px; color: #555555;">【ABCD週】</span><br>

<table class="List_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col style="font-weight: bold;" align="center" width="30">
<col span="7" width="100">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">担当者名</td>
        <td class="Title_Purple">週</td>
        <td class="Title_Purple">月</td>
        <td class="Title_Purple">火</td>
        <td class="Title_Purple">水</td>
        <td class="Title_Purple">木</td>
        <td class="Title_Purple">金</td>
        <td class="Title_Purple">土</td>
        <td class="Title_Purple">日</td>
    </tr>
    {foreach key=i from=$ary_list_item[0] item=item}
    <tr class="{$item[0]}"> 
        <td rowspan="4"><a href="./2-1-228.php?staff_id={$item[1][0]}">{$item[1][1]}</a></b></td>
        <td>A</td>
        {foreach key=j from=$item[2][0] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    <tr class="{$item[0]}">
        <td>B</td>
        {foreach key=j from=$item[2][1] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    <tr class="{$item[0]}">
        <td>C</td>
        {foreach key=j from=$item[2][2] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    <tr class="{$item[0]}">
        <td>D</td>
        {foreach key=j from=$item[2][3] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    {/foreach}
</table>
<br><br>

        </td>
    </tr>
    <tr>
        <td>

<span style="font: bold 16px; color: #555555;">【月例】</span><br>

<table class="List_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col span="7" width="100">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">担当者名</td>
        <td class="Title_Purple" colspan="7">日付</td>
    </tr>
    {foreach key=i from=$ary_list_item[1] item=item}
    <tr class="{$item[0]}" style="font-weight: bold;" align="center"> 
        <td rowspan="10"><a href="./2-1-228.php?staff_id={$item[1][0]}">{$item[1][1]}</a></td>
        <td bgcolor="#cccccc">1</td>
        <td bgcolor="#cccccc">2</td>
        <td bgcolor="#cccccc">3</td>
        <td bgcolor="#cccccc">4</td>
        <td bgcolor="#cccccc">5</td>
        <td bgcolor="#cccccc">6</td>
        <td bgcolor="#cccccc">7</td>
    </tr>
    <tr class="{$item[0]}"> 
        {foreach key=j from=$item[2][0] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    <tr bgcolor="#cccccc" style="font-weight: bold;" align="center">
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
        <td>12</td>
        <td>13</td>
        <td>14</td>
    </tr>
    <tr class="{$item[0]}">
        {foreach key=j from=$item[2][1] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    <tr bgcolor="#cccccc" style="font-weight: bold;" align="center">
        <td>15</td>
        <td>16</td>
        <td>17</td>
        <td>18</td>
        <td>19</td>
        <td>20</td>
        <td>21</td>
    </tr>
    <tr class="{$item[0]}">
        {foreach key=j from=$item[2][2] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    <tr bgcolor="#cccccc" style="font-weight: bold;" align="center">
        <td>22</td>
        <td>23</td>
        <td>24</td>
        <td>25</td>
        <td>26</td>
        <td>27</td>
        <td>28</td>
    </tr>
    <tr class="{$item[0]}">
        {foreach key=j from=$item[2][3] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    <tr>
        <td bgcolor="#cccccc" style="font-weight: bold;" align="center">月末</td>
        <td rowspan="2" colspan="6"></td>
    </tr>
    <tr class="{$item[0]}">
        <td><nobr>{$item[2][4][0]}</nobr></td>
    </tr>
    {/foreach}
</table>
<br><br>

        </td>
    </tr>
    <tr>
        <td>

<span style="font: bold 16px; color: #555555;">【毎月 第[1-4] [月-日]曜日】</span><br>

<table class="List_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col style="font-weight: bold;" align="center" width="30">
<col span="7" width="100">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">担当者名</td>
        <td class="Title_Purple">週</td>
        <td class="Title_Purple">月</td>
        <td class="Title_Purple">火</td>
        <td class="Title_Purple">水</td>
        <td class="Title_Purple">木</td>
        <td class="Title_Purple">金</td>
        <td class="Title_Purple">土</td>
        <td class="Title_Purple">日</td>
    </tr>
    {foreach key=i from=$ary_list_item[2] item=item}
    <tr class="{$item[0]}"> 
        <td rowspan="4"><a href="./2-1-228.php?staff_id={$item[1][0]}">{$item[1][1]}</a></td>
        <td>第1</td>
        {foreach key=j from=$item[2][0] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    <tr class="{$item[0]}">
        <td>第2</td>
        {foreach key=j from=$item[2][1] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    <tr class="{$item[0]}">
        <td>第3</td>
        {foreach key=j from=$item[2][2] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    <tr class="{$item[0]}">
        <td>第4</td>
        {foreach key=j from=$item[2][3] item=week}
        <td><nobr>{$week}</nobr></td>
        {/foreach}
    </tr>
    {/foreach}
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
