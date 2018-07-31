<?php
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 *   2016/01/20                amano  Dialogue関数でボタン名が送られない IE11 バグ対応
 */
$page_title = "発注書コメント設定";

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
//外部変数取得
/****************************/
$client_id  = $_SESSION[client_id];

/****************************/
//デフォルト値設定
/****************************/
$sql  = "SELECT ";
$sql .= "o_pattern_id, ";
$sql .= "o_memo1_1, ";		//発注書コメント（郵便１）
$sql .= "o_memo1_2, ";		//発注書コメント（郵便２）
$sql .= "o_memo2, ";		//発注書コメント2
$sql .= "o_memo3, ";		//発注書コメント3
$sql .= "o_memo4, ";		//発注書コメント4
$sql .= "o_memo5, ";		//発注書コメント5
$sql .= "o_memo6, ";		//発注書コメント6
$sql .= "o_memo7, ";		//発注書コメント7
$sql .= "o_memo8, ";		//発注書コメント8
$sql .= "o_memo9, ";		//発注書コメント9
$sql .= "o_memo10, ";		//発注書コメント10
$sql .= "o_memo11, ";		//発注書コメント11
$sql .= "o_memo12, ";		//発注書コメント12
$sql .= "shop_id ";
$sql .= "FROM ";
$sql .= "t_order_sheet ";
$sql .= "WHERE ";
$sql .= "shop_id = $client_id;";

$result = Db_Query($db_con,$sql);
//DBの値を配列に保存
$o_memo = Get_Data($result, 2);

//行の存在判定フラグ
$id_null_flg=false;
//データのNULL判定フラグ
$value_flg=false;
//データ存在判定
if($o_memo[0][0]==null){
	$id_null_flg = true;
}
//新規登録・更新判定
for($c=1;$c<count($o_memo[0]);$c++){
	if($o_memo[0][$c] != null){
		$value_flg = true;
	}
}

$def_fdata = array(
    "form_post[o_memo1_1]"     	=> $o_memo[0][1],
    "form_post[o_memo1_2]"     	=> $o_memo[0][2],
    "o_memo2"      				=> $o_memo[0][3],
    "o_memo3"     				=> $o_memo[0][4],
    "o_memo4"     				=> $o_memo[0][5],
    "o_memo5"     				=> $o_memo[0][6],
	"o_memo6"     				=> $o_memo[0][7],
    "o_memo7"     				=> $o_memo[0][8],
    "o_memo8"     				=> $o_memo[0][9],
    "o_memo9"     				=> $o_memo[0][10],
	"o_memo10"     				=> $o_memo[0][11],
    "o_memo11"     				=> $o_memo[0][12],
	"o_memo12"     				=> $o_memo[0][13]
);
$form->setDefaults($def_fdata);

/****************************/
//部品定義
/****************************/
//郵便番号
$text[] =& $form->createElement("text","o_memo1_1","テキストフォーム","size=\"3\" maxLength=\"3\" onkeyup=\"changeText(this.form,'form_post[o_memo1_1]','form_post[o_memo1_2]',3)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","<font color=black>-</font>");
$text[] =& $form->createElement("text","o_memo1_2","テキストフォーム","size=\"4\" maxLength=\"4\"".$g_form_option."\"");
$form->addGroup( $text, "form_post", "form_post");

//コメント2〜6
for($x=2;$x<=6;$x++){
	$form->addElement("text","o_memo".$x,"テキストフォーム","size=\"32\" maxLength=\"32\" style=\"font-size:12px; font-family: 'ＭＳ ゴシック',monospace;\"".$g_form_option."\"");
}

//コメント7〜12
for($x=7;$x<=12;$x++){
	$form->addElement("text","o_memo".$x,"テキストフォーム","size=\"100\" maxLength=\"92\" style=\"font-size:15px;\"".$g_form_option."\"");
}

//登録ボタン
$form->addElement("submit","new_button","登　録","onClick=\"javascript: return Dialogue('登録します。','#', this)\" $disabled");

//発注書発行ボタン
//$form->addElement("button","order_button","発注書発行","onClick=\"javascript:window.open('".HEAD_DIR."buy/1-3-105.php','_blank','')\"");
$form->addElement("button","order_button","プレビュー","onClick=\"javascript:window.open('".HEAD_DIR."buy/1-3-105.php','_blank','')\"");

