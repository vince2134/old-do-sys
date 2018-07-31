<?php
/****************************
 * 変更履歴
 *  　・(2006-07-27)商品マスタの構成変更に伴い、抽出条件を変更＜watanabe-k＞
 *      ・（2006-12-01）丸め区分を東陽に変更＜suzuki＞
 *
 *
 *
*****************************/
$page_title = "契約マスタ";
//環境設定ファイル
require_once("ENV_local.php");

//DBに接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

/****************************/
//契約関数定義
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");

/****************************/
//外部変数取得
/****************************/
$client_id   = $_GET["client_id"];      //得意先
$get_con_id  = $_GET["contract_id"];    //契約情報ID
$row         = $_GET["break_row"];      //契約登録の行番号
$client_h_id = $_SESSION["client_id"];  //ログインユーザID
$rank_cd     = $_SESSION["fc_rank_cd"]; //顧客区分コード
$staff_id    = $_SESSION["staff_id"];   //ログイン者ID

//得意先IDをhiddenにより保持する
if($_GET["client_id"] != NULL){
	$con_data2["hdn_client_id"] = $client_id;
	
}else{
	$client_id = $_POST["hdn_client_id"];
}

//契約情報IDをhiddenにより保持する
if($_GET["contract_id"] != NULL){
	$con_data2["hdn_con_id"] = $get_con_id;
}else{
	$get_con_id = $_POST["hdn_con_id"];
}

//契約登録の行番号をhiddenにより保持する
if($_GET["break_row"] != NULL){
	$con_data2["hdn_row"] = $row;
}else{
	$row = $_POST["hdn_row"];
}

//不正判定
Get_ID_Check3($client_id);
Get_ID_Check3($get_con_id);

