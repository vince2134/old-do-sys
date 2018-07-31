<?php

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/23　なし　　　　yamanaka-s　　表示ボタンクリックのときにみるPOST情報を変更
 * 　2006/10/23　なし　　　　yamanaka-s　　支払予定一覧の処理削除忘れをコメントアウト
 * 　2006/10/23　なし　　　　yamanaka-s　　回収予定額を修正
 * 　2006/10/26　なし　　　　yamanaka-s　　回収予定額がマイナスの場合は「0」と表示するようにSQLを修正
 * 　2006/12/07　bun_0054　　suzuki　　　　日付をゼロ埋め
 *
 */

$page_title = "回収予定一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

$group_kind= $_SESSION["group_kind"];

//DB接続
$db_con = Db_Connect();

/****************************/
//外部変数取得
/****************************/

/****************************/
//デフォルト値設定
/****************************/
$def_fdata = array(
    "f_account_class"       => "0"
);
$form->setDefaults($def_fdata);

$def_fdata = array(
    "f_pay_way"           => "0"
);
$form->setDefaults($def_fdata);

$def_fdata = array(
    "show_number"           => "2"
);
$form->setDefaults($def_fdata);
/****************************/
//部品定義
/****************************/
//回収予定日
$collect_day = null;
$collect_day[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'f_collect_day[y_start]','f_collect_day[m_start]',4)\" onFocus=\"onForm_today(this,this.form,'f_collect_day[y_start]','f_collect_day[m_start]','f_collect_day[d_start]')\" onBlur=\"blurForm(this)\"");
$collect_day[] =& $form->createElement("static", "", "", "-");
$collect_day[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'f_collect_day[m_start]','f_collect_day[d_start]',2)\" onFocus=\"onForm_today(this,this.form,'f_collect_day[y_start]','f_collect_day[m_start]','f_collect_day[d_start]')\" onBlur=\"blurForm(this)\"");
$collect_day[] =& $form->createElement("static", "", "", "-");
$collect_day[] =& $form->createElement("text", "d_start", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'f_collect_day[y_start]','f_collect_day[m_start]','f_collect_day[d_start]')\" onBlur=\"blurForm(this)\"");
$collect_day[] =& $form->createElement("static", "", "", "　〜　");
$collect_day[] =& $form->createElement("text", "y_end", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'f_collect_day[y_end]','f_collect_day[m_end]',4)\" onFocus=\"onForm_today(this,this.form,'f_collect_day[y_end]','f_collect_day[m_end]','f_collect_day[d_end]')\" onBlur=\"blurForm(this)\"");
$collect_day[] =& $form->createElement("static", "", "", "-");
$collect_day[] =& $form->createElement("text", "m_end", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'f_collect_day[m_end]','f_collect_day[d_end]',2)\" onFocus=\"onForm_today(this,this.form,'f_collect_day[y_end]','f_collect_day[m_end]','f_collect_day[d_end]')\" onBlur=\"blurForm(this)\"");
$collect_day[] =& $form->createElement("static", "", "", "-");
$collect_day[] =& $form->createElement("text", "d_end", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'f_collect_day[y_end]','f_collect_day[m_end]','f_collect_day[d_end]')\" onBlur=\"blurForm(this)\"");
$form->addGroup($collect_day, "f_collect_day", "回収予定日");

