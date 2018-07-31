<?php
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 *   2016/01/20                amano  Dialogue関数でボタン名が送られない IE11 バグ対応
 */
$page_title = "契約内容登録（変則日設定）";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

// DB接続
$db_con = Db_Connect();

/****************************/
// フォームパーツ作成
/****************************/
// 設定ボタン
$form->addElement("button", "form_set_button", "設　定", "onClick=\"javascript:Dialogue('変則日を設定します。','".HEAD_DIR."system/1-1-104.php', this)\"");

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\"");

// 閉じるボタン
$form->addElement("button", "form_close_button", "閉じる", "onClick=\"window.close()\"");

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
	$calendar .= '<table cellpadding="15"><tr><td valign="top">'."\n";

	for($m1=1;$m1<5;$m1++){
		//明示的に変数を整数型へ変換
		$date[MONTH] = (int) $date[MONTH];
		$date[YEAR] = (int) $date[YEAR];
		$date[DAY] = (int) $date[DAY];
		//月が12月だったら次の月は1月
		if($date[MONTH] == 12){
			$date[MONTH] = 1;
			$date[YEAR] = $date[YEAR]+1;
		//12月以外だったら＋１月
		}else{
			$date[MONTH] = $date[MONTH]+1;
		}

		//今月の日数、最初の日、最後の日の曜日を得る
		$days = date('d', mktime(0, 0, 0, $date[MONTH]+1, 0, $date[YEAR]));
		$first_day = date('w', mktime(0, 0, 0, $date[MONTH], 1, $date[YEAR]));
		$last_day = date('w', mktime(0, 0, 0, $date[MONTH], $days, $date[YEAR]));
		
		if($first_day == 0){
			$first_day = 6;
		}else{
			$first_day = $first_day-1;
		}
		
		if($last_day == 0){
			$last_day = 6;
		}else{
			$last_day = $last_day-1;
		}
		
		//最後の週の曜日を得る
		$last_week_days = ($days + $first_day) % 7;
		if ($last_week_days == 0){
			$weeks = ($days + $first_day) / 7;
		}else{
			$weeks = ceil(($days + $first_day) / 7);
		}
		//カレンダーを表として出力する
		$calendar .= '<table class=\'List_Table\' border=\'1\' width=\'200\'>'."\n";
		$calendar .= '<caption><b><font size="+1">【'.$date[YEAR].'年'.$date[MONTH].'月】</font></b></caption>';

		$calendar .= '<tr><th class=\'Title_Purple\'>月</th><th class=\'Title_Purple\'>火</th><th class=\'Title_Purple\'>水</th><th class=\'Title_Purple\'>木</th><th class=\'Title_Purple\'>金</th><th class=\'Title_Purple\'>土</th><th class=\'Title_Purple\'>日</th></tr>';

		$i=$j=$day=0;
		while($i<$weeks){
			$calendar .= '<tr class=\'Result1\' align=\'center\'>'."\n";
			$j=0;
			while($j<7){
				$calendar .= '<td';
				if(($i==0 && $j<$first_day) || ($i==$weeks-1 && $j>$last_day)){
					$calendar .= '> '."\n";
				}else{
					$calendar .= '>'."\n";
					$calendar .= ++$day;
					$calendar .= "<br>";
					//チェックボックス定義
					$form->addElement('checkbox', "check_".$date[YEAR]."-".$date[MONTH]."-".$day, 'チェックボックス', '');
					$calendar .= $form->_elements[$form->_elementIndex["check_".$date[YEAR]."-".$date[MONTH]."-".$day]]->toHtml();
				}
				$calendar .= '</td>'."\n";
				$j++;
			}
			$calendar .= '</tr>'."\n";
			$i++;
		}
		$calendar .= '</table></td><td valign="top">'."\n";
	}
	$calendar .= '</tr>'."\n";
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
	'calendar'      => "$calendar",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
