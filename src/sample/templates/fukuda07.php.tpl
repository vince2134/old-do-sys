<html>
<head>
<title></title>
</head>

<body style="font-family: Verdana; font-size: 11px;">


<form name="dateForm" method="post">
{$form.hidden}
{$form.form_quick.html}　{$form.form_back.html}　{$form.form_commit.html}　{$form.form_clear.html}<br><br>

{* エラーメッセージ *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $err.no_random_err_msg != null}<li>{$err.no_random_err_msg}<br>{/if}
{if $err.no_select_err_msg != null}<li>{$err.no_select_err_msg}<br>{/if}
</ul>
</span>

{$form.form_src_tpl.html}<br><br>
{$html}
</form>

</body>
</html>