//請求締日
$bill_close_day_this = null;
$bill_close_day_this[] =& $form->createElement("text", "y_start", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'f_bill_close_day_this[y_start]','f_bill_close_day_this[m_start]',4)\" onFocus=\"onForm_today(this,this.form,'f_bill_close_day_this[y_start]','f_bill_close_day_this[m_start]','f_bill_close_day_this[d_start]')\" onBlur=\"blurForm(this)\"");
$bill_close_day_this[] =& $form->createElement("static", "", "", "-");
$bill_close_day_this[] =& $form->createElement("text", "m_start", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'f_bill_close_day_this[m_start]','f_bill_close_day_this[d_start]',2)\" onFocus=\"onForm_today(this,this.form,'f_bill_close_day_this[y_start]','f_bill_close_day_this[m_start]','f_bill_close_day_this[d_start]')\" onBlur=\"blurForm(this)\"");
$bill_close_day_this[] =& $form->createElement("static", "", "", "-");
$bill_close_day_this[] =& $form->createElement("text", "d_start", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'f_bill_close_day_this[y_start]','f_bill_close_day_this[m_start]','f_bill_close_day_this[d_start]')\" onBlur=\"blurForm(this)\"");
$bill_close_day_this[] =& $form->createElement("static", "", "", "　〜　");
$bill_close_day_this[] =& $form->createElement("text", "y_end", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'f_bill_close_day_this[y_end]','f_bill_close_day_this[m_end]',4)\" onFocus=\"onForm_today(this,this.form,'f_bill_close_day_this[y_end]','f_bill_close_day_this[m_end]','f_bill_close_day_this[d_end]')\" onBlur=\"blurForm(this)\"");
$bill_close_day_this[] =& $form->createElement("static", "", "", "-");
$bill_close_day_this[] =& $form->createElement("text", "m_end", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'f_bill_close_day_this[m_end]','f_bill_close_day_this[d_end]',2)\" onFocus=\"onForm_today(this,this.form,'f_bill_close_day_this[y_end]','f_bill_close_day_this[m_end]','f_bill_close_day_this[d_end]')\" onBlur=\"blurForm(this)\"");
$bill_close_day_this[] =& $form->createElement("static", "", "", "-");
$bill_close_day_this[] =& $form->createElement("text", "d_end", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onFocus=\"onForm_today(this,this.form,'f_bill_close_day_this[y_end]','f_bill_close_day_this[m_end]','f_bill_close_day_this[d_end]')\" onBlur=\"blurForm(this)\"");
$form->addGroup($bill_close_day_this, "f_bill_close_day_this", "請求締日");

// 請求先コード
$claim_cd[] =& $form->createElement("text", "claim_cd_1", "請求先コード１", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'f_claim_cd[claim_cd_1]','f_claim_cd[claim_cd_2]',6)\" $g_form_option");
$claim_cd[] =& $form->createElement("static", "", "", "-");
$claim_cd[] =& $form->createElement("text", "claim_cd_2", "請求先コード２", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $claim_cd, "f_claim_cd", "請求先コード");

// 請求先名
$form->addElement("text", "f_claim_name", "請求先名", "size=\"34\" maxLength=\"20\" $g_form_option");

// 銀行コード
$form->addElement("text", "f_bank_cd", "銀行コード", "size=\"5\" maxLength=\"4\" $g_form_option");

// 銀行名
$form->addElement("text", "f_bank_name", "銀行名", "size=\"34\" maxLength=\"15\" $g_form_option");

// 支店コード
$form->addElement("text", "f_branch_cd", "支店コード", "size=\"3\" maxLength=\"3\" $g_form_option");

// 支店名
$form->addElement("text", "f_branch_name", "支店名", "size=\"34\" maxLength=\"15\" $g_form_option");

// 預金種目
$f_account[] =& $form->createElement( "radio",NULL,NULL, "指定なし","0");
$f_account[] =& $form->createElement( "radio",NULL,NULL, "普通","1");
$f_account[] =& $form->createElement( "radio",NULL,NULL, "当座","2");
$form->addGroup($f_account, "f_account_class", "預金種目");

// 口座番号
$form->addElement("text", "f_bank_account", "口座番号", "size=\"8\" maxLength=\"7\" $g_form_option");

// 請求番号
$form->addElement("text", "f_bill_no", "請求番号", "size=\"9\" maxLength=\"8\" $g_form_option");

// 集金方法
$number=array(
              "0"=>"指定なし",
              "1"=>"自動引落",
              "2"=>"振込",
              "3"=>"訪問集金",
              "4"=>"その他");
$form->addElement("select","f_pay_way","集金方法",$number,$g_form_option_select);

//表示件数
$number=array(
              "1"=>"10",
              "2"=>"50",
              "3"=>"100",
              "4"=>"全て");
$form->addElement("select","show_number","",$number,$g_form_option_select);

//表示ボタン
$form->addElement("submit", "show_button", "表　示");

