<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/01/15      xx_xxx      kajioka-h   オフライン解約のときに変更ボタンをつけた件の変更
*/

/****************************/
//レンタルTOレンタルの部品定義
/****************************/

//レンタル番号
$form->addElement(
    "text","form_rental_no","",
    "style=\"color : #585858; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);

//画面表示形式判定
if(($disp_stat == 4 || $disp_stat == 2 || $disp_stat == 1) && $online_flg == 'f' && $group_kind == 1){
	//オフライン

	// FCのショップ
	$select_value = NULL;
	//プルダウン値取得条件
	$where  = " WHERE ";
    $where .= "     t_client.client_div = '3' ";
    $where .= " AND ";
    $where .= "     t_rank.group_kind IN ('2','3') ";
    $where .= " AND ";
	//変更表示判定
	if($rental_id != NULL){
		//変更(取引中orDBに登録されているショップ)
		$where .= "     (t_client.state = '1' OR (t_client.client_id = (SELECT shop_id FROM t_rental_h WHERE rental_id = $rental_id)))";
	}else{
		//新規登録(取引中のみ)
		$where .= "     t_client.state = '1' ";
	}

	$select_value = Select_Get($db_con, "rshop",$where);
	$offline = $form->addElement('select', 'form_shop_name', 'セレクトボックス', $select_value,"onKeyDown=\"chgKeycode();\" onChange =\"Button_Submit('client_search_flg','#','true');window.focus();\"");

	//オフラインの契約中はショップは変更不可
	if($disp_stat == 2){
		$offline->freeze();
	}

}else{
	//オンライン

	//ショップ名
	$form->addElement(
	    "text","form_shop_name","",
	    "style=\"color : #585858; width:300pt;
	    border : #ffffff 1px solid; 
	    background-color: #ffffff; 
	    text-align: left\" readonly'"
	);
}

//画面表示形式判定
if($disp_stat == 1 || $disp_stat == 5 || (($disp_stat == 4 || $disp_stat == 2 || $disp_stat == 1) && $online_flg == 'f' && $group_kind == 1)){
	//レンタルID無し、取消済、契約済・解約済(オフライン)、レンタルID無し(オフライン)、解約予定(オフライン)

	//レンタル申込日
	$form_rental_day[] =& $form->createElement("text","y","テキストフォーム","style=\"ime-mode:disabled;\" size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_rental_day[y]','form_rental_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_rental_day[y]','form_rental_day[m]','form_rental_day[d]')\" onBlur=\"blurForm(this)\"");
	$form_rental_day[] =& $form->createElement("text","m","テキストフォーム","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_rental_day[m]','form_rental_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_rental_day[y]','form_rental_day[m]','form_rental_day[d]')\" onBlur=\"blurForm(this)\"");
	$form_rental_day[] =& $form->createElement("text","d","テキストフォーム","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onFocus=\"onForm_today(this,this.form,'form_rental_day[y]','form_rental_day[m]','form_rental_day[d]')\" onBlur=\"blurForm(this)\"");
	$form->addGroup( $form_rental_day,"form_rental_day","form_rental_day","-");
}else{
	//新規申請中
	//契約済・解約済
	//解約申請
	//解約予定

	//レンタル申込日
	$form_rental_day[] =& $form->createElement("text","y","テキストフォーム","style=\"ime-mode:disabled;\" size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_rental_day[y]','form_rental_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_rental_day[y]','form_rental_day[m]','form_rental_day[d]')\" onBlur=\"blurForm(this)\"");
	$form_rental_day[] =& $form->createElement("text","m","テキストフォーム","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_rental_day[m]','form_rental_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_rental_day[y]','form_rental_day[m]','form_rental_day[d]')\" onBlur=\"blurForm(this)\"");
	$form_rental_day[] =& $form->createElement("text","d","テキストフォーム","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onFocus=\"onForm_today(this,this.form,'form_rental_day[y]','form_rental_day[m]','form_rental_day[d]')\" onBlur=\"blurForm(this)\"");
	$freeze_data = $form->addGroup( $form_rental_day,"form_rental_day","form_rental_day","-");
	$freeze_data->freeze();
}

$form_staff_id = Select_Get($db_con,'cstaff');

//フォーム判定
if((($disp_stat == 4 || $disp_stat == 2 || $disp_stat == 1) && $online_flg == 'f') || $group_kind == 1){
	//オフラインor本部
	
	//申請担当者
	$freeze_form[] = $form->addElement('text', 'form_app_staff',"",'size="23" maxLength="10"'." $g_form_option");
	//巡回担当者
	$freeze_form[] = $form->addElement('text', 'form_round_staff',"",'size="23" maxLength="10"'." $g_form_option");
}else{
	//オンライン(FC)

	//申請担当者
	$freeze_form[] = $form->addElement('select', 'form_app_staff', 'セレクトボックス', $form_staff_id, $g_form_option_select);
	//巡回担当者
	$freeze_form[] = $form->addElement('select', 'form_round_staff', 'セレクトボックス', $form_staff_id, $g_form_option_select);
}

//オフライン判定
if(($disp_stat == 4 || $disp_stat == 2 || $disp_stat == 1) && $online_flg == 'f' && $group_kind == 1){
	//オフライン

	//ユーザ名1
	$form_client[] =& $form->createElement("text", "name", "",'size="34" maxLength="20"'." $g_form_option");
	$freeze_form[] = $form->addGroup( $form_client, "form_client", "");

	//ユーザ名2
	$freeze_form[] = $form->addElement('text', 'form_client_name2',"",'size="34" maxLength="25"'." $g_form_option");
}else{
	//オンライン

	//ユーザ名
	$form_client[] =& $form->createElement(
	    "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\" onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
	);
	$form_client[] =& $form->createElement(
	    "static","","","-"
	);
	$form_client[] =& $form->createElement(
	    "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onChange=\"javascript:Button_Submit('client_search_flg','#','true')\"".$g_form_option."\""
	);
	$form_client[] =& $form->createElement(
	    "text","name","",
	    "size=\"34\" $g_text_readonly"
	);

	//契約済・解約済(FC)判定
	if($disp_stat == 2 && $group_kind == 2){
		//契約済・解約済(FC)ならユーザは変更不可
		$freeze_client = $form->addGroup( $form_client, "form_client", "");
		$freeze_client->freeze();
	}else{
		//オンライン
		$freeze_form[] = $form->addGroup( $form_client, "form_client", "");
	}
}

//画面表示形式判定
if(($disp_stat == 2) || ($disp_stat == 1 && $group_kind == 1)){
	//契約済・解約済
	//レンタルID無し(本部)
	//確認画面

	//ユーザ名リンクなし
	$form->addElement("static","form_client_link","","ユーザ名");

}else if($disp_stat == 1 || $disp_stat == 5){
	//レンタルID無し
	//取消済
	
	//ユーザ名リンク
	$form->addElement("link","form_client_link","","./2-1-141.php","ユーザ名","
	    onClick=\"return Open_SubWin('".FC_DIR."dialog/2-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]', 'client_search_flg'),500,450,5,1);\""
	);
}else{
	//新規申請中
	//解約申請
	//解約予定

	//ユーザ名リンクなし
	$form->addElement("static","form_client_link","","ユーザ名");
}

//ユーザTEL
$freeze_form[] = $form->addElement("text", "form_tel", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option");

//郵便番号
$form_post[] =& $form->createElement("text", "no1", "", "size=\"3\" maxLength=\"3\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_post[no1]', 'form_post[no2]',3)\"".$g_form_option."\"");
$form_post[] =& $form->createElement("static", "", "", "-");
$form_post[] =& $form->createElement("text", "no2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\""." $g_form_option");
$freeze_form[] = $form->addGroup($form_post, "form_post", "");

// 住所１
$freeze_form[] = $form->addElement("text", "form_add1", "",'size="50" maxLength="25"'." $g_form_option");
// 住所２
$freeze_form[] = $form->addElement("text", "form_add2", "",'size="50" maxLength="25"'." $g_form_option");
// 住所３
$freeze_form[] = $form->addElement("text", "form_add3", "",'size="55" maxLength="30"'." $g_form_option");
// 住所(フリガナ)
$freeze_form[] = $form->addElement("text", "form_add_read", "",'size="50" maxLength="50"'." $g_form_option");

//備考
$freeze_form[] = $form->addElement("textarea","form_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area);

//本部判定
if($group_kind == 1){
	//本部

	//レンタル出荷日
	$form_forward_day[] =& $form->createElement("text","y","テキストフォーム","style=\"ime-mode:disabled;\" size=\"4\" maxLength=\"4\" onkeyup=\"Rental_claim(this.form,'form_forward_day[y]','form_forward_day[m]',4,'form_forward_day[y]','form_forward_day[m]','form_claim_day[y]','form_claim_day[m]')\" onFocus=\"Forward_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]','form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
	$form_forward_day[] =& $form->createElement("text","m","テキストフォーム","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onkeyup=\"Rental_claim(this.form,'form_forward_day[m]','form_forward_day[d]',2,'form_forward_day[y]','form_forward_day[m]','form_claim_day[y]','form_claim_day[m]')\" onFocus=\"Forward_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]','form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
	$form_forward_day[] =& $form->createElement("text","d","テキストフォーム","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onFocus=\"Forward_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]','form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
	$freeze_form2[] = $form->addGroup( $form_forward_day,"form_forward_day","form_forward_day","-");

	//本部担当者
	$freeze_form2[] = $form->addElement('select', 'form_head_staff', 'セレクトボックス', $form_staff_id, $g_form_option_select);

	//請求月
	$form_claim_day[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_claim_day[y]','form_claim_day[m]',4)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
	$form_claim_day[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
	$freeze_form2[] = $form->addGroup( $form_claim_day,"form_claim_day","form_claim_day","-");

	//備考(本部用)
	$freeze_form2[] = $form->addElement("textarea","form_h_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area);
}else{
	//FC

	//レンタル出荷日
	$form_forward_day[] =& $form->createElement("text","y","テキストフォーム","style=\"ime-mode:disabled;\" size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_forward_day[y]','form_forward_day[m]',4)\" onFocus=\"onForm_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]')\" onBlur=\"blurForm(this)\"");
	$form_forward_day[] =& $form->createElement("text","m","テキストフォーム","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onkeyup=\"changeText(this.form,'form_forward_day[m]','form_forward_day[d]',2)\" onFocus=\"onForm_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]')\" onBlur=\"blurForm(this)\"");
	$form_forward_day[] =& $form->createElement("text","d","テキストフォーム","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onFocus=\"onForm_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]')\" onBlur=\"blurForm(this)\"");
	$freeze_data = $form->addGroup( $form_forward_day,"form_forward_day","form_forward_day","-");
	$freeze_data->freeze();

	//本部担当者
	$freeze_data = $form->addElement('select', 'form_head_staff', 'セレクトボックス', $form_staff_id, $g_form_option_select);
	$freeze_data->freeze();

	//請求月
	$form_claim_day[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_claim_day[y]','form_claim_day[m]',4)\" onFocus=\"onForm_today2(this,this.form,'form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
	$form_claim_day[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" onFocus=\"onForm_today2(this,this.form,'form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
	$freeze_data = $form->addGroup( $form_claim_day,"form_claim_day","form_claim_day","-");
	$freeze_data->freeze();

	//備考(本部用)
	$freeze_data = $form->addElement("textarea","form_h_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area);
	$freeze_data->freeze();
}

//画面表示形式判定
if($disp_stat == 6 && $group_kind == 1 && $online_flg == 't'){
	//新規申請中(本部)
	
	//承認確認ボタン
	$form->addElement("submit","comp_btn","承認確認画面へ","$disabled");
	//承認ＯＫボタン
	$form->addElement("submit","ok_btn","承認OK");

	//申請取消確認ボタン
	$form->addElement("submit","cancel_btn","申請取消確認画面へ","$disabled");
	//申請取消ＯＫボタン
	$form->addElement("button","cancel_ok_btn", "申請取消OK", "onClick=\"javascript:Button_Submit_1('cancel_flg', '#','true')\"");

}else if($disp_stat == 2 && $group_kind == 1 && $online_flg == 'f'){
	//契約済・解約済(オフライン)

    //変更確認ボタン
    $form->addElement("submit","edit_btn", "変更確認画面へ", "$disabled");

    //解約確認ボタン
    $form->addElement("submit","comp_btn","解約確認画面へ","$disabled");

    //変更時
    if($edit_flg == true){
    	//変更ＯＫボタン
        $form->addElement("submit","ok_btn","変更OK");
    //解約時
    }else{
        //解約ＯＫボタン
        $form->addElement("submit","ok_btn","解約OK");
    }

	//自動入力
	$form->addElement("button","input_auto", "自動入力", "onClick=\"javascript:Button_Submit_1('auto_flg', '#', 'true')\"");

}else if($disp_stat == 2 && $group_kind == 1){
	//契約済・解約済(本部)

	//変更確認ボタン
	$form->addElement("submit","comp_btn","変更確認画面へ","$disabled");
	//変更ＯＫボタン
	$form->addElement("submit","ok_btn","変更OK");

}else if($disp_stat == 3 && $group_kind == 1 && $online_flg == 't'){
	//解約申請(本部)
	
	//解約承認・実施確認ボタン
	$form->addElement("submit","comp_btn","解約承認・実施確認画面へ","$disabled");
	//解約承認・実施ＯＫボタン
	$form->addElement("submit","ok_btn","解約承認・実施OK");

	//解約取消確認ボタン
	$form->addElement("submit","cancel_btn","解約取消確認画面へ","$disabled");
	//解約取消ＯＫボタン
	$form->addElement("button","cancel_ok_btn", "解約取消OK", "onClick=\"javascript:Button_Submit_1('cancel_flg', '#','true')\"");

}else if($disp_stat == 4 && $group_kind == 1){
	//解約予定(本部)
	
	//解約取消確認ボタン
	$form->addElement("submit","comp_btn","解約取消確認画面へ","$disabled");
	//解約取消ＯＫボタン
	$form->addElement("submit","ok_btn","解約取消OK");

}else if($disp_stat == 1 || $disp_stat == 5 || ($disp_stat == 1 && $online_flg == 'f')){
	//レンタルID無し・取消済・レンタルID無し(オフライン)

	//自動入力
	$form->addElement("button","input_auto", "自動入力", "onClick=\"javascript:Button_Submit_1('auto_flg', '#', 'true')\"");
	//行追加ボタン
	$form->addElement("button","add_row_btn","行追加","onClick=\"javascript:Button_Submit('add_row_flg', '#foot', 'true')\"");
	//登録確認ボタン
	$form->addElement("submit","comp_btn","登録確認画面へ","$disabled");
	//登録ＯＫボタン
	$form->addElement("submit","ok_btn","登録OK");

	//レンタルID無し(オフライン)判定
	if($disp_stat == 1 && $online_flg == 'f'){
		//入力欄を表示
		$form->addElement("button","input_form_btn", "入力欄を表示", "onClick=\"javascript:Button_Submit_1('input_form_flg', '#', 'true')\"");
	}

}else if($disp_stat == 2){
	//契約済・解約済(FC)

	//自動入力
	$form->addElement("button","input_auto", "自動入力", "onClick=\"javascript:Button_Submit_1('auto_flg', '#', 'true')\"");

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
		if($stat_data[0] == '契約済'){
			$stat_flg = true;
		}
	}

	//契約済があるか判定
	if($stat_flg == true){
		//契約済・解約済がある

		//解約申請確認ボタン
		$form->addElement("submit","comp_btn","解約申請確認画面へ","$disabled");
		//解約申請ＯＫボタン
		$form->addElement("submit","ok_btn","解約申請OK");
	}else{
		//解約済のみ

		//変更確認ボタン
		$form->addElement("submit","comp_btn","変更確認画面へ","$disabled");
		//変更ＯＫボタン
		$form->addElement("submit","ok_btn","変更OK");
	}
}

//TOPメニュー以外から遷移してきた場合に戻るボタン表示
if($top_menu == NULL){
	//本部判定
	if($group_kind == 1){
		//本部

		//戻る
		//$form->addElement("button","return_btn","戻　る","onClick=\"location.href='".HEAD_DIR."sale/1-2-130.php'\"");
		$form->addElement("button","return_btn","戻　る","onClick=\"location.href='".Make_Rtn_Page("rental")."'\"");
	}else{
		//ＦＣ

		//戻る
		//$form->addElement("button","return_btn","戻　る","onClick=\"location.href='".FC_DIR."system/2-1-142.php'\"");
		$form->addElement("button","return_btn","戻　る","onClick=\"location.href='".Make_Rtn_Page("rental")."'\"");
	}

}

//確認画面用の戻るボタン
$form->addElement("button","back_btn","戻　る","onClick=\"javascript:history.back()\"");

//本部判定
if($group_kind == 1){
	//本部

	//一覧
	$form->addElement("button","disp_btn","一　覧","onClick=\"location.href='".HEAD_DIR."sale/1-2-130.php'\"");
}else{
	//FC

	//一覧
	$form->addElement("button","disp_btn","一　覧","onClick=\"location.href='".FC_DIR."system/2-1-142.php'\"");
}

//登録(ヘッダ)
$form->addElement("button","input_btn","登　録",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

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
?>
