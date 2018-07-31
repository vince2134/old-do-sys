<?php

/******************************
 *  変更履歴
 *      ・（2006-10-30）変則日画面の戻るボタン押下処理変更<suzuki>
 *      ・              変則日カレンダーの表示形式を変更<suzuki>                      
 *
 *
******************************/
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/06/29      B0702-067   kajioka-h   クリアボタンを押すと戻る画面がおかしいバグ修正
 *  2009/06/24      改修No.37	aizawa-m	カレンダー表示を2年分→5年分へ変更
 *  2009/06/25      改修No.37	aizawa-m	カレンダー表示行間に<hr>を追加
 *
 */


$page_title = "変則日設定";

//環境設定ファイル
require_once("ENV_local.php");

//DBに接続
$db_con = Db_Connect();
// 権限チェック
$auth       = Auth_Check($db_con);

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

/****************************/
//外部変数
/****************************/
$flg       = $_GET["flg"];
$client_id = $_GET["client_id"];
$get_con_id = $_GET["contract_id"];

//不正判定
Get_ID_Check3($client_id);
Get_ID_Check3($get_con_id);


/****************************/
//初期表示
/****************************/
if($_POST["form_issiki"] != NULL){
	$con_data["form_cost_div"] = 1;
	$form->setConstants($con_data);
}

/****************************/
//hiddenで契約登録の部品定義
/****************************/
require_once(INCLUDE_DIR."keiyaku_hidden.inc");

//戻るページをhiddenに保持
$form->addElement('hidden', "daiko_page_flg");


/****************************/
//hiddenで内訳の部品定義
/****************************/
/*
//契約登録の行数分
for($i=1;$i<=5;$i++){
	//内訳登録の行数分
	for($j=1;$j<=5;$j++){
		//商品コード
		$form->addElement("hidden","break_goods_cd[$i][$j]","");
		//商品名
		$form->addElement("hidden","break_goods_name[$i][$j]","");
		//商品数
		$form->addElement("hidden","break_goods_num[$i][$j]","");
		//商品ID
		$form->addElement("hidden","hdn_bgoods_id[$i][$j]","");
		//品名変更フラグ
		$form->addElement("hidden","hdn_bname_change[$i][$j]","");

		//営業原価
		$form->addElement("hidden","break_trade_price[$i][$j][1]","");
		$form->addElement("hidden","break_trade_price[$i][$j][2]","");
		//原価合計
		$form->addElement("hidden","break_trade_amount[$i][$j]","");
		//売上単価
		$form->addElement("hidden","break_sale_price[$i][$j][1]","");
		$form->addElement("hidden","break_sale_price[$i][$j][2]","");
		//売上合計
		$form->addElement("hidden","break_sale_amount[$i][$j]","");
	}
}
*/


/****************************/
//クリアボタン押下処理
/****************************/
//-- 2009/06/24 改修No.37 追加
$term = 5;	//年数
//----
if($_POST["clear_flg"] == true){
	//変則日の値初期化
	$year  = date("Y");
	$month = date("m");

	//-- 2009/06/25 改修No.37 変更
	// 表示月数を算出
	$m_term = $term * 12;	//月数を算出
	for($i=0;$i<$m_term;$i++){
	//for($i=0;$i<28;$i++){
		//月の日数取得
		$now = mktime(0, 0, 0, $month+$i,1,$year);
		$num = date("t",$now);
		//１年１１ヶ月分データ取得
		for($s=1;$s<=$num;$s++){
			$now = mktime(0, 0, 0, $month+$i,$s,$year);
			$syear  = (int) date("Y",$now);
			$smonth = (int) date("n",$now);
			$sday   = (int) date("d",$now);
			$input_date = "check_".$syear."-".$smonth."-".$sday;

			//チェックされた日付だけを取得
			if($_POST["$input_date"] != NULL){
				$con_data["$input_date"]      = "";
			}
		}
	}

	/*
	 * 履歴：
	 * 　日付　　　　B票No.　　　　担当者　　　内容　
	 * 　2006/10/30　01-009　　　　suzuki-t　　変則日画面の戻るボタン押下処理変更
	 *
	*/
	//クリアボタン押下数判定
	if($_POST["clear_count"] == NULL){
		//クリアボタン押下数が０の場合は、二つ前が契約登録画面の為-1をセット
		$clear_count = -1;
	}else{
		//現在の押下数を復元
		$clear_count = $_POST["clear_count"];
	}
	$clear_count--;
	$con_data["clear_count"] = $clear_count;

	$con_data["clear_flg"]      = "";
}

