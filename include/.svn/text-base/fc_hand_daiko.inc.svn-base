<?php
/**
 *
 * 代行用のフォーム生成
 *
 * 呼出元
 * ・2-2-201（手書伝票発行）
 * ・2-2-118（予定手書伝票）
 *
 */
/*
 *  変更履歴
 *  日付            担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/15      suzuki      月の周期のvalue値追加
 *  2007/06/04      kajioka-h   代行料の仕様が戻ったためJS等を追加しました
 */

/**************************************************
代行
**************************************************/
//FC・直営判定
if($group_kind == 2){
	//直営

	//代行依頼チェックボックス
	$form_daiko = NULL;
	//顧客名指定判定
	if($client_id != NULL){
        //$daiko_js = "onClick=\"javascript:tegaki_daiko_checked(); Mult_double_All('$coax',false,'$daiko_coax'); \"";
        $daiko_js = "onClick=\"javascript:tegaki_daiko_checked(); Act_Request_Rate('$coax',false,'$daiko_coax'); \"";
		//javascript実行フォーム作成
		$form_daiko[] =& $form->createElement("radio", NULL, NULL, "自社巡回　　　", "1", $daiko_js);
		//$form_daiko[] =& $form->createElement("radio", NULL, NULL, "オンライン代行", "2", $daiko_js);
		$form_daiko[] =& $form->createElement("radio", NULL, NULL, "オフライン代行", "3", $daiko_js);
	}else{
		//javascriptなしフォーム作成
		$form_daiko[] =& $form->createElement("radio", NULL, NULL, "自社巡回　　　", "1");
		//$form_daiko[] =& $form->createElement("radio", NULL, NULL, "オンライン代行", "2");
		$form_daiko[] =& $form->createElement("radio", NULL, NULL, "オフライン代行", "3");
	}
	$form->addGroup($form_daiko, "daiko_check", "");

	//代行料
	//$form->addElement("text","form_daiko_price","",'size="8" maxLength="10"'.$g_form_option." style='text-align:right; ime-mode:disabled;' onKeyup=\"Mult_double4('form_goods_num1','form_sale_price','form_sale_amount','form_trade_price','form_trade_amount','form_issiki','$coax','$daiko_coax');\"");

    //代行料区分
    //$act_div_js = "onClick=\"t_price_readonly(this.value); Mult_double4('form_goods_num1','form_sale_price','form_sale_amount','form_trade_price','form_trade_amount','form_issiki','$coax','$daiko_coax'); \"";
    $act_div_js = "onClick=\"t_price_readonly('$coax',this.value,'$daiko_coax');\"";

    $act_div_ary1[] =& $form->createElement("radio",NULL,NULL, "発生する：固定額","2", $act_div_js);
    $form->addGroup($act_div_ary1, "act_div[]", "委託料");

    $act_div_ary2[] =& $form->createElement("radio",NULL,NULL, "発生する：売上の","3", $act_div_js);
    $form->addGroup($act_div_ary2, "act_div[]", "委託料");

    $act_div_ary3[] =& $form->createElement("radio",NULL,NULL, "発生しない","1", $act_div_js);
    $form->addGroup($act_div_ary3, "act_div[]", "委託料");

    //代行料フォーム
    //$form->addElement("text","act_request_price","円",'class="money_num" size="7" maxLength="6"'.$g_form_option);
    $form->addElement("text","act_request_price","円",'class="money_num" size="7" maxLength="6"'.$g_form_option);
    //$form->addElement("text","act_request_rate" ,"％",'class="num"       size="7" maxLength="3"'.$g_form_option);
    $form->addElement("text","act_request_rate" ,"％",'class="num"       size="7" maxLength="3"'.$g_form_option.
        "onKeyup=\"Act_Request_Rate('$coax',false,'$daiko_coax');\""
    );


	//受託先 （FC）コード
	$form_daiko = NULL;
	$form_daiko[] =& $form->createElement(
		        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onChange=\"javascript:Change_Submit('daiko_search_flg','#','true','form_daiko[cd2]')\" onkeyup=\"changeText(this.form,'form_daiko[cd1]','form_daiko[cd2]',6)\"".$g_form_option."\""
		        );

	$form_daiko[] =& $form->createElement(
		        "static","","","-"
		        );
	$form_daiko[] =& $form->createElement(
		        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onChange=\"javascript:Button_Submit('daiko_search_flg','#','true')\"".$g_form_option."\""
		        );
	$form_daiko[] =& $form->createElement(
	    "text","name","",
	    "size=\"34\" $g_text_readonly"
	);
	$form->addGroup( $form_daiko, "form_daiko", "");

	//受託先リンク
	$form->addElement("link","form_daiko_link","代行先","./2-2-201.php","代行先","
	    onClick=\"return Open_SubWin('../../franchise/dialog/2-0-251.php',Array('form_daiko[cd1]','form_daiko[cd2]','form_daiko[name]', 'daiko_search_flg'),500,450,5,'daiko');\""
	);

	//受託先宛備考
	$form->addElement("textarea","form_daiko_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area);


    $form->addElement("hidden", "hdn_daiko_id");        //代行ID
    $form->addElement("hidden", "hdn_daiko_coax");      //代行のまるめ区分
    $form->addElement("hidden", "daiko_search_flg");    //代行サーチフラグ


}


?>