/****************************/
//エラーチェック(AddRule)
/****************************/
//◇郵便番号
//・文字数チェック
//・文字種チェック
$form->addGroupRule('form_post', array(
	'o_memo1_1' => array(
		array('郵便番号は半角数字の7桁です。','rangelength',array(3,3)),
		array('郵便番号は半角数字の7桁です。','numeric')
	),
	'o_memo1_2' => array(
		array('郵便番号は半角数字の7桁です。','rangelength',array(4,4)),
		array('郵便番号は半角数字の7桁です。','numeric'),
	)
));

/****************************/
//登録ボタン押下処理
/****************************/
if($_POST["new_button"] == "登　録"){
	$o_memo1_1 = $_POST["form_post"]["o_memo1_1"];		//郵便1
	$o_memo1_2 = $_POST["form_post"]["o_memo1_2"];		//郵便2
	$o_memo2 = $_POST["o_memo2"];						//コメント2
	$o_memo3 = $_POST["o_memo3"];						//コメント3
	$o_memo4 = $_POST["o_memo4"];						//コメント4
	$o_memo5 = $_POST["o_memo5"];						//コメント5
	$o_memo6 = $_POST["o_memo6"];						//コメント6
	$o_memo7 = $_POST["o_memo7"];						//コメント7
	$o_memo8 = $_POST["o_memo8"];						//コメント8
	$o_memo9 = $_POST["o_memo9"];						//コメント9
	$o_memo10 = $_POST["o_memo10"];						//コメント10
	$o_memo11 = $_POST["o_memo11"];						//コメント11
	$o_memo12 = $_POST["o_memo12"];						//コメント12

	//エラーの際には、登録・変更処理を行わない
	if($form->validate()){
		Db_Query($db_con, "BEGIN;");

		//新規登録・更新判定
		if($id_null_flg==true){
			//新規登録完了メッセージ
			$comp_msg = "登録しました。";

			$sql  = "INSERT INTO ";
			$sql .= "t_order_sheet ";
			$sql .= "(o_pattern_id, ";
			$sql .= "o_memo1_1, ";
			$sql .= "o_memo1_2, ";
			$sql .= "o_memo2, ";
			$sql .= "o_memo3, ";
			$sql .= "o_memo4, ";
			$sql .= "o_memo5, ";
			$sql .= "o_memo6, ";
			$sql .= "o_memo7, ";
			$sql .= "o_memo8, ";
			$sql .= "o_memo9, ";
			$sql .= "o_memo10, ";
			$sql .= "o_memo11, ";
			$sql .= "o_memo12, ";
            $sql .= "shop_id) ";
			$sql .= "VALUES(";
            $sql .= "(SELECT COALESCE(MAX(o_pattern_id), 0)+1 FROM t_order_sheet), ";
			$sql .= "'$o_memo1_1', ";
			$sql .= "'$o_memo1_2', ";
			$sql .= "'$o_memo2', ";
			$sql .= "'$o_memo3', ";
			$sql .= "'$o_memo4', ";
			$sql .= "'$o_memo5', ";
			$sql .= "'$o_memo6', ";
			$sql .= "'$o_memo7', ";
			$sql .= "'$o_memo8', ";
			$sql .= "'$o_memo9', ";
			$sql .= "'$o_memo10', ";
			$sql .= "'$o_memo11', ";
			$sql .= "'$o_memo12', ";
			$sql .= "$client_id);";
		}else{
			//行は存在するが、発注書コメントがNULLの場合
			if($value_flg==false){
				//登録完了メッセージ
				$comp_msg = "登録しました。";
			}else{
				//変更完了メッセージ
				$comp_msg = "変更しました。";
			}

			$sql  = "UPDATE ";
			$sql .= "t_order_sheet ";
			$sql .= "SET ";
			$sql .= "o_memo1_1 = '$o_memo1_1', ";
			$sql .= "o_memo1_2 = '$o_memo1_2', ";
			$sql .= "o_memo2 = '$o_memo2', ";
			$sql .= "o_memo3 = '$o_memo3', ";
			$sql .= "o_memo4 = '$o_memo4', ";
			$sql .= "o_memo5 = '$o_memo5', ";
			$sql .= "o_memo6 = '$o_memo6', ";
			$sql .= "o_memo7 = '$o_memo7', ";
			$sql .= "o_memo8 = '$o_memo8', ";
			$sql .= "o_memo9 = '$o_memo9', ";
			$sql .= "o_memo10 = '$o_memo10', ";
			$sql .= "o_memo11 = '$o_memo11', ";
			$sql .= "o_memo12 = '$o_memo12' ";
			$sql .= "WHERE ";
			$sql .= "o_pattern_id = ".$o_memo[0][0].";";
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
	'comp_msg'      => "$comp_msg",
    'auth_r_msg'    => "$auth_r_msg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
