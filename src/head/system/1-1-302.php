<?php

$page_title = "パスワード変更";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB接続
$db_con = Db_Connect();

//セッション開始
session_start();

/****************************/
//外部変数取得
/****************************/
$staff_id      = $_SESSION["staff_id"];


/**************HTMLイメージ作成用部品********************/

//現在のパスワード
$form->addElement("password","password_now","テキストフォーム",'size="24" maxLength="20" onFocus="onForm(this)" onBlur="blurForm(this)"');

//新パスワード
$form->addElement("password","password","テキストフォーム",'size="24" maxLength="20" onFocus="onForm(this)" onBlur="blurForm(this)"');

//新パスワード確認
$form->addElement("password","password_conf","テキストフォーム",'size="24" maxLength="20" onFocus="onForm(this)" onBlur="blurForm(this)"');

//変更ボタン
$form->addElement("submit","touroku","変　更","onClick=\"javascript: return Dialogue4('変更します。');\" $disabled");

/******************エラーチェック定義**********************/

//空文字チェック
$form->addRule( "password_now", "現在のパスワードを入力して下さい。", "required");
$form->addRule( "password", "新しいパスワード は6文字以上20文字以内です。", "required");
$form->addRule( "password_conf", "パスワード確認を入力して下さい。", "required");

//・文字数チェック
$form->addRule('password','パスワード は6文字以上20文字以内です。','rangelength',array(6,20));

//再入力チェック
$form->addRule( array("password","password_conf"),"パスワードとパスワード確認が一致しません。","compare");

/**********************変更ボタン押下処理*****************/

if($_POST["touroku"] == "変　更"){

	/*********************
	//エラー判定（ＰＨＰ）
	**********************/
	$error_flg = false;   //エラー判定フラグ
	//現在のパスワードと比較判定
	$sql = "SELECT password FROM t_login WHERE staff_id = $staff_id;";
	$result = Db_Query($db_con, $sql); 
	$pass_now = pg_fetch_result($result, 0,0);                  //現在のパスワード
	$pass_now_input = crypt($_POST["password_now"],$pass_now);  //入力のパスワード
	if($pass_now_input != $pass_now){
		$error_msg = "現在のパスワードが一致しません。";
		$error_flg = true;
	}

	//チェック判定
	if($form->validate() && $error_flg == false){
		//POST情報取得
		$password = $_POST["password"];
		$password_conf = $_POST["password_conf"];
	
		//パスワードを暗号化する
		$password = crypt($password);

		//DB接続
		Db_Query($db_con, "BEGIN;");
		//パスワード更新SQL
		$sql = "UPDATE t_login SET password = '".$password."' WHERE staff_id = '".$staff_id."';";
		$result = Db_Query($db_con,$sql);
		if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
		Db_Query($db_con, "COMMIT;");
		//POST情報を初期化
		$delete_data = array(
		"password_now"     => "",
	    "password"         => "",
	    "password_conf"    => "",
		);
		$form->setConstants($delete_data);

		//変更完了メッセージ
		$comp_msg = "変更しました。";

	}
}

/*********************************************************/


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
$page_menu = Create_Menu_h('system','3');
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
	'error_msg'     => "$error_msg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
