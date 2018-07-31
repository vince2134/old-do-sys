<?php

/******************************
 *  変更履歴
 *      ・2006-10-26 売上率が０％の巡回担当者を表示<suzuki>
 *      ・2007-02-22 不要機能の削除<watanabe−k>
 *      ・2007-03-29 変更履歴を表示するように修正<morita-d>
 *      ・2007-04-13 戻るボタンの遷移先を修正<fukuda>
 *      ・2007-04-23 代行料の表示を変更<morita-d>
 *      ・2007-05-26 固定額の代行料が0で表示されてしまう不具合を修正<morita-d>
 *      ・2007-06-06 変更履歴のスタッフ名がサニタイジングされていない不具合を修正<morita-d>
 *      ・2007-06-19 前受金に関する処理を追加<morita-d>
 *      ・2009-09-24 値引商品は赤字で表示<aoyama-n>
 *      ・2011-02-11 不正な得意先IDが渡ってきた場合に正しくない請求先が表示されるバグの修正<watanabe-k>
 *
******************************/

$page_title = "契約マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$client_id    = $_GET["client_id"];      //得意先
$get_flg      = $_GET["get_flg"];        //遷移元判定フラグ
$back_display = $_GET["back_display"];   //予定明細の遷移元
$array_id     = $_GET["aord_id_array"];  //該当日の全ての受注ID
$aord_id      = $_GET["aord_id"];        //受注ID
$shop_id      = $_SESSION["client_id"];  //ログインID


//不正判定
Get_ID_Check3($client_id);
Get_ID_Check3($aord_id);


/****************************/
//フォーム定義
/****************************/
//得意先
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
$form->addGroup( $form_client, "form_client", "");

//得意先リンク
$form->addElement("link","form_client_link","","./2-1-115.php","得意先名","
    onClick=\"return Open_Contract('../dialog/2-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]', 'client_search_flg'),500,450,5,1);\""
);

//変更・一覧
$form->addElement("button","change_button","変更・一覧",$g_button_color."onClick=\"location.href='2-1-111.php'\"");
//一括訂正(ヘッダー)
//$form->addElement("button","all_button","一括訂正","onClick=\"location.href='2-1-114.php'\"");
//登録(ヘッダー)
$form->addElement("button","new_button","登　録","onClick=\"location.href='2-1-104.php?flg=add'\"");

//戻るボタン遷移先判定
/*
switch($get_flg){
	case 'cal':
		//予定明細
		$form->addElement("button","form_back","戻　る","onClick=\"location.href='".FC_DIR."sale/2-2-106.php&search=1?aord_id[0]=$aord_id&aord_id_array=$array_id&back_display=$back_display'\"");
		break;
	case 'reason':
		//予定データ訂正
		$form->addElement("button","form_back","戻　る","onClick=\"location.href='".FC_DIR."sale/2-2-107.php?aord_id=$aord_id&back_display=$back_display&aord_id_array=$array_id'\"");
		break;
	case 'con':
		//契約一覧
		$form->addElement("button","form_back","戻　る","onClick=\"location.href='".FC_DIR."system/2-1-111.php'\"");
		break;
	Default:
		//得意先一覧
		$form->addElement("button","form_back","戻　る","onClick=\"location.href='".FC_DIR."system/2-1-101.php?search=1'\"");
}
*/
/*
// 戻るボタン（検索を行ったページへ遷移する）
$referer = $_SESSION["referer"]["f"]["sale"];

if ($referer == "2-1-237" || $referer == "2-1-238"){
    $form->addElement("button", "form_back", "戻　る", "onClick=\"Submit_Page('./".$_SESSION["referer"]["f"]["sale"].".php')\"");

}elseif ($referer == "2-1-111"){
    $form->addElement("button", "form_back", "戻　る", "onClick=\"location.href='2-1-111.php'\"");

}elseif ($referer == "2-1-104"){
    $form->addElement("button", "form_back", "戻　る", "onClick=\"location.href='2-1-104.php?flg=add'\"");

}else{
    $form->addElement("button", "form_back", "戻　る", 
//        "onClick=\"Submit_Page('".Make_Rtn_Page("contract")."')\"");
        "onClick=\"location.href='".Make_Rtn_Page("contract")."'\"");
}
*/


/****************************/
// 戻るボタンリンク（4/13作成）
/****************************/
// 再遷移先を変数に
$referer = $_SESSION["f"]["contract"]["return_page"]["page"];

// 再遷移先が契約マスタ（登録画面）＋の場合
if ($referer == "../system/2-1-104.php"){
    $get_flg = "add";
}

switch ($get_flg){
	case "con" :
		// 契約一覧
		$form->addElement("button", "form_back", "戻　る", "onClick=\"location.href='".FC_DIR."system/2-1-111.php?search=1'\"");
		break;
    case "add" :
		// 契約マスタ（登録画面）
		$form->addElement("button", "form_back", "戻　る", "onClick=\"location.href='".FC_DIR."system/2-1-104.php?flg=add'\"");
		break;
    default :
        // その他
        $form->addElement("button", "form_back", "戻　る", "onClick=\"location.href='".Make_Rtn_Page("contract")."'\"");
}




