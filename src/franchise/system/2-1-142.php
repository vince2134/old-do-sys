<?php

/******************************
 *  変更履歴
 *      ・（2006-10-31）略称に「,」が入力されても崩れないように修正＜suzuki-t＞
 *      ・（2007-05-08）本部と略称が同じ場合、本部データを結合してしまう不具合を修正＜morita-d＞
 *      ・（2007-05-31）検索条件に商品分類を追加＜morita-d＞
 *
 *
******************************/
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/13      10-016      suzuki      オフライン伝票は非表示にする
 *  2010/05/13      Rev.1.5     hashimoto-y 初期表示に検索項目だけ表示する修正
*/

$page_title = "レンタルTOレンタル";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);


/****************************/
// 検索条件復元関連
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_stat_check"   => array("stat1" => "1", "stat2" => "1", "stat3" => "1", "stat4" => "1", "stat5" => "1", "stat6" => "1"),
    "form_rental_no"    => "",
    "form_client"       => array("cd1" => "", "cd2" => ""), 
    "form_client_name"  => "",  
    "form_goods_cd"     => "",  
    "form_goods_cname"   => "",  
    "form_g_product_id"   => "",  
);

$module_no = Get_Mod_No();
if ($_SESSION[$module_no] != null){
    $ary_pass_list = array(
        "form_stat_check"   => array(
            "stat1" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat1"] == "1") ? "1" : ""),
            "stat2" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat2"] == "1") ? "1" : ""),
            "stat3" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat3"] == "1") ? "1" : ""),
            "stat4" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat4"] == "1") ? "1" : ""),
            "stat5" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat5"] == "1") ? "1" : ""),
            "stat6" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat6"] == "1") ? "1" : ""),
        ),      
    );
}else{
    $ary_pass_list = array(
        "form_stat_check"   => array(
            "stat1" => "1", 
            "stat2" => "1", 
            "stat3" => "1", 
            "stat4" => "1", 
            "stat5" => "1", 
            "stat6" => "1", 
        ),      
    );
}

// 検索条件復元
Restore_Filter2($form, array("contract", "rental"), "form_show_button", $ary_form_list, $ary_pass_list);


/****************************/
// 外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];
$group_kind = $_SESSION["group_kind"];


/****************************/
// 初期値表示
/****************************/
$form->setDefaults($ary_form_list);


/****************************/
// フォームパーツ定義
/****************************/
// 状況
$check = null;
$check[] =& $form->addElement("checkbox", "stat1", "", "新規申請中");
$check[] =& $form->addElement("checkbox", "stat6", "", "取消済");
$check[] =& $form->addElement("checkbox", "stat2", "", "契約済");
$check[] =& $form->addElement("checkbox", "stat3", "", "解約申請");
$check[] =& $form->addElement("checkbox", "stat4", "", "解約予定");
$check[] =& $form->addElement("checkbox", "stat5", "", "解約済");
$form->addGroup($check, "form_stat_check", "");

