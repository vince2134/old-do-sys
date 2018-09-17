<?php

/**************************************************
基本情報
**************************************************/
//契約状態
$form->addElement('hidden',"state", "");

//顧客名
$form->addElement("hidden","form_client[cd1]");
$form->addElement("hidden","form_client[cd2]");
$form->addElement("hidden","form_client[name]");

//紹介口座先
$form->addElement('hidden',"intro_ac_name", "");
$form->addElement('hidden',"intro_ac_price", "");
$form->addElement('hidden',"intro_ac_rate", "");
$form->addElement("hidden","intro_ac_div[0]",""); //有無

//契約日
$form->addElement("hidden","form_contract_day[y]");
$form->addElement("hidden","form_contract_day[m]");
$form->addElement("hidden","form_contract_day[d]");

//請求先
$form->addElement('hidden',"form_claim", "");

/**************************************************
代行
**************************************************/
//代行依頼チェックボックス
$form->addElement('hidden',"daiko_check", "");

//代行料
$form->addElement('hidden',"act_request_price", "");
$form->addElement('hidden',"act_request_rate", "");
$form->addElement("hidden","act_div[0]",""); //有無

//受託先 （FC）コード
$form->addElement("hidden","form_daiko[cd1]");
$form->addElement("hidden","form_daiko[cd2]");
$form->addElement("hidden","form_daiko[name]");

//受託先宛備考
$form->addElement('hidden',"form_daiko_note", "");

/**************************************************
巡回日
**************************************************/
//巡回日(1)
$form->addElement("hidden","form_abcd_week1");
$form->addElement("hidden","form_week_rday1");

//巡回日(2)
$form->addElement("hidden","form_rday2");

//巡回日(3)
$form->addElement("hidden","form_cale_week3");
$form->addElement("hidden","form_week_rday3");

//巡回日(4)
$form->addElement("hidden","form_cale_week4","");
$form->addElement("hidden","form_week_rday4","");
//巡回日(5)
$form->addElement("hidden","form_cale_month5","");
$form->addElement("hidden","form_week_rday5","");
//巡回日(6)
$form->addElement("hidden","form_cale_month6","");
$form->addElement("hidden","form_cale_week6","");
$form->addElement("hidden","form_week_rday6","");

//巡回日ラジオボタン
$form->addElement("hidden","form_round_div1[0]","");


//契約発効日
$form->addElement("hidden","form_stand_day[y]","");
$form->addElement("hidden","form_stand_day[m]","");
$form->addElement("hidden","form_stand_day[d]","");

//修正有効日
$form->addElement("hidden","form_update_day[y]","");
$form->addElement("hidden","form_update_day[m]","");
$form->addElement("hidden","form_update_day[d]","");

//契約終了日
$form->addElement("hidden","form_contract_eday[y]","");
$form->addElement("hidden","form_contract_eday[m]","");
$form->addElement("hidden","form_contract_eday[d]","");


/**************************************************
巡回担当者
**************************************************/
//NO
$form->addElement("hidden","form_line","");
//巡回担当
$form->addElement("hidden","form_c_staff_id1","");
$form->addElement("hidden","form_c_staff_id2","");
$form->addElement("hidden","form_c_staff_id3","");
$form->addElement("hidden","form_c_staff_id4","");
//売上
$form->addElement("hidden","form_sale_rate1","");
$form->addElement("hidden","form_sale_rate2","");
$form->addElement("hidden","form_sale_rate3","");
$form->addElement("hidden","form_sale_rate4","");
//順路
$form->addElement("hidden","form_route_load[1]","");
$form->addElement("hidden","form_route_load[2]","");
//備考
$form->addElement("hidden","form_note","");

/**************************************************
巡回商品
**************************************************/
for($i=1;$i<=5;$i++){
	//販売区分
	$form->addElement("hidden","form_divide[".$i."]","");
	//一式フラグ
	$form->addElement("hidden","form_issiki[".$i."]","");
	//サービス
	$form->addElement("hidden","form_serv[".$i."]","");
	//商品名（正式）
	$form->addElement("hidden","official_goods_name[".$i."]","");

	for($s=1;$s<=3;$s++){
		//伝票印字
		$form->addElement( "hidden","form_print_flg".$s."[".$i."]" ,"");
		//商品コード
		$form->addElement("hidden","form_goods_cd".$s."[$i]","");
		//商品名
		$form->addElement("hidden","form_goods_name".$s."[$i]","");
		//商品数
		$form->addElement("hidden","form_goods_num".$s."[$i]","");
		//商品ID
		$form->addElement("hidden","hdn_goods_id".$s."[$i]","");
		//品名変更フラグ
		$form->addElement("hidden","hdn_name_change".$s."[$i]","");
	}

	//営業原価
	$form->addElement("hidden","form_trade_price[".$i."][1]","");
	$form->addElement("hidden","form_trade_price[".$i."][2]","");
	//原価合計
	$form->addElement("hidden","form_trade_amount[".$i."]","");
	//売上単価
	$form->addElement("hidden","form_sale_price[".$i."][1]","");
	$form->addElement("hidden","form_sale_price[".$i."][2]","");
	//売上合計
	$form->addElement("hidden","form_sale_amount[".$i."]","");

	//口座料
	$form->addElement('hidden',"form_aprice_div[$i]", "");
	$form->addElement('hidden',"form_account_price[$i]", "");
	$form->addElement('hidden',"form_account_rate[$i]", "");

	//前受相殺
	$form->addElement('hidden',"form_ad_offset_radio[$i]", "");
	$form->addElement('hidden',"form_ad_offset_amount[$i]", "");

	//商品マスタ同期フラグ
	$form->addElement('hidden',"mst_sync_flg[$i]", "");
}

	
$form->addElement("hidden", "goods_search_row");    //商品コード入力行    
$form->addElement("hidden", "entry_flg");           //登録ボタン押下フラグ    
$form->addElement("hidden", "delete_flg");          //削除ボタン押下フラグ    
$form->addElement("hidden", "hdn_client_id");       //得意先
$form->addElement("hidden", "hdn_daiko_id");        //代行ID
$form->addElement("hidden", "hdn_flg");             //追加・更新判別フラグ
$form->addElement("hidden", "hdn_con_id");          //契約情報ID
$form->addElement("hidden", "client_search_flg");   //得意先検索フラグ
$form->addElement("hidden", "daiko_search_flg");    //受託先検索フラグ
$form->addElement("hidden", "hdn_return_flg");      //戻る表示判定フラグ
$form->addElement("hidden", "clear_flg");           //クリア判定フラグ
$form->addElement("hidden", "hdn_get_flg");         //契約概要の戻るボタン遷移判定フラグ
$form->addElement("hidden", "hdn_c_check_flg");     //変則日復元判定フラグ
$form->addElement("hidden", "copy_value_flg");      //複写追加の次へ前へボタン押下判定フラグ

?>