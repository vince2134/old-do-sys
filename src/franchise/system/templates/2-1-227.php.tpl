{$var.html_header}

<body bgcolor="#D8D0C8">
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



{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="400">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">���ô����</td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.show_button.html}����{$form.clear_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$form.hidden}

{* ɽ���ܥ��󲡲����Τ߽��� *}
{if $smarty.post.show_button != null}
<table width="100%">
    <tr>
        <td>

�� <b>{$var.staff_count}</b> ��<br><br><br>

{foreach key=i from=$ary_disp_data item=item}
<table class="List_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col style="font-weight: bold;" width="50">
<col span="7" width="100">
    {* ABCD�� *}
    <tr style="font: bold 13px;" class="Result1">
        <td rowspan="23" style="font: bold 15px;"><a href="./2-1-228.php?staff_id={$item[1][0]}">{$item[1][1]}</a></b></td>
        <td colspan="9" class="Title_Purple">��ABCD����</td>
    </tr>
    <tr style="font-weight: bold;" align="center" bgcolor="#cccccc">
        <td></td>
        <td bgcolor="#ffbbc3" style="color: #ff0000;">��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td bgcolor="#66ccff" style="color: #0000ff;">��</td>
    </tr>
    <tr class="Result1">
        <td>A��</td>
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
        <td>B��</td>
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
        <td>C��</td>
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
        <td>D��</td>
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
    {* ��������ա� *}
    <tr>
        <td colspan="9" class="Title_Purple">�ڷ�������աˡ�</td>
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
        <td style="font-weight: bold;" align="center" bgcolor="#cccccc">����</td>
        <td rowspan="2" colspan="6"></td>
    </tr>
    <tr class="Result1">
        <td><nobr>{$item[2][1][4][0]}</nobr><br></td>
    </tr>
    {* ����������� *}
    <tr>
        <td colspan="9" class="Title_Purple">�ڷ���������ˡ�</td>
    </tr>
    <tr style="font-weight: bold;" align="center" bgcolor="#cccccc">
        <td></td>
        <td bgcolor="#ffbbc3" style="color: #ff0000;">��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td>��</td>
        <td bgcolor="#66ccff" style="color: #0000ff;">��</td>
    </tr>
    <tr class="Result1">
        <td>��1��</td>
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
        <td>��2��</td>
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
        <td>��3��</td>
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
        <td>��4��</td>
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
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- ����ƥ���� e n d ---------------*}

</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