$form->addElement("hidden", "client_search_flg");   //得意先検索フラグ

$form->addElement("hidden", "check_value_flg");     //契約登録チェックボックス復元判定フラグ
$client_data["check_value_flg"]   = "t";

/****************************/
//得意先コード入力処理
/****************************/
$client_d_flg = false;   //データ存在判定フラグ
$client_cd1         = $_POST["form_client"]["cd1"];       //得意先コード1
$client_cd2         = $_POST["form_client"]["cd2"];       //得意先コード2

//ダイアログ入力orPOSTにコードがある場合
if($_POST["client_search_flg"] == true || ($client_cd1 != NULL && $client_cd2 != NULL)){

    //得意先の情報を抽出
    $sql  = "SELECT";
    $sql .= "   client_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_cd1 = '$client_cd1'";
    $sql .= "   AND";
	$sql .= "   client_cd2 = '$client_cd2'";
    $sql .= "   AND";
    $sql .= "   client_div = '1' ";

	//ダイアログ入力は、取引中の得意先のみ表示
	if($_POST["client_search_flg"] == true){
		$sql .= "AND ";
		$sql .= "    state = '1' ";
	}

	$sql .= "   AND";
	if($_SESSION["group_kind"] == '2'){
	    $sql .= "    t_client.shop_id IN (".Rank_Sql().")";
	}else{
	    $sql .= "     t_client.shop_id = $shop_id";
	}
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);
	//該当データがある
	if($num == 1){
		//データあり
		$client_id      = pg_fetch_result($result, 0,0);        //得意先ID

	}else{
		//データなし
		$client_d_flg = true;
		//新規登録の為、追加ボタンのGET情報なし
		$client_id = "";
	}
}

/****************************/
//フォーム定義（GET情報の得意先が処理によって変更）
/****************************/
//追加ボタン
$form->addElement("button","form_insert","追　加","onClick=\"javascript:return Submit_Page2('".FC_DIR."system/2-1-104.php?flg=add&client_id=$client_id&return_flg=true&get_flg=$get_flg');\""
);

//データが存在したor変更時に実行
if($client_id != NULL && $_POST["client_search_flg"] != "get"){
	/****************************/
	//得意先情報取得処理
	/****************************/
	//得意先の情報を抽出
	$sql  = "SELECT";
	$sql .= "   t_client.client_cname,";
	$sql .= "   t_trade.trade_name,";
	//$sql .= "   t_client.intro_ac_price,";
	//$sql .= "   t_client.intro_ac_rate, ";
	$sql .= "   t_client.state, ";
	$sql .= "   t_client.client_cd1, ";
	$sql .= "   t_client.client_cd2 ";
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= "   INNER JOIN t_trade ON t_client.trade_id = t_trade.trade_id ";
	$sql .= " WHERE";
	$sql .= "   t_client.client_id = $client_id";
	$sql .= " AND";
	$sql .= "    t_client.shop_id = $shop_id";
	$sql .= ";";

	$result = Db_Query($db_con, $sql); 
	//Get_Id_Check($result);

	//データ配列取得
	$result_count = pg_numrows($result);
	for($i = 0; $i < $result_count; $i++){
        $row[] = @pg_fetch_array ($result, $i,PGSQL_NUM);
    }
    for($i = 0; $i < $result_count; $i++){
        for($j = 0; $j < count($row[$i]); $j++){
			//サニタイジング判定
			if($j == 0){
				//得意先名はしない
				$data_list[$i][$j] = nl2br($row[$i][$j]);
			}else{
				//以外
				$data_list[$i][$j] = nl2br(htmlspecialchars($row[$i][$j]));
			}
        }
    }

	$cname          = $data_list[0][0];        //得意先名
	$trade_name     = $data_list[0][1];        //取引区分
	//$ac_price       = $data_list[0][2];        //紹介料（固定金額）
	//$ac_rate        = $data_list[0][3];        //紹介料（％指定）
	$state          = $data_list[0][2];        //取引状態
	$client_cd1     = $data_list[0][3];        //得意先CD1
	$client_cd2     = $data_list[0][4];        //得意先CD2

	//紹介口座名取得
	$sql  = "SELECT";
	$sql .= " CASE  ";
	$sql .= " WHEN t_client.client_cd2 IS NOT NULL";
	$sql .= "  THEN t_client.client_cd1 || '-' ||t_client.client_cd2 || ' ' ||t_client.client_cname";
	$sql .= " ELSE";
	$sql .= "  t_client.client_cd1 || ' ' ||t_client.client_cname";
	$sql .= " END  ";

	//$sql .= " t_client.client_cname ";
	$sql .= " FROM";
	$sql .= "   t_client_info ";
	$sql .= "   INNER JOIN t_client ON t_client.client_id = t_client_info.intro_account_id ";
	$sql .= " WHERE";
	$sql .= "   t_client_info.client_id = $client_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql); 
	$info_list = Get_Data($result);

	$ac_name        = $info_list[0][0];        //紹介口座
	if($ac_name == ""){
		$ac_name = "無し";
	}

	//取引状態判定
	if($state == 1){
		//取引中
		$state = "取引中";
	}else if($state == 2){
		//休止中
		$state = "休止中";
	}else if($state == 3){
		//解約
		$state = "解約";
	}

	/*	
	//紹介料判定
	$client_flg = false;                       //紹介料表示フラグ
	if($ac_price != NULL){
		//得意先の紹介料（固定金額）
		$intro_ac_money = number_format($ac_price);
	}else if($ac_rate != NULL){
		//得意先の紹介料（％指定）
		$intro_ac_money = $ac_rate."%";
	}else{
		//得意先に紹介料が設定されていない場合に、契約の紹介料を表示
		$client_flg = true;
	}
	*/


	//POST情報変更
	$client_data["form_client"]["cd1"] = $client_cd1;
	$client_data["form_client"]["cd2"] = $client_cd2;
	$client_data["form_client"]["name"] = $cname;
	$client_data["client_search_flg"]   = "";
	
}else{
	//POST情報変更
	$client_data["form_client"]["cd1"] = "";
	$client_data["form_client"]["cd2"] = "";
	$client_data["form_client"]["name"] = "";
	$client_data["client_search_flg"]   = "";
}
$form->setConstants($client_data);

