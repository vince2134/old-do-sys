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



{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="400">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">巡回担当者</td>
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

{* 表示ボタン押下時のみ出力 *}
{if $smarty.post.show_button != null}
<table width="100%">
    <tr>
        <td>

全 <b>{$var.staff_count}</b> 件<br><br><br>

{foreach key=i from=$ary_disp_data item=item}
<table class="List_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col style="font-weight: bold;" width="50">
<col span="7" width="100">
    {* ABCD週 *}
    <tr style="font: bold 13px;" class="Result1">
        <td rowspan="23" style="font: bold 15px;"><a href="./2-1-228.php?staff_id={$item[1][0]}">{$item[1][1]}</a></b></td>
        <td colspan="9" class="Title_Purple">【ABCD週】</td>
    </tr>
    <tr style="font-weight: bold;" align="center" bgcolor="#cccccc">
        <td></td>
        <td bgcolor="#ffbbc3" style="color: #ff0000;">日</td>
        <td>月</td>
        <td>火</td>
        <td>水</td>
        <td>木</td>
        <td>金</td>
        <td bgcolor="#66ccff" style="color: #0000ff;">土</td>
    </tr>
    <tr class="Result1">
        <td>A週</td>
        {foreach key=j from=$item[2][0][0] item=week}
        {if $j != 0 && $j != 6}
        <td><nobr>{$week}</nobr><br></td>
        {elseif $j == 0}
        <td bgcolor="#ffdde7"><nobr>{$week}</nobr><br></td>
        {elseif $j == 6}
        <td bgcolor="#99ffff"><nobr>{$week}</nobr><br></td>
        {/if}
        {/foreach}
    </tr>
    <tr class="Result1">
        <td>B週</td>
        {foreach key=j from=$item[2][0][1] item=week}
        {if $j != 0 && $j != 6}
        <td><nobr>{$week}</nobr><br></td>
        {elseif $j == 0}
        <td bgcolor="#ffdde7"><nobr>{$week}</nobr><br></td>
        {elseif $j == 6}
        <td bgcolor="#99ffff"><nobr>{$week}</nobr><br></td>
        {/if}
        {/foreach}
    </tr>
    <tr class="Result1">
        <td>C週</td>
        {foreach key=j from=$item[2][0][2] item=week}
        {if $j != 0 && $j != 6}
        <td><nobr>{$week}</nobr><br></td>
        {elseif $j == 0}
        <td bgcolor="#ffdde7"><nobr>{$week}</nobr><br></td>
        {elseif $j == 6}
        <td bgcolor="#99ffff"><nobr>{$week}</nobr><br></td>
        {/if}
        {/foreach}
    </tr>
    <tr class="Result1">
        <td>D週</td>
        {foreach key=j from=$item[2][0][3] item=week}
        {if $j != 0 && $j != 6}
        <td><nobr>{$week}</nobr><br></td>
        {elseif $j == 0}
        <td bgcolor="#ffdde7"><nobr>{$week}</nobr><br></td>
        {elseif $j == 6}
        <td bgcolor="#99ffff"><nobr>{$week}</nobr><br></td>
        {/if}
        {/foreach}
    </tr>
    {* 月例（日付） *}
    <tr>
        <td colspan="9" class="Title_Purple">【月例（日付）】</td>
    </tr>
    <tr align="center" style="font-weight: bold;" bgcolor="#cccccc">
        <td rowspan="10" class="Value"></td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
    </tr>
    <tr class="Result1">
        {foreach key=j from=$item[2][1][0] item=week}
        <td><nobr>{$week}</nobr><br></td>
        {/foreach}
    </tr>
    <tr align="center" style="font-weight: bold;" bgcolor="#cccccc">
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
        <td>12</td>
        <td>13</td>
        <td>14</td>
    </tr>
    <tr class="Result1">
        {foreach key=j from=$item[2][1][1] item=week}
        <td><nobr>{$week}</nobr><br></td>
        {/foreach}
    </tr>
    <tr align="center" style="font-weight: bold;" bgcolor="#cccccc">
        <td>15</td>
        <td>16</td>
        <td>17</td>
        <td>18</td>
        <td>19</td>
        <td>20</td>
        <td>21</td>
    </tr>
    <tr class="Result1">
        {foreach key=j from=$item[2][1][2] item=week}
        <td><nobr>{$week}</nobr><br></td>
        {/foreach}
    </tr>
    <tr align="center" style="font-weight: bold;" bgcolor="#cccccc">
        <td>22</td>
        <td>23</td>
        <td>24</td>
        <td>25</td>
        <td>26</td>
        <td>27</td>
        <td>28</td>
    </tr>
    <tr class="Result1">
        {foreach key=j from=$item[2][1][3] item=week}
        <td><nobr>{$week}</nobr><br></td>
        {/foreach}
    </tr>
    <tr>
        <td style="font-weight: bold;" align="center" bgcolor="#cccccc">月末</td>
        <td rowspan="2" colspan="6"></td>
    </tr>
    <tr class="Result1">
        <td><nobr>{$item[2][1][4][0]}</nobr><br></td>
    </tr>
    {* 月例（曜日） *}
    <tr>
        <td colspan="9" class="Title_Purple">【月例（曜日）】</td>
    </tr>
    <tr style="font-weight: bold;" align="center" bgcolor="#cccccc">
        <td></td>
        <td bgcolor="#ffbbc3" style="color: #ff0000;">日</td>
        <td>月</td>
        <td>火</td>
        <td>水</td>
        <td>木</td>
        <td>金</td>
        <td bgcolor="#66ccff" style="color: #0000ff;">土</td>
    </tr>
    <tr class="Result1">
        <td>第1週</td>
        {foreach key=j from=$item[2][2][0] item=week}
        {if $j != 0 && $j != 6}
        <td><nobr>{$week}</nobr><br></td>
        {elseif $j == 0}
        <td bgcolor="#ffdde7"><nobr>{$week}</nobr><br></td>
        {elseif $j == 6}
        <td bgcolor="#99ffff"><nobr>{$week}</nobr><br></td>
        {/if}
        {/foreach}
    </tr>
    <tr class="Result1">
        <td>第2週</td>
        {foreach key=j from=$item[2][2][1] item=week}
        {if $j != 0 && $j != 6}
        <td><nobr>{$week}</nobr><br></td>
        {elseif $j == 0}
        <td bgcolor="#ffdde7"><nobr>{$week}</nobr><br></td>
        {elseif $j == 6}
        <td bgcolor="#99ffff"><nobr>{$week}</nobr><br></td>
        {/if}
        {/foreach}
    </tr>
    <tr class="Result1">
        <td>第3週</td>
        {foreach key=j from=$item[2][2][2] item=week}
        {if $j != 0 && $j != 6}
        <td><nobr>{$week}</nobr><br></td>
        {elseif $j == 0}
        <td bgcolor="#ffdde7"><nobr>{$week}</nobr><br></td>
        {elseif $j == 6}
        <td bgcolor="#99ffff"><nobr>{$week}</nobr><br></td>
        {/if}
        {/foreach}
    </tr>
    <tr class="Result1">
        <td>第4週</td>
        {foreach key=j from=$item[2][2][3] item=week}
        {if $j != 0 && $j != 6}
        <td><nobr>{$week}</nobr><br></td>
        {elseif $j == 0}
        <td bgcolor="#ffdde7"><nobr>{$week}</nobr><br></td>
        {elseif $j == 6}
        <td bgcolor="#99ffff"><nobr>{$week}</nobr><br></td>
        {/if}
        {/foreach}
    </tr>
</table>
<br><br>
{/foreach}

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
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
