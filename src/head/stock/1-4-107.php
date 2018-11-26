<?php
/********************
 * 在庫移動入力
 *
 *
 * 変更履歴
 *    2006/07/10 (kaji)
 *      ・shop_gidをなくす
 *    2006/08/30 (watanabe-k)
 ********************/
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/04/03      B0702-028   kajioka-h   未承認商品が使えるバグ修正
 *                  B0702-029   kajioka-h   無効商品が使えるバグ修正
 *  2007/06/05                  watanabe-k  商品が入力できないバグの修正
 *  2007/06/05                  watanabe-k  行追加後にフォーカスが移動しないバグの修正
 *  2009/03/13                  hashimoto-y 入力した商品とは違う商品が移動されるバグの修正
 *  2009/07/10                  aoyama-n    在庫受払照会で移動の受払先に「自倉庫」と表示されるバグの修正
 *  2009/10/12                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 */

$page_title = "在庫移動入力";

//環境設定ファイル environment setting file
require_once("ENV_local.php");

//HTML_QuickFormを作成 create
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続 connect
$db_con = Db_Connect();

// 権限チェック auth check
$auth       = Auth_Check($db_con);
// ボタンDisabled button
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//外部変数取得 acquire external variable
/****************************/
$shop_id     = $_SESSION["client_id"];   //取引先ID trade partner ID
$staff_id    = $_SESSION["staff_id"];    //スタッフID staff ID
$insert_flg  = $_GET["insert"];          //登録確認メッセージ表示フラグ register confirmatiom message display flag

/****************************/
//初期設定 initial setting
/****************************/
//表示行数 display row number
if($_POST["max_row"] != NULL){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 5;
}

//削除行数 delete number of rows
$del_history[] = NULL; 

//在庫移動後に自画面に遷移した場合、メッセージ表示 if the screen transitioned from the goods movement to the next screen
if ($_POST["hdn_first"] == null && $insert_flg == true){
    $insert_msg = "移動しました。";
    $form->addElement("hidden", "hdn_first", "1");
}else{
    $form->addElement("hidden", "hdn_first");
}