/****************************/
//データ表示部品作成処理
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    t_contract.line, ";                    //行No0
$sql .= "    t_contract.contract_day,";             //契約日1
$sql .= "    t_contract.route,";                    //順路2
$sql .= "    CASE t_con_info.divide ";              //販売区分3
$sql .= "         WHEN '01' THEN 'リピート'";
$sql .= "         WHEN '02' THEN '商品'";
$sql .= "         WHEN '03' THEN 'レンタル'";
$sql .= "         WHEN '04' THEN 'リース'";
$sql .= "         WHEN '05' THEN '工事'";
$sql .= "         WHEN '06' THEN 'その他'";
$sql .= "    END,";
$sql .= "    CASE t_con_info.serv_pflg ";           //サービス印字4
$sql .= "         WHEN 't' THEN '○'";
$sql .= "         WHEN 'f' THEN '×'";
$sql .= "    END,";
$sql .= "    t_serv.serv_name,";                    //サービス名5

$sql .= "    CASE t_con_info.goods_pflg ";          //アイテム印字6
$sql .= "         WHEN 't' THEN '○'";
$sql .= "         WHEN 'f' THEN '×'";
$sql .= "    END,";
$sql .= "    t_con_info.goods_name,";               //アイテム名7
$sql .= "    t_con_info.set_flg,";                  //一式フラグ8
$sql .= "    t_con_info.num,";                      //数量9

$sql .= "    t_con_info.trade_price,";              //営業原価10
$sql .= "    t_con_info.sale_price,";               //売上単価11
$sql .= "    t_con_info.trade_amount,";             //営業金額12
$sql .= "    t_con_info.sale_amount,";              //売上金額13

$sql .= "    t_con_info.egoods_name,";              //消耗品名14
$sql .= "    t_con_info.egoods_num, ";              //消耗品数量15

$sql .= "    t_con_info.rgoods_name,";              //本体名16
$sql .= "    t_con_info.rgoods_num,";               //本体数量17

$sql .= "    t_con_info.account_price,";            //口座金額18
$sql .= "    t_con_info.account_rate,";             //口座率19

$sql .= "    t_contract.round_div,";                //巡回区分20
$sql .= "    t_contract.cycle,";                    //周期21
$sql .= "    t_contract.cycle_unit,";               //周期単位22
$sql .= "    CASE t_contract.cale_week ";           //週名(1-4)23
$sql .= "        WHEN '1' THEN ' 第1'";
$sql .= "        WHEN '2' THEN ' 第2'";
$sql .= "        WHEN '3' THEN ' 第3'";
$sql .= "        WHEN '4' THEN ' 第4'";
$sql .= "    END,";
$sql .= "    CASE t_contract.abcd_week ";           //週名(ABCD)24
$sql .= "        WHEN '1' THEN 'A(4週間隔)週'";
$sql .= "        WHEN '2' THEN 'B(4週間隔)週'";
$sql .= "        WHEN '3' THEN 'C(4週間隔)週'";
$sql .= "        WHEN '4' THEN 'D(4週間隔)週'";
$sql .= "        WHEN '5' THEN 'A,C(2週間隔)週'";
$sql .= "        WHEN '6' THEN 'B,D(2週間隔)週'";
$sql .= "        WHEN '21' THEN 'A(8週間隔)週'";
$sql .= "        WHEN '22' THEN 'B(8週間隔)週'";
$sql .= "        WHEN '23' THEN 'C(8週間隔)週'";
$sql .= "        WHEN '24' THEN 'D(8週間隔)週'";
$sql .= "    END,";
$sql .= "    t_contract.rday, ";                    //指定日25
$sql .= "    CASE t_contract.week_rday ";           //指定曜日26
$sql .= "        WHEN '1' THEN ' 月曜'";
$sql .= "        WHEN '2' THEN ' 火曜'";
$sql .= "        WHEN '3' THEN ' 水曜'";
$sql .= "        WHEN '4' THEN ' 木曜'";
$sql .= "        WHEN '5' THEN ' 金曜'";
$sql .= "        WHEN '6' THEN ' 土曜'";
$sql .= "        WHEN '7' THEN ' 日曜'";
$sql .= "    END,";
//$sql .= "    t_contract.stand_day,";                //作業基準日27

