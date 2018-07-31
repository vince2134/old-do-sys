<?php
$page_title = "請求書一括発行";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
// フォームパーツ作成
/****************************/
// 出力形式
$form_output_type[] =& $form->createElement("radio", null, null, "画面", "1");
$form_output_type[] =& $form->createElement("radio", null, null, "帳票", "2");
$form_output_type[] =& $form->createElement("radio", null, null, "CSV", "3");
$form->addGroup($form_output_type, "form_output_type", "");

// 請求番号
$form->addElement(
            "text", "form_bill_no", "", "size=\"10\" maxLength=\"8\" 
            style=\"$g_form_style\" 
            $g_form_option"
);

// 請求締日
$form_close_sday[] =& $form->createElement(
            "text", "y", "", "size=\"4\" maxLength=\"4\" 
            style=\"$g_form_style\" 
            onkeyup=\"changeText5(this.form,1)\" 
            $g_form_option"
);
$form_close_sday[] =& $form->createElement("text", "m", "", "size=\"1\" maxLength=\"2\"
            style=\"$g_form_style\" 
            onkeyup=\"changeText6(this.form,1)\" 
            $g_form_option"
);
$form_close_sday[] =& $form->createElement(
            "text", "d", "", "size=\"1\" maxLength=\"2\" 
            style=\"$g_form_style\" 
            onkeyup=\"changeText7(this.form,1)\" 
            $g_form_option"
);
$form->addGroup($form_close_sday, "form_close_sday", "","-");

$form_close_eday[] =& $form->createElement(
            "text", "y", "", "size=\"4\" maxLength=\"4\" 
            style=\"$g_form_style\" 
            onkeyup=\"changeText8(this.form,1)\" 
            $g_form_option"
);
$form_close_eday[] =& $form->createElement(
            "text", "m", "", "size=\"1\" maxLength=\"2\" 
            style=\"$g_form_style\" 
            onkeyup=\"changeText9(this.form,1)\" 
            $g_form_option"
);
$form_close_eday[] =& $form->createElement(
            "text", "d", "", "size=\"1\" maxLength=\"2\" 
            style=\"$g_form_style\" 
            $g_form_option"
);
$form->addGroup( $form_close_eday, "form_close_eday", "", "-");

// 回収予定日
$form_collect_sday[] =& $form->createElement(
            "text", "y", "", "size=\"4\" maxLength=\"4\" 
            style=\"$g_form_style\" 
            onkeyup=\"changeText5(this.form,2)\" 
            $g_form_option"
);
$form_collect_sday[] =& $form->createElement(
            "text", "m", "", "size=\"1\" maxLength=\"2\" 
            style=\"$g_form_style\" 
            onkeyup=\"changeText6(this.form,2)\" 
            $g_form_option"
);
$form_collect_sday[] =& $form->createElement(
            "text", "d", "", "size=\"1\" maxLength=\"2\" 
            stlye=\"$g_form_style\" 
            onkeyup=\"changeText7(this.form,2)\" 
            $g_form_option"
);
$form->addGroup($form_collect_sday, "form_collect_sday", "", "-");

$form_collect_eday[] =& $form->createElement(
            "text", "y", "", "size=\"4\" maxLength=\"4\" 
            style=\"$g_form_style\" 
            onkeyup=\"changeText8(this.form,2)\" 
            $g_form_option"
);
$form_collect_eday[] =& $form->createElement(
            "text", "m", "", "size=\"1\" maxLength=\"2\" 
            style=\"$g_form_style\" 
            onkeyup=\"changeText9(this.form,2)\" 
            $g_form_option"
);
$form_collect_eday[] =& $form->createElement(
            "text", "d", "", "size=\"1\" maxLength=\"2\" 
            $g_form_option"

);
$form->addGroup( $form_collect_eday, "form_collect_eday", "", "-");

