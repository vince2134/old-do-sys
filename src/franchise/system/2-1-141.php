<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/13      10-018      suzuki      解約日エラーメッセージ変更
 *  2006/11/13      10-013      suzuki      レンタル単価の小数部が正しく登録されるように修正
 *  2006/11/13      10-021      suzuki      データに登録する商品を略称から商品名に変更
 *  2006/11/13      10-012      suzuki      商品CDからJSを呼ぶイベントをOnChangeに変更
 *  2006/11/29      scl_201-1-1 suzuki      商品CDからJSを呼ぶイベントをonBlurに変更
 *  2006/12/09      ban_0104    suzuki      日付のゼロ埋め
 *  2007/05/11                  morita-d    解約理由の入力欄を追加
 *  2007/05/31                  morita-d    商品分類の入力欄を追加
 *  2007/06/10                  morita-d    商品名の変更を選択可能に修正
 *  2007/06/19                  morita-d    画面で更新処理が入ると丸め区分がNULLになる不具合を修正
 *
*/

$page_title = "レンタルTOレンタル";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //契約関数定義
require_once(INCLUDE_DIR."function_rental.inc");  //レンタル関数定義
require_once(INCLUDE_DIR."rental.inc");  //レンタル伝票作成関数群

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;


/****************************/
//外部変数取得
/****************************/
$shop_name  = htmlspecialchars($_SESSION["fc_client_cname"]);
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];
$group_kind = $_SESSION["group_kind"];
$rental_id  = $_GET["rental_id"];      //レンタルID
$top_menu   = $_GET["top_menu"];       //TOPメニュから遷移してきたか判定
$g_product_ary = Select_Get($db_con, 'g_product'); //商品分類マスタ

//レンタルIDをhiddenにより保持する
if($_GET["rental_id"] != NULL){
	$cons_data["hdn_rental_id"] = $rental_id;
}else{
	$rental_id = $_POST["hdn_rental_id"];
}

//TOPメニューフラグをhiddenにより保持する
if($_GET["top_menu"] != NULL){
	$cons_data["hdn_top_menu"] = $top_menu;
}else{
	$top_menu = $_POST["hdn_top_menu"];
}

//得意先が指定されているか
if($_POST["hdn_client_id"] == null){
	$warning = "ユーザを選択して下さい。";
}else{
	$warning = null;
	$client_id    = $_POST["hdn_client_id"];
	$coax         = $_POST["hdn_coax"];
	$client_name  = $_POST["form_client"]["name"];
}

//不正判定
Get_ID_Check3($rental_id);


//仕入先（本部）のIDを取得
$h_client_id = Get_Client_Id_Head($db_con);
    
//仕入先（本部）の丸め区分
$h_client_tax = Get_Tax_div($db_con,$h_client_id);
$h_coax       = $h_client_tax[coax];

/*****************************/ 
// 再遷移先をSESSIONにセット
/*****************************/
// GET、POSTが無い場合
if ($_GET["rental_id"] == null && $_POST == null){
	Set_Rtn_Page(array("rental", "contract"));
}

/****************************/
//レンタルJS作成関数
/****************************/
$java_sheet = Create_JS_Rental($db_con);

/****************************/
//レンタル登録画面表示形式判定関数
/****************************/
/*
	・画面識別値
	 1:レンタルID無し
	 2:契約済・解約済
	 3:解約申請
	 4:解約予定
	 5:取消済
	 6:新規申請中
*/
$stat_list  = Rental_display($db_con,$rental_id);
$disp_stat  = $stat_list[0];  //画面識別値
$online_flg = $stat_list[1];  //オンラインフラグ

if($_POST["online_flg"] != NULL){
	$online_flg = $_POST["online_flg"];
}

//print_array($_POST);