//クリアボタン
$form->addElement("button", "clear_button", "クリア", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

//hidden
$form->addElement("hidden","form_h_f_collect_day_s");
$form->addElement("hidden","form_h_f_collect_day_e");
$form->addElement("hidden","form_h_f_bill_close_day_this_s");
$form->addElement("hidden","form_h_f_bill_close_day_this_e");
$form->addElement("hidden","form_h_f_claim_cd1");
$form->addElement("hidden","form_h_f_claim_cd2");
$form->addElement("hidden","form_h_f_claim_name");
$form->addElement("hidden","form_h_f_bank_cd");
$form->addElement("hidden","form_h_f_bank_name");
$form->addElement("hidden","form_h_f_branch_cd");
$form->addElement("hidden","form_h_f_branch_name");
$form->addElement("hidden","form_h_f_claim_name");
$form->addElement("hidden","form_h_f_account_class");
$form->addElement("hidden","form_h_f_bill_no");
$form->addElement("hidden","form_h_f_pay_way");
$form->addElement("hidden","form_h_show_number");

/*****************************/
//初期値設定
/*****************************/
$const_data["form_h_f_collect_day_s"] = "0000-00-00";
$const_data["form_h_f_collect_day_e"] = "0000-00-00";
$const_data["form_h_f_bill_close_day_this_s"] = "0000-00-00";
$const_data["form_h_f_bill_close_day_this_e"] = "0000-00-00";
$const_data["form_h_f_claim_cd1"] = null;
$const_data["form_h_f_claim_cd2"] = null;
$const_data["form_h_f_claim_name"] = null;
$const_data["form_h_f_bank_cd"] = null;
$const_data["form_h_f_bank_name"] = null;
$const_data["form_h_f_branch_cd"] = null;
$const_data["form_h_f_branch_name"] = null;
$const_data["form_h_f_account_class"] = null;
$const_data["form_h_f_bank_account"] = null;
$const_data["form_h_f_bill_no"] = null;
$const_data["form_h_f_pay_way"] = null;
$const_data["form_h_show_number"] = null;
$form->setDefaults($const_data);

/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["show_button"] == "表　示"){
	/****************************/
	//エラーチェック
	/****************************/
	$collect_day["y_s"] = $_POST["f_collect_day"]["y_start"];
	$collect_day["m_s"] = $_POST["f_collect_day"]["m_start"];
	$collect_day["d_s"] = $_POST["f_collect_day"]["d_start"];
	$collect_day["y_e"] = $_POST["f_collect_day"]["y_end"];
	$collect_day["m_e"] = $_POST["f_collect_day"]["m_end"];
	$collect_day["d_e"] = $_POST["f_collect_day"]["d_end"];

	$bill_close_day_this["y_s"] = $_POST["f_bill_close_day_this"]["y_start"];
	$bill_close_day_this["m_s"] = $_POST["f_bill_close_day_this"]["m_start"];
	$bill_close_day_this["d_s"] = $_POST["f_bill_close_day_this"]["d_start"];
	$bill_close_day_this["y_e"] = $_POST["f_bill_close_day_this"]["y_end"];
	$bill_close_day_this["m_e"] = $_POST["f_bill_close_day_this"]["m_end"];
	$bill_close_day_this["d_e"] = $_POST["f_bill_close_day_this"]["d_end"];

	//●日付の妥当性チェック
	//回収予定日
	$form->addGroupRule('f_collect_day', array(
	   'y_start' => array(
	          array('回収予定日の日付は妥当ではありません。', 'numeric')
	          ),      
	   'm_start' => array(
	          array('回収予定日の日付は妥当ではありません。', 'numeric')
	          ),       
	   'd_start' => array(
	          array('回収予定日の日付は妥当ではありません。', 'numeric')
	          ),
	   'y_end' => array(
	          array('回収予定日の日付は妥当ではありません。', 'numeric')
	          ),      
	   'm_end' => array(
	          array('回収予定日の日付は妥当ではありません。', 'numeric')
	          ),       
	   'd_end' => array(
	          array('回収予定日の日付は妥当ではありません。', 'numeric')
	          )       
	));
	if(($collect_day["y_s"] != null || $collect_day["m_s"] != null || $collect_day["d_s"] != null)
	        &&      
	   ($collect_day["y_s"] == null || $collect_day["m_s"] == null || $collect_day["d_s"] == null)){ 
	   $form->setElementError("f_collect_day", "回収予定日の日付は妥当ではありません。");
	   $err_flg = true;
	}elseif($collect_day["y_s"] != null && $collect_day["m_s"] != null && $collect_day["d_s"] != null){
	   $collect_day_err = false;
	  if(!checkdate((int)$collect_day["m_s"], (int)$collect_day["d_s"], (int)$collect_day["y_s"]) && $collect_day_err === false){ 
	   $form->setElementError("f_collect_day", "回収予定日の日付は妥当ではありません。");
	   $err_flg = true;
	  }
	}
	if(($collect_day["y_e"] != null || $collect_day["m_e"] != null || $collect_day["d_e"] != null)
	        &&      
	   ($collect_day["y_e"] == null || $collect_day["m_e"] == null || $collect_day["d_e"] == null)){ 
	   $form->setElementError("f_collect_day", "回収予定日の日付は妥当ではありません。");
	   $err_flg = true;
	}elseif($collect_day["y_e"] != null && $collect_day["m_e"] != null && $collect_day["d_e"] != null){
	   $collect_day_err = false;
	  if(!checkdate((int)$collect_day["m_e"], (int)$collect_day["d_e"], (int)$collect_day["y_e"]) && $collect_day_err === false){ 
	   $form->setElementError("f_collect_day", "回収予定日の日付は妥当ではありません。");
	   $err_flg = true;
	  }
	}

	//請求締日
	$form->addGroupRule('f_bill_close_day_this', array(
	   'y_start' => array(
	          array('請求締日の日付は妥当ではありません。', 'numeric')
	          ),
	   'm_start' => array(
	          array('請求締日の日付は妥当ではありません。', 'numeric')
	          ),
	   'd_start' => array(
	          array('請求締日の日付は妥当ではありません。', 'numeric')
	          ),
	   'y_end' => array(
	          array('請求締日の日付は妥当ではありません。', 'numeric')
	          ),
	   'm_end' => array(
	          array('請求締日の日付は妥当ではありません。', 'numeric')
	          ),
	   'd_end' => array(
	          array('請求締日の日付は妥当ではありません。', 'numeric')
	          )
	));
	if(($bill_close_day_this["y_s"] != null || $bill_close_day_this["m_s"] != null || $bill_close_day_this["d_s"] != null)
	        &&
	   ($bill_close_day_this["y_s"] == null || $bill_close_day_this["m_s"] == null || $bill_close_day_this["d_s"] == null)){ 
	   $form->setElementError("f_bill_close_day_this", "請求締日の日付は妥当ではありません。");
	   $err_flg = true;
	}elseif($bill_close_day_this["y_s"] != null && $bill_close_day_this["m_s"] != null && $bill_close_day_this["d_s"] != null){
	   $bill_close_day_this_err = false;
	  if(!checkdate((int)$bill_close_day_this["m_s"], (int)$bill_close_day_this["d_s"], (int)$bill_close_day_this["y_s"]) && $bill_close_day_this_err === false){ 
	   $form->setElementError("f_bill_close_day_this", "請求締日の日付は妥当ではありません。");
	   $err_flg = true;
	  }
	}
	if(($bill_close_day_this["y_e"] != null || $bill_close_day_this["m_e"] != null || $bill_close_day_this["d_e"] != null)
	        &&
	   ($bill_close_day_this["y_e"] == null || $bill_close_day_this["m_e"] == null || $bill_close_day_this["d_e"] == null)){ 
	   $form->setElementError("f_bill_close_day_this", "請求締日の日付は妥当ではありません。");
	   $err_flg = true;
	}elseif($bill_close_day_this["y_e"] != null && $bill_close_day_this["m_e"] != null && $bill_close_day_this["d_e"] != null){
	   $bill_close_day_this_err = false;
	  if(!checkdate((int)$bill_close_day_this["m_e"], (int)$bill_close_day_this["d_e"], (int)$bill_close_day_this["y_e"]) && $bill_close_day_this_err === false){ 
	   $form->setElementError("f_bill_close_day_this", "請求締日の日付は妥当ではありません。");
	   $err_flg = true;
	  }
	}

	if ($form->validate() == true){
		$collect_sday  = str_pad($_POST["f_collect_day"]["y_start"],4,"0",STR_PAD_LEFT);
		$collect_sday .= "-"; 
		$collect_sday .= str_pad($_POST["f_collect_day"]["m_start"],2,"0",STR_PAD_LEFT);
		$collect_sday .= "-";
		$collect_sday .= str_pad($_POST["f_collect_day"]["d_start"],2,"0",STR_PAD_LEFT);
		$collect_eday  = str_pad($_POST["f_collect_day"]["y_end"],4,"0",STR_PAD_LEFT);
		$collect_eday .= "-";                                    
		$collect_eday .= str_pad($_POST["f_collect_day"]["m_end"],2,"0",STR_PAD_LEFT);
		$collect_eday .= "-";                                    
		$collect_eday .= str_pad($_POST["f_collect_day"]["d_end"],2,"0",STR_PAD_LEFT);
		$bill_close_sday_this = str_pad($_POST["f_bill_close_day_this"]["y_start"],4,"0",STR_PAD_LEFT);
		$bill_close_sday_this .= "-"; 
		$bill_close_sday_this .= str_pad($_POST["f_bill_close_day_this"]["m_start"],2,"0",STR_PAD_LEFT);
		$bill_close_sday_this .= "-";
		$bill_close_sday_this .= str_pad($_POST["f_bill_close_day_this"]["d_start"],2,"0",STR_PAD_LEFT);
		$bill_close_eday_this = str_pad($_POST["f_bill_close_day_this"]["y_end"],4,"0",STR_PAD_LEFT);
		$bill_close_eday_this .= "-"; 
		$bill_close_eday_this .= str_pad($_POST["f_bill_close_day_this"]["m_end"],2,"0",STR_PAD_LEFT);
		$bill_close_eday_this .= "-";
		$bill_close_eday_this .= str_pad($_POST["f_bill_close_day_this"]["d_end"],2,"0",STR_PAD_LEFT);
		$claim_cd1 = $_POST["f_claim_cd"]["claim_cd_1"];
		$claim_cd2 = $_POST["f_claim_cd"]["claim_cd_2"];
		$claim_name = $_POST["f_claim_name"];
		$bank_cd = $_POST["f_bank_cd"];
		$bank_name = $_POST["f_bank_name"];
		$branch_cd = $_POST["f_branch_cd"];
		$branch_name = $_POST["f_branch_name"];
		$account_class = $_POST["f_account_class"];
		$bank_account = $_POST["f_bank_account"];
		$bill_no = $_POST["f_bill_no"];
		$pay_way = $_POST["f_pay_way"];
		$show_number = $_POST["show_number"];//表示件数

		$def_data["form_h_f_collect_day_s"] = stripslashes($collect_sday);
		$def_data["form_h_f_collect_day_e"] = stripslashes($collect_eday);
		$def_data["form_h_f_bill_close_day_this_s"] = stripslashes($bill_close_sday_this);
		$def_data["form_h_f_bill_close_day_this_e"] = stripslashes($bill_close_eday_this);
		$def_data["form_h_f_claim_cd1"] = stripslashes($claim_cd1);
		$def_data["form_h_f_claim_cd2"] = stripslashes($claim_cd2);
		
		/*	参照しているPOST情報とPOSTに詰める情報に食違いがあるため修正	2006-10/23	yamanaka-s
		$def_data["form_h_f_claim_name"] = stripslashes($claim_name);
		$def_data["form_h_f_bank_cd"] = stripslashes($bank_cd);
		$def_data["form_h_f_bank_name"] = stripslashes($bank_name);
		$def_data["form_h_f_branch_cd"] = stripslashes($branch_cd);
		$def_data["form_h_f_branch_name"] = stripslashes($branch_name);
		$def_data["form_h_f_account_class"] = stripslashes($account_class);
		$def_data["form_h_f_bank_account"] = stripslashes($bank_account);
		$def_data["form_h_f_bill_no"] = stripslashes($bill_no);
		$def_data["form_h_f_pay_way"] = stripslashes($pay_way);
		$def_data["form_h_show_number"] = stripslashes($show_number);
		*/
		
		$def_data["f_claim_name"] = stripslashes($claim_name);
		$def_data["f_bank_cd"] = stripslashes($bank_cd);
		$def_data["f_bank_name"] = stripslashes($bank_name);
		$def_data["f_branch_cd"] = stripslashes($branch_cd);
		$def_data["f_branch_name"] = stripslashes($branch_name);
		$def_data["f_account_class"] = stripslashes($account_class);
		$def_data["f_bank_account"] = stripslashes($bank_account);
		$def_data["f_bill_no"] = stripslashes($bill_no);
		$def_data["f_pay_way"] = stripslashes($pay_way);
		$def_data["show_number"] = stripslashes($show_number);
		
		$form->setConstants($def_data);

		if($show_number == "1"){
			$show_number = "10";
		}else if($show_number == "2"){
			$show_number = "50";
		}else if($show_number == "3"){
			$show_number = "100";
		}else if($show_number == "4"){
			$show_number = null;
		}
		$post_flg   = true;                                   //POSTフラグ
		$page_count = null;
		$offset     = 0;
	}
}else if(count($_POST) > 0 && $_POST["show_button"] != "表　示"){
		/****************************/
		//ページ数
		/****************************/
		$collect_sday = $_POST["form_h_f_collect_day_s"];
		$collect_eday = $_POST["form_h_f_collect_day_e"];
		$bill_close_sday_this = $_POST["form_h_f_bill_close_day_this_s"];
		$bill_close_eday_this = $_POST["form_h_f_bill_close_day_this_e"];
		$claim_cd1 = $_POST["form_h_f_claim_cd1"];
		$claim_cd2 = $_POST["form_h_f_claim_cd2"];
		
		/*
		$claim_name = $_POST["form_h_f_claim_name"];
		$bank_cd = $_POST["form_h_f_bank_cd"];
		$bank_name = $_POST["form_h_f_bank_name"];
		$branch_cd = $_POST["form_h_f_branch_cd"];
		$branch_name = $_POST["form_h_f_branch_name"];
		$account_class = $_POST["form_h_f_account_class"];
		$bank_account = $_POST["form_h_f_bank_account"];
		$bill_no = $_POST["form_h_f_bill_no"];
		$pay_way = $_POST["form_h_f_pay_way"];
		$show_number = $_POST["form_h_show_number"];
		*/
		
		//取得するPOST情報を上記のコメントアウトから修正	2006-10-23	yamanaka-s
		$claim_name = $_POST["f_claim_name"];
		$bank_cd = $_POST["f_bank_cd"];
		$bank_name = $_POST["f_bank_name"];
		$branch_cd = $_POST["f_branch_cd"];
		$branch_name = $_POST["f_branch_name"];
		$account_class = $_POST["f_account_class"];
		$bank_account = $_POST["f_bank_account"];
		$bill_no = $_POST["f_bill_no"];
		$pay_way = $_POST["f_pay_way"];
		$show_number = $_POST["show_number"];

		if($show_number == "1"){
			$show_number = "10";
		}else if($show_number == "2"){
			$show_number = "50";
		}else if($show_number == "3"){
			$show_number = "100";
		}else if($show_number == "4"){
			$show_number = null;
		}
		$post_flg = true;
		$page_count     = $_POST["f_page1"];
		$offset         = $page_count * $show_number - $show_number;

		/****************************/
		//支払入力へボタン押下処理
		/****************************/

/*

//	2006-10-23		不要な部分なのでコメントアウト（支払予定一覧からコピーしてきたときの削除忘れ）	yamanaka-s
}elseif($_POST["order_button_flg"] == true  &&  $_POST["show_button"] != "表　示"){
		$collect_sday = $_POST["form_h_f_collect_day_s"];
		$collect_eday = $_POST["form_h_f_collect_day_e"];
		$bill_close_sday_this = $_POST["form_h_f_bill_close_day_this_s"];
		$bill_close_eday_this = $_POST["form_h_f_bill_close_day_this_e"];
		$claim_cd1 = $_POST["form_h_f_claim_cd1"];
		$claim_cd2 = $_POST["form_h_f_claim_cd2"];
		$claim_name = $_POST["form_h_f_claim_name"];
		$bank_cd = $_POST["form_h_f_bank_cd"];
		$bank_name = $_POST["form_h_f_bank_name"];
		$branch_cd = $_POST["form_h_f_branch_cd"];
		$branch_name = $_POST["form_h_f_branch_name"];
		$account_class = $_POST["form_h_f_account_class"];
		$bank_account = $_POST["form_h_f_bank_account"];
		$bill_no = $_POST["form_h_f_bill_no"];
		$pay_way = $_POST["form_h_f_pay_way"];
		$show_number = $_POST["form_h_show_number"];

		$post_flg = true;
		$page_count     = $_POST["f_page1"];
		$offset         = $page_count * $show_number - $show_number;
*/
}else{
		$dflg = true;
		$show_number = "2";

		if($show_number == "1"){
			$show_number = "10";
		}else if($show_number == "2"){
			$show_number = "50";
		}else if($show_number == "3"){
			$show_number = "100";
		}else if($show_number == "4"){
			$show_number = null;
		}
		$offset = 0;
		$page_count = null;
		$post_flg = false;
}

