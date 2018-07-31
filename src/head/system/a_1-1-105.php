<?php

$page_title = "変則日設定";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//HTMLイメージ作成用部品
require_once(PATH."include/html_quick.php");

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_h('system','1');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

//定数の定義(ソースコードを見やすくするために定義)
define('YEAR', 0);
define('MONTH', 1);
define('DAY', 2);

//今日の日付(年、月、日)を$dateへ配列として代入
$date = date('Y n d');
$date = explode(' ', $date);
$date[MONTH] = (int) $date[MONTH]-1;

for($m2=1;$m2<7;$m2++){
$calendar .= '<table cellpadding="15"><tr><td valign="top">'."\r\n";

for($m1=1;$m1<5;$m1++){
//明示的に変数を整数型へ変換
$date[MONTH] = (int) $date[MONTH];
$date[YEAR] = (int) $date[YEAR];
$date[DAY] = (int) $date[DAY];
if($date[MONTH] == 12){
	$date[MONTH] = 1;
	$date[YEAR] = $date[YEAR]+1;
}else{
	$date[MONTH] = $date[MONTH]+1;
}

//今月の日数、最初の日、最後の日の曜日を得る
$days = date('d', mktime(0, 0, 0, $date[MONTH]+1, 0, $date[YEAR]));
$first_day = date('w', mktime(0, 0, 0, $date[MONTH], 1, $date[YEAR]));
$last_day = date('w', mktime(0, 0, 0, $date[MONTH], $days, $date[YEAR]));

//最後の週の曜日を得る
$last_week_days = ($days + $first_day) % 7;

if ($last_week_days == 0){
$weeks = ($days + $first_day) / 7;
}else{
$weeks = ceil(($days + $first_day) / 7);
}

$weeks = (int) $weeks;
$last_day = (int) $last_day;
$first_day = (int) $first_day;

//カレンダーを表として出力する
$calendar .= '<table class=\'List_Table\' border=\'1\' width=\'200\'>'."\r\n";
$calendar .= '<caption><b><font size="+1">【'.$date[YEAR].'年'.$date[MONTH].'月】</font></b></caption>';

$calendar .= '<tr><th class=\'Title_Purple\'>日</th><th class=\'Title_Purple\'>月</th><th class=\'Title_Purple\'>火</th><th class=\'Title_Purple\'>水</th><th class=\'Title_Purple\'>木</th><th class=\'Title_Purple\'>金</th><th class=\'Title_Purple\'>土</th></tr>';


$i=$j=$day=0;
while($i<$weeks){
$calendar .= '<tr class=\'Result1\' align=\'center\'>'."\r\n";
$j=0;
while($j<7){
$calendar .= '<td';
if(($i==0 && $j<$first_day) || ($i==$weeks-1 && $j>$last_day)){
$calendar .= '> '."\r\n";
}else{
$calendar .= '>'."\r\n";
$calendar .= ++$day;
$calendar .= "<br><input type='checkbox'>";
}
$calendar .= '</td>'."\r\n";
$j++;
}
$calendar .= '</tr>'."\r\n";
$i++;
}
$calendar .= '</table><table width=\'200\'><tr><td align=\'right\'><input type="button" value="クリア"></td></tr></table></td><td valign="top">'."\r\n";
}
$calendar .= '</tr>'."\r\n";
}

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'calendar'   => "$calendar",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
