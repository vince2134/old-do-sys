{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}
{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%">

        <td valign="top">
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}

{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<form {$form.attributes}>

<table>
    <tr>
        <td>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}����{$form.form_clear_button.html}</td>
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
<table width="100%">
    <tr>
        <td>

{$var.html_page}
{if $smarty.post.form_show_button == "ɽ����" }

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">���ʥ�����<br>����̾</td>
        <td class="Title_Purple">ά��</td>
        <td class="Title_Purple">���ʶ�ʬ</td>
        <td class="Title_Purple">�Ͷ�ʬ</td>
        <td class="Title_Purple">°����ʬ</td>
    </tr>

    {* 1���� *}
    {foreach from=$page_data item=items key=i}
    <tr class="Result1">
        <td align="right">{$i+1}</td>
        {foreach from=$items item=item key=j}
        {if $j==0}
        <td>{$item}<br>
        {elseif $j==1}
        {$item}</a></td>
        {elseif $j==2}
        <td>{$item}</td>
        {elseif $j==3}
        <td align="center">{$item}</td>
        {elseif $j==4}
        <td align="center">{$item}</td>
        {elseif $j==5}
        <td align="center">{$item}</td>
        {/if}
        {/foreach}
    </tr>
    {/foreach}

</table>
{/if}

        </td>
    </tr>
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