//以下の処理はほとんど意味無し
//$online_flg ⇒ 定義されていない
//$group_kind ⇒ FCは必ず2となる
/****************************/
//表示画面と実際のデータの整合性判定 
/****************************/
//画面表示判定(不正な場合は不正画面を表示)
if($_POST["comp_btn"] == "承認確認画面へ" || $_POST["ok_btn"] == "承認OK" || $_POST["cancel_btn"] == "申請取消確認画面へ" || $_POST["cancel_ok_btn"] == "申請取消OK"){

	//新規申請中(本部)判定
	if(!($disp_stat == 6 && $group_kind == 1 && $online_flg == 't')){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "解約確認画面へ" || $_POST["ok_btn"] == "解約OK"){

	//契約済・解約済(オフライン)判定
	if(!($disp_stat == 2 && $group_kind == 1 && $online_flg == 'f')){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "変更確認画面へ" || $_POST["ok_btn"] == "変更OK"){

	//契約済・解約済(本部・FC)判定
	if(!($disp_stat == 2)){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "解約承認・実施確認画面へ" || $_POST["ok_btn"] == "解約承認・実施OK" || $_POST["cancel_btn"] == "解約取消確認画面へ" || $_POST["cancel_ok_btn"] == "解約取消OK"){

	//解約申請(本部)判定
	if(!($disp_stat == 3 && $group_kind == 1 && $online_flg == 't')){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "解約取消確認画面へ" || $_POST["ok_btn"] == "解約取消OK"){

	//解約予定(本部)判定
	if(!($disp_stat == 4 && $group_kind == 1)){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "登録確認画面へ" || $_POST["ok_btn"] == "登録OK"){

	//レンタルID無し・取消済・レンタルID無し(オフライン)判定
	if(!($disp_stat == 1 || $disp_stat == 5 || ($disp_stat == 1 && $online_flg == 'f'))){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "解約申請確認画面へ" || $_POST["ok_btn"] == "解約申請OK"){

	//契約済・解約済(FC)判定
	if(!($disp_stat == 2)){
		$injust_msg = true;
	}
}

/****************************/
//レンタルTOレンタルの部品定義
/****************************/
//FCでオンライン場合
if($online_flg == "t"){
	$freeze_online = array(
		"form_forward_day",
		"form_head_staff",
		"form_claim_day",
		"form_h_note",
	);
}elseif($online_flg == "f"){
	$freeze_online = array(
		"form_head_staff",
		"form_h_note",
	);
}

//■レンタル区分
//新規
if($disp_stat == 1){
	$online_flg_arr[] =& $form->createElement("radio", null, null, "オフライン", "f","onclick=\"h_column_disabled(this);\"");
	$online_flg_arr[] =& $form->createElement("radio", null, null, "オンライン", "t","onclick=\"h_column_disabled(this);\"");
	$form->addGroup($online_flg_arr, "online_flg", "レンタル区分");

}else{
	$online_flg_name = "オフライン";
	if($online_flg == "t"){
		$online_flg_name = "オンライン";
	}
	$form->addElement("static","online_flg","レンタル区分");

	$static_data["online_flg"]    = "$online_flg_name";
	$form->setConstants($static_data);

}

//■レンタル番号
$form->addElement("text","form_rental_no","","class='Textbox_readonly nborder'");

//■ショップ名
$form->addElement("text","form_shop_name","","class='Textbox_readonly nborder'");

//■レンタル申込日
Addelement_Date($form,"form_rental_day","レンタル申込日","-");

//FCスタッフ取得
$form_staff_id = Select_Get($db_con,'cstaff');

//■申請担当者
$form->addElement('select', 'form_app_staff', '', $form_staff_id, $g_form_option_select);
//■巡回担当者
$form->addElement('select', 'form_round_staff', '', $form_staff_id, $g_form_option_select);

//■ユーザ名
$form_client[] =& $form->createElement(
	"text","cd1","","size=\"7\" maxLength=\"6\" 
	style=\"$g_form_style\" onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\" 
	onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
);
$form_client[] =& $form->createElement("static","","","-");
$form_client[] =& $form->createElement(
	"text","cd2","","size=\"4\" maxLength=\"4\" 
	style=\"$g_form_style\" onChange=\"javascript:Button_Submit('client_search_flg','#','true')\"".$g_form_option."\""
);
$form_client[] =& $form->createElement("text","name","","size=\"34\" readonly");
$form->addGroup( $form_client, "form_client", "");
//$form->freeze("form_client");

//■ユーザ名リンク
$form->addElement("link","form_client_link","","./2-1-141.php","ユーザ名","
	onClick=\"return Open_SubWin('".FC_DIR."dialog/2-0-250.php',
	Array('form_client[cd1]','form_client[cd2]','form_client[name]', 'client_search_flg'),500,450,5,1);\""
);

//■ユーザTEL
$form->addElement("text", "form_tel", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option");

//■郵便番号
$form_post[]   =& $form->createElement("text", "no1", "", "size=\"3\" maxLength=\"3\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_post[no1]', 'form_post[no2]',3)\"".$g_form_option."\"");
$form_post[]   =& $form->createElement("text", "no2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\""." $g_form_option");
$form->addGroup($form_post, "form_post", "","-");

$form->addElement("text", "form_add1", "",'size="50" maxLength="25"'." $g_form_option");     //■住所１
$form->addElement("text", "form_add2", "",'size="50" maxLength="25"'." $g_form_option");     //■住所２
$form->addElement("text", "form_add3", "",'size="55" maxLength="30"'." $g_form_option");     //■住所３
$form->addElement("text", "form_add_read", "",'size="50" maxLength="50"'." $g_form_option"); //■住所(フリガナ)
$form->addElement("textarea","form_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area); //■備考

//■レンタル出荷日
$form_forward_day[] =& $form->createElement("text","y","","style=\"ime-mode:disabled;\" size=\"4\" maxLength=\"4\" onkeyup=\"Rental_claim(this.form,'form_forward_day[y]','form_forward_day[m]',4,'form_forward_day[y]','form_forward_day[m]','form_claim_day[y]','form_claim_day[m]')\" onFocus=\"Forward_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]','form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
$form_forward_day[] =& $form->createElement("text","m","","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onkeyup=\"Rental_claim(this.form,'form_forward_day[m]','form_forward_day[d]',2,'form_forward_day[y]','form_forward_day[m]','form_claim_day[y]','form_claim_day[m]')\" onFocus=\"Forward_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]','form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
$form_forward_day[] =& $form->createElement("text","d","","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onFocus=\"Forward_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]','form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_forward_day,"form_forward_day","form_forward_day","-");

$form->addElement('select', 'form_head_staff', '', $form_staff_id, $g_form_option_select); //本部担当者

//■請求月
$form_claim_day[] =& $form->createElement("text","y","","style=\"ime-mode:disabled;\" size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_claim_day[y]','form_claim_day[m]',4)\" onFocus=\"onForm_today2(this,this.form,'form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
$form_claim_day[] =& $form->createElement("text","m","","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onFocus=\"onForm_today2(this,this.form,'form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_claim_day,"form_claim_day","form_claim_day","-");

$form->addElement("textarea","form_h_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area); //備考(本部用)



//オフライン or 新規 or 取消済
if($online_flg == "f" || $disp_stat == 1 || $disp_stat == 5){
	//■シリアル入力欄
	$form->addElement("button","input_form_btn", "入力欄を表示", 
		"onClick=\"javascript:Button_Submit_1('input_form_flg', '#', 'true')\"");

	//■自動入力
	$form->addElement("button","input_auto", "自動入力", "onClick=\"javascript:Button_Submit_1('auto_flg', '#', 'true')\"");
	//■行追加ボタン
	$form->addElement("button","add_row_btn","行追加","onClick=\"javascript:Button_Submit('add_row_flg', '#foot', 'true')\"");

}else{
	$freeze_online[] = "form_rental_day";
}

$form->freeze($freeze_online);




//新規 or 取消済　の場合
if($disp_stat == 1 || $disp_stat == 5){
	$form->addElement("submit","comp_btn","登録確認画面へ","$disabled");
	$form->addElement("submit","ok_btn","登録OK");

}else if($disp_stat == 2){

	//契約済・解約済(FC)
	$sql  = "SELECT ";
	$sql .= "    CASE rental_stat ";       //レンタル状況 
	$sql .= "     WHEN '0'  THEN '取消済' ";
	$sql .= "     WHEN '10' THEN '契約済' ";
	$sql .= "     WHEN '11' THEN '新規申請中' ";
	$sql .= "     WHEN '20' THEN '解約済' ";
	$sql .= "     WHEN '21' THEN '解約申請' ";
	$sql .= "     WHEN '22' THEN '解約予定' ";
	$sql .= "    END ";
	$sql .= "FROM ";
	$sql .= "    t_rental_d ";
	$sql .= "WHERE ";
	$sql .= "    rental_id = $rental_id;";
	$result = Db_Query($db_con, $sql);

	$stat_flg = false;   //契約済存在判定フラグ
	while($stat_data = pg_fetch_array($result)){

		//$r_stat[] = $stat_data[0];
		if($stat_data[0] == '契約済'){
			$stat_flg = true;
		}
	}

	//契約済が1つもない or オフライン
	if($stat_flg != true || $online_flg == "f"){
		$form->addElement("submit","comp_btn","変更確認画面へ","$disabled");
		$form->addElement("submit","ok_btn","変更OK");

	//契約済が1つでもある場合
	}else{
		$form->addElement("submit","comp_btn","解約申請確認画面へ","$disabled");
		$form->addElement("submit","ok_btn","解約申請OK");

	}
	
	/*
	if($stat_flg == true){
		$form->addElement("submit","comp_btn","解約申請確認画面へ","$disabled");
		$form->addElement("submit","ok_btn","解約申請OK");

	//解約済のみの場合
	}else{
		$form->addElement("submit","comp_btn","変更確認画面へ","$disabled");
		$form->addElement("submit","ok_btn","変更OK");
	}
	*/
}

//TOPメニュー以外から遷移してきた場合に戻るボタン表示
if($top_menu == NULL){
	$form->addElement("button","return_btn","戻　る","onClick=\"location.href='".Make_Rtn_Page("rental")."'\"");
}

//確認画面用の戻るボタン
$form->addElement("button","back_btn","戻　る","onClick=\"javascript:history.back()\"");

//ヘッダの切替ボタン
$form->addElement("button","disp_btn","一　覧","onClick=\"location.href='".FC_DIR."system/2-1-142.php'\"");
$form->addElement("button", "input_btn","登　録",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addElement("hidden", "hdn_client_id");       //ユーザID
$form->addElement("hidden", "hdn_shop_id");         //ショップID
$form->addElement("hidden", "hdn_rental_id");       //レンタルID
$form->addElement("hidden", "hdn_online_no");       //オンラインフラグ
$form->addElement("hidden", "auto_flg");            //自動入力ボタン押下フラグ    
$form->addElement("hidden", "client_search_flg");   //ユーザリンク押下フラグ    
$form->addElement("hidden", "del_row");             //削除行
$form->addElement("hidden", "add_row_flg");         //追加行フラグ
$form->addElement("hidden", "max_row");             //最大行数
$form->addElement("hidden", "goods_search_row");    //商品コード入力行
$form->addElement("hidden", "hdn_top_menu");        //TOPメニュ遷移判定フラグ
$form->addElement("hidden", "input_form_flg");      //入力欄表示フラグ
$form->addElement("hidden", "cancel_flg");          //解約取消フラグ
$form->addElement("hidden", "hdn_coax");            //丸め


//不正時にはこれ以降の処理を行わない
if($injust_msg == false){
	/****************************/
	//初期設定(変更の場合)
	/****************************/
	if($rental_id != NULL){

		/****************************/
		//ヘッダー復元
		/****************************/
		$sql  = "SELECT ";
		$sql .= "    t_rental_h.rental_id,";          //レンタルID 0
		$sql .= "    t_rental_h.rental_no,";          //レンタル番号 1
		$sql .= "    t_rental_h.shop_id,";            //ショップID 2
		$sql .= "    t_rental_h.shop_cd1,";           //ショップCD1 3
		$sql .= "    t_rental_h.shop_cd2,";           //ショップCD2 4
		$sql .= "    t_rental_h.shop_name,";          //ショップ名 5
		$sql .= "    t_rental_h.ap_staff_id,";        //申請担当者ID 6
		$sql .= "    t_rental_h.ap_staff_name,";      //申請担当者名 7
		$sql .= "    t_rental_h.c_staff_id,";         //巡回担当者ID 8
		$sql .= "    t_rental_h.c_staff_name,";       //巡回担当者名 9
		$sql .= "    t_rental_h.client_id,";          //得意先ID 10
		$sql .= "    t_rental_h.client_cd1, ";        //得意先CD1 11
		$sql .= "    t_rental_h.client_cd2, ";        //得意先CD2 12
		$sql .= "    t_rental_h.client_name, ";       //得意先名1 13
		$sql .= "    t_rental_h.client_name2, ";      //得意先名2 14
		$sql .= "    t_rental_h.client_cname, ";      //略称 15
		$sql .= "    t_rental_h.tel, ";               //TEL 16
		$sql .= "    t_rental_h.post_no1, ";          //郵便番号1 17
		$sql .= "    t_rental_h.post_no2, ";          //郵便番号2 18
		$sql .= "    t_rental_h.address1, ";          //住所1 19
		$sql .= "    t_rental_h.address2, ";          //住所2 20
		$sql .= "    t_rental_h.address3, ";          //住所3 21
		$sql .= "    t_rental_h.address_read, ";      //住所カナ 22
		$sql .= "    t_rental_h.note_fc, ";           //備考(FC) 23
		$sql .= "    t_rental_h.apply_day, ";         //レンタル申込日 24
		$sql .= "    t_rental_h.online_flg, ";        //オンラインフラグ 25

		$sql .= "    t_rental_h.note_h, ";            //備考(本部) 26
		$sql .= "    t_rental_h.forward_day, ";       //レンタル出荷日 27
		$sql .= "    t_rental_h.h_staff_id, ";        //本部担当者ID 28
		$sql .= "    t_rental_h.h_staff_name, ";      //本部担当者名 29
		$sql .= "    t_rental_h.claim_day, ";         //請求月 30
		
		$sql .= "    t_client.coax ";                //丸め区分 31

		$sql .= "FROM ";
		$sql .= "    t_rental_h ";
		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_rental_h.client_id ";
		$sql .= "WHERE ";
		$sql .= "    t_rental_h.regist_shop_id = $shop_id ";
		$sql .= "AND ";
		$sql .= "    t_rental_h.rental_id = $rental_id;";
		$result = Db_Query($db_con, $sql);
		//GETデータ判定
		Get_Id_Check($result);
		$ren_h_data = Get_Data($result,2);

		$def_data["form_rental_no"]       = $ren_h_data[0][1];  //レンタル番号
		$def_data["form_app_staff"]       = $ren_h_data[0][6];  //申請担当者
		$def_data["form_round_staff"]     = $ren_h_data[0][8];  //巡回担当者

		$def_data["hdn_client_id"]        = $ren_h_data[0][10]; //得意先ID

		//POST情報の得意先ID指定判定
		if($_POST["hdn_client_id"] != NULL){
			//POST
			$client_id = $_POST["hdn_client_id"]; //SUBMITする前に使用する為
		}else{
			//DB
			$client_id = $ren_h_data[0][10]; //SUBMITする前に使用する為
		}

		$def_data["form_client"]["cd1"]   = $ren_h_data[0][11]; //得意先コード１
		$def_data["form_client"]["cd2"]   = $ren_h_data[0][12]; //得意先コード２
		$def_data["form_client"]["name"]  = $ren_h_data[0][15]; //得意先名
		$def_data["form_post"]["no1"]     = $ren_h_data[0][17]; //郵便番号1
		$def_data["form_post"]["no2"]     = $ren_h_data[0][18]; //郵便番号2
		$def_data["form_add1"]            = $ren_h_data[0][19]; //住所１
		$def_data["form_add2"]            = $ren_h_data[0][20]; //住所２
		$def_data["form_add3"]            = $ren_h_data[0][21]; //住所３
		$def_data["form_add_read"]        = $ren_h_data[0][22]; //住所カナ
		$def_data["form_tel"]             = $ren_h_data[0][16]; //TEL
		$def_data["form_note"]            = $ren_h_data[0][23]; //備考

		$forward_day_array = explode('-',$ren_h_data[0][27]);
		$def_data["form_forward_day"]["y"] = $forward_day_array[0]; //レンタル出荷日
		$def_data["form_forward_day"]["m"] = $forward_day_array[1];   
		$def_data["form_forward_day"]["d"] = $forward_day_array[2];   
		$def_data["form_head_staff"]       = $ren_h_data[0][28];    //本部担当者
	 
		$claim_day_array = explode('-',$ren_h_data[0][30]);
		$def_data["form_claim_day"]["y"] = $claim_day_array[0];     //請求月
		$def_data["form_claim_day"]["m"] = $claim_day_array[1];   

		$def_data["online_flg"]          = $ren_h_data[0][25];      //オンラインフラグ 25
		$def_data["form_h_note"]         = $ren_h_data[0][26];      //備考(本部)
		$def_data["hdn_coax"]            = $ren_h_data[0][31];      //丸め区分

		//POST情報の丸め区分指定判定
		if($_POST["hdn_coax"] != NULL){
			//POST
			$coax = $_POST["hdn_coax"]; //SUBMITする前に使用する為
		}else{
			//DB
			$coax = $ren_h_data[0][31]; //SUBMITする前に使用する為
		}

		$rental_day_array = explode('-',$ren_h_data[0][24]);
		$def_data["form_rental_day"]["y"] = $rental_day_array[0];   //レンタル申込日
		$def_data["form_rental_day"]["m"] = $rental_day_array[1];   
		$def_data["form_rental_day"]["d"] = $rental_day_array[2];   


		$online_flg = $ren_h_data[0][25];      //オンラインフラグ 25

		/****************************/
		//データ復元
		/****************************/
		$sql  = "SELECT ";
		$sql .= "    t_rental_d.rental_d_id,";            //レンタルデータID 0
		$sql .= "    t_rental_d.rental_id,";              //レンタルID 1
		$sql .= "    t_rental_d.line,";                   //行 2
		$sql .= "    t_rental_d.goods_id,";               //商品ID 3
		$sql .= "    t_rental_d.goods_cd,";               //商品CD 4
		//$sql .= "    t_rental_d.official_goods_name,";    //商品名(正式) 5
		$sql .= "    '',";                     //商品名(正式) 5
		$sql .= "    t_rental_d.num,";                    //数量 6
		$sql .= "    t_rental_d.shop_price,";             //レンタル単価 7
		$sql .= "    t_rental_d.shop_amount,";            //レンタル金額 8
		$sql .= "    t_rental_d.user_price,";             //ユーザ単価 9
		$sql .= "    t_rental_d.user_amount,";            //ユーザ金額 10
		$sql .= "    t_rental_d.serial_no,";              //シリアル番号 11
		$sql .= "    CASE t_rental_d.rental_stat ";       //レンタル状況 12
		$sql .= "     WHEN '0'  THEN '取消済' ";
		$sql .= "     WHEN '10' THEN '契約済' ";
		$sql .= "     WHEN '11' THEN '新規申請中' ";
		$sql .= "     WHEN '20' THEN '解約済' ";
		$sql .= "     WHEN '21' THEN '解約申請' ";
		$sql .= "     WHEN '22' THEN '解約予定' ";
		$sql .= "    END,";
		$sql .= "    t_rental_d.calcel_exec,";            //解約実施 13
		$sql .= "    t_rental_d.renew_num,";              //解約数 14
		$sql .= "    t_rental_d.calcel_day,";             //解約日 15
		$sql .= "    t_rental_d.exec_day, ";              //実施日 16
		$sql .= "    t_rental_d.reason, ";                 //解約理由 17
		$sql .= "    t_rental_d.rental_stat AS rental_stat_num, ";                 //レンタル状況 18
		$sql .= "    t_rental_d.serial_flg, ";                     //シリアル管理フラグ 19
		$sql .= "    t_rental_d.g_product_id, ";                    //商品分類ID 20
		$sql .= "    t_rental_d.goods_cname, ";                      //商品名（略称） 21
		$sql .= "    t_goods.name_change ";                      //品名変更 22
		$sql .= "FROM ";
		$sql .= "    t_rental_d ";
		$sql .= "    INNER JOIN t_goods ON t_rental_d.goods_id = t_goods.goods_id ";		
		$sql .= "WHERE ";
		$sql .= "    t_rental_d.rental_id = $rental_id ";
		$sql .= "ORDER BY line;";
		$result = Db_Query($db_con, $sql);
		$ren_d_data = Get_Data($result,2);

		//データ復元
		for($i=0;$i<count($ren_d_data);$i++){
			$search_line                               = $ren_d_data[$i][2]-1; //復元する行

			//状況のfontカラー判定
			if($ren_d_data[$i][12] == "新規申請中" || $ren_d_data[$i][12] == "解約申請"){
				$ren_d_data[$i][12] = "<font color=red>".$ren_d_data[$i][12]."</font>";

			}elseif($ren_d_data[$i][12] == "契約済"){
				$ren_d_data[$i][12] = "<font color=blue>".$ren_d_data[$i][12]."</font>";
			}

			//$def_data["rental_stat"][$search_line]     = $ren_d_data[$i][12];  //レンタル状況
			$rental_stat[$search_line]     = $ren_d_data[$i][12];                  //レンタル状況
			$def_data["hdn_rental_stat_num"][$search_line] = $ren_d_data[$i][18];  //レンタル状況
			$def_data["hdn_calcel_day"][$search_line]      = $ren_d_data[$i][15];  //解約日
			$def_data["hdn_goods_id"][$search_line]        = $ren_d_data[$i][3];   //商品ID
			$def_data["form_goods_cd"][$search_line]       = $ren_d_data[$i][4];   //商品CD
			//$def_data["form_goods_name"][$search_line]     = $ren_d_data[$i][5];   //商品名
			$def_data["form_goods_cname"][$search_line]    = $ren_d_data[$i][21];  //商品名
			$def_data["form_g_product_id"][$search_line]   = $ren_d_data[$i][20];  //商品分類
			$def_data["form_num"][$search_line]            = $ren_d_data[$i][6];   //数量
			$serial_num[$search_line]                      = $ren_d_data[$i][6];   //シリアルの入力フォーム数
			$def_data["form_serial"][$search_line][0]      = $ren_d_data[$i][11];  //シリアル
			$def_data["hdn_serial_flg"][$search_line]      = $ren_d_data[$i][19];  //シリアル管理フラグ
			$serial_flg[$search_line]                      = $ren_d_data[$i][19];  //SUBMITする前に使用する為
			$name_change[$search_line]                     = $ren_d_data[$i][22];   //品名変更（SUBMITする前に使用する為）


			//レンタル単価を整数部と少数部に分ける
			$ren_price = explode('.', $ren_d_data[$i][7]);
			$def_data["form_shop_price"][$search_line]["i"] = $ren_price[0];                      //レンタル単価
			$def_data["form_shop_price"][$search_line]["d"] = ($ren_price[1] != null)? $ren_price[1] : '00';     
			$def_data["form_shop_amount"][$search_line]     = number_format($ren_d_data[$i][8]);  //レンタル金額

			//ユーザ単価を整数部と少数部に分ける
			$use_price = explode('.', $ren_d_data[$i][9]);
			$def_data["form_user_price"][$search_line]["i"] = $use_price[0];  //ユーザ単価
			$def_data["form_user_price"][$search_line]["d"] = ($use_price[1] != null)? $use_price[1] : '00';
			$def_data["form_user_amount"][$search_line]     = number_format($ren_d_data[$i][10]);  //ユーザ金額

			//解約日
			$calcel_day_array = explode('-',$ren_d_data[$i][15]);
			$def_data["form_calcel_day"][$search_line]["y"] = $calcel_day_array[0];           
			$def_data["form_calcel_day"][$search_line]["m"] = $calcel_day_array[1];   
			$def_data["form_calcel_day"][$search_line]["d"] = $calcel_day_array[2];   

			$def_data["form_renew_num"][$search_line]    = $ren_d_data[$i][14];               //解約数
			$def_data["reason"][$search_line]            = $ren_d_data[$i][17];               //解約理由

			$exec_day_array = explode('-',$ren_d_data[$i][16]);
			$def_data["form_exec_day"][$search_line]["y"] = $exec_day_array[0];               //実施日
			$def_data["form_exec_day"][$search_line]["m"] = $exec_day_array[1];   
			$def_data["form_exec_day"][$search_line]["d"] = $exec_day_array[2];   

			//解約実施チェック判定
			if($ren_d_data[$i][13] == 2){
				$def_data["form_calcel1"][$search_line]    = 1;               //即解約
				$calcel_msg_flg[$search_line] = true;                         //今すぐ実施表示フラグ
			}else if($ren_d_data[$i][13] == 3){
				$def_data["form_calcel2"][$search_line]    = 1;               //解約日に解約
			}
		}

		//表示行数
		if($_POST["max_row"] != NULL){
			$max_row = $_POST["max_row"];
		}else{
			//レンタルデータの数
			$max_row = count($ren_d_data);
		}

		//警告は非表示
		$warning = null;

	//****************************
	//初期値(新規登録)
	//****************************
	}else{
		//自動採番のレンタル番号取得
		$sql  = "SELECT";
		$sql .= "   MAX(rental_no)";
		$sql .= " FROM";
		$sql .= "   t_rental_h";
		$sql .= ";";
		$result = Db_Query($db_con, $sql);
		$rental_no = pg_fetch_result($result, 0 ,0);
		$rental_no = $rental_no +1;
		$rental_no = str_pad($rental_no, 8, 0, STR_PAD_LEFT);
		$def_data["form_rental_no"] = $rental_no;

		//レンタル申込日に本日の日付設定
		$def_data["form_rental_day"]["y"] = date("Y");
		$def_data["form_rental_day"]["m"] = date("m");
		$def_data["form_rental_day"]["d"] = date("d");

		//申請担当者をログインした人に設定
		$def_data["form_app_staff"] = $staff_id;

		//巡回担当者をログインした人に設定
		$def_data["form_round_staff"] = $staff_id;

		//レンタル区分
		$def_data["online_flg"] = "f";

		//表示行数
		if($_POST["max_row"] != null){
			$max_row = $_POST["max_row"];
		}else{
			$max_row = 5;
		}
	}
	$form->setDefaults($def_data); //初回のみデータ値変更


	/****************************/
	//行数追加処理
	/****************************/
	if($_POST["add_row_flg"]==true){
		if($_POST["max_row"] == NULL){
			//初期値はPOSTが無い為、
			$max_row = 10;
		}else{
			//最大行を＋5
			$max_row = $_POST["max_row"]+5;
		}
		//行数追加フラグをクリア
		$cons_data["add_row_flg"] = "";
	}
	$cons_data["max_row"] = $max_row; //最大行数をhiddenにセット

	/****************************/
	//行削除処理
	/****************************/
	//削除行数
	$del_history[] = NULL; //削除行数
	if($_POST["del_row"] != ""){

		//削除リストを取得
		$del_row = $_POST["del_row"];

		//削除履歴を配列にする。
		$del_history = explode(",", $del_row);
		//削除した行数
		$del_num     = count($del_history)-1;
	}

	/****************************/
	//自動入力ボタン押下
	/****************************/
	if($_POST["auto_flg"] == true){
		$post1      = $_POST["form_post"]["no1"];             // 郵便番号１
		$post2      = $_POST["form_post"]["no2"];             // 郵便番号２
		$post_value = Post_Get($post1, $post2, $db_con);
		// 郵便番号フラグをクリア
		$cons_data["auto_flg"]  = "";
		// 郵便番号から自動入力
		$cons_data["form_post"]["no1"]  = $_POST["form_post"]["no1"];
		$cons_data["form_post"]["no2"]  = $_POST["form_post"]["no2"];
		$cons_data["form_add_read"] = $post_value[0];
		$cons_data["form_add1"]     = $post_value[1];
		$cons_data["form_add2"]     = $post_value[2];
		$cons_data["auto_flg"]   = "";
	}

	/****************************/
	//入力欄表示ボタン押下or自動入力ボタンor登録確認画面へ押下or登録OKボタン押下
	/****************************/
	/*if($_POST["input_form_flg"]==true || $_POST["auto_flg"] == true || $online_flg == "f" ||
	($_POST["comp_btn"] == "登録確認画面へ" && $online_flg == 'f' && $disp_stat == 1) || 
	($_POST["ok_btn"] == "登録OK" && $online_flg == 'f' && $disp_stat == 1)){
*/
	if($_POST["input_form_flg"]==true || $_POST["auto_flg"] == true || $online_flg == "f" ||
	($_POST["comp_btn"] == "登録確認画面へ" && $online_flg == 'f' && $disp_stat == 1) || 
	($_POST["ok_btn"] == "登録OK" && $online_flg == 'f' && $disp_stat == 1)){

		$serial_array = $_POST["form_num"];
		if($_POST["form_num"] == NULL){
			$serial_array = $serial_num;
		} 
		$row_disp = 1;    //ブラウザの行番号

		for($i = 0; $i < $max_row; $i++){
			//表示行判定
			if(!in_array("$i", $del_history)){
				//対象となる行のシリアル入力数
				$serial_num[$i] = $serial_array[$i];

				//商品ＣＤ入力判定
				if($_POST["form_goods_cd"][$i] != null){
					//シリアル管理判定
					$goods_id[$i] = $_POST["hdn_goods_id"][$i];      //商品ID
					$sql  = "SELECT serial_flg FROM t_goods WHERE goods_id = ".$goods_id[$i].";";
					$result = Db_Query($db_con, $sql);
					$goods_data = Get_Data($result);

					$cons_data["hdn_serial_flg"][$i] = $goods_data[0][0];  //シリアル管理フラグ
					$serial_flg[$i]                  = $goods_data[0][0];  //SUBMITする前に使用する為
				}

				//◇シリアル
				if($serial_flg[$i] == 't'){
					//・シリアル入力フォームが50より大きいか判定
					if($serial_num[$i] > 50){
						//$form->setElementError("form_goods_name[$i]",$row_disp."行目 シリアル入力欄 は50個以下にして下さい。");
						$form->setElementError("form_goods_cname[$i]",$row_disp."行目 シリアル入力欄 は50個以下にして下さい。");
						$serial_error_flg = true;   //シリアル必須判定やらないフラグ
						$serial_num[$i] = 0;        //シリアル入力フォーム数をなし
					}
				}
				$row_disp++;
			}
		}

		$cons_data["input_form_flg"]   = "";
	}



	/****************************/
	//ユーザコード入力処理
	/****************************/
	if($_POST["client_search_flg"] == true){

		$client_cd1  = $_POST["form_client"]["cd1"];       //ユーザコード1
		$client_cd2  = $_POST["form_client"]["cd2"];       //ユーザコード2

		//得意先の情報を抽出
		$sql  = "SELECT";
		$sql .= "   client_id,";
		$sql .= "   client_cname,";
		$sql .= "   coax, ";
		$sql .= "   post_no1, ";
		$sql .= "   post_no2, ";
		$sql .= "   address1, ";
		$sql .= "   address2, ";
		$sql .= "   address3, ";
		$sql .= "   address_read, ";
		$sql .= "   tel ";
		$sql .= " FROM";
		$sql .= "   t_client";
		$sql .= " WHERE";
		$sql .= "   client_cd1 = '$client_cd1'";
		$sql .= "   AND";
		$sql .= "   client_cd2 = '$client_cd2'";
		$sql .= "   AND";
		$sql .= "   client_div = '1' ";
		$sql .= "   AND ";
		$sql .= "   state = '1' ";
		$sql .= "   AND";
		$sql .= "    t_client.shop_id = $shop_id";
		$sql .= ";";

		$result = Db_Query($db_con, $sql); 
		$num = pg_num_rows($result);

		//該当データがある
		if($num == 1){
			$client_data = Get_Data($result,2);
			$client_id      = $client_data[0][0];        //得意先ID
			$client_name    = $client_data[0][1];        //得意先名
			$coax           = $client_data[0][2];        //丸め区分（商品）

			//取得したデータをフォームにセット
			$warning = null;
			$cons_data["client_search_flg"]    = "";
			$cons_data["hdn_client_id"]        = $client_id;
			$cons_data["form_client"]["name"]  = $client_name;
			$cons_data["hdn_coax"]             = $coax;

			$cons_data["form_post"]["no1"]     = $client_data[0][3]; //郵便番号1
			$cons_data["form_post"]["no2"]     = $client_data[0][4]; //郵便番号2
			$cons_data["form_add1"]            = $client_data[0][5]; //住所１
			$cons_data["form_add2"]            = $client_data[0][6]; //住所２
			$cons_data["form_add3"]            = $client_data[0][7]; //住所３
			$cons_data["form_add_read"]        = $client_data[0][8]; //住所カナ
			$cons_data["form_tel"]             = $client_data[0][9]; //TEL

		}else{
			$warning = "ユーザを選択して下さい。";
			$cons_data["client_search_flg"]   = "";
			$cons_data["hdn_client_id"]       = "";
			$cons_data["form_client"]["cd1"]  = "";
			$cons_data["form_client"]["cd2"]  = "";
			$cons_data["form_client"]["name"] = "";
			$cons_data["hdn_coax"]            = "";
			$cons_data["form_post"]["no1"]    = ""; 
			$cons_data["form_post"]["no2"]    = "";
			$cons_data["form_add1"]           = "";
			$cons_data["form_add2"]           = "";
			$cons_data["form_add3"]           = "";
			$cons_data["form_add_read"]       = "";
			$cons_data["form_tel"]            = "";
		}
		//前に入力された値を初期化
		for($i = 0; $i < $max_row; $i++){
			$cons_data["hdn_goods_id"][$i]           = "";
			$cons_data["rental_stat"][$i]            = "";
			$cons_data["hdn_rental_stat_num"][$i]    = "";
			$cons_data["hdn_calcel_day"][$i]         = "";
			$cons_data["form_goods_cd"][$i]          = "";
			//$cons_data["form_goods_name"][$i]        = "";
			$cons_data["form_goods_cname"][$i]        = "";
			$cons_data["form_g_product_id"][$i]        = "";
			$cons_data["form_num"][$i]               = "";
			$cons_data["form_shop_price"]["$i"]["i"] = "";
			$cons_data["form_shop_price"]["$i"]["d"] = "";
			$cons_data["form_shop_amount"][$i]       = "";
			$cons_data["form_user_price"]["$i"]["i"] = "";
			$cons_data["form_user_price"]["$i"]["d"] = "";
			$cons_data["form_user_amount"][$i]       = "";
		}
		$hdn_goods_id                     = "";
		$hdn_rental_stat                  = "";
		$hdn_rental_stat_num              = "";
		$hdn_calcel_day                   = "";

		//行初期化
		$cons_data["del_row"]             = "";
		$cons_data["max_row"]             = 5;
		$max_row                          = 5;
		$del_history                      = NULL;
		$del_history[]                    = NULL;
		$del_row                          = NULL; 
		
	}
#echo $disp_stat."<hr>";
	/****************************/
	//エラーチェック(addRule)
	/****************************/
	$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");

	//レンタル申込日
	$form->addGroupRule("form_rental_day", "レンタル申込日 を入力して下さい。",  "required"); 

	//申請担当者
	$form->addRule("form_app_staff","申請担当者 を入力して下さい。",'required');

	//巡回担当者
	$form->addRule("form_round_staff","巡回担当者 を入力して下さい。",'required');

	//郵便番号
	$form->addGroupRule("form_post", "郵便番号 を入力して下さい。",  "required"); 
	$form->addGroupRule("form_post", "郵便番号 は数字を入力して下さい。",  "numeric"); 

	//住所１
	$form->addRule("form_add1","住所1 を入力して下さい。",'required');

	//備考
	$form->addRule("form_note","備考 は100文字以内です。","mb_maxlength","100");

	//オフライン
	if($online_flg == "f"){
		$form->addGroupRule("form_forward_day", "レンタル出荷日が入力されていません。",  "required"); 
		$form->addGroupRule("form_claim_day", "請求月が入力されていません。",  "required"); 
	}


	/****************************/
	//登録ボタン・解約申請ボタン・変更ボタン押下処理
	/****************************/
	if(($_POST["comp_btn"] == "登録確認画面へ" || $_POST["comp_btn"] == "解約申請確認画面へ" || $_POST["comp_btn"] == "変更確認画面へ") 
	|| ($_POST["ok_btn"] == "登録OK" || $_POST["ok_btn"] == "解約申請OK" || $_POST["ok_btn"] == "変更OK")){

		//ヘッダー情報
		$rental_id       = $_POST["hdn_rental_id"];              //レンタルID
		$rental_no       = $_POST["form_rental_no"];             //レンタル番号

		$ren_day_y       = $_POST["form_rental_day"]["y"];       //レンタル申込日
		$ren_day_m       = $_POST["form_rental_day"]["m"];            
		$ren_day_d       = $_POST["form_rental_day"]["d"];            

		if($ren_day_y != null && $ren_day_m != null && $ren_day_d != null){
			$ren_day_y = str_pad($ren_day_y,4, 0, STR_PAD_LEFT);  
			$ren_day_m = str_pad($ren_day_m,2, 0, STR_PAD_LEFT); 
			$ren_day_d = str_pad($ren_day_d,2, 0, STR_PAD_LEFT); 
			$ren_day   = $ren_day_y."-".$ren_day_m."-".$ren_day_d; //日付の形式変更
		}

		$for_day_y       = $_POST["form_forward_day"]["y"];      //レンタル出荷日
		$for_day_m       = $_POST["form_forward_day"]["m"];            
		$for_day_d       = $_POST["form_forward_day"]["d"];            

		if($for_day_y != null && $for_day_m != null && $for_day_d != null){
			$for_day_y = str_pad($for_day_y,4, 0, STR_PAD_LEFT);  
			$for_day_m = str_pad($for_day_m,2, 0, STR_PAD_LEFT); 
			$for_day_d = str_pad($for_day_d,2, 0, STR_PAD_LEFT); 
			$for_day   = $for_day_y."-".$for_day_m."-".$for_day_d; //日付の形式変更
		}

		$claim_day_y     = $_POST["form_claim_day"]["y"];        //請求月
		$claim_day_m     = $_POST["form_claim_day"]["m"];   

		$client_cd1      = $_POST["form_client"]["cd1"];         //得意先CD1
		$client_cd2      = $_POST["form_client"]["cd2"];         //得意先CD2
		$app_staff       = $_POST["form_app_staff"];             //申請担当者
		$round_staff     = $_POST["form_round_staff"];           //巡回担当者
		$tel             = $_POST["form_tel"];                   //ユーザTEL
		$post_no1        = $_POST["form_post"]["no1"];           //郵便番号
		$post_no2        = $_POST["form_post"]["no2"];       
		$add1            = $_POST["form_add1"];                  //住所１
		$add2            = $_POST["form_add2"];                  //住所２
		$add3            = $_POST["form_add3"];                  //住所３
		$add_read        = $_POST["form_add_read"];              //住所カナ
		$note            = $_POST["form_note"];                  //備考

		//データ情報
		$j = 0;           //データ配列の添字
		$row_disp = 1;    //ブラウザの行番号
		for($i = 0; $i < $max_row; $i++){
			//表示行判定
			if(!in_array("$i", $del_history)){

				if($_POST["form_goods_cd"][$i] != null){
					$j = $i;
					$goods_id[$j]         = $_POST["hdn_goods_id"][$i];                          //商品ID
					//$goods_name[$j]       = $_POST["form_goods_name"][$i];                     //商品名
					$goods_cname[$j]      = $_POST["form_goods_cname"][$i];                      //商品名
					$g_product_id[$j]     = $_POST["form_g_product_id"][$i];                     //商品名
					$goods_cd[$j]         = $_POST["form_goods_cd"][$i];                         //商品CD
					$num[$j]              = $_POST["form_num"][$i];                              //数量
					$serial[$j]           = $_POST["form_serial"][$i];                           //シリアル
					$shop_price_i[$j]     = $_POST["form_shop_price"][$i]["i"];                  //レンタル単価（整数部）
					$shop_price_d[$j]     = $_POST["form_shop_price"][$i]["d"];                  //レンタル単価（小数部）
					$user_price_i[$j]     = $_POST["form_user_price"][$i]["i"];                  //ユーザ単価（整数部）
					$user_price_d[$j]     = $_POST["form_user_price"][$i]["d"];                  //ユーザ単価（小数部）
					$shop_amount[$j]      = str_replace(',','',$_POST["form_shop_amount"][$i]);  //レンタル金額
					$user_amount[$j]      = str_replace(',','',$_POST["form_user_amount"][$i]);  //ユーザ金額
	
					$renew_num[$j]        = $_POST["form_renew_num"][$i];                        //解約数
					$calcel1[$j]          = $_POST["form_calcel1"][$i];                          //解約チェック１
					$calcel2[$j]          = $_POST["form_calcel2"][$i];                          //解約チェック２
					$exec_day_y[$j]       = $_POST["form_exec_day"][$i]["y"];                    //実施日
					$exec_day_m[$j]       = $_POST["form_exec_day"][$i]["m"];            
					$exec_day_d[$j]       = $_POST["form_exec_day"][$i]["d"];            
					$reason[$j]           = $_POST["reason"][$i];                  //解約理由

					$hdn_calcel_day[$j]   = $_POST["hdn_calcel_day"][$i];                          //解約日
					//$hdn_rental_stat[$j]  = $_POST["hdn_rental_stat"][$i];                       //状態
					$rental_stat_num[$j]  = $_POST["hdn_rental_stat_num"][$i];                     //状態

					//ヘッダの合計金額計算
					$total_shop = bcadd($total_shop,$shop_amount[$j]);
					$total_user = bcadd($total_user,$user_amount[$j]);
					/****************************/
					//エラーチェック(PHP)
					/****************************/
					//商品チェック
					//数量、レンタル単価、ユーザ単価、入力チェック
					if($goods_id[$j] != null && ($num[$j] == null || $shop_price_i[$j] == null || $shop_price_d[$j] == null || $user_price_i[$j] == null || $user_price_d[$j] == null)){
						$form->setElementError("form_goods_cd[$i]",$row_disp."行目 数量とレンタル単価とユーザ提供単価は必須です。");
					}
	
					//◇数量
					//・正の数判定
					if(!ereg("^[0-9]+$",$num[$j]) && $num[$j] != null){
						$form->setElementError("form_num[$i]",$row_disp."行目 数量 は0以上で入力して下さい。");
					}
	
					//◇レンタル単価
					//・正の数判定
					if((!ereg("^[0-9]+$",$shop_price_i[$j]) && $shop_price_i[$j] != NULL) || (!ereg("^[0-9]+$",$shop_price_d[$j]) && $shop_price_d[$j] != NULL)){
						$form->setElementError("form_shop_price[$i]",$row_disp."行目 レンタル単価 は0以上で入力して下さい。");
					}
	
					//◇ユーザ単価
					//・正の数判定
					if((!ereg("^[0-9]+$",$user_price_i[$j]) && $user_price_i[$j] != NULL) || (!ereg("^[0-9]+$",$user_price_d[$j]) && $user_price_d[$j] != NULL)){
						$form->setElementError("form_user_price[$i]",$row_disp."行目 ユーザ提供単価 は0以上で入力して下さい。");
					}
	
					//契約済・解約済判定(解約にチェックが付いているものor解約数が入力済だけを行う)
					if($disp_stat == 2 && ($calcel1[$j] != null || $calcel2[$j] != null || $renew_num[$j] != NULL)){
						//◇解約数
						//・妥当性判定
						if($num[$j] < $renew_num[$j]){
							//数量より解約数の方が大きかった場合エラー
							$form->setElementError("form_renew_num[$i]",$row_disp."行目 商品の解約数が数量を超えています。");
						}
						//・正の数判定
						if(!ereg("^[0-9]+$",$renew_num[$j])){
							$form->setElementError("form_renew_num[$i]",$row_disp."行目 解約数 は1以上で入力して下さい。");
						}
						//解約数が１以上か判定
						if($renew_num[$j] < 1){
							$form->setElementError("form_renew_num[$i]",$row_disp."行目 解約数 は1以上で入力して下さい。");
						}

						//商品分類、正式名、略称、シリアル管理フラグを返す
						$goods_data = Get_Goods_Info($db_con,$goods_id[$i]);
						if($goods_data[serial_flg] == "t" && $renew_num[$i] != "1"){
							$form->setElementError("form_renew_num[$i]",$row_disp."行目 シリアル管理ありの商品は 解約数を1で入力して下さい。");
						}


						//実施日にチェックが付いていた場合にエラー判定
						if($calcel2[$j] != null){
							//◇実施日
	
							$exec_day_y[$j] = str_pad($exec_day_y[$j],4, 0, STR_PAD_LEFT);  
							$exec_day_m[$j] = str_pad($exec_day_m[$j],2, 0, STR_PAD_LEFT); 
							$exec_day_d[$j] = str_pad($exec_day_d[$j],2, 0, STR_PAD_LEFT); 
	
							//日付の形式変更
							//$exec_day[$j]  = date("Y-m-d",mktime(0, 0, 0,$exec_day_m[$j],$exec_day_d[$j],$exec_day_y[$j]));
							$exec_day[$j]  = $exec_day_y[$j]."-".$exec_day_m[$j]."-".$exec_day_d[$j];
	
							//本日以前か判定
							$exec_today = date("Y-m-d");
							if($exec_today >= $exec_day[$j]){
								$form->setElementError("form_exec_day[$i]",$row_disp."行目 実施日 の日付は翌日以降を入力して下さい。");
							}
	
							//数値判定
							if(!ereg("^[0-9]{4}$",$exec_day_y[$j]) || !ereg("^[0-9]{2}$",$exec_day_m[$j]) || !ereg("^[0-9]{2}$",$exec_day_d[$j])){
								$form->setElementError("form_exec_day[$i]",$row_disp."行目 実施日 の日付は妥当ではありません。");
							}
	
							$exec_day_y[$j] = (int)$exec_day_y[$j];
							$exec_day_m[$j] = (int)$exec_day_m[$j];
							$exec_day_d[$j] = (int)$exec_day_d[$j];
	
							//・妥当性判定
							if(!checkdate($exec_day_m[$j],$exec_day_d[$j],$exec_day_y[$j])){
								$form->setElementError("form_exec_day[$i]",$row_disp."行目 実施日 の日付は妥当ではありません。");
							}
						}
	
						//◇解約チェック
						//・妥当性判定
						if($calcel1[$j] != null && $calcel2[$j] != null){
							$form->setElementError("form_calcel1[$i]",$row_disp."行目 実施日 のチェックは一つまでです。");
						}
						//・必須判定
						if($calcel1[$j] == null && $calcel2[$j] == null){
							$form->setElementError("form_calcel1[$i]",$row_disp."行目 実施日 にチェックを一つ付けて下さい。");
						}
					}
	
					$j++;
				}else{
						//商品以外の入力欄に値があるか判定
					if($_POST["form_num"][$i] != NULL || $_POST["form_shop_price"][$i]["i"] != NULL || $_POST["form_shop_price"][$i]["d"] != NULL || $_POST["form_user_price"][$i]["i"] != NULL || $_POST["form_user_price"][$i]["d"] != NULL || $_POST["form_renew_num"][$i] != NULL || $_POST["form_calcel1"][$i] != NULL || $_POST["form_calcel2"][$i] != NULL || $_POST["form_exec_day"][$i]["y"] != NULL || $_POST["form_exec_day"][$i]["m"] != NULL || $_POST["form_exec_day"][$i]["d"] != NULL){
							$form->setElementError("form_goods_cd[$i]",$row_disp."行目 商品を選択して下さい。");
							//商品選択チェックを行わない
							$goods_check_flg = true;
						}
				}
				$row_disp++;
			}
		}

		/****************************/
		//エラーチェック(PHP)
		/****************************/
		$error_flg = false;                                         //エラー判定フラグ

		//レンタル申込日
		//・文字種チェック
		if($ren_day_y != null && $ren_day_m != null && $ren_day_d != null){

			$ren_day_y = str_pad($ren_day_y,4, 0, STR_PAD_LEFT);  
			$ren_day_m = str_pad($ren_day_m,2, 0, STR_PAD_LEFT); 
			$ren_day_d = str_pad($ren_day_d,2, 0, STR_PAD_LEFT); 

			//日付の形式変更
			//$ren_day  = date("Y-m-d",mktime(0, 0, 0,$ren_day_m,$ren_day_d,$ren_day_y));
			$ren_day  = $ren_day_y."-".$ren_day_m."-".$ren_day_d;

			//数値判定
			if(!ereg("^[0-9]{4}$",$ren_day_y) || !ereg("^[0-9]{2}$",$ren_day_m) || !ereg("^[0-9]{2}$",$ren_day_d)){
				$form->setElementError("form_rental_day","レンタル申込日 の日付は妥当ではありません。");
				$error_flg = true;
			}

			//・文字種チェック
			$ren_day_y = (int)$ren_day_y;
			$ren_day_m = (int)$ren_day_m;
			$ren_day_d = (int)$ren_day_d;

			//日付の妥当性判定
			if(!checkdate($ren_day_m,$ren_day_d,$ren_day_y)){
				//エラー

				$form->setElementError("form_rental_day","レンタル申込日 の日付は妥当ではありません。");
				$error_flg = true;
			}else{
				//正しい日付

				//システム開始時間判定
				$err_msge = Sys_Start_Date_Chk($ren_day_y,$ren_day_m,$ren_day_d,"レンタル申込日");
				if($err_msge != null){
					$form->setElementError("form_rental_day","$err_msge"); 
				}
			}
		}

		//レンタル出荷日
		//・妥当性チェック
		if($for_day_y != null && $for_day_m != null && $for_day_d != null){

			$for_day_y = str_pad($for_day_y,4, 0, STR_PAD_LEFT);  
			$for_day_m = str_pad($for_day_m,2, 0, STR_PAD_LEFT); 
			$for_day_d = str_pad($for_day_d,2, 0, STR_PAD_LEFT); 

			//日付の形式変更
			//$for_day  = date("Y-m-d",mktime(0, 0, 0,$for_day_m,$for_day_d,$for_day_y));
			$for_day  = $for_day_y."-".$for_day_m."-".$for_day_d;

			//数値判定
			if(!ereg("^[0-9]{4}$",$for_day_y) || !ereg("^[0-9]{2}$",$for_day_m) || !ereg("^[0-9]{2}$",$for_day_d)){
				$form->setElementError("form_forward_day","レンタル出荷日 の日付は妥当ではありません。");
				$error_flg = true;
			}

			//・文字種チェック
			$for_day_y = (int)$for_day_y;
			$for_day_m = (int)$for_day_m;
			$for_day_d = (int)$for_day_d;

			//日付の妥当性判定
			if(!checkdate($for_day_m,$for_day_d,$for_day_y)){
				//エラー

				$form->setElementError("form_forward_day","レンタル出荷日 の日付は妥当ではありません。");
				$error_flg = true;
			}else{
				//正しい日付

				//システム開始時間判定
				$err_msge = Sys_Start_Date_Chk($for_day_y,$for_day_m,$for_day_d,"レンタル出荷日");
				if($err_msge != null){
					$form->setElementError("form_forward_day","$err_msge"); 
				}
			}
		}

		//レンタル出荷日が申込日より前か判定
		if($error_flg == false && $ren_day > $for_day && $for_day != NULL){
			$form->setElementError("form_rental_day","レンタル申込日 の日付はレンタル出荷日以前の日付を入力して下さい。");
		}

		//請求月
		if($claim_day_y != null && $claim_day_m != null){

			$claim_day_y = str_pad($claim_day_y,4, 0, STR_PAD_LEFT);  
			$claim_day_m = str_pad($claim_day_m,2, 0, STR_PAD_LEFT); 
			$claim_ymd = $claim_day_y."-".$claim_day_m."-01"; //請求年月日

			//数値判定
			if(!ereg("^[0-9]{4}$",$claim_day_y) || !ereg("^[0-9]{2}$",$claim_day_m)){
				$form->setElementError("form_claim_day","請求月 の日付は妥当ではありません。");
			}

			//・文字種チェック
			$claim_day_y = (int)$claim_day_y;
			$claim_day_m = (int)$claim_day_m;
			$claim_day_d = 1;

			//$for_ymd   = date("Y-m-d",mktime(0, 0, 0,$for_day_m,1,$for_day_y));     //出荷年月日
			//$claim_ymd = date("Y-m-d",mktime(0, 0, 0,$claim_day_m,1,$claim_day_y)); //請求年月日
			$for_ymd   = str_pad($for_day_y,4, 0, STR_PAD_LEFT)."-".str_pad($for_day_m,2, 0, STR_PAD_LEFT)."-01";     //出荷年月日

			//請求月が出荷日より前の場合
			if($claim_ymd < $for_ymd ){
				$form->setElementError("form_claim_day","請求月 はレンタル出荷日以降を入力して下さい。");
			}

			//請求月がレンタル出荷日より前か判定
			//if($for_ymd >= $claim_ymd){
				//$form->setElementError("form_claim_day","請求月 の日付はレンタル出荷日の翌月以降を入力して下さい。");
			//}

			//日付の形式変更
			$claim_day  = $claim_day_y."-".$claim_day_m."-".$claim_day_d;
			//・妥当性チェック
			if(!checkdate($claim_day_m,$claim_day_d,$claim_day_y)){
				//エラー
				$form->setElementError("form_claim_day","請求月 の日付は妥当ではありません。");

			}else{
				//正しい日付

				//システム開始時間判定
				$err_msge = Sys_Start_Date_Chk($claim_day_y,$claim_day_m,$claim_day_d,"請求月");
				if($err_msge != null){
					$form->setElementError("form_claim_day","$err_msge"); 
				}
			}
		}

		//$form->registerRule("check_date","function","check_date");
		//$form->addRule("form_rental_day", "レンタル申込日 の日付は妥当ではありません。",  "check_date", $_POST["form_rental_day"]);
		//$form->addRule("form_forward_day", "レンタル出荷日 の日付は妥当ではありません。",  "check_date", $_POST["form_forward_day"]);

		//◇郵便番号
		//マイナス判定
		if(!ereg("^[0-9]{3}$",$post_no1) || !ereg("^[0-9]{4}$",$post_no2)){
			$form->setElementError("form_post","郵便番号 は数字を入力して下さい。");
		}

		//TEL
		//・半角数字と「-」以外はエラー
		if($tel != NULL && !ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$tel)){
			$form->setElementError("form_tel","TELは半角数字と｢-｣のみ30桁以内です。");
		}

		//ユーザ名
		//不正値チェック
		$injust = Injustice_check($db_con,"client",$client_id,$client_cd1,$client_cd2);
		if($injust == false){
			$error_msg2 = "ユーザ の情報が取得できませんでした。再度操作を行って下さい。";
			$error_flg = true;        //エラー表示
		}

		//商品以外の入力欄に値がある・ユーザに不正値の場合以下の処理は行わない
		if($goods_check_flg == false && $error_msg2 == NULL){
			//商品選択チェック
			for($i = 0; $i < count($goods_id); $i++){
				//if($goods_name[$i] != null){
				if($goods_cname[$i] != null){
				   $input_error_flg = true;
				}
			}
			if($input_error_flg != true){
				$goods_error ="商品が一つも選択されていません。";
				$error_flg = true;
			}
		}

		//エラーの場合はこれ以降の表示処理を行なわない
		if($form->validate() && $error_flg == false){

			//確認画面判定
			if($_POST["ok_btn"] == "登録OK" || $_POST["ok_btn"] == "解約申請OK" || $_POST["ok_btn"] == "変更OK"){

				//レンタルヘッダ・レンタルデータ　登録・更新SQL
				Db_Query($db_con, "BEGIN");

				$duplicate_flg = false;      //重複判定フラグ

				//画面表示形式判定
				if($disp_stat == 1){
					//レンタルID無し

					//レンタルヘッダ登録
					$sql  = "INSERT INTO t_rental_h (";
					$sql .= "    rental_id,";          //レンタルID
					$sql .= "    rental_no,";          //レンタル番号
					$sql .= "    shop_id,";            //ショップID
					$sql .= "    shop_cd1,";           //ショップCD1
					$sql .= "    shop_cd2,";           //ショップCD2
					$sql .= "    shop_name,";          //ショップ名1
					$sql .= "    shop_name2,";         //ショップ名2
					$sql .= "    shop_cname,";         //ショップ名(略称)
					$sql .= "    ap_staff_id,";        //申請担当者ID
					$sql .= "    ap_staff_name,";      //申請担当者名
					$sql .= "    c_staff_id,";         //巡回担当者ID
					$sql .= "    c_staff_name,";       //巡回担当者名
					$sql .= "    client_id,";          //得意先ID
					$sql .= "    client_cd1, ";        //得意先CD1
					$sql .= "    client_cd2, ";        //得意先CD2
					$sql .= "    client_name, ";       //得意先名1
					$sql .= "    client_name2, ";      //得意先名2
					$sql .= "    client_cname, ";      //略称
					$sql .= "    tel, ";               //TEL
					$sql .= "    post_no1, ";          //郵便番号1
					$sql .= "    post_no2, ";          //郵便番号2
					$sql .= "    address1, ";          //住所1
					$sql .= "    address2, ";          //住所2
					$sql .= "    address3, ";          //住所3
					$sql .= "    address_read, ";      //住所カナ
					//$sql .= "    note_h, ";          //備考(本部)
					$sql .= "    note_fc, ";           //備考(FC)
					$sql .= "    apply_day, ";         //レンタル申込日
					$sql .= "    forward_day, ";     //レンタル出荷日
					//$sql .= "    h_staff_id, ";      //本部担当者ID
					//$sql .= "    h_staff_name, ";    //本部担当者名
					$sql .= "    claim_day, ";       //請求月
					$sql .= "    online_flg, ";        //オンラインフラグ
					$sql .= "    regist_shop_id, ";    //登録ショップID
					$sql .= "    shop_amount, ";       //レンタル金額
					$sql .= "    user_amount ";        //ユーザ金額

					$sql .= ")VALUES(";
					$sql .= "    (SELECT COALESCE(MAX(rental_id), 0)+1 FROM t_rental_h),";         
					$sql .= "    '$rental_no',";          
					$sql .= "    $shop_id,";
					$sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $shop_id), ";
					$sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $shop_id), ";
					$sql .= "    (SELECT shop_name FROM t_client WHERE client_id = $shop_id), ";
					$sql .= "    (SELECT shop_name2 FROM t_client WHERE client_id = $shop_id), ";
					$sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $shop_id), ";
					$sql .= "    $app_staff,";
					$sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $app_staff), ";
					$sql .= "    $round_staff,";
					$sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $round_staff), ";
					$sql .= "    $client_id,"; 
					$sql .= "    '$client_cd1',";
					$sql .= "    '$client_cd2',";   
					$sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";                 
					$sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
					$sql .= "    '$client_name',"; 
					$sql .= "    '$tel',";
					$sql .= "    '$post_no1',";
					$sql .= "    '$post_no2',";
					$sql .= "    '$add1',";
					$sql .= "    '$add2',";
					$sql .= "    '$add3',";
					$sql .= "    '$add_read',";
					$sql .= "    '$note',";
					$sql .= "    '$ren_day',";
					//$sql .= "    't',";
					if($for_day != NULL){
						$sql .= "    '$for_day',"; 
					}else{
						$sql .= "    NULL,"; 
					}
					if($claim_day != NULL){
						$sql .= "    '$claim_day',"; 
					}else{
						$sql .= "    NULL,"; 
					}
					$sql .= "    '$online_flg',";
					$sql .= "    $shop_id,";
					$sql .= "    $total_shop,";
					$sql .= "    $total_user";
					$sql .= ");";

					$result = Db_Query($db_con, $sql);
					//同時実行制御処理
					if($result === false){
						$err_message = pg_last_error();
						$err_format = "t_rental_h_rental_no_key";

						Db_Query($db_con, "ROLLBACK");

						//レンタル番号が重複した場合            
						if(strstr($err_message,$err_format) != false){
							$error_msg = "同時に申請を行った為、レンタル番号が重複しました。もう一度申請をして下さい。";
				 
							//再度レンタル番号を取得する
							$sql  = "SELECT";
							$sql .= "   MAX(rental_no)";
							$sql .= " FROM";
							$sql .= "   t_rental_h";
							$sql .= ";";
							$result = Db_Query($db_con, $sql);
							$rental_no = pg_fetch_result($result, 0 ,0);
							$rental_no = $rental_no +1;
							$rental_no = str_pad($rental_no, 8, 0, STR_PAD_LEFT);

							$cons_data["form_rental_no"] = $rental_no;

							$duplicate_flg = true;
						}else{
							exit;
						}
					}

				}else if($disp_stat == 2 || $disp_stat == 5){
					//契約済・解約済
					//取消済
					
					//レンタルヘッダ更新
					$sql  = "UPDATE t_rental_h SET";
					$sql .= "    shop_id =  $shop_id,";                                                               //ショップID
					$sql .= "    shop_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $shop_id),";           //ショップCD1
					$sql .= "    shop_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $shop_id),";           //ショップCD2
					$sql .= "    shop_name = (SELECT shop_name FROM t_client WHERE client_id = $shop_id),";           //ショップ名
					$sql .= "    shop_name2 = (SELECT shop_name2 FROM t_client WHERE client_id = $shop_id),";         //ショップ名2
					$sql .= "    shop_cname = (SELECT client_cname FROM t_client WHERE client_id = $shop_id),";       //ショップ名(略称)
					$sql .= "    ap_staff_id = $app_staff,";                                                          //申請担当者ID
					$sql .= "    ap_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $app_staff),";      //申請担当者名
					$sql .= "    c_staff_id = $round_staff,";                                                         //巡回担当者ID
					$sql .= "    c_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $round_staff),";     //巡回担当者名
					$sql .= "    client_id = $client_id,";                                                            //得意先ID
					$sql .= "    client_cd1 = '$client_cd1', ";                                                       //得意先CD1
					$sql .= "    client_cd2 = '$client_cd2', ";                                                       //得意先CD2
					$sql .= "    client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";    //得意先名1
					$sql .= "    client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";  //得意先名2
					$sql .= "    client_cname = '$client_name', ";                                                    //略称
					$sql .= "    tel = '$tel', ";                                                                     //TEL
					$sql .= "    post_no1 = '$post_no1', ";                                                           //郵便番号1
					$sql .= "    post_no2 = '$post_no2', ";                                                           //郵便番号2
					$sql .= "    address1 = '$add1', ";                                                               //住所1
					$sql .= "    address2 = '$add2', ";                                                               //住所2
					$sql .= "    address3 = '$add3', ";                                                               //住所3
					$sql .= "    address_read = '$add_read', ";                                                       //住所カナ
					//$sql .= "    note_h, ";                                                                         //備考(本部)
					$sql .= "    note_fc = '$note', ";                                                                //備考(FC)
					$sql .= "    apply_day   = '$ren_day', ";                                                         //レンタル申込日
					if($for_day != NULL){
						$sql .= "    forward_day = '$for_day', ";                                                         //レンタル出荷日
					}
					if($claim_day != NULL){
						$sql .= "    claim_day = '$claim_day', ";                                                          //請求月
					}


					//$sql .= "    forward_day = '$for_day', ";                                                         //レンタル出荷日
					//$sql .= "    h_staff_id, ";                                                                     //本部担当者ID
					//$sql .= "    h_staff_name, ";                                                                   //本部担当者名
					//$sql .= "    claim_day = '$claim_day', ";                                                          //請求月
					//$sql .= "    online_flg, ";                                                                     //オンラインフラグ
					$sql .= "    shop_amount = $total_shop, ";                                                        //レンタル金額
					$sql .= "    user_amount = $total_user ";                                                         //ユーザ金額
					$sql .= "WHERE ";
					$sql .= "    rental_id = $rental_id;";
					$result = Db_Query($db_con, $sql);
					if($result == false){
						Db_Query($db_con, "ROLLBACK");
						exit;
					}
					//取消済の場合のみデータ削除
					if($online_flg == "f" || $disp_stat == 5){
						//レンタルデータを削除
						Delete_Rental_D($db_con,$rental_id);
					}
				}


				//****************************
				//レンタルデータ登録
				//****************************
				//オフライン or 新規登録 or 取消済
				if($online_flg == "f" || $disp_stat == 1 || $disp_stat == 5){

					//レンタルデータを削除
					//Delete_Rental_D($db_con,$rental_id);

					if($duplicate_flg != true){
						//レンタルデータ登録
						$line = 1;  //行
						while($goods_num = each($goods_id)){
							$g_num = $goods_num[0];

							//単価の整数部と小数部を結合
							$r_price = $shop_price_i[$g_num].".".$shop_price_d[$g_num];   //レンタル単価
							$u_price = $user_price_i[$g_num].".".$user_price_d[$g_num];   //ユーザ単価

							//レンタル状況取得
							//オフラインの場合
							if($online_flg == "f"){
								//POSTデータが無い場合
								if($rental_stat_num[$g_num] == NULL){
									$rental_stat_num[$g_num] = 10; //契約済
								}
								
							//オンラインの場合
							}else{
								$rental_stat_num[$g_num] = 11; //新規申請
							}
							
							//レンタルID取得
							$sql           = "SELECT rental_id FROM t_rental_h WHERE rental_no = '$rental_no'";  
							$result        = Db_Query($db_con, $sql);
							$rental_id_sql = pg_fetch_result($result,0,0);
/*
							//商品分類・正式名称取得
							$sql  = "SELECT ";
							$sql .= "    t_g_product.g_product_name,";
							$sql .= "    t_g_product.g_product_name || '　' || t_goods.goods_name, ";
							$sql .= "    t_goods.goods_name,";
							$sql .= "    t_goods.serial_flg ";
							$sql .= "FROM ";
							$sql .= "    t_g_product ";
							$sql .= "    INNER JOIN t_goods ON t_goods.g_product_id = t_g_product.g_product_id ";
							$sql .= "WHERE ";
							$sql .= "    t_goods.goods_id = ".$goods_id[$g_num].";";
							$result = Db_Query($db_con, $sql);
							//$pro_data = Get_Data($result,3);
							$pro_data = pg_fetch_array($result);
*/
							//商品分類、正式名、略称、シリアル管理フラグを返す
							$pro_data = Get_Goods_Info($db_con,$goods_id[$g_num]);
							$gpro_data = Get_G_Product_Info($db_con,$g_product_id[$g_num]);


							//シリアル管理あり
							if($serial_flg[$g_num] == 't'){

								//シリアル分データ登録
								for($n = 0; $n < $num[$g_num]; $n++){
									$rental_d_column = NULL;
									$rental_d_column = array(
										"rental_d_id"         => Get_Pkey(),
										"rental_id"           => "$rental_id_sql",
										"line"                => "$line",
										"goods_id"            => "$goods_id[$g_num]",
										"goods_cd"            => "$goods_cd[$g_num]",
										"g_product_id"        => "$gpro_data[g_product_id]",
										//"g_product_name"      => "$pro_data[g_product_name]",
										//"official_goods_name" => "$pro_data[official_goods_name]",
										//"goods_name"          => "$pro_data[goods_name]",
										//"goods_cname"         => "$pro_data[goods_cname]",
										"goods_cname"         => $goods_cname[$g_num],
										"num"                 => "1",
										"serial_no"           => $serial[$g_num][$n],
										"serial_flg"          => "t",
										"shop_price"          => "$r_price",
										"shop_amount"         => ($shop_amount[$g_num] / $num[$g_num]),
										"user_price"          => "$u_price",
										"user_amount"         => ($user_amount[$g_num] / $num[$g_num]),
										"rental_stat"         => "$rental_stat_num[$g_num]",
										"calcel_exec"         => "1",
										"calcel_day"          => "$hdn_calcel_day[$g_num]",
										"reason"              => "$reason[$g_num]",
									);
									//print_array($rental_d_column,"前");
									$rental_d_column = pg_convert($db_con,'t_rental_d',$rental_d_column);//SQLインジェクション対策
									//print_array($rental_d_column,"後");

									$result = Db_Insert($db_con, t_rental_d, $rental_d_column);
									if($result == false){
										Db_Query($db_con, "ROLLBACK");
										exit;
									}
									$line++;

								}

							//シリアル管理しない
							}else{

								$rental_d_column = NULL;
								$rental_d_column = array(
									"rental_d_id"         => Get_Pkey(),
									"rental_id"           => "$rental_id_sql",
									"line"                => "$line",
									"goods_id"            => "$goods_id[$g_num]",
									"goods_cd"            => "$goods_cd[$g_num]",
									"g_product_id"        => "$gpro_data[g_product_id]",
									//"g_product_name"      => "$pro_data[g_product_name]",
									//"official_goods_name" => "$pro_data[official_goods_name]",
									//"goods_name"          => "$pro_data[goods_name]",
									//"goods_cname"         => "$pro_data[goods_cname]",
									"goods_cname"         => $goods_cname[$g_num],
									"num"                 => "$num[$g_num]",
									"serial_no"           => NULL,
									"serial_flg"          => "$pro_data[3]",
									"shop_price"          => "$r_price",
									"shop_amount"         => "$shop_amount[$g_num]",
									"user_price"          => "$u_price",
									"user_amount"         => "$user_amount[$g_num]",
									"rental_stat"         => "$rental_stat_num[$g_num]",
									"calcel_exec"         => "1",
									"calcel_day"          => "$hdn_calcel_day[$g_num]",
									"reason"              => "$reason[$g_num]",
								);

								$rental_d_column = pg_convert($db_con,'t_rental_d',$rental_d_column);//SQLインジェクション対策
								$result = Db_Insert($db_con, t_rental_d, $rental_d_column);

								if($result == false){
									Db_Query($db_con, "ROLLBACK");
									exit;
								}

								$line++;
							}
						}
						//指標をリセットする
						reset($goods_id);
					}
				}



				//****************************
				//レンタルデータ登録
				//****************************
/*

					if($duplicate_flg != true){
						//レンタルデータ登録
						for($g_num = 0; $g_num < count($goods_id); $g_num++){
							//行
							$line = $g_num + 1;


							$rental_d_column = NULL;
							$rental_d_column = array(
								"rental_d_id"         => Get_Pkey(),
								"rental_id"           => "$rental_id_sql",
								"line"                => "$line",
								"goods_id"            => "$goods_id[$g_num]",
								"goods_cd"            => "$goods_cd[$g_num]",
								"g_product_name"      => "$pro_data[0]",
								"official_goods_name" => "$pro_data[1]",
								"goods_name"          => "$pro_data[2]",
								"num"                 => "$num[$g_num]",
								"serial_no"           => "$serial[$g_num]",
								"serial_flg"          => "$pro_data[3]",
								"shop_price"          => "$r_price",
								"shop_amount"         => "$shop_amount[$g_num]",
								"user_price"          => "$u_price",
								"user_amount"         => "$user_amount[$g_num]",
								"rental_stat"         => "$rental_stat_num[$g_num]",
								"calcel_exec"         => "1",
								"calcel_day"          => "$hdn_calcel_day[$g_num]",
								"reason"              => "$reason[$g_num]",
							);
							$rental_d_column = pg_convert($db_con,'t_rental_d',$rental_d_column);//SQLインジェクション対策
							$result = Db_Insert($db_con, t_rental_d, $rental_d_column);

							if($result == false){
								Db_Query($db_con, "ROLLBACK");
								exit;
							}

						}
					}
				}
*/
				//****************************
				//解約処理
				//****************************
				//}else if($disp_stat == 2){
				//契約済・解約済
				if($disp_stat == 2){

					//レンタルデータ更新
					for($g_num = 0; $g_num < count($goods_id); $g_num++){
						//行
						$line = $g_num + 1;

						//チェックが付いている行のみ解約申請
						if($calcel1[$g_num] != null || $calcel2[$g_num] != null){
							$sql  = "UPDATE t_rental_d SET ";
							//解約実施判定
							if($calcel1[$g_num] != NULL){
								//即解約
								$sql .= "    calcel_exec = '2',";                 //解約実施
							}else if($calcel2[$g_num] != NULL){
								//解約日に解約
								$sql .= "    calcel_exec = '3',";                 //解約実施
								$sql .= "    exec_day = '".$exec_day[$g_num]."',";    //実施日
							}
							$sql .= "    renew_num = ".$renew_num[$g_num].",";        //解約数
							$sql .= "    reason    = '".$reason[$g_num]."',";           //解約理由
							$sql .= "    rental_stat = '21' ";                    //レンタル状況を解約申請にする
							$sql .= " WHERE ";
							$sql .= "    rental_id = $rental_id ";
							$sql .= "AND ";
							$sql .= "    line = $line;";
							$result = Db_Query($db_con, $sql);
							if($result == false){
								Db_Query($db_con, "ROLLBACK");
								exit;
							}
						}
					}
					reset($goods_id);
					//オフラインであれば解約処理を実施
					if($online_flg == "f"){
						$result = Rental_sql($db_con,$rental_id,4);
						if($result === false){
							Db_Query($db_con, "ROLLBACK");
							exit;
						}
					}

				}
				Db_Query($db_con, "COMMIT");

				header("Location: ./2-1-143.php?rental_id=$rental_id&disp_stat=$disp_stat&stat_flg=$stat_flg&client_id=$client_id&flg=$online_flg");
			}else{
				//確認画面表示フラグ
				$comp_flg = true;
			}
		}
	}


	/****************************/
	//POST情報変更
	/****************************/
	$form->setConstants($cons_data);
	/****************************/
	//部品作成（可変）
	/****************************/
	$row_num        = 1;    //行番号カウンタ
	$error_loop_num = NULL; //エラー表示ループ配列

	for($i = 0; $i < $max_row; $i++){
		//表示行判定
		if(!in_array("$i", $del_history)){
			$del_data = $del_row.",".$i;

			//商品コード      
			$form->addElement(
				"text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
				style=\" $g_form_style \" 
				onBlur=\"goods_display('hdn_goods_id','form_goods_cd','form_goods_cname','form_shop_price','form_user_price',$i,'form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','$h_coax');blurForm(this);\" onKeyDown=\"chgKeycode();\" onFocus=\"onForm(this)\" "
			);

			//商品分類マスタ
			$form->addElement('select', "form_g_product_id[$i]","", $g_product_ary);

			//商品名
			//$form->addElement("text","form_goods_name[$i]","","size=\"55\" maxLength=\"40\" $g_form_option");

			//品名変更なしの場合はreadonly
			if($name_change[$i] == "1"){
				$readonly = "";
			}else{
				$readonly = readonly;
			}
			//商品名（略称）
			$form->addElement("text","form_goods_cname[$i]","","size=\"38\" maxLength=\"20\" $g_form_option $readonly");

			//数量
			$form->addElement(
				"text","form_num[$i]","",
				"class=\"money\" size=\"11\" maxLength=\"5\" 
					onKeyup=\"Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','true','$h_coax','true','$h_coax');\" $g_form_option "
			);

			//レンタル単価
			$form_shop_price[$i][] =& $form->createElement(
				"text","i","",
				"size=\"11\" maxLength=\"9\"
				class=\"money\"
					onKeyup=\"Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','true','$h_coax');\"
				style=\"text-align: right; $style $g_form_style\"
				$g_form_option"
			);
			$form_shop_price[$i][] =& $form->createElement(
				"text","d","","size=\"2\" maxLength=\"2\" 
					onKeyup=\"Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','true','$h_coax');\"
				style=\"text-align: left; $style $g_form_style\"
				$g_form_option"
			);
			$form->addGroup( $form_shop_price[$i], "form_shop_price[$i]", "",".");

			//レンタル金額
			$form->addElement("text","form_shop_amount[$i]","",'maxLength="18" class="amount"');

		
			//ユーザ提供単価
			$form_user_price[$i][] =& $form->createElement(
				"text","i","",
				"size=\"11\" maxLength=\"9\"
				class=\"money\"
					onKeyup=\"Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','true','$h_coax');\"
				style=\"text-align: right; $style $g_form_style\"
				$g_form_option"
			);
			$form_user_price[$i][] =& $form->createElement(
				"text","d","","size=\"2\" maxLength=\"2\" 
					onKeyup=\"Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','true','$h_coax');\"
				style=\"text-align: left; $style $g_form_style\"
				$g_form_option"
			);
			$form->addGroup( $form_user_price[$i], "form_user_price[$i]", "",".");

			//ユーザ提供金額
			$form->addElement("text","form_user_amount[$i]","",'maxLength="18" class="amount"');


			//画面表示形式判定
			if($disp_stat == 2 && $online_flg == "t"){
				//契約済・解約済は以下の項目フリーズ
				$form->freeze("form_goods_cd[$i]");
				//$form->freeze("form_goods_name[$i]");
				$form->freeze("form_goods_cname[$i]");
				$form->freeze("form_g_product_id[$i]");
				$form->freeze("form_num[$i]");
				$form->freeze("form_shop_price[$i]");
				$form->freeze("form_shop_amount[$i]");
				$form->freeze("form_user_price[$i]");
				$form->freeze("form_user_amount[$i]");
			}

			//■シリアル入力欄

/*
			if($online_flg == "t" || $disp_stat == 6 || $disp_stat == 1 ){

				if($_POST["form_goods_cd"][$i] != NULL || $goods_cd_flg[$i] != NULL){
					$serial_disp[$i] = "シリアル管理なし";
				}

			//if($online_flg == "f" || $disp_stat == 6 || $disp_stat == 1 ){
			}elseif($online_flg == "f" || $disp_stat == 6 || $disp_stat == 1 ){
				//新規申請中(本部)
				//レコードID無し

				//シリアル管理あり
				if($serial_flg[$i] == 't' ){
					//数量分入力フォーム作成
					for($d=0;$d<$serial_num[$i];$d++){
						//シリアル      
						$form->addElement("text","form_serial[$i][$d]","","size=\"18\" maxLength=\"15\" style=\"$g_form_style \" $g_form_option ");
					}

				//シリアル管理しない かつ 商品が選択されている行のみ表示
				}elseif($_POST["form_goods_cd"][$i] != NULL || $goods_cd_flg[$i] != NULL){
					$serial_disp[$i] = "シリアル管理なし";
				}

			}else{
				//FC
				//契約済・解約済(本部)

				//シリアル（数量は必ず1なのでフォームは1しか作成しない）      
				$form->addElement("text","form_serial[$i][0]","","size=\"16\" maxLength=\"15\" style=\"$g_form_style \" $g_form_option ");
				$form->freeze("form_serial[$i][0]");

			}
*/


			//数量分入力フォーム作成
			for($d=0;$d<$serial_num[$i];$d++){
				//シリアル      
				$form->addElement("text","form_serial[$i][$d]","","size=\"18\" maxLength=\"15\" style=\"$g_form_style \" $g_form_option ");
				//オンライン
				if($online_flg == "t" || $rental_stat[$i] == '解約済' || $rental_stat[$i] == '解約予定'){
					$form->freeze("form_serial[$i][$d]");
				}
			}



			//解約理由
			$form->addElement("text","reason[$i]","",'maxLength="20" size="26" style="$g_form_style"'."$g_form_option");
			if($rental_stat[$i] == "解約済"){
				$form->freeze("reason[$i]");
			}

			//解約日
			Addelement_Date($form,"form_calcel_day[$i]","解約実施日","-");
			$form->freeze("form_calcel_day[$i]");

			//解約数
			$form->addElement("text","form_renew_num[$i]","解約数",'class="money" size="11" maxLength="5"'.$g_form_option);

			//実施日
			Addelement_Date($form,"form_exec_day[$i]","実施日","-");


			//契約済　または　解約済の場合
			if($online_flg == "f"){
				
				//解約チェックボックス
				$form->addElement( "checkbox","form_calcel1[".$i."]" ,"");
				$form->addElement( "checkbox","form_calcel2[".$i."]" ,"");

			}elseif($disp_stat == 2){
				
				//解約チェックボックス
				$form->addElement( "checkbox","form_calcel1[".$i."]" ,"");
				$form->addElement( "checkbox","form_calcel2[".$i."]" ,"");

			//解約申請　または　解約予定の場合
			}elseif($disp_stat == "3" || $disp_stat == "4"){
				$form->freeze("form_renew_num[$i]"); //解約数
				$form->freeze("form_exec_day[$i]");  //実施日
			}


			//検索リンク
			$form->addElement(
				"link","form_search[$i]","","#","検索",
				"TABINDEX=-1 onClick=\"Open_SubWin('../dialog/2-0-210.php', Array('hdn_goods_id[$i]','form_goods_cd[$i]','form_goods_cname[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_user_price[$i][i]','form_user_price[$i][d]'), 500, 450,'rental',$i);
				goods_display('hdn_goods_id','form_goods_cd','form_goods_cname','form_shop_price','form_user_price',$i,'form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','$h_coax');
				return false;\""
				 //return Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax');
			);

			//削除リンク
			$form->addElement(
				"link","form_del_row[$i]","",
				"#","<font color='#FEFEFE'>削除</font>",
				"TABINDEX=-1 onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num-1);return false;\""
			);
			
			//商品ID
			$form->addElement("hidden","hdn_goods_id[$i]");

			//レンタル状況（文字列）
			$form->addElement("hidden","hdn_rental_stat[$i]");

			//レンタル状況（数値）
			$form->addElement("hidden","hdn_rental_stat_num[$i]");

			//解約日
			$form->addElement("hidden","hdn_calcel_day[$i]");

			//シリアル管理
			$form->addElement("hidden","hdn_serial_flg[$i]");

			/****************************/
			//フォームフリーズ
			/****************************/
			if($rental_stat[$i] == '解約予定' ){
				$form->freeze("form_goods_cd[$i]"); //商品コード      
				//$form->freeze("form_goods_name[$i]");//商品名
				$form->freeze("form_goods_cname[$i]");//商品名
				$form->freeze("form_g_product_id[$i]");//商品分類
				$form->freeze("form_num[$i]");//数量
				$form->freeze("form_user_price[$i]");//レンタル単価
				$form->freeze("form_user_amount[$i]");//レンタル金額
				$form->freeze("form_shop_price[$i]");//ユーザ提供単価
				$form->freeze("form_shop_amount[$i]");//ユーザ提供金額
				$form->freeze("reason[$i]");
				$form->freeze("form_serial[".$i."][0]");
				$form->freeze("form_calcel_day[$i]");
				$form->freeze("form_renew_num[$i]");
				$form->freeze("form_exec_day[$i]");
				$form->freeze("form_calcel1[$i]");
				$form->freeze("form_calcel2[$i]");
			}


			//確認画面
			if($comp_flg == true){
					$form->freeze();

			//「新規申請中」「解約申請」「解約予定」
			}elseif($disp_stat == 6 || $disp_stat == 3 || $disp_stat == 4){
				if($online_flg != f){
					$form->freeze();
				}
			}

			//****************************
			//表示用HTML作成
			//****************************
			$html .= "<tr class=\"Result1\">";
			$html .=    "<A NAME=$row_num><td align=\"right\">$row_num</td></A>";
			//契約済/解約済・解約申請・解約予定は状況表示
			if($disp_stat == 2 || $disp_stat == 3 || $disp_stat == 4){
				$html .=    "<td align=\"center\">".$rental_stat[$i]."</td>";
				//$html .=    "<td align=\"center\">".$hdn_rental_stat[$i]."</td>";
			}
			$html .=    "<td align=\"left\">";
			$html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
			//検索リンク表示判定(確認画面は非表示)
			if(($disp_stat == 1 || $disp_stat == 5) && $comp_flg != true){
				//レコードID無し
				//取消済
				$html .=    "（";
				$html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
				$html .=    "）";
			}
			$html .=    "<br>";
			//$html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
			$html .=        $form->_elements[$form->_elementIndex["form_g_product_id[$i]"]]->toHtml();
			$html .=    "　";
			$html .=        $form->_elements[$form->_elementIndex["form_goods_cname[$i]"]]->toHtml();
			$html .=    "</td>";
			$html .=    "<td align=\"right\">";
			$html .=        $form->_elements[$form->_elementIndex["form_num[$i]"]]->toHtml();
			$html .=    "</td>";


			//■シリアル
			$html .=    "<td align=\"left\">";
			//シリアル管理する
			if($serial_flg[$i] == 't'){

				//数量分入力フォーム作成
				for($d=0;$d<$serial_num[$i];$d++){
						if($d != 0){
							$html .= "<br>";
						}
						$html .=        $form->_elements[$form->_elementIndex["form_serial[$i][$d]"]]->toHtml();
				}

			//シリアル管理しない かつ 商品が選択されている行のみ表示
			}elseif($_POST["form_goods_cd"][$i] != NULL || $goods_cd_flg[$i] != NULL){
				$html .=    "シリアル管理なし";

			}else{
				$html .=    "";
			}

			$html .=    "</td>";

			//新規申請中
			//レコードID無し
			//if($disp_stat == 6 || $disp_stat == 1){
/*
			if($online_flg == "t" || $disp_stat == 6 || $disp_stat == 1 ){

					$html .=    "<td align=\"center\">";
					$html .=  $serial_disp[$i];

			//if($online_flg == "f" || $disp_stat == 6 || $disp_stat == 1 ){
			}elseif($online_flg == "f" $disp_stat == 6 || $disp_stat == 1 ){

			//if($disp_stat == 6 || $disp_stat == 1 || $online_flg == "f" ){

				//シリアル管理する
				if($serial_flg[$i] == 't'){
					$html .=    "<td align=\"left\">";
					//数量分入力フォーム作成
					for($d=0;$d<$serial_num[$i];$d++){
						if($d != 0){
							$html .= "<br>";
						}
						$html .=        $form->_elements[$form->_elementIndex["form_serial[$i][$d]"]]->toHtml();
					}

				//シリアル管理しない
				}else{
					$html .=    "<td align=\"center\">";
					$html .=  $serial_disp[$i];
				}
				
			//契約済・解約済
			}else{
				$html .=    "<td align=\"left\">";
				$html .=        $form->_elements[$form->_elementIndex["form_serial[$i][0]"]]->toHtml();
			}
*/
			$html .=    "<td align=\"right\">";
			$html .=        $form->_elements[$form->_elementIndex["form_shop_price[$i]"]]->toHtml();
			$html .=    "<br>";
			$html .=        $form->_elements[$form->_elementIndex["form_user_price[$i]"]]->toHtml();
			$html .=    "</td>";
			$html .=    "<td align=\"right\">";
			$html .=        $form->_elements[$form->_elementIndex["form_shop_amount[$i]"]]->toHtml();
			$html .=    "<br>";
			$html .=        $form->_elements[$form->_elementIndex["form_user_amount[$i]"]]->toHtml();
			$html .=    "</td>";


			//新規　または　取消の場合
			if($disp_stat == "1" || $disp_stat == "5"){

			//契約済・解約済
			//}elseif($disp_stat == "2" || $online_flg == "f"){
			}elseif($disp_stat == "2"){

				$html .=    "<td align=\"center\">";
				$html .=        $form->_elements[$form->_elementIndex["form_calcel_day[$i]"]]->toHtml();
				$html .= "  </td>";

				//解約済判定
				if($rental_stat[$i] == '解約済'){
					//解約済は解約数・実施日非表示
					$html .=    "<td align=\"right\">　</td>";
					$html .=    "<td align=\"left\">";
					$html .=        $form->_elements[$form->_elementIndex["reason[$i]"]]->toHtml();
					$html .= "  </td>";
					$html .=    "<td align=\"left\">　</td>";
				}else{
					//契約済
					$html .=    "<td align=\"right\">";
					$html .=        $form->_elements[$form->_elementIndex["form_renew_num[$i]"]]->toHtml();
					$html .= "  </td>";
					$html .=    "<td align=\"left\">";
					$html .=        $form->_elements[$form->_elementIndex["reason[$i]"]]->toHtml();
					$html .= "  </td>";
					$html .=    "<td align=\"left\">";
					$html .=        $form->_elements[$form->_elementIndex["form_calcel1[$i]"]]->toHtml();
					$html .=    "今すぐ実施<br>";
					$html .=        $form->_elements[$form->_elementIndex["form_calcel2[$i]"]]->toHtml();
					$html .=        $form->_elements[$form->_elementIndex["form_exec_day[$i]"]]->toHtml();
					$html .= "  </td>";
				}

			}elseif($disp_stat == "3" || $disp_stat == "4"){
				//解約申請
				//解約予定
				$html .=    "<td align=\"center\">";
				$html .=        $form->_elements[$form->_elementIndex["form_calcel_day[$i]"]]->toHtml();
				$html .=    "</td>";
				$html .=    "<td align=\"right\">";
				$html .=        $form->_elements[$form->_elementIndex["form_renew_num[$i]"]]->toHtml();
				$html .= "  </td>";
				$html .=    "<td align=\"left\">";
				$html .=        $form->_elements[$form->_elementIndex["reason[$i]"]]->toHtml();
				$html .= "  </td>";
				//表示形式判定
				if($calcel_msg_flg[$i] == true){
					//即解約
					$html .=    "<td align=\"center\">今すぐ実施</td>";
				}else{
					//解約予定
					$html .=    "<td align=\"center\">";
					$html .=        $form->_elements[$form->_elementIndex["form_exec_day[$i]"]]->toHtml();
					$html .=    "</td>";
				}
			}
			
			//オフラインの場合は削除リンクを表示
			if($online_flg == "f" || $disp_stat == "1" || $disp_stat == "5" ){

				//確認画面は削除リンク非表示
				if($comp_flg != true){
					//レンタルID無し・取消済
					$html .= "  <td class=\"Title_Add\" align=\"center\">";
					$html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
					$html .= "  </td>";
				}

			}
			$html .= "</tr>\n\n";

			//行番号を＋１
			$row_num = $row_num+1;

		}
		//エラーループ数配列作成
		$error_loop_num[] = $i;
	}

	//タイトルの横にボタン表示
	$page_title_btn .= "　".$form->_elements[$form->_elementIndex[input_btn]]->toHtml();
	$page_title_btn .= "　".$form->_elements[$form->_elementIndex[disp_btn]]->toHtml();

}else{
	//不正時には一覧ボタン表示のみ
	$form->addElement("button","disp_btn","一　覧","onClick=\"location.href='".FC_DIR."system/2-1-142.php'\"");
}

/****************************/
// HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
// 画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title.$page_title_btn);

//  Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_menu"     => "$page_menu",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer", 
	"shop_name"     => "$shop_name",
	'html'          => "$html",
	'warning'       => "$warning",
	'java_sheet'    => "$java_sheet",
	'error_msg'     => "$error_msg",
	'error_msg2'    => "$error_msg2",
	'goods_error'   => "$goods_error",
	'disp_stat'     => "$disp_stat",
	'comp_flg'      => "$comp_flg",
	'injust_msg'    => "$injust_msg",
	'auth_r_msg'    => "$auth_r_msg",
	'stat_flg'      => "$stat_flg",
	'online_flg'      => "$online_flg",
));

// 表示データ
$smarty->assign("disp_data", $disp_data);
//エラーループ数
$smarty->assign('error_loop_num',$error_loop_num);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