/****************************/
//エラーチェック(PHP)
/****************************/

/****************************/
//where_sql作成
/****************************/
//デフォルト表示処理
$first_list  = " SELECT \n";
$first_list .= " t_bill.collect_day, \n";            //回収予定日
$first_list .= " t_bill_d.bill_close_day_this, \n";  //請求締日
$first_list .= " t_bill.bill_no, \n";                //請求番号
$first_list .= " t_bill.claim_cd1, \n";              //請求先コード1
$first_list .= " t_bill.claim_cd2, \n";              //請求先コード2
$first_list .= " t_bill.claim_cname, \n";            //請求先名（略称）
$first_list .= " t_bill.pay_way, \n";                //集金方法
$first_list .= " t_bank.bank_cd, \n";                //銀行コード
$first_list .= " t_bank.bank_name, \n";              //銀行名
$first_list .= " t_b_bank.b_bank_cd, \n";            //支店コード
$first_list .= " t_b_bank.b_bank_name, \n";          //支店名
$first_list .= " t_account.deposit_kind, \n";        //預金種目
$first_list .= " t_account.account_no, \n";          //口座番号
//$first_list .= " t_bill_d.intax_amount - t_bill_d.installment_sales_amount + t_bill_d.split_bill_amount, \n";//回収予定額
//2006-10-23	回収予定額を修正	yamanaka-s
//$first_list .= " payment_this, \n";//回収予定額
//$first_list .= " CASE WHEN payment_this < 0 THEN 0 ELSE payment_this END AS payment_this, \n";//2006-10-26	修正	yamanaka
//2006-10-30	0以下の場合に修正	yamanaka
$first_list .= " CASE WHEN payment_this <= 0 THEN 0 ELSE payment_this END AS payment_this, \n";
$first_list .= " COALESCE(t_payin.pay_amount,0) AS pay_amount \n";                                          //入金額
$first_list .= " FROM \n";
$first_list .= " t_bill INNER JOIN t_bill_d \n";
$first_list .= " ON t_bill.bill_id = t_bill_d.bill_id \n";
$first_list .= " INNER JOIN  t_client \n";
$first_list .= " ON t_bill_d.client_id = t_client.client_id \n";
$first_list .= " LEFT JOIN t_account \n";
$first_list .= " ON t_client.account_id = t_account.account_id \n";
$first_list .= " LEFT JOIN t_b_bank \n";
$first_list .= " ON t_account.b_bank_id = t_b_bank.b_bank_id \n";
$first_list .= " LEFT JOIN t_bank \n";
$first_list .= " ON t_b_bank.bank_id = t_bank.bank_id \n";
$first_list .= " LEFT JOIN \n";
$first_list .= " ( \n";
$first_list .= "	SELECT \n";
$first_list .= "	t_payin_h.bill_id, \n";
$first_list .= "		SUM(t_payin_d.amount) AS pay_amount \n";
$first_list .= "	FROM \n";
$first_list .= "		t_payin_h INNER JOIN t_payin_d \n";
$first_list .= "		ON t_payin_h.pay_id = t_payin_d.pay_id \n";
$first_list .= "	GROUP BY t_payin_h.bill_id \n";
$first_list .= ") AS t_payin \n";
$first_list .= "ON t_bill.bill_id = t_payin.bill_id \n";