$sql .= "    CASE  ";          //作業基準日27
$sql .= "         WHEN t_contract.update_day IS NULL THEN t_contract.stand_day";
$sql .= "         WHEN t_contract.update_day IS NOT NULL THEN t_contract.update_day";
$sql .= "    END,";


$sql .= "    t_contract.last_day,";                 //最終巡回日28

$sql .= "    '1:' || t_staff1.staff_name || ";              //担当者１・売上率１29
$sql .= "    '(' || t_staff1.sale_rate || '%)',"; 
$sql .= "    '2:' || t_staff2.staff_name || ";              //担当者２・売上率２30
$sql .= "    '(' || t_staff2.sale_rate || '%)',"; 
$sql .= "    '3:' || t_staff3.staff_name || ";              //担当者３・売上率３31
$sql .= "    '(' || t_staff3.sale_rate || '%)',"; 
$sql .= "    '4:' || t_staff4.staff_name || ";              //担当者４・売上率４32
$sql .= "    '(' || t_staff4.sale_rate || '%)',"; 
$sql .= "    t_contract.note,";                     //備考33
$sql .= "    t_contract.contract_id,";              //契約情報ID34
$sql .= "    t_contract.client_id, ";               //得意先ID35
$sql .= "    t_con_info.con_info_id, ";             //契約内容ID36
$sql .= "    t_con_info.line, ";                    //契約内容行37

$sql .= "    t_trust.client_cname,";                //代行名 38
$sql .= "    t_contract.act_request_day,";          //依頼日 39
$sql .= "    t_contract.act_request_rate || '%',";  //代行料 40
$sql .= "    t_contract.request_state, ";           //代行状況 41
$sql .= "    t_trust.client_cd1, ";                 //代行CD1 42
$sql .= "    t_trust.client_cd2, ";                  //代行CD2 43   
$sql .= "    t_con_info.official_goods_name, ";                  //代行CD2 44   
$sql .= "    CASE t_contract.state ";           //契約状態 45   
$sql .= "     WHEN '1' THEN '契約中'";                  
$sql .= "     WHEN '2' THEN '休止・解約中'";                  
$sql .= "    END,  ";                  

$sql .= "    CASE  ";           //紹介口座区分 46
$sql .= "     WHEN t_contract.intro_ac_div = '1' THEN '無し'";                  
$sql .= "     WHEN t_contract.intro_ac_div = '2' THEN intro_ac_price || '円'";                  
$sql .= "     WHEN t_contract.intro_ac_div = '3' THEN intro_ac_rate  || '％'";                  
$sql .= "     WHEN t_contract.intro_ac_div = '4' THEN '商品別' ";                  
$sql .= "    END,  ";                  

$sql .= "    CASE  ";           //紹介口座料（商品別） 47
$sql .= "     WHEN t_contract.intro_ac_div = '4' AND t_con_info.account_price >0 THEN t_con_info.account_price || '円'";                  
$sql .= "     WHEN t_contract.intro_ac_div = '4' AND t_con_info.account_rate  >0 THEN t_con_info.account_rate  || '％'";           
$sql .= "     ELSE '' ";                       
$sql .= "    END,  ";                  
$sql .= "    t_contract.act_div,";                       //代行料区分 48
$sql .= "    t_contract.trust_sale_amount,";         //代行料49
$sql .= "    t_contract.act_request_rate, ";          //代行料（％）50
$sql .= "    t_contract.act_request_price, ";          //代行料（固定額）51
$sql .= "    t_con_info.advance_flg, ";                //前受相殺フラグ52
//aoyama-n 2009-09-24
#$sql .= "    t_con_info.advance_offset_amount ";      //前受相殺額53
$sql .= "    t_con_info.advance_offset_amount, ";      //前受相殺額53
$sql .= "    t_goods.discount_flg ";                   //値引フラグ54
/*
$sql .= "    CASE t_contract.act_div ";           //契約状態 48   
$sql .= "     WHEN '1' THEN '無し'";                  
$sql .= "     WHEN '2' THEN t_contract.trust_sale_amount || '(固定額)'";                  
$sql .= "     WHEN '3' THEN t_contract.trust_sale_amount || '(' || t_contract.act_request_rate ||'%)'";                  
$sql .= "    END  ";                  
*/
$sql .= "FROM "; 
$sql .= "    t_con_info ";

