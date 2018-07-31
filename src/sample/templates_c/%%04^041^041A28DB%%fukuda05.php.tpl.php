<?php /* Smarty version 2.6.9, created on 2006-09-29 11:29:52
         compiled from fukuda05.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


ヒアセレクト用アイテムをエンティティ変換してるバージョン - 通常はこう使う<br><?php echo $this->_tpl_vars['form']['form_select1']['html']; ?>
<hr>
ヒアセレクト用アイテムをエンティティ変換してないバージョン - XSS無視の時<br><?php echo $this->_tpl_vars['form']['form_select2']['html']; ?>
<hr>
<?php echo $this->_tpl_vars['form']['form_submit']['html']; ?>

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