/****************************/
//部品定義
/****************************/
if ($_POST[daiko_page_flg] == "1") {
	$r_url = "2-1-240.php";
}else{
	$r_url = "2-1-104.php";
}

$form->addElement("submit","set","設　定",
    "onClick=\"return Dialogue('設定します。','./$r_url?flg=$flg&client_id=$client_id&contract_id=$get_con_id&c_check=true');\""
	);

$form->addElement("button","kuria","クリア","onClick=\"insert_row('clear_flg');\"");

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/30　01-009　　　　suzuki-t　　変則日画面の戻るボタン押下処理変更
 *
*/
//クリアボタン押下時以外は、一つ前の画面に戻る
if($clear_count == NULL){
	$clear_count = -1;
}
//$form->addElement("button","back","戻　る","onClick=\"SubMenu2('./2-1-104.php?flg=$flg&client_id=$client_id&contract_id=$get_con_id')\"");
$form->addElement("button","back","戻　る","onClick=\"history.go($clear_count)\"");
//クリアボタン押下数
$form->addElement("hidden","clear_count");

/****************************/
//POST情報の値を変更
/****************************/
$form->setConstants($con_data);


//定数の定義(ソースコードを見やすくするために定義)
define('YEAR', 0);
define('MONTH', 1);
define('DAY', 2);

//今日の日付(年、月、日)を$dateへ配列として代入
$date = date('Y n d');
$date = explode(' ', $date);
$date[MONTH] = (int) $date[MONTH]-1;

//-- 2009/06/24 改修No.37 変更 ----------------
// カレンダーの表示年数を変更する
// （表示年数*12ヶ月/表示列数）
$rows = 4;	//表示列数
$line = (($term) * 12 / $rows) + 2;	//表示行数(最高が+2)

// カレンダー表示の最終日を変数に格納
$last_date = date('Ynd', mktime(0, 0, 0, $date[MONTH]+1, 0, $date[YEAR]+$term));

for($m2=1;$m2<$line;$m2++){
//for($m2=1;$m2<7;$m2++){
//---------------------------------------------

	//-- 2009/06/25 改修No.37 変更
	//$calendar .= '<table cellpadding="15"><tr><td valign="top">'."\n";
	$calendar .= '<table cellpadding="15"><tr><td valign="top" width=200>'."\n";
	
	// 表示列数に合わせて繰返す
	for($m1=1;$m1<($rows+1);$m1++){
	//for($m1=1;$m1<5;$m1++){
	//---------

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

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/30　01-004　　　　suzuki-t　　カレンダーを日曜日から始めるように変更
 *
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
*/
		
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

		$calendar .= '<tr><th class=\'Title_Purple\'>日</th><th class=\'Title_Purple\'>月</th><th class=\'Title_Purple\'>火</th><th class=\'Title_Purple\'>水</th><th class=\'Title_Purple\'>木</th><th class=\'Title_Purple\'>金</th><th class=\'Title_Purple\'>土</th></tr>';

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
					++$day;
					#$calendar .= ++$day;
					#$calendar .= "<br>";
					//チェックボックス定義
					$form->addElement('checkbox', "check_".$date[YEAR]."-".$date[MONTH]."-".$day, 'チェックボックス', "<br>"." $day");
					$calendar .= $form->_elements[$form->_elementIndex["check_".$date[YEAR]."-".$date[MONTH]."-".$day]]->toHtml();
				}
				$calendar .= '</td>'."\n";
				$j++;
			}
			$calendar .= '</tr>'."\n";
			$i++;
		}

		//-- 2009/06/25 改修No.37 追加
		//$calendar .= "</table></td><td valign='top'> \n";

		// 現在のカレンダー表示が4列目の場合
		if ($m1 == $rows) {
			$calendar .= "</table></td> \n";
		} else {
			$calendar .= "</table></td><td valign='top' width=200> \n";
		}

		// 12月の場合
		// カレンダー表示を改行する
		if($date[MONTH] == 12) {
			$calendar .= "</td><tr><td colspan=4><hr></td></tr><td valign=top> \n";
			$m1 = $rows; 	//ループ終了 	
		}
		// 現在カレンダー表示された日付と、カレンダー表示最終日が同日の場合
		else if($date[YEAR].$date[MONTH].$day == $last_date) {
			$m1 = $rows;	//ループ終了
		}
		//-----------------------------

	}
	$calendar .= '</tr>'."\n";
}

/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
//	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'calendar'   => "$calendar",
	'onload'     => "$onload",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
