<?php

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "dateForm","POST");

/**************HTMLイメージ作成用部品********************/

//基準日数入力テキスト
$text[] =& $form->createElement("text","t_year","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime','t_year','t_month',1)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text[] =& $form->createElement("static","","","年");
$text[] =& $form->createElement("text","t_month","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime','t_month','t_day',2)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text[] =& $form->createElement("static","","","月");
$text[] =& $form->createElement("text","t_day","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text[] =& $form->createElement("static","","","日");
$form->addGroup( $text, "f_datetime", "f_datetime");

//日付入力テキスト
$text2[] =& $form->createElement("text","t_year","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime2','t_year','t_month',1)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text2[] =& $form->createElement("static","","","年");
$text2[] =& $form->createElement("text","t_month","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"move_text(this.form,'f_datetime2','t_month','t_day',2)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text2[] =& $form->createElement("static","","","月");
$text2[] =& $form->createElement("text","t_day","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text2[] =& $form->createElement("static","","","日");
$form->addGroup( $text2, "f_datetime2", "f_datetime2");

//翌日の日付表示
$text1[] =& $form->createElement("text","t_year","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onkeyup=\"move_text(this.form,'next_date','t_year','t_month',1)\" onFocus=\"Comp_Form_NextToday(this,this.form,'next_date','t_year','t_month','t_day')\" onBlur=\"blurForm(this)\"");
$text1[] =& $form->createElement("static","","","年");
$text1[] =& $form->createElement("text","t_month","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"move_text(this.form,'next_date','t_month','t_day',2)\" onFocus=\"Comp_Form_NextToday(this,this.form,'next_date','t_year','t_month','t_day')\" onBlur=\"blurForm(this)\"");
$text1[] =& $form->createElement("static","","","月");
$text1[] =& $form->createElement("text","t_day","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onFocus=\"Comp_Form_NextToday(this,this.form,'next_date','t_year','t_month','t_day')\" onBlur=\"blurForm(this)\"");
$text1[] =& $form->createElement("static","","","日");
$form->addGroup( $text1, "next_date", "next_date");

//日付表示テキスト
$form->addElement("text","t_display","テキストフォーム",'size="15" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//登録ボタン
$form->addElement("submit","touroku","登　録","onClick=\"javascript: return dialogue('登録します。','#')\"");

//クリアボタン
$form->addElement("submit","reset","クリア");

/**********************登録ボタン押下処理*****************/

if(isset($_POST["touroku"])){
	
	//基準日取得
	$b_year = $_POST["f_datetime"]["t_year"];
	$b_month = $_POST["f_datetime"]["t_month"];
	$b_day = $_POST["f_datetime"]["t_day"];
	//日付取得
	$year = $_POST["f_datetime2"]["t_year"];
	$month = $_POST["f_datetime2"]["t_month"];
	$day = $_POST["f_datetime2"]["t_day"];

	//該当日取得
	$display = Basic_date($b_year,$b_month,$b_day,$year,$month,$day);

	if($display == false){
		$display = "エラー";
	}else{
		$display = $display[0]."週の".$display[1]."日目";
	}

	//POST情報を変更
	$delete_data = array(
		"t_display"     => "$display"
	);
	$form->setConstants($delete_data);

}

/**********************クリアボタン押下処理***************/

if(isset($_POST["reset"])){
	//POST情報を変更
	$delete_data = array(
	    "f_datetime[t_year]"     => "",
		"f_datetime[t_month]"     => "",
		"f_datetime[t_week]"     => "",
		"f_datetime[t_day]"     => "",
		"f_datetime2[t_year]"     => "",
		"f_datetime2[t_month]"     => "",
		"f_datetime2[t_week]"     => "",
		"f_datetime2[t_day]"     => "",
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