if($group_kind == 2){
	$first_list .= "  WHERE t_bill.shop_id IN (".Rank_Sql().") \n";
}else{
	$first_list .= "  WHERE t_bill.shop_id = $_SESSION[client_id] \n";
}

$first_list .= " AND \n";
$first_list .= " t_bill.bill_no is not null \n";
$first_list .= " AND \n";
$first_list .= " t_bill_d.bill_data_div = '0' \n";
$first_list .= " AND \n";
$first_list .= " t_bill.last_update_flg = 't' \n";

$order_by = " ORDER BY  t_bill.collect_day, t_bill.claim_cd1, t_bill.claim_cd2 \n";

if($post_flg == true){

	//回収予定日(開始)
	if($collect_sday != "0000-00-00"){
		$collect_sday_sql = " t_bill.collect_day >= '$collect_sday'";

		$where1_sql .= " AND" ;
		$where1_sql .= $collect_sday_sql;
	}

	//回収予定日(終了)
	if($collect_eday != "0000-00-00"){
		$collect_eday_sql = " t_bill.collect_day <= '$collect_eday'";

		$where1_sql .= " AND" ;
		$where1_sql .= $collect_eday_sql;
	}

	//請求締日(開始)
	if($bill_close_sday_this != "0000-00-00"){
		$bill_close_sday_this_sql = " t_bill_d.bill_close_day_this >= '$bill_close_sday_this'";

		$where1_sql .= " AND" ;
		$where1_sql .= $bill_close_sday_this_sql;
	}

	//請求締日(終了)
	if($bill_close_eday_this != "0000-00-00"){
		$bill_close_eday_this_sql = " t_bill_d.bill_close_day_this <= '$bill_close_eday_this'";

		$where1_sql .= " AND" ;
		$where1_sql .= $bill_close_eday_this_sql;
	}

	//請求先コード1
	if($claim_cd1 != null){
		$claim_cd1_sql = " t_bill.claim_cd1 LIKE '$claim_cd1%'";

		$where1_sql .= " AND" ;
		$where1_sql .= $claim_cd1_sql;
	}

	//請求先コード2
	if($claim_cd2 != null){
		$claim_cd2_sql = " t_bill.claim_cd2 LIKE '$claim_cd2%'";

		$where1_sql .= " AND" ;
		$where1_sql .= $claim_cd2_sql;
	}

	//請求先名
	if($claim_name != null){
		$claim_name_sql = " t_bill.claim_cname LIKE '%$claim_name%'";

		$where1_sql .= " AND" ;
		$where1_sql .= $claim_name_sql;
	}

	//銀行コード
	if($bank_cd != null){
		$bank_cd_sql = " t_bank.bank_cd LIKE '$bank_cd%'";

		$where1_sql .= " AND" ;
		$where1_sql .= $bank_cd_sql;
	}

	//銀行名
	if($bank_name != null){
		$bank_name_sql = " t_bank.bank_name LIKE '%$bank_name%'";

		$where1_sql .= " AND" ;
		$where1_sql .= $bank_name_sql;
	}

	//支店コード
	if($branch_cd != null){
		$branch_cd_sql = " t_b_bank.b_bank_cd LIKE '$branch_cd%'";

		$where1_sql .= " AND" ;
		$where1_sql .= $branch_cd_sql;
	}

	//支店名
	if($branch_name != null){
		$branch_name_sql = " t_b_bank.b_bank_name LIKE '%$branch_name%'";

		$where1_sql .= " AND" ;
		$where1_sql .= $branch_name_sql;
	}

	//預金種別
	if($account_class != "0"){
		if($account_class == "1"){
			$account_class_sql = " t_account.deposit_kind = '1'";
		}elseif($account_class == "2"){
		    	$account_class_sql = " t_account.deposit_kind = '2'";
		}
        	$where1_sql .= " AND" ;
        	$where1_sql .= $account_class_sql;
	}

	//口座番号
	if($bank_account != null){
		$bank_account_sql = " t_account.account_no LIKE '$bank_account%'";

		$where1_sql .= " AND" ;
		$where1_sql .= $bank_account_sql;
	}

	//請求番号
	if($bill_no != null){
		$bill_no_sql = " t_bill.bill_no LIKE '$bill_no%'";

		$where1_sql .= " AND" ;
		$where1_sql .= $bill_no_sql;
	}

	//集金方法
	if($pay_way != "0"){
		$pay_way_sql = " t_bill.pay_way = '$pay_way'";

		$where1_sql .= " AND" ;
		$where1_sql .= $pay_way_sql;
	}
}

