{* -------------------------------------------------------------------
 * @fnc.Overview    テストページ
 * @author          ふくだ
 * @Cng.Tracking    #1: 20060201
 * ---------------------------------------------------------------- *}

{$form.javascript}
{$var.html_header}

<body class="bgimg_purple">

<form {$form.attributes}>
{$form.form_input1.label}：　{$form.form_input1.html}<br>
{$form.form_input2.label}：　{$form.form_input2.html}<br><br>
{$form.form_output1.label}：　{$form.form_output1.html}<br>
{$form.form_output2.label}：　{$form.form_output2.html}<br><br>
{$form.form_static1.label}：　{$form.form_static1.html}<br>
{$form.form_static2.label}：　{$form.form_static2.html}<br><br>
{$form.form_submit.html}
{$form.form_reset.html}
</form>

{$var.html_footer}