/****************************/
//ダイアログ表示処理
/****************************/
$get_con_id2  = $_GET["select_id"];     //概要から渡した契約情報ID
$get_info_id  = $_GET["select_id2"];    //概要から渡した契約内容ID
//遷移元判定
if($get_info_id != NULL){
	//契約概要からダイアログ表示

	//ＧＥＴ情報不正判定
	Get_ID_Check2($get_con_id2);
	Get_ID_Check2($get_info_id);

	/****************************/
	//契約内容テーブル
	/****************************/
	$sql  = "SELECT ";
	$sql .= "    t_con_info.line,";               //行数
	$sql .= "    t_con_info.serv_id,";            //サービスID
	$sql .= "    t_goods.goods_cd,";              //商品CD
	$sql .= "    t_con_info.goods_name,";         //略称
	$sql .= "    t_con_info.num, ";               //アイテム数
	$sql .= "    t_con_info.trust_trade_price,";  //営業原価
	$sql .= "    t_con_info.sale_price,";         //売上単価
	$sql .= "    t_con_info.trust_trade_amount,"; //営業金額
	$sql .= "    t_con_info.sale_amount ";        //売上金額
	$sql .= "FROM ";
	$sql .= "    t_con_info ";
	$sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_con_info.goods_id ";
	$sql .= "WHERE ";
	$sql .= "    con_info_id = $get_info_id;";
	$result = Db_Query($db_con, $sql);
	$info_data = Get_Data($result);

	$row = $info_data[0][0];        //契約登録の行番号
	
	$serv_id = $info_data[0][1];    //サービスID
	//サービスが指定されているか判定
	if($serv_id != NULL){
		$sql  = "SELECT serv_name FROM t_serv WHERE serv_id = $serv_id;";
		$result = Db_Query($db_con, $sql); 
		$data_list = Get_Data($result);
		$serv_name = $data_list[0][0];
	}

 	$main_goods_name = $info_data[0][3];   //アイテム名
	$main_goods_num = number_format($info_data[0][4]);    //アイテム数

	//営業単価
	$th_price = explode('.', $info_data[0][5]);
	if($th_price[1] == null){
	    $th_price[1] = '00';
	}
	$main_trade_price = $th_price[0].".".$th_price[1];
	$main_trade_price = number_format($main_trade_price,2);

	//売上単価
	$sh_price = explode('.', $info_data[0][6]);
	if($sh_price[1] == null){
	    $sh_price[1] = '00';
	}
	$main_sale_price = $sh_price[0].".".$sh_price[1];
	$main_sale_price = number_format($main_sale_price,2);

	//営業金額
	$main_trade_amount = $info_data[0][7];
	//売上金額
	$main_sale_amount = $info_data[0][8];
	
	/****************************/
	//内訳テーブル
	/****************************/
	$sql  = "SELECT ";
	$sql .= "    t_con_detail.line,";               //行
	$sql .= "    t_con_detail.goods_id,";           //商品ID
	$sql .= "    t_goods.goods_cd,";                //商品CD
	$sql .= "    t_goods.name_change,";             //品名変更
	$sql .= "    t_con_detail.goods_name,";         //略称
	$sql .= "    t_con_detail.num,";                //数量
	$sql .= "    t_con_detail.trust_trade_price,";  //営業原価
	$sql .= "    t_con_detail.sale_price,";         //売上単価
	$sql .= "    t_con_detail.trust_trade_amount,"; //営業金額   
	$sql .= "    t_con_detail.sale_amount ";        //売上金額
	$sql .= "FROM ";
	$sql .= "    t_con_detail ";
	$sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_con_detail.goods_id ";
	$sql .= "WHERE ";
	$sql .= "    t_con_detail.con_info_id = $get_info_id;";  
	$result = Db_Query($db_con, $sql);
	$detail_data = Get_Data($result,2);

	//契約内容IDに該当するデータが存在するか
	for($d=0;$d<count($detail_data);$d++){
		$search_line2 = $detail_data[$d][0];                                  //復元する行
		$con_data["hdn_bgoods_id"][$row][$search_line2]      = $detail_data[$d][1]; //商品ID
		$con_data["break_goods_cd"][$row][$search_line2]     = $detail_data[$d][2]; //商品CD
		$con_data["hdn_bname_change"][$row][$search_line2]   = $detail_data[$d][3]; //品名変更
		$con_data["break_goods_name"][$row][$search_line2]   = $detail_data[$d][4]; //略称
		$con_data["break_goods_num"][$row][$search_line2]    = number_format($detail_data[$d][5]); //数量

		$t_price = explode('.', $detail_data[$d][6]);
		$con_data["break_trade_price"][$row][$search_line2]["1"] = number_format($t_price[0]);     //営業原価
		$con_data["break_trade_price"][$row][$search_line2]["2"] = ($t_price[1] != null)? $t_price[1] : '00';     

		$s_price = explode('.', $detail_data[$d][7]);
		$con_data["break_sale_price"][$row][$search_line2]["1"] = number_format($s_price[0]);     //売上単価
		$con_data["break_sale_price"][$row][$search_line2]["2"] = ($s_price[1] != null)? $s_price[1] : '00';     

		$con_data["break_trade_amount"][$row][$search_line2] = number_format($detail_data[$d][8]); //営業金額
		$con_data["break_sale_amount"][$row][$search_line2]  = number_format($detail_data[$d][9]); //売上金額
	}

	$form->setDefaults($con_data);
	$form->freeze();

}else{
	//契約登録から遷移

	//ＧＥＴ情報不正判定
	Get_ID_Check2($client_id);
	Get_ID_Check2($row);

	/****************************/
	//不正値判定関数
	/****************************/
	Injustice_check($db_con,"trust",$get_con_id,$client_h_id);

	/****************************/
	//hiddenで契約登録の部品定義
	/****************************/
	require_once(INCLUDE_DIR."keiyaku_hidden.inc");

	/****************************/
	//POST情報取得
	/****************************/
	//サービス
	$serv_id = $_POST["form_serv"][$row];
	//サービスが指定されているか判定
	if($serv_id != NULL){
		$sql  = "SELECT serv_name FROM t_serv WHERE serv_id = $serv_id;";
		$result = Db_Query($db_con, $sql); 
		$data_list = Get_Data($result);
		$serv_name = $data_list[0][0];
	}

	//アイテム
	$main_goods_cd = $_POST["form_goods_cd1"][$row];
	$main_goods_name = stripslashes($_POST["form_goods_name1"][$row]);
	//数量形式判定
	if($_POST["form_goods_num1"][$row] != NULL){
		$main_goods_num = number_format($_POST["form_goods_num1"][$row]);
	}

	//金額
	//営業単価形式変更判定
	if($_POST["form_trade_price"][$row][1] != NULL){
		$sale_1 = number_format($_POST["form_trade_price"][$row][1]);
		$sale_2 = ($_POST["form_trade_price"][$row][2] != null)? $_POST["form_trade_price"][$row][2] : '00';
		$main_trade_price = $sale_1.".".$sale_2;
	}
	$main_sale_price = $_POST["form_sale_price"][$row][1].".".$_POST["form_sale_price"][$row][2];
	$main_trade_amount = $_POST["form_trade_amount"][$row];
	$main_sale_amount = $_POST["form_sale_amount"][$row];

	//内訳戻るボタンをhiddenにより保持する
	if($_POST["return_btn"] == NULL){
		//変更前の内訳データをhiddenにセット
		for($d=1;$d<=5;$d++){
			$def_data["return_bgoods_id"][$row][$d]        = $_POST["hdn_bgoods_id"][$row][$d];
			$def_data["return_bname_change"][$row][$d]     = $_POST["hdn_bname_change"][$row][$d];
			$def_data["return_goods_cd"][$row][$d]         = $_POST["break_goods_cd"][$row][$d];
			$def_data["return_goods_name"][$row][$d]       = $_POST["break_goods_name"][$row][$d];
			$def_data["return_goods_num"][$row][$d]        = $_POST["break_goods_num"][$row][$d];
			$def_data["return_trade_price"][$row][$d]["1"] = $_POST["break_trade_price"][$row][$d]["1"];
			$def_data["return_trade_price"][$row][$d]["2"] = $_POST["break_trade_price"][$row][$d]["2"];
			$def_data["return_trade_amount"][$row][$d]     = $_POST["break_trade_amount"][$row][$d];
			$def_data["return_sale_price"][$row][$d]["1"]  = $_POST["break_sale_price"][$row][$d]["1"];
			$def_data["return_sale_price"][$row][$d]["2"]  = $_POST["break_sale_price"][$row][$d]["2"];
			$def_data["return_sale_amount"][$row][$d]      = $_POST["break_sale_amount"][$row][$d];
		}
		$def_data["return_btn"] = true;
		$form->setConstants($def_data);
	}

	/****************************/
	//得意先情報取得
	/****************************/
	//東陽のclient_idを取得（各ショップの得意先マスタに自動で登録されるやつ）
	$sql = "SELECT client_id FROM t_client WHERE shop_id = $client_h_id AND act_flg = true;";
	$result = Db_Query($db_con, $sql);
	$toyo_id = pg_fetch_result($result, 0, 0);
	//丸め区分取得
	$sql  = "SELECT ";
	$sql .= "   t_client.coax ";    
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= " WHERE";
	$sql .= "   t_client.client_id = $toyo_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql); 
	$data_list = Get_Data($result,2);
	$coax = $data_list[0][0];        //丸め区分（商品）

	//POST情報変更
	$con_data2["hdn_coax"]            = $coax;

	/****************************/
	//全件数取得
	/****************************/
	$client_sql  = " SELECT ";
	$client_sql .= "     t_client.client_id ";
	$client_sql .= " FROM";
	$client_sql .= "     t_client ";
	$client_sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
	$client_sql .= " WHERE";
	$client_sql .= "     t_contract.trust_id = $client_h_id";
	$client_sql .= "     AND";
	$client_sql .= "     t_client.client_div = '1'";
	//ヘッダーに表示させる全件数
	$count_res = Db_Query($db_con, $client_sql.";");
	$total_count = pg_num_rows($count_res);

	/****************************/
	//クリアボタン押下処理
	/****************************/
	if($_POST["clear_flg"] == true){
		//商品欄を全て初期化
		for($c=1;$c<=5;$c++){
			$con_data2["break_trade_price"][$row][$c]["1"] = "";
			$con_data2["break_trade_price"][$row][$c]["2"] = "";
			$con_data2["break_trade_amount"][$row][$c]     = "";
		}

		$con_data2["clear_flg"] = "";    //クリアボタン押下フラグ
	}
}
/****************************/
//部品定義
/****************************/
//契約登録の行数分
$type = $g_form_option;
for($i=1;$i<=5;$i++){
	//内訳を設定する行か判定
	if($row == $i){
		//設定行

		//内訳の行数分
		for($j=1;$j<=5;$j++){

			//商品コード      
			$freeze_data = $form->addElement(
			    "text","break_goods_cd[$i][$j]","","size=\"10\" maxLength=\"8\"
			    style=\"$g_form_style;$style\" $type
				onChange=\"goods_search_1(this.form, 'break_goods_cd[$i][$j]', 'goods_search_row', $j)\""
			);
			$freeze_data->freeze();
	
			//商品名
			//変更不可判定
			if($_POST["hdn_bname_change"][$i][$j] == '2' || $hdn_bname_change[$i][$j] == '2'){
				//不可
			    $freeze_data = $form->addElement(
			        "text","break_goods_name[$i][$j]","",
			        "size=\"21\" $g_text_readonly" 
			    );
			}else{
				//可
			    $freeze_data = $form->addElement(
			        "text","break_goods_name[$i][$j]","",
			        "size=\"21\" maxLength=\"20\" 
			        style=\"$style\" $type"
			    );
			}
			$freeze_data->freeze();

			//商品数
			$freeze_data = $form->addElement(
		       "text","break_goods_num[$i][$j]","",
		       "class=\"money_num\" size=\"6\" maxLength=\"5\" 
		        style=\"$g_form_style;$style\" $type"
		    );
			$freeze_data->freeze();

			//商品ID
			$form->addElement("hidden","hdn_bgoods_id[$i][$j]");
			//品名変更フラグ
			$form->addElement("hidden","hdn_bname_change[$i][$j]");

			//営業原価
			$form_cost_price = NULL;
			$form_cost_price[$i][] =& $form->createElement(
			        "text","1","",
			        "size=\"9\" maxLength=\"8\"
			        class=\"money\"
			        onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false);\"
			        style=\"$g_form_style;text-align: right; $style\"
			        $type"
			    );
			    $form_cost_price[$i][] =& $form->createElement(
			        "text","2","","size=\"1\" maxLength=\"2\" 
			        onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',true);\"
			        style=\"$g_form_style;text-align: left; $style\"
			        $type"
			    );
		    $form->addGroup( $form_cost_price[$i], "break_trade_price[$i][$j]", "",".");

			//原価合計額
		    $form->addElement(
		        "text","break_trade_amount[$i][$j]","",
		        "size=\"17\" maxLength=\"10\" 
		        style=\"color : #000000; 
		        border : #ffffff 1px solid; 
		        background-color: #ffffff; 
		        text-align: right\" readonly'"
		    );

			//売上単価
			$form_sale_price = NULL;
			$form_sale_price[$i][] =& $form->createElement(
			        "text","1","",
			        "size=\"9\" maxLength=\"8\"
			        class=\"money\"
			        onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false,$i,true);\"
			        style=\"$g_form_style;text-align: right; $style\"
			        $type"
			    );
			    $form_sale_price[$i][] =& $form->createElement(
			        "text","2","","size=\"1\" maxLength=\"2\" 
			        onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',true,$i,true);\"
			        style=\"$g_form_style;text-align: left; $style\"
			        $type"
			    );
		    $freeze_data = $form->addGroup( $form_sale_price[$i], "break_sale_price[$i][$j]", "",".");
			$freeze_data->freeze();

			//売上合計額
			$freeze_data = $form->addElement(
		        "text","break_sale_amount[$i][$j]","",
		        "size=\"17\" maxLength=\"10\" 
		        style=\"color : #000000; 
		        border : #ffffff 1px solid; 
		        background-color: #ffffff; 
		        text-align: right\" readonly'"
		    );
			$freeze_data->freeze();

			//商品コード
			$form->addElement("hidden","return_goods_cd[$i][$j]","");

			//商品名
			$form->addElement("hidden","return_goods_name[$i][$j]","");
			//商品数
			$form->addElement("hidden","return_goods_num[$i][$j]","");
			//商品ID
			$form->addElement("hidden","return_bgoods_id[$i][$j]","");
			//品名変更フラグ
			$form->addElement("hidden","return_bname_change[$i][$j]","");

			//営業原価
			$form->addElement("hidden","return_trade_price[$i][$j][1]","");
			$form->addElement("hidden","return_trade_price[$i][$j][2]","");
			//原価合計
			$form->addElement("hidden","return_trade_amount[$i][$j]","");
			//売上単価
			$form->addElement("hidden","return_sale_price[$i][$j][1]","");
			$form->addElement("hidden","return_sale_price[$i][$j][2]","");
			//売上合計
			$form->addElement("hidden","return_sale_amount[$i][$j]","");

		}
	}else{
		//内訳を設定する行以外はhiddenとして定義

		//内訳登録の行数分
		for($j=1;$j<=5;$j++){
			//商品コード
			$form->addElement("hidden","break_goods_cd[$i][$j]","");

			//商品名
			$form->addElement("hidden","break_goods_name[$i][$j]","");
			//商品数
			$form->addElement("hidden","break_goods_num[$i][$j]","");
			//商品ID
			$form->addElement("hidden","hdn_bgoods_id[$i][$j]","");
			//品名変更フラグ
			$form->addElement("hidden","hdn_bname_change[$i][$j]","");

			//営業原価
			$form->addElement("hidden","break_trade_price[$i][$j][1]","");
			$form->addElement("hidden","break_trade_price[$i][$j][2]","");
			//原価合計
			$form->addElement("hidden","break_trade_amount[$i][$j]","");
			//売上単価
			$form->addElement("hidden","break_sale_price[$i][$j][1]","");
			$form->addElement("hidden","break_sale_price[$i][$j][2]","");
			//売上合計
			$form->addElement("hidden","break_sale_amount[$i][$j]","");
		}
	}
}