$sql .= "    INNER JOIN t_contract ON t_contract.contract_id = t_con_info.contract_id ";

$sql .= "    LEFT JOIN t_serv ON t_serv.serv_id = t_con_info.serv_id ";

$sql .= "    LEFT JOIN t_client AS t_trust ON t_trust.client_id = t_contract.trust_id ";

//aoyama-n 2009-09-24
$sql .= "    LEFT JOIN t_goods ON t_con_info.goods_id = t_goods.goods_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_name,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '0'";
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/25　01-008　　　　suzuki-t　　売上率が０％の担当者表示
 *
$sql .= "         AND ";
$sql .= "             t_con_staff.sale_rate != '0'";
*/
$sql .= "         AND \n";
$sql .= "             t_con_staff.sale_rate IS NOT NULL\n";
$sql .= "        )AS t_staff1 ON t_staff1.contract_id = t_contract.contract_id ";
 
$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_name,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '1'";
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/25　01-008　　　　suzuki-t　　売上率が０％の担当者表示
 *
$sql .= "         AND ";
$sql .= "             t_con_staff.sale_rate != '0'";
*/
$sql .= "         AND \n";
$sql .= "             t_con_staff.sale_rate IS NOT NULL\n";
$sql .= "        )AS t_staff2 ON t_staff2.contract_id = t_contract.contract_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_name,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '2'";
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/25　01-008　　　　suzuki-t　　売上率が０％の担当者表示
 *
$sql .= "         AND ";
$sql .= "             t_con_staff.sale_rate != '0'";
*/
$sql .= "         AND \n";
$sql .= "             t_con_staff.sale_rate IS NOT NULL\n";
$sql .= "        )AS t_staff3 ON t_staff3.contract_id = t_contract.contract_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_name,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '3'";
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/25　01-008　　　　suzuki-t　　売上率が０％の担当者表示
 *
$sql .= "         AND ";
$sql .= "             t_con_staff.sale_rate != '0'";
*/
$sql .= "         AND \n";
$sql .= "             t_con_staff.sale_rate IS NOT NULL\n";
$sql .= "        )AS t_staff4 ON t_staff4.contract_id = t_contract.contract_id ";

$sql .= "WHERE "; 
$sql .= "    t_contract.client_id = $client_id "; 
$sql .= "AND ";
if($_SESSION["group_kind"] == '2'){
    $sql .= "    t_contract.shop_id IN (".Rank_Sql().") ";
}else{
    $sql .= "    t_contract.shop_id = $shop_id ";
}

$sql .= "ORDER BY ";
$sql .= "    t_contract.line,";
$sql .= "    t_con_info.line;";
print $sql;

//データが存在したor変更時に実行
if($client_d_flg == false && $client_id != NULL){
	$result = Db_Query($db_con, $sql); 
	//Get_Id_Check($result);
	//$disp_data = pg_fetch_all($result);
	$disp_data = Get_Data($result);
}



//データ存在判定
if($disp_data == NULL){
	//データが存在しない場合に、表示が崩れる為、フラグによって表示形式変更
	$early_flg = true;
}

