{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%">

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}

{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>{$form.form_button.close_button.html}</td>
    </tr>
</table>
<br>

{$form.hidden}
<table class="List_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">�����襳����<br>������̾</td>
        <td class="Title_Purple">�϶�</td>
        <td class="Title_Purple">����</td>
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">
            ��  {$j+1}
        </td>               
        <td>
            {$row[$j][0]}-{$row[$j][1]}<br>
            {$row[$j][2]}</td>
        </td>
        <td align="center">{$row[$j][3]}</td>
        <td align="center">
        {if $row[$j][4] == 1}
            �����
        {else if}
            ����ٻ���
        {/if}
        </td>
    </tr>
    {/foreach}
</table>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- ����ƥ���� e n d ---------------*}

</table>
{*--------------- ���� e n d ---------------*}

</body>
</html>