if ($dflg == true || ($form->validate() == true && $err_flg != true)){
	//該当データ件数
	$total_count_sql1 = $first_list.$where1_sql.$order_by.";\n";
	$count_res = Db_Query($db_con, $total_count_sql1);
	$total_count = pg_num_rows($count_res);

	if($show_number != null){
		$limit_sql = " LIMIT $show_number OFFSET $offset";
	}

	$total_count_sql2 = $first_list.$where1_sql.$order_by.$limit_sql.";\n";
	$count_res        = Db_Query($db_con, $total_count_sql2);
	$page_data        = Get_Data($count_res);
	$num              = pg_num_rows($count_res);
}

//金額をカンマで区切る
for($i = 0; $i < $num; $i++){
	$sum1 = bcadd($sum1, $page_data[$i][13]);//回収予定額
	$sum2 = bcadd($sum2, $page_data[$i][14]);//入金額
}
$sum1 = number_format($sum1);
$sum2 = number_format($sum2);

//金額をカンマで区切る
for($i = 0; $i < $num; $i++){
	$page_data[$i][13] = number_format($page_data[$i][13]);//回収予定額
	$page_data[$i][14] = number_format($page_data[$i][14]);//入金額
}

// 預金種目,集金方法をコードから値に変換
for($i = 0; $i < $num; $i++){
	if($page_data[$i][11] == "1"){
		$page_data[$i][11] = "普通";
	}elseif($page_data[$i][11] == "2"){
		$page_data[$i][11] = "当座";
	}else{
		$page_data[$i][11] = "";
	}

	if($page_data[$i][6] == "1"){
		$page_data[$i][6] = "自動引落";
	}elseif($page_data[$i][6] == "2"){
		$page_data[$i][6] = "振込";
	}elseif($page_data[$i][6] == "3"){
		$page_data[$i][6] = "訪問集金";
	}elseif($page_data[$i][6] == "4"){
		$page_data[$i][6] = "その他";
	}else{
		$page_data[$i][6] = "";
	}
}

/****************************/
//チェックボックス作成
/****************************/

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
$page_menu = Create_Menu_h('sale','4');

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/
//表示範囲指定
if($show_number != null){
	$range = $show_number;
}else{
	$range = $total_count;
}
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
        'sum1'          => "$sum1",
        'sum2'          => "$sum2",
        'r'             => "$range",
));
$smarty->assign('row',$page_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
?>