/****************************/
//データ表示形式変更
/****************************/
$row = 0;          //行数カウント
for($i=0;$i<count($disp_data);$i++){

	//変更履歴を取得
	$contract_id = $disp_data[$i][34];
	$disp_data[$i][history] = Log_Get($db_con,"契約マスタ",$contract_id);

    //履歴分ループ
    $count = count($disp_data[$i][history]);
    for($j=0;$j<$count;$j++){
        $disp_data[$i][history][$j][staff_name] = htmlspecialchars($disp_data[$i][history][$j][staff_name]);
    }

	//順路形式変更
	if($disp_data[$i][2] != NULL){
		$disp_data[$i][2] = str_pad($disp_data[$i][2], 4, 0, STR_POS_LEFT);
		$route1 = substr($disp_data[$i][2],0,2);
		$route2 = substr($disp_data[$i][2],2,2);
		$disp_data[$i][2] = $route1."-".$route2;
	}

	//紹介料表示判定
	if($disp_data[$i][18] != NULL){
		//円
		$disp_data[$i][18] = number_format($disp_data[$i][18]);
	}else if($disp_data[$i][19] != NULL){
		//率(売上金額÷口座率)
		$disp_data[$i][19] = $disp_data[$i][19]."%(".number_format(bcmul($disp_data[$i][13],bcdiv($disp_data[$i][19],100,2),2)).")";
	}

	//数量形式変更
	$disp_data[$i][9]  = my_number_format($disp_data[$i][9]);
	$disp_data[$i][15] = my_number_format($disp_data[$i][15]);
	$disp_data[$i][17] = my_number_format($disp_data[$i][17]);
	$disp_data[$i][53] = my_number_format($disp_data[$i][53]);
	
	//単価形式変更
	for($c=10;$c<=11;$c++){
		$disp_data[$i][$c] = number_format($disp_data[$i][$c],2);
	}
	//金額形式変更
	for($c=12;$c<=13;$c++){
		$disp_data[$i][$c] = number_format($disp_data[$i][$c]);
	}

	//$stand_day  = substr($disp_data[$i][27],0,7); //契約発効日
	$stand_day  = $disp_data[$i][27]; //契約発効日

	//巡回日形式変更
	if($disp_data[$i][20] == "1"){
		//巡回１
		$round_data[$i] = $disp_data[$i][24].$disp_data[$i][26];
	}else if($disp_data[$i][20] == "2"){
		//巡回２

		if($disp_data[$i][25] == "30"){
			$round_data[$i] = "毎月 月末 <br>(".$stand_day.")";
		}else{
			$round_data[$i] = "毎月 ".$disp_data[$i][25]."日 <br>(".$stand_day.")";
		}
	}else if($disp_data[$i][20] == "3"){
		//巡回３
		$round_data[$i] = "毎月".$disp_data[$i][23].$disp_data[$i][26]."<br>(".$stand_day.")";

	}else if($disp_data[$i][20] == "4"){
		//巡回４
		$round_data[$i] = $disp_data[$i][21]."週間周期の".$disp_data[$i][26]."<br>(".$disp_data[$i][27].")";

	}else if($disp_data[$i][20] == "5"){
		//巡回５
		if($disp_data[$i][25] == "30"){
			$round_data[$i] = $disp_data[$i][21]."ヶ月周期の 月末 <br>(".$stand_day.")";
		}else{
			$round_data[$i] = $disp_data[$i][21]."ヶ月周期の ".$disp_data[$i][25]."日 <br>(".$stand_day.")";
		}

	}else if($disp_data[$i][20] == "6"){
		//巡回６
		$round_data[$i] = $disp_data[$i][21]."ヶ月周期の ".$disp_data[$i][23].$disp_data[$i][26]."<br>(".$stand_day.")";

	}else if($disp_data[$i][20] == "7"){
		//巡回７
		$round_data[$i] = "変則日<br>(最終日:".$disp_data[$i][28].")";
	}

	//巡回担当・売上比率表示判定
	for($c=29;$c<=32;$c++){
		//数値判定
		if(!ereg("[0-9]",$disp_data[$i][$c])){
			//値が入力されていない場合は、NULL
			$disp_data[$i][$c] = NULL;
		}else{
			//値が入力されている場合は、メイン以外は改行を追加
			if($c!=29){
				$disp_data[$i][$c] = "<br>".$disp_data[$i][$c];
			}
		}
	}

	//得意先に紹介料が設定されている場合、契約ごとの紹介料欄には、NULL表示
	if($client_flg != true){
		$disp_data[$i][18] = "　";
		$disp_data[$i][19] = "　";
	}
	
	//行No.変更判定
	if($disp_data[$i][0] != $line_num){
		//一行目判定
		if($i != 0){
			//１契約のデータ結合行数を配列に追加
			$disp_data[$i-$row][101] = $row;

			//行の背景色指定
			if($color_flg == true){
				//色を緑にする
				$disp_data[$i-$row][100] = true;
				$color_flg = false;
			}else{
				//色を白にする
				$disp_data[$i-$row][100] = false;
				$color_flg = true;
			}

			//次の行No.をセット
			$line_num = $disp_data[$i][0];
			$row = 0;
		}else{
			//一行目の場合は、行No.をセット
			$line_num = $disp_data[$i][0];
		}
	}

	//■代行料
	//固定額
	if($disp_data[$i][48] == "2"){
		$disp_data[$i][48] = Minus_Numformat($disp_data[$i][51])."円<br>(固定額)";

	//％
	}elseif($disp_data[$i][48] == "3"){
		$disp_data[$i][48] = Minus_Numformat($disp_data[$i][49])."円<br>(".$disp_data[$i][50]."%)";

	//発生しない
	}else{
		$disp_data[$i][48] = "無し";
	}

	//行の背景色指定
	if($color_flg == true){
		//色を緑にする
		$disp_data[$i][100] = true;
	}else{
		//色を白にする
		$disp_data[$i][100] = false;
	}

	$row++;

	/*
	//内訳指定判定
	$sql  = "SELECT con_info_id FROM t_con_detail WHERE con_info_id = ".$disp_data[$i][36].";";
	$result = Db_Query($db_con, $sql);
	$row_num = pg_num_rows($result);
	if(1 <= $row_num){
		//内訳リンク表示
		$disp_data[$i][101] = true;
	}else{
		//内訳リンク非表示
		$disp_data[$i][101] = false;
	}
	*/


}

//最後の行数をセット
$disp_data[$i-$row][101] = $row;

//行の背景色指定
if($color_flg == true){
	//色を緑にする
	$disp_data[$i-$row][100] = true;
}else{
	//色を白にする
	$disp_data[$i-$row][100] = false;
}

/****************************/
//全件数取得
/****************************/
$client_sql  = " SELECT ";
$client_sql .= "     DISTINCT(t_client.client_id) ";
$client_sql .= " FROM";
$client_sql .= "     t_client ";
$client_sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
$client_sql .= " WHERE";
$client_sql .= "     t_client.shop_id = $shop_id";
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = '1'";

