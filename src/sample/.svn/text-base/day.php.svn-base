<?php

$page_title = "日付入力";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "dateForm","POST");

/**************HTMLイメージ作成用部品********************/

//日付入力テキスト
$text[] =& $form->createElement("text","t_year","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime','t_year','t_month',1)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");

$text[] =& $form->createElement("static","","","年");

$text[] =& $form->createElement("text","t_month","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime','t_month','t_week',2)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");

$text[] =& $form->createElement("static","","","月　");
$text[] =& $form->createElement("static","","","第");

$text[] =& $form->createElement("text","t_week","テキストフォーム","size=\"2\" maxLength=\"1\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime','t_week','t_day',3)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");

$text[] =& $form->createElement("static","","","　");

$text[] =& $form->createElement("text","t_day","テキストフォーム","size=\"2\" maxLength=\"1\" value=\"\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");

$text[] =& $form->createElement("static","","","曜日");

$form->addGroup( $text, "f_datetime", "f_datetime");

//日付表示テキスト
$form->addElement("text","t_display","テキストフォーム","size=\"15\" maxLength=\"5\" value=\"\" readonly");

//登録ボタン
$form->addElement("submit","touroku","登　録","onClick=\"javascript: return dialogue('登録します。','#')\"");

//クリアボタン
$form->addElement("submit","reset","クリア");

/******************エラーチェック定義**********************/

//必須入力チェック
$form->addGroupRule('f_datetime', array(
	't_year' => array(
		array('年は必須項目です！！', 'required')
	),
	't_month' => array(
		array('月は必須項目です！！','required')
	),
	't_week' => array(
		array('週は必須項目です！！','required')
	),
	't_day' => array(
		array('曜日は必須項目です！！','required')
	)
));

/******************フィルター定義***************************/

//全要素にtrimフィルターを適用
$form->applyFilter('__ALL__','trim');
//タグ無効
$form->applyFilter('__ALL__','htmlspecialchars');
//￥マークを取り除く
$form->applyFilter('__ALL__','stripslashes');


/**********************登録ボタン押下処理*****************/

if(isset($_POST["touroku"])){
	
	//チェック判定
	if($form->validate()){
		
		//POST情報取得
		$year = $_POST["f_datetime"]["t_year"];
		$month = $_POST["f_datetime"]["t_month"];
		$week = $_POST["f_datetime"]["t_week"];
		$day = $_POST["f_datetime"]["t_day"];

		//該当日取得
		$display = Day_Get($year,$month,$week,$day);

		if($display == false){
			$display = "該当日なし";
		}else{
			$display = $display."日";
		}

		//POST情報を変更
		$delete_data = array(
			"t_display"     => "$display"
		);
		$form->setConstants($delete_data);
	}
}

/**********************クリアボタン押下処理***************/

if(isset($_POST["reset"])){
	//POST情報を変更
	$delete_data = array(
	    "f_datetime[t_year]"     => "",
		"f_datetime[t_month]"     => "",
		"f_datetime[t_week]"     => "",
		"f_datetime[t_day]"     => "",
		"t_display"     => ""
	);
	$form->setConstants($delete_data);
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

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'html_footer'   => "$html_footer",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
