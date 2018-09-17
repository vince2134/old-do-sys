<?php

/**************************************************
基本情報
**************************************************/
//配送日
$form->addElement("hidden","form_delivery_day[y]");
$form->addElement("hidden","form_delivery_day[m]");
$form->addElement("hidden","form_delivery_day[d]");
//売上計上日
$form->addElement("hidden","form_sale_day[y]");
$form->addElement("hidden","form_sale_day[m]");
$form->addElement("hidden","form_sale_day[d]");
//請求日
$form->addElement("hidden","form_request_day[y]");
$form->addElement("hidden","form_request_day[m]");
$form->addElement("hidden","form_request_day[d]");
//順路
$form->addElement("hidden","form_route_load[1]","");
$form->addElement("hidden","form_route_load[2]","");
//取引区分
$form->addElement("hidden","trade_aord","");
//請求先
$form->addElement('hidden',"form_claim", "");

/**************************************************
巡回担当者
**************************************************/
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

//備考
$form->addElement("hidden","form_note","");
//訂正理由
$form->addElement("hidden","form_reason","");

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
}

	
$form->addElement("hidden", "hdn_client_id");       //得意先
$form->addElement("hidden", "hdn_contract_id");     //契約情報ID
$form->addElement("hidden", "goods_search_row");    //商品コード入力行    
$form->addElement("hidden", "correction_flg");      //訂正ボタン押下フラグ    
$form->addElement("hidden", "attach_gid");          //所属グループID
$form->addElement("hidden", "hdn_aord_id");         //受注ID
$form->addElement("hidden", "clear_flg");           //クリア判定フラグ
$form->addElement("hidden", "hdn_contract_div");    //契約区分
$form->addElement("hidden", "hdn_trust_rate");      //代行依頼料
$form->addElement("hidden", "hdn_back_display");    //予定明細の遷移元
$form->addElement("hidden", "hdn_aord_id_array");   //該当日の全ての受注ID

?>