// レンタル番号
$form->addElement("text", "form_rental_no", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

// ユーザコード
Addelement_Client_64($form, "form_client", "ユーザコード", "-");

// ユーザ名
$form->addElement("text", "form_client_name", "", "size=\"34\" maxlength=\"15\" $g_form_option");

// 商品コード
$form->addElement("text", "form_goods_cd", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

// 商品名
$form->addElement("text", "form_goods_cname", "", "size=\"28\" maxlength=\"35\" $g_form_option");

//商品分類マスタ
$g_product_ary = Select_Get($db_con, 'g_product'); //商品分類マスタ
$form->addElement('select', "form_g_product_id","", $g_product_ary);

// 表示ボタン
$form->addElement("submit", "form_show_button", "表　示");

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// 登録（ヘッダ）
$form->addElement("button", "input_btn", "登　録", "onClick=\"location.href='2-1-141.php'\"");
// 一覧（ヘッダ）
$form->addElement("button", "disp_btn", "一　覧", "$g_button_color onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");


/****************************/
// 表示ボタン押下時
/****************************/

#2010-05-13 hashimoto-y
if($_POST["form_show_button"]=="表　示"){


if ($_POST["form_display"] != null){

    /****************************/
    // エラーチェック
    /****************************/
    # なし

    /****************************/
    // エラーチェック結果集計
    /****************************/
    // チェック適用
    $test = $form->validate();

    // 結果をフラグに
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}


/****************************/
// POSTを変数にセット
/****************************/
if ($_POST != null){

    $stat_check1    = $_POST["form_stat_check"]["stat1"];
    $stat_check2    = $_POST["form_stat_check"]["stat2"];
    $stat_check3    = $_POST["form_stat_check"]["stat3"];
    $stat_check4    = $_POST["form_stat_check"]["stat4"];
    $stat_check5    = $_POST["form_stat_check"]["stat5"];
    $stat_check6    = $_POST["form_stat_check"]["stat6"];
    $rental_no      = $_POST["form_rental_no"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client_name"];
    $goods_cd       = $_POST["form_goods_cd"];
    $goods_cname    = $_POST["form_goods_cname"];
    $g_product_id   = $_POST["form_g_product_id"];

    $post_flg = true;

}


/****************************/
// 一覧データ取得条件作成
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = null;

    // 状況
    if ($stat_check1 != null || $stat_check2 != null || $stat_check3 != null || $stat_check4 != null || $stat_check5 != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        // 新規申請中判定
        if ($stat_check1 != null){
            $stat_sql[] = "       t_rental_d.rental_stat = '11' \n";
        }
        // 契約済判定
        if ($stat_check2 != null){
            $stat_sql[] = "       t_rental_d.rental_stat = '10' \n";
        }
        // 解約申請判定
        if ($stat_check3 != null){
            $stat_sql[] = "       t_rental_d.rental_stat = '21' \n";
        }
        // 解約予定判定
        if ($stat_check4 != null){
            $stat_sql[] = "       t_rental_d.rental_stat = '22' \n";
        }
        // 解約済判定
        if ($stat_check5 != null){
            $stat_sql[] = "       t_rental_d.rental_stat = '20' \n";
        }
	    // 取消済判定
	    if ($stat_check6){
		    $stat_sql[] = "       t_rental_d.rental_stat = '0' \n";
	    }
        for ($i = 0; $i < count($stat_sql); $i++){
            if($i != 0){
                $sql .= "       OR \n";
            }
            $sql .= $stat_sql[$i];
        }
        $sql .= "   ) \n";
    }
    // レンタル番号
    $sql .= ($rental_no != null) ? "AND t_rental_h.rental_no LIKE '$rental_no%' \n" : null;
    // ユーザコード１
    $sql .= ($client_cd1 != null) ? "AND t_rental_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // ユーザコード２
    $sql .= ($client_cd2 != null) ? "AND t_rental_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    //ユーザ名
    if($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_rental_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
    	$sql .= "       t_rental_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
	    $sql .= "       t_rental_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
		
		
    // 商品分類
    $sql .= ($g_product_id != null) ? "AND t_rental_d.g_product_id = $g_product_id" : null;

    // 商品コード
    $sql .= ($goods_cd != null) ? "AND t_rental_d.goods_cd LIKE '$goods_cd%' \n" : null;

    // 商品名
    $sql .= ($goods_cname != null) ? "AND t_rental_d.goods_cname LIKE '$goods_cname%' \n" : null;

/*
    // 商品名
    if ($goods_name != null){
        $sql .= "AND \n";
        $sql .= "( \n";
        $sql .= "   t_rental_d.goods_name LIKE '%$goods_name%' \n";
        $sql .= "   OR \n";
        $sql .= "   t_rental_d.official_goods_name LIKE '%$goods_name%' \n";
        $sql .= ") \n";
    }

 */
    $where_sql = $sql;

}


/****************************/
// データ表示部品作成処理
/****************************/
$sql  = "SELECT \n";
$sql .= "   t_rental_h.shop_id, \n";                            //ショップID 0
$sql .= "   t_rental_h.shop_cd1, \n";                           //ショップCD1 1
$sql .= "   t_rental_h.shop_cd2, \n";                           //ショップCD2 2
$sql .= "   t_rental_h.shop_cname, \n";                         //ショップ名(略称) 3
$sql .= "   t_rental_h.client_cname || ',' \n";                 //得意先名(略称),NOごとのrowspan数,得意先CD1,得意先CD2 4
$sql .= "   || t_count2.rowspan2 || ',' \n";  
$sql .= "   || CASE WHEN t_rental_h.client_cd1 IS NULL THEN '' \n";
$sql .= "           ELSE t_rental_h.client_cd1 \n";
$sql .= "      END || ',' \n";
$sql .= "   || CASE WHEN t_rental_h.client_cd2 IS NULL THEN '' \n";
$sql .= "           ELSE t_rental_h.client_cd2 \n";
$sql .= "      END, \n";
$sql .= "   t_rental_h.rental_id, \n";                          //レンタルID 5
$sql .= "   t_rental_h.rental_no || ',' \n";
$sql .= "   || t_count.rowspan || ',' \n";
$sql .= "   || t_rental_h.rental_id, \n";                        //レンタル番号,レンタル番号ごとのrowspan数,レンタルID 6
$sql .= "   t_rental_h.forward_day, \n";                        //出荷日 7
$sql .= "   t_rental_d.calcel_day, \n";                         //変更日・解約日 8
$sql .= "   CASE t_rental_d.rental_stat \n";                    //レンタル状況 9
$sql .= "        WHEN '0'  THEN '取消済' \n";
$sql .= "        WHEN '10' THEN '契約済' \n";
$sql .= "        WHEN '11' THEN '新規申請中' \n";
$sql .= "        WHEN '20' THEN '解約済' \n";
$sql .= "        WHEN '21' THEN '解約申請' \n";
$sql .= "        WHEN '22' THEN '解約予定' \n";
$sql .= "   END, \n";
$sql .= "   t_rental_d.goods_id, \n";                           //商品ID 10
$sql .= "   t_rental_d.goods_cd, \n";                           //商品CD 11
//$sql .= "   t_rental_d.official_goods_name, \n";                //商品名 12
$sql .= "   t_g_product.g_product_name || '　' || t_rental_d.goods_cname, \n";  //商品名 12
$sql .= "   t_rental_d.num, \n";                                //数量 13
$sql .= "   t_rental_d.serial_no, \n";                          //シリアルNO 14
$sql .= "   t_rental_d.shop_price, \n";                       //レンタル単価 15
$sql .= "   t_rental_d.shop_amount, \n";                      //レンタル金額 16
$sql .= "   t_rental_d.user_price, \n";                         //ユーザ単価 17
$sql .= "   t_rental_d.user_amount, \n";                        //ユーザ金額 18
$sql .= "   t_rental_h.note_fc \n";                             //備考(ショップ用) 19
$sql .= "FROM \n";
$sql .= "   t_rental_h \n";
$sql .= "   INNER JOIN t_rental_d ON t_rental_h.rental_id = t_rental_d.rental_id \n";
$sql .= "   INNER JOIN t_goods ON t_rental_d.goods_id = t_goods.goods_id \n";
$sql .= "   INNER JOIN t_g_product ON t_rental_d.g_product_id = t_g_product.g_product_id \n";
$sql .= "   INNER JOIN \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           t_rental_d.rental_id, \n";
$sql .= "           count(t_rental_d.rental_d_id) AS rowspan \n";
$sql .= "       FROM \n";
$sql .= "           t_rental_d \n";
$sql .= "           INNER JOIN t_rental_h ON t_rental_h.rental_id = t_rental_d.rental_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_rental_h.shop_id = $shop_id \n";
if ($stat_check1 == null && $stat_check2 == null && $stat_check3 == null && $stat_check4 == null && $stat_check5 == null && $stat_check6 == null){
$sql .= "       AND t_rental_d.rental_stat IN ('11', '10', '21', '22', '20', '0') \n ";
}
$sql .=         $where_sql;
$sql .= "       GROUP BY \n";
$sql .= "           t_rental_d.rental_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_count \n";
$sql .= "   ON t_count.rental_id = t_rental_h.rental_id \n";
$sql .= "   LEFT JOIN \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           t_rental_h.shop_id, \n";
$sql .= "           t_rental_h.client_id, \n";
$sql .= "           t_rental_h.client_cd1, \n";
$sql .= "           t_rental_h.client_cd2, \n";
$sql .= "           t_rental_h.client_cname, \n";
$sql .= "           count(t_rental_d.rental_d_id)AS rowspan2 \n";
$sql .= "       FROM \n";
$sql .= "           t_rental_d \n";
$sql .= "           INNER JOIN t_rental_h ON t_rental_h.rental_id = t_rental_d.rental_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_rental_h.shop_id = $shop_id \n";
if ($stat_check1 == null && $stat_check2 == null && $stat_check3 == null && $stat_check4 == null && $stat_check5 == null && $stat_check6 == null){
$sql .= "       AND t_rental_d.rental_stat IN ('11', '10', '21', '22', '20', '0') \n ";
}
$sql .=         $where_sql;
$sql .= "       GROUP BY \n";
$sql .= "           t_rental_h.shop_id, \n";
$sql .= "           t_rental_h.client_id, \n";
$sql .= "           t_rental_h.client_cd1, \n";
$sql .= "           t_rental_h.client_cd2, \n";
$sql .= "           t_rental_h.client_cname \n";
$sql .= "   ) \n";
$sql .= "   AS t_count2 \n";
//以下の条件だと、本部のオフラインデータと結合してしまう。
/*
$sql .= "   ON t_count2.shop_id = t_rental_h.shop_id \n";
$sql .= "   AND \n";
$sql .= "      t_count2.client_id = t_rental_h.client_id \n";
$sql .= "       ( \n";
$sql .= "           ( \n";
$sql .= "               t_count2.client_cname = t_rental_h.client_cname \n";
$sql .= "               AND \n";
$sql .= "               t_count2.client_cd1 IS NULL \n";
$sql .= "               AND \n";
$sql .= "               t_count2.client_cd2 IS NULL \n";
$sql .= "           ) \n";
$sql .= "           OR \n";
$sql .= "           ( \n";
$sql .= "               t_count2.client_cname = t_rental_h.client_cname \n";
$sql .= "               AND \n";
$sql .= "               t_count2.client_cd1 = t_rental_h.client_cd1 \n";
$sql .= "               AND \n";
$sql .= "               t_count2.client_cd2 = t_rental_h.client_cd2 \n";
$sql .= "           ) \n";
$sql .= "       ) \n";
*/
$sql .= "   ON t_count2.shop_id = t_rental_h.shop_id \n";
$sql .= "   AND \n";
$sql .= "      t_count2.client_id = t_rental_h.client_id \n";

$sql .= "WHERE \n";
//$sql .= "   t_rental_h.shop_id = $shop_id \n";
//$sql .= "AND ";
//$sql .= "    t_rental_h.online_flg = 't' \n";
$sql .= "    t_rental_h.regist_shop_id = $shop_id \n";
if ($stat_check1 == null && $stat_check2 == null && $stat_check3 == null && $stat_check4 == null && $stat_check5 == null && $stat_check6 == null){
//$sql .= "AND t_rental_d.rental_stat IN ('11', '10', '21', '22', '20') \n ";
$sql .= "       AND t_rental_d.rental_stat IN ('11', '10', '21', '22', '20', '0') \n ";
}
$sql .=     $where_sql;
$sql .= "ORDER BY \n";
$sql .= "   t_rental_h.shop_cd1, \n";
$sql .= "   t_rental_h.shop_cd2, \n";
$sql .= "   t_rental_h.client_cd1, \n";
$sql .= "   t_rental_h.client_cd2, \n";
$sql .= "   t_rental_h.rental_no, \n";
$sql .= "   t_rental_d.line \n";
$sql .= ";";
$result = Db_Query($db_con, $sql); 
$disp_data = Get_Data($result);
//print_array($_POST);

/****************************/
//データ表示形式変更
/****************************/
$n_data_list = NULL;
for($x=0;$x<count($disp_data);$x++){
	$shop_num   = $disp_data[$x][0];     //ショップID
	$client_num = $disp_data[$x][4];     //得意先名(略称),NOごとのrowspan数,得意先CD1,得意先CD2
	$rental_num = $disp_data[$x][6];     //レンタル番号,レンタル番号ごとのrowspan数

	//連想配列に登録する。$n_data_list[ショップID][得意先情報][レンタル情報]
	$n_data_list[$shop_num][$client_num][$rental_num][] = $disp_data[$x];

	$disp_data2[$shop_num][0] = $disp_data[$x][1]."-".$disp_data[$x][2];           //ショップCD
	$disp_data2[$shop_num][1] = $disp_data[$x][3];                                 //ショップ名
	$disp_data2[$shop_num][2] = $disp_data2[$shop_num][2] + $disp_data[$x][13];    //レンタル合計数
	$disp_data2[$shop_num][3] = $disp_data2[$shop_num][3] + $disp_data[$x][16];    //レンタル合計額
	$disp_data2[$shop_num][4] = $disp_data2[$shop_num][4] + $disp_data[$x][18];    //ユーザ提供額
}

/****************************/
//HTML作成処理
/****************************/
//データがある場合に作成
if($disp_data != NULL){
	//ショップごとに繰り返す
	$html = NULL;

	while($shop_arr = each($n_data_list)){
		$shop = $shop_arr[0]; //ショップID
		$no   = 1;            //行のNO

		while($client_arr = each($n_data_list[$shop])){

		/* 2006-10-31 略称に「,」が入力されても崩れないように修正 */
		$client2 = explode(',',$client_arr[0]);  //得意先名(略称),NOごとのrowspan数,得意先CD1,得意先CD2

		//略称に「,」があった場合分割されているので、分割された略称の文字を結合
		for($c=0;$c<count($client2)-3;$c++){
			//配列の先頭か判定
			if($c==0){
				//分割した先頭には「,」が付かない
				$client[0] = $client2[$c];
			}else{
				//先頭以外は、「,」で分割された為、文字の前に「,」を付ける
				$client[0] .= ",".$client2[$c];
			}
		}
		$client[1] = $client2[(count($client2)-3)]; //NOごとのrowspan数
		$client[2] = $client2[(count($client2)-2)]; //得意先CD1
		$client[3] = $client2[(count($client2)-1)]; //得意先CD2

			//色判定
			if(($no % 2) == 0){
				//偶数行
				$html[$shop] .= "<tr class=\"Result2\">";
			}else{
				//奇数行
				$html[$shop] .= "<tr class=\"Result1\">";
			}

			//合計値初期化
			$sum_num = NULL;
			$rental_money = NULL;
			$user_money = NULL;
			
			//NO
			$html[$shop] .= "    <td  align=\"right\" rowspan=".($client[1]+1).">$no</td> ";
			//CD指定判定判定
			if($client[2] != NULL){
				//オンライン

				//設置先
				$html[$shop] .= "    <td  align=\"left\" rowspan=".($client[1]+1).">".$client[2]."-".$client[3]."<br>".$client[0]."</td> ";
			}else{
				//オフライン

				//設置先
				$html[$shop] .= "    <td  align=\"left\" rowspan=".($client[1]+1).">".$client[0]."</td> ";
			}

			$ren_no = 0;    //レンタル番号ごとの行数
			while($rental_arr = each($n_data_list[$shop][$client_arr[0]])){
				$rental = explode(',',$rental_arr[0]);  //レンタル番号,レンタル番号ごとのrowspan数,レンタルID

				//<tr>判定
				if($ren_no != 0){
					//得意先ごとの一行目以外は<tr>からはじめる
					//色判定
					if(($no % 2) == 0){
						//偶数行
						$html[$shop] .= "<tr class=\"Result2\">";
					}else{
						//奇数行
						$html[$shop] .= "<tr class=\"Result1\">";
					}
				}

				//レンタル番号
				$html[$shop] .= "<td  align=\"left\" rowspan=".$rental[1]."><a href='".FC_DIR."system/2-1-141.php?rental_id=".$rental[2]."'>".$rental[0]."</a></td>";
				//出荷日
				$html[$shop] .= "<td  align=\"center\" rowspan=".$rental[1].">".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][0][7]."</td>";
				
				//レンタルデータごと繰り返す
				for($x=0;$x<count($n_data_list[$shop][$client_arr[0]][$rental_arr[0]]);$x++){

					//<tr>判定
					if($x!=0){
						//レンタル番号ごとの一行目以外は<tr>からはじめる
						//色判定
						if(($no % 2) == 0){
							//偶数行
							$html[$shop] .= "<tr class=\"Result2\">";
						}else{
							//奇数行
							$html[$shop] .= "<tr class=\"Result1\">";
						}
					}

					//変更・解約日
					$html[$shop] .= "<td  align=\"center\" >".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][8]."</td>";
					
					//状況のfontカラー判定
					switch($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][9]){
						//状況
						case "新規申請中" :
						case "解約申請" :
							$html[$shop] .= "<td  align=\"center\" ><font color=red>".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][9]."</font></td>";
							break;
						case "契約済" :
							$html[$shop] .= "<td  align=\"center\" ><font color=blue>".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][9]."</font></td>";
							break;
						default:
							//取消済
	                        //解約済
	                        //解約予定
							$html[$shop] .= "<td  align=\"center\" >".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][9]."</td>";
					}

					//商品名
					$html[$shop] .= "<td  align=\"left\" >".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][11]."<br>".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][12]."</td>";
					//数量
					$html[$shop] .= "<td  align=\"right\" >".number_format($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][13])."</td>";
					//シリアル
					$html[$shop] .= "<td  align=\"left\" >".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][14]."</td>";

					//レンタル単価・金額
					$html[$shop] .= "<td  align=\"right\" >".number_format($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][15],2).
					                "<br>".number_format($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][17],2)."</td>";
					//ユーザ単価・金額
					$html[$shop] .= "<td  align=\"right\" >".number_format($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][16]).
					"<br>".number_format($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][18])."</td>";

					//一行目判定
					if($x==0){
						//備考
						$html[$shop] .= "<td  align=\"left\" rowspan=".$rental[1].">".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][19]."</td>";
					}
					$html[$shop] .= "</tr>";

					//得意先ごとの合計計算
					$sum_num    = $sum_num + $n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][13];   //数量
					$rental_money = $rental_money + $n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][16];//レンタル金額
					$user_money   = $user_money + $n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][18];  //ユーザ金額

				}
				$ren_no++;
			}
			
			//得意先ごとの合計行
			$html[$shop] .= "<tr class=\"Result3\">";
			$html[$shop] .= "    <td  align=\"center\"><b>合計</b></td>";
			$html[$shop] .= "    <td  >　</td>";
			$html[$shop] .= "    <td  >　</td>";
			$html[$shop] .= "    <td  >　</td>";
			$html[$shop] .= "    <td  >　</td>";
			$html[$shop] .= "    <td  align=\"right\">".number_format($sum_num)."</td>";
			$html[$shop] .= "    <td  >　</td>";
			$html[$shop] .= "    <td  >　</td>";
			$html[$shop] .= "    <td  align=\"right\">".number_format($rental_money)."<br>".number_format($user_money)."</td>";
			$html[$shop] .= "    <td  >　</td>";
			$html[$shop] .= "</tr>";

			//総合計計算
			$total_num = $total_num + $sum_num;
			$total_rental = $total_rental + $rental_money;
			$total_user = $total_user + $user_money;

			$no++;
		}
	}

	//金額形式変更
	while($money_num = each($disp_data2)){
		$money = $money_num[0];
		$disp_data2[$money][2] = number_format($disp_data2[$money][2]);
		$disp_data2[$money][3] = number_format($disp_data2[$money][3]);
		$disp_data2[$money][4] = number_format($disp_data2[$money][4]);
	}
}


#2010-05-13 hashimoto-y
}

//print_array($n_data_list);
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
$page_menu = Create_Menu_f('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[input_btn]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[disp_btn]]->toHtml();
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
));

//表示データ
$smarty->assign("disp_data", $disp_data);
$smarty->assign("disp_data2",$disp_data2);
$smarty->assign("html", $html);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