/****************************/
//行数追加処理 row addition process
/****************************/
if($_POST["add_row_flg"] == "true"){
	if($_POST["max_row"] == NULL){
		//初期値はPOSTが無い為、 because the initial value has no POST
		$max_row = 6;
	}else{
		//最大行に＋１する +1 to the maximum row
    	$max_row = $_POST["max_row"]+5;
	}
    //行数追加フラグをクリア clear the row addition flag
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//行削除処理 row deletion process
/****************************/
if($_POST["del_row"] != ""){

    //削除リストを取得 acquire the deletion list
    $del_row = $_POST["del_row"];

    //削除履歴を配列にする。make array of the deletion history
    $del_history = explode(",", $del_row);


    //削除した行数 row number deleted
    $del_num     = count($del_history)-1;

}

//***************************/
//最大行数をhiddenにセット set the max row number to hidden
/****************************/
$max_row_data["max_row"] = $max_row;

$form->setConstants($max_row_data);

/****************************/
//部品作成(固定) create parts (fixed)
/****************************/
//在庫移動日 goods movement date
$text[] =& $form->createElement("text", "y", "",
        "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_move_day_day[y]', 'form_move_day[m]',4)\"
         onFocus=\"onForm_today(this,this.form,'form_move_day[y]','form_move_day[m]','form_move_day[d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("text", "m", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_move_day[m]', 'form_move_day[d]',2)\"
         onFocus=\"onForm_today(this,this.form,'form_move_day[y]','form_move_day[m]','form_move_day[d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("text", "d", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onFocus=\"onForm_today(this,this.form,'form_move_day[y]','form_move_day[m]','form_move_day[d]')\"
         onBlur=\"blurForm(this)\""
);
$form->addGroup($text, "form_move_day", "", " - ");

//移動元倉庫(一覧表示) warehouse where the goods come from (list)
$select_value = Select_Get($db_con,'ware');
$form->addElement('select', 'form_org_move', 'セレクトボックス', $select_value,$g_form_option_select);
//移動先倉庫(一覧表示) warehouse where the goods go to (list)
$form->addElement('select', 'form_move', 'セレクトボックス', $select_value,$g_form_option_select);

//移動元倉庫の商品を全て表示 display all the products of the warehouse where the goods will come from
$form->addElement("submit","form_show_button","移動元倉庫の商品を全て表示");
//倉庫一括設定 set warehouse at once
$form->addElement("submit","form_set_button","倉庫一括設定");
//移動(遷移先1-4-107-1.php) move (page to go to 1-4-107-1.php)
$form->addElement("button","form_move_button","移　動","onClick=\"javascript:Button_Submit('move_button_flg','#','true', this)\" $disabled");

//行追加リンク row addition link
$form->addElement("link","add_row_link","","#","追加","
    onClick=\"javascript:Button_Submit_1('add_row_flg', '#foot', 'true', this);\""
);

//hidden
$form->addElement("hidden", "del_row");             //削除行 row deletion
$form->addElement("hidden", "add_row_flg");         //追加行フラグ row addition flag
$form->addElement("hidden", "max_row");             //最大行数 max row number
$form->addElement("hidden", "goods_search_row");    //商品コード入力行 product code input row
$form->addElement("hidden", "ware_select_row1");    //移動元倉庫プルダウン選択フラグ pull down seletion flag of the warehouse where the goods will come from
$form->addElement("hidden", "ware_select_row2");    //移動先倉庫プルダウン選択フラグ pull down seletion flag of the warehouse where the goods will go to
$form->addElement("hidden", "move_button_flg");     //移動ボタン押下判定 determine if move button is pressed
// エラーメッセージセット専用hidden hidden for error message set
$form->addElement("text", "err_illegal_verify");    // 不正POST invalid POST


/****************************/
//商品コード入力 input product code
/****************************/
if($_POST["goods_search_row"] != null){

	//商品データを取得する行 row that will acquire product data 
	$search_row = $_POST["goods_search_row"];

	$sql  = "SELECT \n";
    $sql .= "   t_goods.goods_id, \n";
    $sql .= "   t_goods.goods_cd, \n";
    $sql .= "   t_goods.goods_name, \n";
	$sql .= "   t_goods.unit \n";
    $sql .= "FROM \n";
    $sql .= "   t_goods \n";
    #2009-10-12 hashimoto-y
    #$sql .= "WHERE \n";
    #$sql .= "   goods_cd = '".$_POST["form_goods_cd"][$search_row]."' \n";
    #$sql .= "AND ";
    #$sql .= "   public_flg = 't' \n";
    #$sql .= "AND ";
    #$sql .= "   stock_manage = '1' \n";
    #$sql .= "AND ";
    #$sql .= "   accept_flg = '1' \n";
    #$sql .= "AND ";
    #$sql .= "   state IN ('1', '3') \n";
    #$sql .= "AND \n";
    #$sql .= "   goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id) \n";
    #$sql .= ";";

    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_goods.goods_cd = '".$_POST["form_goods_cd"][$search_row]."' \n";
    $sql .= "AND ";
    $sql .= "   t_goods.public_flg = 't' \n";
    $sql .= "AND ";
    $sql .= "   t_goods_info.stock_manage = '1' \n";
    $sql .= "AND \n";
    $sql .= "t_goods_info.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "   t_goods.accept_flg = '1' \n";
    $sql .= "AND ";
    $sql .= "   t_goods.state IN ('1', '3') \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id) \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);

	//データが存在した場合、フォームにデータを表示 if there is a data, display the data in form
	if($data_num == 1){
    	$goods_data = pg_fetch_array($result);

		$set_goods_data["hdn_goods_id"][$search_row]         = $goods_data[0];   //商品ID product ID
		$goods_id                                            = $goods_data[0];   //POSTする前に倉庫処理で使用する為 because it will be used in warehouse process before POST
		$set_goods_data["form_goods_cd"][$search_row]        = $goods_data[1];   //商品CD product code
		$set_goods_data["form_goods_cname"][$search_row]     = $goods_data[2];   //商品名 product name
		$set_goods_data["form_unit"][$search_row]            = $goods_data[3];   //単位 unit
	}else{
		//データが無い場合は、初期化 initialize if there is no data
		$set_goods_data["hdn_goods_id"][$search_row]         = "";
		$set_goods_data["form_goods_cd"][$search_row]        = "";
		$set_goods_data["form_goods_cname"][$search_row]     = "";
		$set_goods_data["form_unit"][$search_row]            = "";
		$set_goods_data["form_bstock_num"][$search_row]      = "";                 
		$set_goods_data["form_brstock_num"][$search_row]     = "";
		$set_goods_data["form_astock_num"][$search_row]      = "";                 
		$set_goods_data["form_arstock_num"][$search_row]     = "";   
	}
	$set_goods_data["goods_search_row"]                      = "";
	$form->setConstants($set_goods_data);
}

/****************************/
//倉庫選択処理 warehouse selection process
/****************************/
//商品コードが入力された場合でも処理を行う conduct process even if the product code is inputted
if($_POST["ware_select_row1"] != null || $_POST["ware_select_row2"] != null || $_POST["goods_search_row"] != null){
	//移動元・移動先の識別判定 determine which warehouse it comes from and it goes to
	if($_POST["ware_select_row1"] != null){
		//移動元倉庫 "from" warehouse
		$wname       = "form_b_ware";                            //移動元の倉庫名 name of the "from" warehouse 
		$sname       = "form_bstock_num";                        //移動元の在庫数名 number of units existing in the "from" warehouse
		$rname       = "form_brstock_num";                       //移動元の引当数名 number of units reserved in the "from" warehouse
		$search_row  = $_POST["ware_select_row1"];               //在庫数を取得する行 row that will acquire inventory number

		$all_ware_id = $_POST["form_org_move"];                  //移動元倉庫（一覧表示） "from" warehouse (list)
	}else if($_POST["ware_select_row2"] != null){
		//移動先倉庫 "to" warehouse
		$wname       = "form_a_ware";                            //移動先の倉庫名 "to" warehouse name
		$sname       = "form_astock_num";                        //移動先の在庫数名 number of units existing in the "to" warehouse
		$rname       = "form_arstock_num";                       //移動先の引当数名 number of units reserved in the "to" warehouse
		$search_row  = $_POST["ware_select_row2"];               //在庫数を取得する行 row that will acquire inventory number

		$all_ware_id = $_POST["form_move"];                      //移動先倉庫（一覧表示）
	}

	//倉庫が選択された後に、商品コードを入力した場合、商品コードの行数を使用
	if($_POST["goods_search_row"] != null){
		$search_row = $_POST["goods_search_row"];                //在庫数を取得する行
		//移動元の存在判定
		if($_POST["form_b_ware"][$search_row] != NULL){
			$wname       = "form_b_ware";                            //移動元の倉庫名
			$sname       = "form_bstock_num";                        //移動元の在庫数名
			$rname       = "form_brstock_num";                       //移動元の引当数名
			$all_ware_id = $_POST["form_org_move"];                  //移動元倉庫（一覧表示）
			$b_ware_flg  = true;                                     //移動元・移動先が両方入力されているか判定フラグ
		}
		//移動先の存在判定
		if($_POST["form_a_ware"][$search_row] != NULL){
			$wname       = "form_a_ware";                            //移動先の倉庫名
			$sname       = "form_astock_num";                        //移動先の在庫数名
			$rname       = "form_arstock_num";                       //移動先の引当数名
			$all_ware_id = $_POST["form_move"];                      //移動先倉庫（一覧表示）
			$a_ware_flg  = true;                                     //移動元・移動先が両方入力されているか判定フラグ
		}	

	}else{
		//商品コードを入力した後に、倉庫を選択した場合
		$goods_id   = $_POST["hdn_goods_id"][$search_row];           //商品ID
	}
    $ware_id    = $_POST["$wname"][$search_row];                     //倉庫ID
/*
	//一覧表示で選択した倉庫とデータで選択した倉庫が違うか判定
	if($all_ware_id != $ware_id){
		//違う場合は、一覧の倉庫を初期化
		$set_data["form_org_move"]                      = "";
		$set_data["form_move"]                          = "";
	}
*/


	//商品と倉庫が選択されていれば処理開始
	if($goods_id != NULL && $ware_id != NULL){
	    $sql  = "SELECT \n";
	    $sql .= "   stock_num, \n";
		$sql .= "   rstock_num \n";
	    $sql .= "FROM \n";
	    $sql .= "   t_stock \n";
	    $sql .= "WHERE \n";
	    $sql .= "   shop_id = $shop_id \n";
	    $sql .= "AND \n";
	    $sql .= "   ware_id = $ware_id \n";
	    $sql .= "AND \n";
	    $sql .= "   goods_id = $goods_id \n";
	    $sql .= ";";
	    $result = Db_Query($db_con, $sql);

		//該当する商品に在庫があるか
	    if(pg_num_rows($result) != 0){
	        $stock_num  = pg_fetch_result($result,0,0);
			$rstock_num = pg_fetch_result($result,0,1);
	    }
	    $set_data["$sname"][$search_row] = ($stock_num != NULL)? $stock_num : 0;      //現在個数
		$set_data["$rname"][$search_row] = ($rstock_num != NULL)? $rstock_num : 0;    //引当数

        //aoyama 2009-07-08
        //変数の初期化
        $stock_num = "";
        $rstock_num = "";

	}else{
		//選択されていない場合は、初期化
		$set_data["$sname"][$search_row] = "";                 
		$set_data["$rname"][$search_row] = "";   
	}

	//移動元・移動先が両方入力されている場合、移動先しか在庫数を取得していない為、移動元も取得する
	if($b_ware_flg == true && $a_ware_flg == true){

		$wname       = "form_b_ware";                            //移動元の倉庫名
		$sname       = "form_bstock_num";                        //移動元の在庫数名
		$rname       = "form_brstock_num";                       //移動元の引当数名
		$ware_id     = $_POST["$wname"][$search_row];            //倉庫ID

		//商品と倉庫が選択されていれば処理開始
		if($goods_id != NULL && $ware_id != NULL){
		    $sql  = "SELECT \n";
		    $sql .= "   stock_num, \n";
			$sql .= "   rstock_num \n";
		    $sql .= "FROM \n";
		    $sql .= "   t_stock \n";
		    $sql .= "WHERE \n";
		    $sql .= "   shop_id = $shop_id \n";
		    $sql .= "AND \n";
		    $sql .= "   ware_id = $ware_id \n";
		    $sql .= "AND \n";
		    $sql .= "   goods_id = $goods_id \n";
		    $sql .= ";";
		    $result = Db_Query($db_con, $sql);

			//該当する商品に在庫があるか
		    if(pg_num_rows($result) != 0){
		        $stock_num  = pg_fetch_result($result,0,0);
				$rstock_num = pg_fetch_result($result,0,1);
		    }
		    $set_data["$sname"][$search_row] = ($stock_num != NULL)? $stock_num : 0;      //現在個数
			$set_data["$rname"][$search_row] = ($rstock_num != NULL)? $rstock_num : 0;    //引当数
		}else{
			//選択されていない場合は、初期化
			$set_data["$sname"][$search_row] = "";                 
			$set_data["$rname"][$search_row] = "";   
		}

	}
	
	$set_data["ware_select_row1"]                      = "";
	$set_data["ware_select_row2"]                      = "";
	$form->setConstants($set_data);

}

/****************************/
//移動元倉庫の商品を全て表示ボタン押下処理
/****************************/
if($_POST["form_show_button"] == "移動元倉庫の商品を全て表示"){
	$org_ware_id = $_POST["form_org_move"];                //移動元倉庫（一覧表示）
	$ware_id     = $_POST["form_move"];                    //移動先倉庫（一覧表示）
	
	//移動元・移動先が選択されている場合のみ処理を行う
	if($org_ware_id != NULL && $ware_id != NULL){
		//対象の倉庫の全商品データを取得SQL
		$sql  = "SELECT \n";
	    $sql .= "   b_stock.goods_id, \n";
		$sql .= "   b_stock.goods_cd, \n";
		$sql .= "   b_stock.goods_name, \n";
		$sql .= "   b_stock.ware_id, \n";
		$sql .= "   b_stock.stock_num, \n";
		$sql .= "   b_stock.rstock_num, \n";
		$sql .= "   b_stock.unit, \n";
		$sql .= "   a_stock.ware_id, \n";
		$sql .= "   a_stock.stock_num, \n";
		$sql .= "   a_stock.rstock_num \n";
	    $sql .= "FROM \n";
	    $sql .= "   ( \n";
        $sql .= "       SELECT \n";
		$sql .= "           t_goods.goods_cd, \n";
		$sql .= "           t_goods.goods_name, \n";
		$sql .= "           t_ware.ware_id, \n";
		$sql .= "           t_stock.stock_num, \n";
		$sql .= "           t_stock.rstock_num, \n";
		$sql .= "           t_goods.unit, \n";
		$sql .= "           t_stock.goods_id \n";
		$sql .= "       FROM \n";
		$sql .= "           t_stock \n";
		$sql .= "           INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id \n";
		$sql .= "           INNER JOIN t_goods ON t_stock.goods_id = t_goods.goods_id \n";
        #2009-10-12 hashimoto-y
        $sql .= "           INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

	    $sql .= "       WHERE \n";
	    $sql .= "           t_stock.shop_id = $shop_id \n";
	    $sql .= "       AND \n";
	    $sql .= "           t_stock.ware_id = $org_ware_id \n";
		$sql .= "       AND \n";
	    $sql .= "           t_goods.public_flg = 't' \n";
	    $sql .= "       AND \n";
        #2009-10-12 hashimoto-y
	    #$sql .= "           t_goods.stock_manage = '1' \n";
        $sql .= "           t_goods_info.stock_manage = '1' \n";
        $sql .= "       AND \n";
        $sql .= "           t_goods_info.shop_id = $shop_id ";

	    $sql .= "       AND \n";
	    $sql .= "           t_goods.accept_flg = '1' \n";
	    $sql .= "       AND \n";
	    $sql .= "           t_goods.state IN ('1', '3') \n";
	    $sql .= "   ) \n";
        $sql .= "   AS b_stock \n";
		$sql .= "   LEFT JOIN \n";
		$sql .= "   ( \n";
        $sql .= "       SELECT \n";
		$sql .= "           t_ware.ware_id, \n";
		$sql .= "           t_stock.stock_num, \n";
		$sql .= "           t_stock.rstock_num, \n";
		$sql .= "           t_stock.goods_id \n";
		$sql .= "       FROM \n";
		$sql .= "           t_stock \n";
		$sql .= "           INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id \n";
		$sql .= "           INNER JOIN t_goods ON t_stock.goods_id = t_goods.goods_id \n";
        #2009-10-12 hashimoto-y
        $sql .= "           INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

	    $sql .= "       WHERE \n";
	    $sql .= "           t_stock.shop_id = $shop_id \n";
	    $sql .= "       AND \n";
	    $sql .= "           t_stock.ware_id = $ware_id \n";
		$sql .= "       AND \n";
	    $sql .= "           t_goods.public_flg = 't' \n";
	    $sql .= "       AND \n";
        #2009-10-12 hashimoto-y
	    #$sql .= "           t_goods.stock_manage = '1' \n";
        $sql .= "           t_goods_info.stock_manage = '1' \n";
        $sql .= "       AND \n";
        $sql .= "           t_goods_info.shop_id = $shop_id ";

	    $sql .= "   ) \n";
        $sql .= "   AS a_stock \n";
		$sql .= "   ON b_stock.goods_id = a_stock.goods_id \n";
		$sql .= "   ORDER BY \n";
        $sql .= "       b_stock.goods_cd \n";
        $sql .= ";";
	    $result = Db_Query($db_con, $sql);
		$data_list = Get_Data($result, 2);

		for($i=0;$i<count($data_list);$i++){
			$set_data["hdn_goods_id"][$i]     = $data_list[$i][0];  //商品ID
			$set_data["form_goods_cd"][$i]    = $data_list[$i][1];  //商品CD
			$set_data["form_goods_cname"][$i] = $data_list[$i][2];  //商品名
			$set_data["form_b_ware"][$i]      = $org_ware_id;       //移動元倉庫
			$set_data["form_bstock_num"][$i]  = ($data_list[$i][4] != NULL)? $data_list[$i][4] : 0;  //現在個数（移動元）
			$set_data["form_brstock_num"][$i] = ($data_list[$i][5] != NULL)? $data_list[$i][5] : 0;  //引当数（移動元）
			$set_data["form_unit"][$i]        = $data_list[$i][6];  //単位
			$set_data["form_a_ware"][$i]      = $ware_id;           //移動先倉庫
			$set_data["form_astock_num"][$i]  = ($data_list[$i][8] != NULL)? $data_list[$i][8] : 0;  //現在個数（移動先）
			$set_data["form_arstock_num"][$i] = ($data_list[$i][9] != NULL)? $data_list[$i][9] : 0;  //引当数（移動先）
		}
		//全商品データ分の行数を取得
		$max_row = count($data_list);
		$set_data["max_row"] = $max_row;                       //表示行数
		$form->setConstants($set_data);

	}else{
		//移動元・移動先が選択されていない場合はエラー表示
		if($org_ware_id == NULL){
			$warning1 = "移動元倉庫を選択して下さい。";
		}
		if($ware_id == NULL){
			$warning2 = "移動先倉庫を選択して下さい。";
		}
	}


/****************************/
//一括設定ボタン押下処理
/****************************/
}elseif($_POST["form_set_button"] == "倉庫一括設定"){

    //移動元倉庫
    $bfr_ware_id = ($_POST["form_org_move"] != null)? $_POST["form_org_move"] : "null";

    //移動先倉庫
    $aft_ware_id = ($_POST["form_move"] != null)? $_POST["form_move"] : "null";

    //現在表示されている一覧に倉庫をセットする。
    for($i = 0; $i < $max_row; $i++){
        //表示行判定
        if(!in_array("$i", $del_history)){
            $set_data["form_b_ware"][$i] = $bfr_ware_id;
            $set_data["form_a_ware"][$i] = $aft_ware_id;

            //既に商品が入力されている場合
            if($_POST["hdn_goods_id"][$i] != null){
                $bfr_data = Get_Stock_Num($db_con, $_POST["hdn_goods_id"][$i], $bfr_ware_id);
                $atr_data = Get_Stock_Num($db_con, $_POST["hdn_goods_id"][$i], $aft_ware_id);

                //移動元
                $set_data["form_bstock_num"][$i]  = $bfr_data[0];    //在庫数
                $set_data["form_brstock_num"][$i] = $bfr_data[1];    //引当数

                //移動先
                $set_data["form_astock_num"][$i]  = $atr_data[0];    //在庫数
                $set_data["form_arstock_num"][$i] = $atr_data[1];    //引当数

            }
        }
    }

    $form->setConstants($set_data);
}

/****************************/
//移動ボタン押下処理
/****************************/
if($_POST["move_button_flg"] == "true"){

    //hashimoto
    //初期化漏れ
    $goods_id = array();


    // フラグをクリア
    $clear_hdn_data["move_button_flg"] = "";
    $form->setConstants($clear_hdn_data);

	//データ情報取得
	$move_day                     = $_POST["form_move_day"];         //移動日
    for($i=0, $j=0; $i<$max_row; $i++){
        if($_POST["form_goods_cd"][$i] != null){
            $goods_id[$j]         = $_POST["hdn_goods_id"][$i];      //商品ID
            $goods_cname[$j]      = $_POST["form_goods_cname"][$i];   //商品名
			$b_ware[$j]           = $_POST["form_b_ware"][$i];       //移動元倉庫
			$bstock_num[$j]       = $_POST["form_bstock_num"][$i];   //現在個数（移動元）
			$brstock_num[$j]      = $_POST["form_brstock_num"][$i];  //引当数（移動元）
			$move_num[$j]         = $_POST["form_move_num"][$i];     //移動数
			$a_ware[$j]           = $_POST["form_a_ware"][$i];       //移動先倉庫
			$astock_num[$j]       = $_POST["form_astock_num"][$i];   //現在個数（移動先）
			$arstock_num[$j]      = $_POST["form_arstock_num"][$i];  //引当数（移動先）
            $j++;
        }
    }

	/****************************/
    //エラーチェック(PHP)
    /****************************/
	$error_flg = false;                                         //エラー判定フラグ

    // ■ 商品コードの編集中に移動ボタンが押下された場合の対処処理
    // 移動ボタンが押された、かつ商品検索フラグがある場合
    if ($_POST["move_button_flg"] == "true" && $_POST["goods_search_row"] != null){

        // 検索した行数を取得
        $search_row = $_POST["goods_search_row"];

        // hiddenの商品ID配列の該当行に商品IDが格納されている場合
        if ($_POST["hdn_goods_id"][$search_row] != null){
            // hiddenに格納されている商品IDとPOSTされた商品コードの整合性をチェック
            $sql  = "SELECT \n";
            $sql .= "   goods_id \n";
            $sql .= "FROM \n";
            $sql .= "   t_goods \n";
            $sql .= "WHERE \n";
            $sql .= "   goods_id = ".$_POST["hdn_goods_id"][$search_row]." \n";
            $sql .= "AND \n";
            $sql .= "   goods_cd = '".$_POST["form_goods_cd"][$search_row]."' \n";
            $sql .= "AND ";
            $sql .= "   public_flg = 't' \n";
            #2009-10-12 hashimoto-y
            #$sql .= "AND ";
            #$sql .= "   stock_manage = '1' \n";

            $sql .= "AND \n";
            $sql .= "   goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id) \n";
            $sql .= "AND ";
            $sql .= "   shop_id = $shop_id \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $num  = pg_num_rows($res);
            // 結果を不正POSTフラグに
            $illegal_verify_flg = ($num > 0) ? false : true; 
        // hiddenの請求先ID配列の該当キーに請求先IDが格納されていない場合
        }else{  
            // 不正POSTフラグをtrueに
            $illegal_verify_flg = true; 
        }

        // 不正POSTフラグtrueの場合はエラーをセット
        if ($illegal_verify_flg == true){
            $form->setElementError("err_illegal_verify", "商品情報取得前に 移動ボタン が押されました。<br>操作をやり直してください。");
            $error_flg = true;
        }

    }

    //■移動日
    //半角、必須チェック
    $form->addGroupRule("form_move_day", array(
        "y"   => array(
                array($err_message, "required"),
                array($err_message, "numeric")
                ),
        "m"   => array(
                array($err_message, "required"),
                array($err_message, "numeric")
                ),
        "d"   => array(
                array($err_message, "required"),
                array($err_message, "numeric")
                ),
    ));

    //日付妥当性チェック
    if(!checkdate((int)$move_day[m], (int)$move_day[d], (int)$move_day[y])){
        $form->setElementError("form_move_day","移動日の日付は妥当ではありません。");
    }else{
        //月次更新
        $sql  = "SELECT \n";
        $sql .= "   MAX(close_day) \n";
        $sql .= "FROM \n";
        $sql .= "   t_sys_renew \n";
        $sql .= "WHERE\n";
        $sql .= "   shop_id = $shop_id \n";
        $sql .= "AND \n";
        $sql .= "   renew_div = '2' \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $renew_date = pg_fetch_result($result,0,0);
        $renew_date = ($renew_date == null) ? START_DAY : $renew_date;

        $move_day[m] = str_pad($move_day[m],2,0,STR_PAD_LEFT);
        $move_day[d] = str_pad($move_day[d],2,0,STR_PAD_LEFT);
        $move_date = implode("-",$move_day);

        if($renew_date >= $move_date){
            $form->setElementError("form_move_day","移動日の日付は妥当ではありません。");
        }
    }

	//商品選択チェック
    for($i = 0; $i < count($goods_id); $i++){
        if($goods_cname[$i] != null){
           $input_error_flg = true;
        }
    }
    if($input_error_flg != true){
        $goods_error0 ="商品が一つも選択されていません。";
		$error_flg = true;
    }

    //移動元・移動数・移動先入力チェック
    for($i = 0; $i < count($goods_id); $i++){
		//必須チェック
        if($goods_id[$i] != null && ($move_num[$i] == null || $b_ware[$i] == null || $a_ware[$i] == null)){
			$goods_error1 = "在庫移動入力に移動元倉庫名と移動数と移動先倉庫名は必須です。";
			$error_flg = true;
        }

        //hashimoto
        //在庫数が表示される前に移動を押した場合
        if($bstock_num[$i] == null || $brstock_num[$i] == null || $astock_num[$i] == null || $arstock_num[$i] == null){
            $goods_error1 = "移動元倉庫もしくは移動先倉庫の在庫数が正しく表示された後に「移動」をクリックして下さい。";
            $error_flg = true;
        }

        //移動数半角数字チェック
        if(!ereg("^[0-9]+$",$move_num[$i]) && $move_num[$i] != null){
			$goods_error2 = "移動数は半角数字のみです。";
			$error_flg = true;
        }

		//移動元と移動先が同じか判定
		if($b_ware[$i] == $a_ware[$i]){
			$goods_error3 = "移動元倉庫と移動先倉庫が同じです。";
			$error_flg = true;
		}
    }

	//エラーの場合はこれ以降の表示処理を行なわない
    if($error_flg == false && $form->validate()){
		Db_Query($db_con, "BEGIN");

		for($i = 0; $i < count($goods_id); $i++){
			//受払テーブル登録（移動元）
            $sql  = "INSERT INTO \n";
            $sql .= "   t_stock_hand \n";
            $sql .= "( \n";
            $sql .= "   goods_id, \n";
            $sql .= "   enter_day, \n";
            $sql .= "   work_day, \n";
            $sql .= "   work_div, \n";
            $sql .= "   ware_id, \n";
            $sql .= "   io_div, \n";
            $sql .= "   num, \n";
            $sql .= "   staff_id, \n";
            //aoyama-n 2009-07-10
            $sql .= "   client_cname,";
            $sql .= "   shop_id \n";
            $sql .= ") \n";
            $sql .= "VALUES \n";
            $sql .= "( \n";
            $sql .= "   $goods_id[$i], \n";
            $sql .= "   NOW(), \n";
            $sql .= "   '$move_date', \n";
            $sql .= "   '5', \n";
            $sql .= "   $b_ware[$i], \n";
            $sql .= "   '2', \n";
            $sql .= "   $move_num[$i], \n";
            $sql .= "   $staff_id, \n";
            //aoyama-n 2009-07-10
            //移動先倉庫名を残す
            $sql .= "   (SELECT ware_name FROM t_ware WHERE ware_id = $a_ware[$i]),";
            $sql .= "   $shop_id \n";
            $sql .= ") \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

			//受払テーブル登録（移動先）
            $sql  = "INSERT INTO \n";
            $sql .= "   t_stock_hand \n";
            $sql .= "( \n";
            $sql .= "   goods_id, \n";
            $sql .= "   enter_day, \n";
            $sql .= "   work_day, \n";
            $sql .= "   work_div, \n";
            $sql .= "   ware_id, \n";
            $sql .= "   io_div, \n";
            $sql .= "   num, \n";
            $sql .= "   staff_id, \n";
            //aoyama-n 2009-07-10
            $sql .= "   client_cname,";
            $sql .= "   shop_id \n";
            $sql .= ") \n";
            $sql .= "VALUES \n";
            $sql .= "( \n";
            $sql .= "   $goods_id[$i], \n";
            $sql .= "   now(), \n";
            $sql .= "   '$move_date', \n";
            $sql .= "   '5', \n";
            $sql .= "   $a_ware[$i], \n";
            $sql .= "   '1', \n";
            $sql .= "   $move_num[$i], \n";
            $sql .= "   $staff_id, \n";
            //aoyama-n 2009-07-10
            //移動元倉庫名を残す
            $sql .= "   (SELECT ware_name FROM t_ware WHERE ware_id = $b_ware[$i]),";
            $sql .= "   $shop_id \n";
            $sql .= ") \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
		}

		Db_Query($db_con, "COMMIT;");
        header("Location: ./1-4-107.php?insert=true");
	}
}

/****************************/
//部品作成（可変）
/****************************/
//行番号カウンタ
$row_num = 1;
$select_value = Select_Get($db_con,'ware');
for($i = 0; $i < $max_row; $i++){
    //表示行判定
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;

		//商品コード      
	    $form->addElement(
	        "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
	        style=\"$g_form_style\" $g_form_option
	        onChange=\"goods_search_2(this.form, 'form_goods_cd', 'goods_search_row', $i, $row_num)\""
	    );

		//商品名
		$form->addElement(
	        "text","form_goods_cname[$i]","",
	        "size=\"34\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: left\" readonly'"
	    );

		//移動元倉庫
		$form->addElement('select', "form_b_ware[$i]", 'セレクトボックス', $select_value,
			"onKeyDown=\"chgKeycode();\" onChange =\"goods_search_2(this.form, 'form_goods_cd', 'ware_select_row1', $i, $row_num);window.focus();\""
		);

        //倉庫が選択されている場合はそのまま、選択されていない場合は、一括設定で選択した倉庫をセット
        if($_POST["form_b_ware"][$i] != null){
            $set_data["form_b_ware"][$i] = $_POST["form_b_ware"][$i];   
        }elseif($_POST["add_row_flg"] == "true" && $i > $max_row-6){
            $set_data["form_b_ware"][$i] = $_POST["form_org_move"];
        }    
        $form->setConstants($set_data);

		//在庫数(移動元)
		$form->addElement(
	        "text","form_bstock_num[$i]","",
	        "size=\"11\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: right\" readonly'"
	    );

		//引当数(移動元)
		$form->addElement(
	        "text","form_brstock_num[$i]","",
	        "size=\"11\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: right\" readonly'"
	    );

		//移動数
	    $form->addElement(
	        "text","form_move_num[$i]","",
	        "class=\"money\" size=\"11\" maxLength=\"5\" 
	        style=\"$g_form_style\" $g_form_option"
	    );

		//単位
		$form->addElement(
	        "text","form_unit[$i]","",
	        "size=\"11\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: left\" readonly'"
	    );

		//移動先倉庫
		$form->addElement('select', "form_a_ware[$i]", 'セレクトボックス', $select_value,
			"onKeyDown=\"chgKeycode();\" onChange =\"goods_search_2(this.form, 'form_goods_cd', 'ware_select_row2', $i, $row_num);window.focus();\""
		);

        //倉庫が選択されている場合はそのまま、選択されていない場合は、一括設定で選択した倉庫をセット
        if($_POST["form_a_ware"][$i] != null){
            $set_data["form_a_ware"][$i] = $_POST["form_a_ware"][$i];   
        }elseif($_POST["add_row_flg"] == "true" && $i > $max_row-6){
            $set_data["form_a_ware"][$i] = $_POST["form_move"];
        }    
        $form->setConstants($set_data);

		//在庫数(移動先)
		$form->addElement(
	        "text","form_astock_num[$i]","",
	        "size=\"11\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: right\" readonly'"
	    );

		//引当数(移動先)
		$form->addElement(
	        "text","form_arstock_num[$i]","",
	        "size=\"11\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: right\" readonly'"
	    );

		//検索リンク
		$form->addElement(
		    "link","form_search[$i]","","#","検索",
		    "TABINDEX=-1 onClick=\"return Open_SubWin_2('../dialog/1-0-210.php', Array('form_goods_cd[$i]','goods_search_row'), 500, 450,'true',1,$i, $row_num);\""
		);

/*
		//削除リンク
		$form->addElement(
		    "link","form_del_row[$i]","",
		    "#","削除","onClick=\"return Dialogue_1('削除します。', '$del_data', 'del_row');\""
		); 
*/
        //削除リンク
        //最終行を削除する場合、削除した後の最終行に合わせる
        if($row_num == $max_row-$del_num){
            $form->addElement(
                "link","form_del_row[$i]","",
                "#","削除",
                "TABINDEX=-1 
                onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num-1);return false;\"");

        //最終行以外を削除する場合、削除する行と同じNOの行に合わせる
        }else{  
            $form->addElement(
                "link","form_del_row[$i]","","#",
                "削除",
                "TABINDEX=-1 
                onClick=\"javascript:Dialogue_3('削除します。', '$del_data', 'del_row' ,$row_num);return false;\""
            ); 
        }       


		//商品ID
	    $form->addElement("hidden","hdn_goods_id[$i]");

		/****************************/
        //表示用HTML作成
        /****************************/
        $html .= "<tr class=\"Result1\">";
        $html .=    "  <A NAME=$row_num><td align=\"right\">$row_num</td>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        $html .=    "（";
        $html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
        $html .=    "）";
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cname[$i]"]]->toHtml();
        $html .=    "</td>";
		$html .=    "<td align=\"left\">";
	    $html .=        $form->_elements[$form->_elementIndex["form_b_ware[$i]"]]->toHtml();
	    $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_bstock_num[$i]"]]->toHtml();
		$html .=    "<br>";
		$html .=        $form->_elements[$form->_elementIndex["form_brstock_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_move_num[$i]"]]->toHtml();
        $html .=    "</td>";
		$html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_unit[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_a_ware[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_astock_num[$i]"]]->toHtml();
		$html .=    "<br>";
		$html .=        $form->_elements[$form->_elementIndex["form_arstock_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "</tr>";

        //行番号を＋１
        $row_num = $row_num+1;
    }
}



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

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html'          => "$html",
	'warning1'      => "$warning1",
	'warning2'      => "$warning2",
	'goods_error0'  => "$goods_error0",
	'goods_error1'  => "$goods_error1",
	'goods_error2'  => "$goods_error2",
	'goods_error3'  => "$goods_error3",
	'insert_msg'    => "$insert_msg",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));




//商品の倉庫ごとの在庫数と引当数を抽出
function Get_Stock_Num($db_con, $goods_id, $ware_id){

	$sql  = "SELECT \n";
	$sql .= "   stock_num, \n";
	$sql .= "   rstock_num \n";
	$sql .= "FROM \n";
	$sql .= "   t_stock \n";
	$sql .= "WHERE \n";
	$sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
	$sql .= "AND \n";
	$sql .= "   ware_id = $ware_id \n";
	$sql .= "AND \n";
	$sql .= "   goods_id = $goods_id \n";
	$sql .= ";";
	$result = Db_Query($db_con, $sql);

    if(pg_num_rows($result) > 0){
        return pg_fetch_array($result, 0);
    }else{
        return array(0,0);
    }
}


?>
