<?php
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 *   2016/01/20                amano  Dialogue関数でボタン名が送られない IE11 バグ対応
 */
$page_title = "注文書フォーマット設定";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//デフォルト値設定
/****************************/
$sql  = "SELECT ";
$sql .= "o_memo1, ";		//FAX
$sql .= "o_memo2, ";		//TEL
$sql .= "o_memo3, ";		//注文書コメント3
$sql .= "o_memo4, ";		//注文書コメント4
$sql .= "o_memo5, ";		//注文書コメント5
$sql .= "o_memo6, ";		//注文書コメント6
$sql .= "o_memo7, ";		//注文書コメント7
$sql .= "o_memo8 ";			//注文書コメント8
$sql .= "FROM ";
$sql .= "t_h_ledger_sheet;";

$result = Db_Query($db_con,$sql);
//DBの値を配列に保存
$o_memo = Get_Data($result, 2);

//行の存在判定フラグ
$id_null_flg=false;
//データのNULL判定フラグ
$value_flg=false;
//データ存在判定
if(pg_num_rows($result)==null){
	$id_null_flg = true;
}
//新規登録・更新判定
for($c=1;$c<count($o_memo[0]);$c++){
	if($o_memo[0][$c] != null){
		$value_flg = true;
	}
}

$def_fdata = array(
    "o_memo1"     	=> $o_memo[0][0],
    "o_memo2"      	=> $o_memo[0][1],
    "o_memo3"     	=> $o_memo[0][2],
    "o_memo4"     	=> $o_memo[0][3],
    "o_memo5"     	=> $o_memo[0][4],
	"o_memo6"     	=> $o_memo[0][5],
    "o_memo7"     	=> $o_memo[0][6],
    "o_memo8"     	=> $o_memo[0][7]
);
$form->setDefaults($def_fdata);

/****************************/
//部品定義
/****************************/

//FAX
$form->addElement("text","o_memo1","テキストフォーム","size=\"13\" maxLength=\"13\" style=\"font-size:14px;\"".$g_form_option."\"");
//TEL
$form->addElement("text","o_memo2","テキストフォーム","size=\"13\" maxLength=\"13\" style=\"font-size:12px;\"".$g_form_option."\"");

//コメント3〜8
for($x=3;$x<=8;$x++){
	$form->addElement("text","o_memo".$x,"テキストフォーム","size=\"140\" maxLength=\"124\" style=\"font-size:10px;\"".$g_form_option."\"");
}

//登録ボタン
$form->addElement("submit","new_button","登　録","onClick=\"javascript: return Dialogue('登録します。','#', this)\" $disabled");

//注文書発行ボタン
//$form->addElement("button","order_button","注文書発行","onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-308.php','_blank','')\"");
$form->addElement("button","order_button","プレビュー","onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-308.php','_blank','')\"");

/****************************/
//登録ボタン押下処理
/****************************/
if($_POST["new_button"] == "登　録"){
	$o_memo1 = $_POST["o_memo1"];				//FAX
	$o_memo2 = $_POST["o_memo2"];				//TEL
	$o_memo3 = $_POST["o_memo3"];				//注文書コメント3
	$o_memo4 = $_POST["o_memo4"];				//注文書コメント4
	$o_memo5 = $_POST["o_memo5"];				//注文書コメント5
	$o_memo6 = $_POST["o_memo6"];				//注文書コメント6
	$o_memo7 = $_POST["o_memo7"];				//注文書コメント7
	$o_memo8 = $_POST["o_memo8"];				//注文書コメント8

	/****************************/
	//エラーチェック(PHP)
	/****************************/
	//■FAX
	//●半角数字と「-」以外はエラー
	if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$o_memo1)){
		$error_fax_msg = "FAXは数値と「-」のみ使用可能です。";
	}
	//■TEL
	//●半角数字と「-」以外はエラー
	if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$o_memo2)){
		$error_tel_msg = "TELは数値と「-」のみ使用可能です。";
	}
	//エラーの際には、登録・変更処理を行わない
	if($error_fax_msg==null && $error_tel_msg==null){
		Db_Query($db_con, "BEGIN;");

		//新規登録・更新判定
		if($id_null_flg==true){
			//登録完了メッセージ
			$comp_msg = "登録しました。";

			$sql  = "INSERT INTO ";
			$sql .= "t_h_ledger_sheet ";
			$sql .= "(o_memo1,";
			$sql .= "o_memo2,";
			$sql .= "o_memo3,";
			$sql .= "o_memo4,";
			$sql .= "o_memo5,";
			$sql .= "o_memo6,";
			$sql .= "o_memo7,";
			$sql .= "o_memo8) ";
			$sql .= "VALUES(";
			$sql .= "'$o_memo1',";
			$sql .= "'$o_memo2',";
			$sql .= "'$o_memo3',";
			$sql .= "'$o_memo4',";
			$sql .= "'$o_memo5',";
			$sql .= "'$o_memo6',";
			$sql .= "'$o_memo7',";
			$sql .= "'$o_memo8');";
		}else{
			//行は存在するが、注文書コメントがNULLの場合
			if($value_flg==false){
				//登録完了メッセージ
				$comp_msg = "登録しました。";
			}else{
				//変更完了メッセージ
				$comp_msg = "変更しました。";
			}

			$sql  = "UPDATE ";
			$sql .= "t_h_ledger_sheet ";
			$sql .= "SET ";
			$sql .= "o_memo1 = '$o_memo1', ";
			$sql .= "o_memo2 = '$o_memo2', ";
			$sql .= "o_memo3 = '$o_memo3', ";
			$sql .= "o_memo4 = '$o_memo4', ";
			$sql .= "o_memo5 = '$o_memo5', ";
			$sql .= "o_memo6 = '$o_memo6', ";
			$sql .= "o_memo7 = '$o_memo7', ";
			$sql .= "o_memo8 = '$o_memo8';";
		}

		$result = Db_Query($db_con,$sql);
		if($result == false){
			Db_Query($db_con,"ROLLBACK;");
			exit;
		}
		Db_Query($db_con, "COMMIT;");
	}
}


/****************************/
//HTMLヘッダ
/****************************/
//$html_header = Html_Header($page_title);
$html_header = Html_Header($page_title, "amenity.js", "global.css", "slip.css");

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_h('system','2');
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
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'comp_msg'   	=> "$comp_msg",
	'error_tel_msg' => "$error_tel_msg",
	'error_fax_msg' => "$error_fax_msg",
    'auth_r_msg'    => "$auth_r_msg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