//遷移元判定
if($get_info_id != NULL){
	//契約概要からダイアログ表示
	$form->addElement("button","close_button","閉じる","onClick=\"window.close()\"");
}else{
	//契約登録から遷移
	$form->addElement("hidden", "hdn_row");       //契約登録の行番号    

	$form->addElement("hidden", "return_btn");    //初期表示の内訳情報をセットするフラグ

	//設定
	$form->addElement("submit","set","設　定",
	   "onClick=\"return Dialogue('設定します。','./2-1-240.php?client_id=$client_id&contract_id=$get_con_id');\""
	);
	//クリア
	$form->addElement("button","clear_button","クリア","onClick=\"insert_row('clear_flg');\"");
	//戻る
	$form->addElement("button","form_back","戻　る","onClick=\"SubMenu2('./2-1-240.php?client_id=$client_id&contract_id=$get_con_id')\"");
}

//フォームループ数
$loop_num = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

/****************************/
//POST情報の値を変更
/****************************/
$form->setConstants($con_data2);

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//画面ヘッダー作成
/****************************/
//契約登録から遷移してきた場合に表示
if($get_info_id == NULL){
	$page_title .= "(全".$total_count."件)";
}
$page_header = Create_Header($page_title);

/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());
$smarty->assign('num',$foreach_num);
$smarty->assign('loop_num',$loop_num);

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'       => "$html_header",
	'page_menu'         => "$page_menu",
	'page_header'       => "$page_header",
	'html_footer'       => "$html_footer",
	'java_sheet'        => "$java_sheet",
	'flg'               => "$flg",
	'get_flg'           => "$get_flg",
	'client_id'         => "$client_id",
	'serv_name'         => "$serv_name",
	'main_goods_name'   => "$main_goods_name",
	'main_goods_cd'     => "$main_goods_cd",
	'main_goods_num'    => "$main_goods_num",
	'main_trade_price'  => "$main_trade_price",
	'main_sale_price'   => "$main_sale_price",
	'main_trade_amount' => "$main_trade_amount",
	'main_sale_amount'  => "$main_sale_amount",
	'row'               => "$row",
	'get_info_id'       => "$get_info_id",
	'form_load'         => "$form_load",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