//ヘッダーに表示させる全件数
$count_res = Db_Query($db_con, $client_sql.";");
$total_count = pg_num_rows($count_res);


/****************************/
// 前受相殺額、前受金残高出力処理
/****************************/
// 得意先IDがある場合
if ($client_id != null){

    // 未来の前受相殺額取得（未確定, 未承認）
    // 対象：契約のみ

    // 条件に合う契約情報を取得
    //  ・前受相殺額あり
    //  ・自ショップの契約
    //  ・指定された得意先への契約
    //  ・契約終了日が未来（かつNULLでない）
    $sql  = "SELECT \n";
    $sql .= "   t_contract.contract_id, \n";                                // 契約ID
    $sql .= "   t_contract.claim_div, \n";                                  // 請求先区分
    $sql .= "   t_contract.contract_eday, \n";                              // 契約終了日
    $sql .= "   SUM(COALESCE(t_con_info.advance_offset_amount, 0)) \n";
    $sql .= "   AS advance_offset \n";                                      // 前受相殺額（伝票内合計）
    $sql .= "FROM \n";
    $sql .= "   t_contract \n";
    $sql .= "   INNER JOIN t_con_info \n";
    $sql .= "       ON  t_contract.contract_id = t_con_info.contract_id \n";
    $sql .= "       AND t_con_info.advance_offset_amount IS NOT NULL \n";   // 前受相殺額あり
    $sql .= "WHERE \n";
    $sql .= "   t_contract.contract_eday > ".date("Y-m-d")." \n";           // 契約終了日が未来（かつNULLでない）
    $sql .= "AND \n";
    $sql .= "   t_contract.shop_id = $shop_id \n";                          // 自ショップの契約
    $sql .= "AND \n";
    $sql .= "   t_contract.client_id = $client_id \n";                      // 指定された得意先への契約
    $sql .= "GROUP BY \n";
    $sql .= "   t_contract.contract_id, \n";
    $sql .= "   t_contract.claim_div, \n";
    $sql .= "   t_contract.contract_eday \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    $ary_contract_data = Get_Data($res, 2, "ASSOC");

    // 条件に合う契約情報がある場合
    if ($num > 0){

        // 契約関連関数をインクルード
        require_once(INCLUDE_DIR."function_keiyaku.inc");

        // 明日の日付作成
        $tomorrow = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));

        // 取得した契約数でループ
        foreach ($ary_contract_data as $key => $value){

            // 該当契約の、未来の巡回回数をカウント
            $cnt_round_day = count(Get_Round_Day($db_con, $value["contract_id"], $tomorrow, $value["contract_eday"], true));

            // 「今後の前受相殺額合計（請求先区分毎）」に「前受相殺額 x 未来の順回回数」を加算
            $adv_total[$value["claim_div"]] += $value["advance_offset"] * $cnt_round_day;

        }

    }

    // 請求先区分毎の前受相殺額合計を返す関数
    // 以下3クエリで使用
    function Adv_Amount($db_con, $sql, $adv_total){
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        $ary_adv_data = Get_Data($res, 2, "ASSOC");
        if ($num > 0){
            foreach ($ary_adv_data as $key => $value){
                $adv_total[$value["claim_div"]] += $value["amount"];
            }
        }
        return $adv_total;
    }

    // 未来の前受相殺額取得（未確定, 未承認）
    // 対象：予定手書のみ
    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.claim_div, \n";
    $sql .= "   SUM(t_aorder_h.advance_offset_totalamount) AS amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_time > '".date("Y-m-d")."' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_id IS NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.confirm_flg = 'f' \n";
    $sql .= "GROUP BY \n";
    $sql .= "   t_aorder_h.claim_div \n";
    $sql .= ";";
    $adv_total = Adv_Amount($db_con, $sql, $adv_total);

    // 過去の前受相殺額取得（未確定, 未承認）
    // 対象：契約
    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.claim_div, \n";
    $sql .= "   SUM(t_aorder_h.advance_offset_totalamount) AS amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   INNER JOIN t_contract \n";
    $sql .= "       ON  t_aorder_h.contract_id = t_contract.contract_id \n";
    $sql .= "       AND t_contract.contract_eday IS NOT NULL \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_time <= '".date("Y-m-d")."' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.confirm_flg = 'f' \n";
    $sql .= "GROUP BY \n";
    $sql .= "   t_aorder_h.claim_div \n";
    $sql .= ";";
    $adv_total = Adv_Amount($db_con, $sql, $adv_total);

    // 過去の前受相殺額取得（未確定, 未承認）
    // 対象：予定手書・手書
    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.claim_div, \n";
    $sql .= "   SUM(t_aorder_h.advance_offset_totalamount) AS amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_time <= '".date("Y-m-d")."' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_id IS NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.confirm_flg = 'f' \n";
    $sql .= "GROUP BY \n";
    $sql .= "   t_aorder_h.claim_div \n";
    $sql .= ";";
    $adv_total = Adv_Amount($db_con, $sql, $adv_total);

    // 過去の前受相殺額取得（確定済, 承認済）
    // 対象：前受相殺の伝票全て
    $sql  = "SELECT \n";
    $sql .= "   t_payin_h.claim_div, \n";
    $sql .= "   SUM(t_payin_d.amount) AS amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_payin_h \n";
    $sql .= "   INNER JOIN t_payin_d \n";
    $sql .= "       ON  t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       AND t_payin_d.trade_id = 40 \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payin_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_payin_h.shop_id = $shop_id \n";
    $sql .= "GROUP BY \n";
    $sql .= "   t_payin_h.claim_div \n";
    $sql .= ";";
    $adv_total = Adv_Amount($db_con, $sql, $adv_total);

    // 請求先情報取得
    // 前受入金額取得
    $sql  = "SELECT \n";
    $sql .= "   claim_data.claim_div, \n";          // 請求先区分
    $sql .= "   claim_data.client_cd1, \n";         // 請求先コード１
    $sql .= "   claim_data.client_cd2, \n";         // 請求先コード２
    $sql .= "   claim_data.client_cname, \n";       // 請求先名略称
    $sql .= "   advance_data.advance_amount \n";    // 前受入金額合計
    $sql .= "FROM \n";
    // 請求先情報
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_claim.claim_div, \n";
    $sql .= "           t_client.client_cd1, \n";
    $sql .= "           t_client.client_cd2, \n";
    $sql .= "           t_client.client_cname \n";
    $sql .= "       FROM \n";
    $sql .= "           t_claim \n";
    $sql .= "           INNER JOIN t_client \n";
    $sql .= "               ON  t_claim.claim_id = t_client.client_id \n";
    $sql .= "               AND t_claim.client_id = $client_id \n";
    $sql .= "               AND t_client.shop_id = $shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS claim_data \n";
    // 前受入金額
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_advance.claim_div, \n";
    $sql .= "           SUM(t_advance.amount) AS advance_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_advance.client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           t_advance.shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_advance.claim_div \n";
    $sql .= "   ) \n";
    $sql .= "   AS advance_data \n";
    $sql .= "   ON claim_data.claim_div = advance_data.claim_div \n";
    $sql .= "ORDER BY \n";
    $sql .= "   claim_data.claim_div \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    Get_Id_Check($res);

    $num  = pg_num_rows($res);
    $advance_data = Get_Data($res, "2", "ASSOC");

    // 出力テーブル作成
    $html_g  = "<table class=\"Data_Table\" border=\"1\">\n";
    $html_g .= "<col width=\" 70px\" style=\"font-weight: bold;\">\n";
    $html_g .= "<col>\n";
    $html_g .= "<col width=\"120px\" style=\"font-weight: bold;\">\n";
    $html_g .= "<col width=\"100px\" align=\"right\">\n";
    // // 取得データでループ（請求先数分）
    foreach ($advance_data as $key => $value){
        $html_g .= "    <tr>\n";
        $html_g .= "        <td class=\"Title_Purple\" rowspan=\"2\">請求先".$value["claim_div"]."</td>\n";
        $html_g .= "        <td class=\"Value\" rowspan=\"2\">\n";
        $html_g .= "            ".$value["client_cd1"]."-".$value["client_cd2"]."<br>".htmlspecialchars($value["client_cname"])."\n";
        $html_g .= "        </td>\n";
        $html_g .= "        <td class=\"Title_Purple\">前受相殺額合計</td>\n";
        $html_g .= "        <td class=\"Value\">".Numformat_Ortho($adv_total[$value["claim_div"]])."</td>\n";
        $html_g .= "    </tr>\n";
        $html_g .= "    <tr>\n";
        $html_g .= "        <td class=\"Title_Purple\">前受金残高</td>\n";
        $html_g .= "        <td class=\"Value\">".Numformat_Ortho($value["advance_amount"] - $adv_total[$value["claim_div"]])."</td>\n";
        $html_g .= "    </tr>\n";
    }
    $html_g .= "</table>\n";

}


/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//ディレクトリ
/****************************/
$fc_page = FC_DIR."system/2-1-104.php";

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
//$page_title .= "　".$form->_elements[$form->_elementIndex[all_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'    => "$html_header",
	'page_menu'      => "$page_menu",
	'page_header'    => "$page_header",
	'html_footer'    => "$html_footer",
	'fc_page'        => "$fc_page",
	//'client_flg'     => "$client_flg",
	'early_flg'      => "$early_flg",
	'cname'          => "$cname",
	'intro_ac_money' => "$intro_ac_money",
	'trade_name'     => "$trade_name",
	'state'          => "$state",
	'ac_name'        => "$ac_name",
	'get_flg'        => "$get_flg",
    "html_g"        => $html_g,
));

//表示データ
$smarty->assign("disp_data", $disp_data);
$smarty->assign("round_data", $round_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