// 請求先コード
$form_claim_cd[] =& $form->createElement(
            "text", "cd1", "請求先コード１", "size=\"7\" maxLength=\"6\" 
            style=\"$g_form_style\" 
            onkeyup=\"changeText1(this.form,1)\" 
            $g_form_option"
);
$form_claim_cd[] =& $form->createElement(
            "text", "cd2", "", "size=\"4\" maxLength=\"4\" 
            style=\"$g_form_style\" 
            $g_form_option"
);
$form->addGroup( $form_claim_cd, "form_claim_cd", "請求先コード");

// 請求先名
$form->addElement(
            "text", "form_claim_name", "", 
            "size=\"34\" maxLength=\"15\" 
            $g_form_option"
);

// 請求金額
$form_bill_amount[] =& $form->createElement(
            "text", "min", "", "size=\"11\" maxLength=\"9\" 
            onkeyup=\"changeText12(this.form,1)\" 
            $g_form_option style=\"text-align: right; 
            $g_form_style\""
);
$form_bill_amount[] =& $form->createElement(
            "text", "max", "", "size=\"11\" maxLength=\"9\" 
            $g_form_option 
            style=\"text-align: right; $g_form_style\""
);
$form->addGroup( $form_bill_amount, "form_bill_amount", "", "-");

// 担当者
$select_value = Select_Get($db_con, "staff", null, true);
$form->addElement("select", "form_staff", "セレクトボックス", $select_value, $g_form_option_select);

// 請求書閲覧(FC)
$form_show_type[] =& $form->createElement("radio", null, null, "指定なし", "1");
$form_show_type[] =& $form->createElement("radio", null, null, "表示済", "2");
$form_show_type[] =& $form->createElement("radio", null, null, "未表示", "3");
$form->addGroup($form_show_type, "form_show_type", "閲覧");

// 請求先送付
$form_send_type[] =& $form->createElement("radio", null, null, "指定なし","1");
$form_send_type[] =& $form->createElement("radio", null, null, "郵送","2");
$form_send_type[] =& $form->createElement("radio", null, null, "メール","3");
$form_send_type[] =& $form->createElement("radio", null, null, "WEB","4");
$form_send_type[] =& $form->createElement("radio", null, null, "郵送・メール","5");
$form->addGroup($form_send_type, "form_send_type", "");

// 確定作業
$form_conf_type[] =& $form->createElement("radio", null, null, "指定なし","1");
$form_conf_type[] =& $form->createElement("radio", null, null, "実施済","2");
$form_conf_type[] =& $form->createElement("radio", null, null, "未実施","3");
$form->addGroup($form_conf_type, "form_conf_type", "確認作業");

// 表示ボタン
$form->addElement(
        "submit", "form_show_button", "表　示",
        "onClick=\"javascript:window.open('".HEAD_DIR."sale/1-2-302.php','_blank','')\""
);

// クリアボタン
$form->addElement(
        "button", "form_clear_button", "クリア", 
        "onClick=\"javascript:SubMenu2('$_SERVER[PHP_SELF]')\""
);

// 請求書発行ALL
$check8[] =& $form->createElement(
        "checkbox", "allcheck8", "請求書発行ALL", "請求書発行", "onClick=\"javascript:Allcheck(8)\""
);
$form->addGroup( $check8, "allcheck8", "請求書発行");

// 請求書発行
$check8_1[] =& $form->createElement("checkbox", "check", "請求書発行", "");
$form->addGroup( $check8_1, "check8", "請求書発行");

// 請求書発行ボタン
$form->addElement(
        "submit", "request", "請求書発行", 
        "onClick=\"javascript:window.open('".HEAD_DIR."sale/1-2-305.php','_blank','')\""
);

/*
$def_fdata = array(
    "f_r_output"    => "1",
    "f_r_output9"   => "1",
    "f_radio11"     => "1"
);

$form->setDefaults($def_fdata);

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
$page_menu = Create_Menu_h('sale','3');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);


/****************************/
//ページ作成
/****************************/
//仮の件数
$total_count = 100;

//表示範囲指定
$range = "20";

//ページ数を取得
$page_count = $_POST["f_page1"];

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);



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
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
