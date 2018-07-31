{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

ヒアセレクト用アイテムをエンティティ変換してるバージョン - 通常はこう使う<br>{$form.form_select1.html}<hr>
ヒアセレクト用アイテムをエンティティ変換してないバージョン - XSS無視の時<br>{$form.form_select2.html}<hr>
{$form.form_submit.html}
<hr>
現象：<br>
セレクトアイテム選択時、htmlエンティティ変換後の文字列がそのまま出力されてしまう。<br>
サブミットすると、POSTされたキーを元にPHPが配列から値を取得してくるため通常の出力になる。<br>
<br>

原因：<br>
hierselectが生成するJavascriptが、エンティティ変換された文字列を元の形に戻してくれないこと。<br>
<br>

対応方法：<br>
まだわからない。<br>
