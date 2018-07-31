<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/07      02-014      kajioka-h   GETの数値チェック追加
 *                  ssl-0052    kajioka-h   初回棚卸のときも前回対比数と前回対比金額を表示するようにした
 *                  ssl-0053    kajioka-h   CSVの「全倉庫名」を「全倉庫」にした
 *  2006/12/09      02-025      kajioka-h   棚卸日取得SQLをshop_idで絞り込むように修正
 *                  02-026      kajioka-h   全倉庫のテーブルがＭ区分でまとまっていなかったのを修正
 *                  02-027      kajioka-h   在庫単価、棚卸金額、前回在庫金額、前回対比金額を小数2桁まで表示するように
 *  2007/01/30      0070,0071   kajioka-h   全倉庫の棚卸単価が単純に合計されているのを、平均単価を表示するように修正
 *  2016/01/22                amano  Button_Submit 関数でボタン名が送られない IE11 バグ対応  
 */

$page_title = "棚卸一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

// 戻るボタンの遷移先
$back_url = ($_SESSION["group_kind"] == "1") ? "./1-4-205.php" : "./2-4-205.php";

//クリアボタンの遷移先
$clear_url = ($_SESSION["group_kind"] == "1") ? "./1-4-206.php" : "./2-4-206.php";


/****************************/
//クエリ実行関数
/****************************/
function Get_Inv_Data($result){
    $g_goods      = "";                    //Ｍ区分比較用
    $result_count = pg_numrows($result);   //要素数
	$count = 0;                            //Ｍ区分を表示した数

    for($i = 0; $i < $result_count; $i++){
        $inv_data[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
//print_array($inv_data[$i]);
		//Ｍ区分計表示判定
		if($inv_data[$i][1] != $g_goods && $i != 0){
			$row[$i+$count][0] = $inv_data[$i][0];         //倉庫名
			$row[$i+$count][1] = "Ｍ区分計";
			$row[$i+$count][2] = number_format($b_money, 2);  //棚卸金額合計
			$row[$i+$count][3] = number_format($a_money, 2);  //前回棚卸金額合計 
			//倉庫計値
			$total_b_money = bcadd($total_b_money, $b_money, 2);
			$total_a_money = bcadd($total_a_money, $a_money, 2);
			$count++;
			$b_money = 0;
			$a_money = 0;
		}

        for($j=0;$j<count($inv_data[$i]);$j++){
            //Ｍ区分
            if($j==1){
                //最初の行かＭ区分が変わった場合に、配列にＭ区分代入     
                if($i==0 || $g_goods != $inv_data[$i][$j]){
                    $g_goods = $inv_data[$i][$j];
                    $inv_array = $inv_data[$i][$j];
                }else{
                    //前の行と同じ場合省略する
                    $inv_array = "";
                }
			//以外の項目
            }else{
				//棚卸金額
				if($j==5){
					//Ｍ区分計計算
					$b_money = bcadd($b_money, $inv_data[$i][$j], 2);
				//前回対比金額
				}else if($j==9){
					//Ｍ区分計計算
					$a_money = bcadd($a_money, $inv_data[$i][$j], 2);
				}

                //数値判定
                if(is_numeric($inv_data[$i][$j])){
                    $inv_data[$i][$j] = number_format($inv_data[$i][$j], 2);
                }
                $inv_array = $inv_data[$i][$j];
            }
			//データ表示
			//if($j == 4 || $j == 5 || $j == 7 || $j == 9){
			if($j == 3 || $j == 6 || $j == 8){
				$inv_array = number_format($inv_array);
			}
            $row[$i+$count][$j] = htmlspecialchars($inv_array);
        }
    }

	//最終のＭ区分計表示判定
	$row[$i+$count][0] = $inv_data[$i-1][0];         //倉庫名
	$row[$i+$count][1] = "Ｍ区分計";
	$row[$i+$count][2] = number_format($b_money, 2);   //棚卸金額合計
	$row[$i+$count][3] = number_format($a_money, 2);   //前回棚卸金額合計 
	//倉庫計値
	$total_b_money = bcadd($total_b_money, $b_money, 2);
	$total_a_money = bcadd($total_a_money, $a_money, 2);
	$count++;

	//倉庫計表示
	$row[$i+$count][0] = $inv_data[$i-1][0];             //倉庫名
	$row[$i+$count][1] = "倉庫計";
	$row[$i+$count][2] = number_format($total_b_money, 2);  //棚卸金額合計
	$row[$i+$count][3] = number_format($total_a_money, 2);  //前回棚卸金額合計 

    return $row;
}

function Get_Inv_Data2($result){
    $g_goods      = "";                    //Ｍ区分比較用
    $result_count = pg_numrows($result);   //要素数
    $count = 0;                            //Ｍ区分を表示した数

    for($i = 0; $i < $result_count; $i++){
        $inv_data[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
        //Ｍ区分計表示判定
//        if($inv_data[$i][1] != $g_goods && $i != 0){
        if($inv_data[$i][0] != $g_goods && $i != 0){
/*
            $row[$i+$count][0] = $inv_data[$i][0];         //倉庫名
            $row[$i+$count][1] = "Ｍ区分計";
            $row[$i+$count][2] = number_format($b_money);  //棚卸金額合計
            $row[$i+$count][3] = number_format($a_money);  //前回棚卸金額合計 
*/
            $row[$i+$count][1] = "Ｍ区分計";
            $row[$i+$count][2] = number_format($b_money, 2);  //棚卸金額合計
            $row[$i+$count][3] = number_format($a_money, 2);  //前回棚卸金額合計 
            //倉庫計値
            $total_b_money = bcadd($total_b_money, $b_money, 2);
            $total_a_money = bcadd($total_a_money, $a_money, 2);
            $count++;
            $b_money = 0;
            $a_money = 0;
        }

        for($j=0;$j<count($inv_data[$i]);$j++){
            //Ｍ区分
//            if($j==1){
            if($j==0){
                //最初の行かＭ区分が変わった場合に、配列にＭ区分代入
                if($i==0 || $g_goods != $inv_data[$i][$j]){
                    $g_goods = $inv_data[$i][$j];
                    $inv_array = $inv_data[$i][$j];
                }else{
                    //前の行と同じ場合省略する
                    $inv_array = "";
                }
            //以外の項目
            }else{
                //棚卸金額
//                if($j==5){
                if($j==4){
                    //Ｍ区分計計算
                    $b_money = bcadd($b_money, $inv_data[$i][$j], 2);
                //前回対比金額
//                }else if($j==9){
                }else if($j==8){
                    //Ｍ区分計計算
                    $a_money = bcadd($a_money, $inv_data[$i][$j], 2);
                }

                //数値判定
                if(is_numeric($inv_data[$i][$j])){
                    $inv_data[$i][$j] = number_format($inv_data[$i][$j], 2);
                }
                $inv_array = $inv_data[$i][$j];
            }
			//データ表示
			//if($j == 4 || $j == 5 || $j == 7 || $j == 9){
			if($j == 2 || $j == 5 || $j == 7){
				$inv_array = number_format($inv_array);
			}
            //データ表示
            $row[$i+$count][$j] = htmlspecialchars($inv_array);
        }
    }

    //最終のＭ区分計表示判定
/*
    $row[$i+$count][0] = $inv_data[$i-1][0];         //倉庫名
    $row[$i+$count][1] = "Ｍ区分計";
    $row[$i+$count][2] = number_format($b_money);   //棚卸金額合計
    $row[$i+$count][3] = number_format($a_money);   //前回棚卸金額合計
*/
    $row[$i+$count][1] = "Ｍ区分計";
    $row[$i+$count][2] = number_format($b_money, 2);   //棚卸金額合計
    $row[$i+$count][3] = number_format($a_money, 2);   //前回棚卸金額合計
    //倉庫計値
    $total_b_money = bcadd($total_b_money, $b_money, 2);
    $total_a_money = bcadd($total_a_money, $a_money, 2);
    $count++;

    //倉庫計表示
/*
    $row[$i+$count][0] = $inv_data[$i-1][0];             //倉庫名
    $row[$i+$count][1] = "倉庫計";
    $row[$i+$count][2] = number_format($total_b_money);  //棚卸金額合計
    $row[$i+$count][3] = number_format($total_a_money);  //前回棚卸金額合計
*/
    $row[$i+$count][1] = "倉庫計";
    $row[$i+$count][2] = number_format($total_b_money, 2);  //棚卸金額合計
    $row[$i+$count][3] = number_format($total_a_money, 2);  //前回棚卸金額合計

    return $row;
}


/****************************/
//外部変数取得
/****************************/
$shop_id   = $_SESSION["client_id"];                  //取引先ID
$invent_no = $_GET["invent_no"];                      //今回調査番号

//今回調査番号をhiddenにより保持する
if($_GET["invent_no"] != NULL){
	Get_Id_Check3($_GET["invent_no"]);
	$set_id_data["hdn_invent_no"] = $invent_no;
	$form->setConstants($set_id_data);
}else{
	$invent_no = $_POST["hdn_invent_no"];
}
$last_no   = $invent_no - 1;                          //前回調査番号
//前回調査番号に０を埋める
$last_no = str_pad($last_no, 10, 0, STR_POS_LEFT);
//今回調査番号に０を埋める
$invent_no = str_pad($invent_no, 10, 0, STR_POS_LEFT);

/****************************/
//初期値設定
/****************************/
$def_data["form_output_type"] = "1";

$form->setDefaults($def_data);

/****************************/
//フォーム作成
/****************************/
//出力形式
$form_output_type[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$form_output_type[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($form_output_type, "form_output_type", "出力形式");

//対象倉庫
/*
$form->addElement(
    "text","form_ware","","size=\"22\" maxLength=\"10\" 
    $g_form_option"
);
*/
$select_value = Select_Get($db_con,'ware');
    $form->addElement('select', 'form_ware', 'セレクトボックス', $select_value,"onkeydown=\"chgKeycode();\" onChange=\"javascript:Button_Submit('stock_search_flg','#','true', this);window.focus();\"");

//戻るボタン
$form->addElement(
    "button","form_back_button","戻　る","onClick=\"location.href='".$back_url."'\"");

//表示ボタン
$form->addElement("submit","show_button","表　示");

//クリアボタン
$form->addElement("button","clear_button","クリア","onClick=\"location.href='".$clear_url."?invent_no=$invent_no'\"");

$form->addElement("hidden", "hdn_invent_no");         //今回調査番号

/****************************/
//棚卸日取得
/****************************/
$sql  = "SELECT ";
$sql .= "   expected_day ";
$sql .= "FROM ";
$sql .= "   t_invent ";
$sql .= "WHERE ";
$sql .= "   invent_no = '$invent_no' "; 
$sql .= "   AND "; 
$sql .= "   shop_id = $shop_id;"; 
$result = Db_Query($db_con, $sql);
Get_Id_Check($result);
$h_data_list = Get_Data($result);
$invent_day = $h_data_list[0][0];

/****************************/
//棚卸調査表番号に対する、各倉庫件数
/****************************/
$sql  = "SELECT ";
$sql .= "   COUNT(b_invent.ware_cd) ";
$sql .= "FROM ";
$sql .= "   (SELECT ";
$sql .= "       t_invent.ware_id,";
$sql .= "       t_contents.goods_id,";
$sql .= "       t_invent.ware_name,";
$sql .= "       t_invent.ware_cd,";
$sql .= "       t_contents.g_goods_name,";
$sql .= "       t_contents.g_goods_cd,";
$sql .= "       t_contents.goods_name,";
$sql .= "       t_contents.goods_cd,";
$sql .= "       t_contents.tstock_num,";
$sql .= "       t_contents.price,";
$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
$sql .= "   FROM ";
$sql .= "       t_invent ";
$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
$sql .= "   WHERE ";
$sql .= "       t_invent.invent_no = '$invent_no' ";
if($_POST["form_ware"] != NULL){
    $sql .= "   AND ";
    //$sql .= "       t_invent.ware_name LIKE '%".$_POST["form_ware"]."%'";
    $sql .= "       t_invent.ware_id = ".$_POST["form_ware"]." ";
}
$sql .= "   AND ";
$sql .= "       t_invent.shop_id = $shop_id ";
$sql .= "   )AS b_invent ";
$sql .= "GROUP BY ";
$sql .= "    b_invent.ware_cd ";
$sql .= "ORDER BY ";
$sql .= "   b_invent.ware_cd;";

$result = Db_Query($db_con,$sql);
$i=0;
$row_count = NULL;
while($row_count_list = pg_fetch_array($result)){
    $row_count[$i] = $row_count_list[0];
    $i++;
}

//倉庫ごとにデータ配列作成
for($c=0;$c<count($row_count);$c++){
	/****************************/
	//棚卸一覧データ取得
	/****************************/
	$sql  = "SELECT ";
	$sql .= "   b_invent.ware_name,";                                      //今回棚卸の倉庫名
	$sql .= "   b_invent.g_goods_name,";                                   //今回棚卸のＭ区分名
	$sql .= "   b_invent.goods_name,";                                     //今回棚卸の商品名
	$sql .= "   b_invent.tstock_num,";                                     //今回棚卸の実棚数
	$sql .= "   b_invent.price,";                                          //今回棚卸の単価
	$sql .= "   b_invent.money,";                                          //今回棚卸の棚卸金額
	$sql .= "   a_invent.tstock_num,";                                     //前回棚卸の実棚数
	$sql .= "   a_invent.money,";                                          //前回棚卸の棚卸金額
	$sql .= "   (b_invent.tstock_num - COALESCE(a_invent.tstock_num, 0)) AS comp_num,"; //前回対比数
	$sql .= "   (b_invent.money - COALESCE(a_invent.money, 0)) AS comp_money ";         //前回対比金額
	$sql .= "FROM ";
	$sql .= "   (SELECT ";
	$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       t_invent.ware_name,";
	$sql .= "       t_invent.ware_cd,";
	$sql .= "       t_contents.g_goods_name,";
	$sql .= "       t_contents.g_goods_cd,";
	$sql .= "       t_contents.goods_name,";
	$sql .= "       t_contents.goods_cd,";
	$sql .= "       t_contents.tstock_num,";
	$sql .= "       t_contents.price,";
	$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$invent_no' ";
	if($_POST["form_ware"] != NULL){
    	$sql .= "   AND ";
    	//$sql .= "       t_invent.ware_name LIKE '%".$_POST["form_ware"]."%'";
	    $sql .= "       t_invent.ware_id = ".$_POST["form_ware"]." ";
	}
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
	$sql .= "   )AS b_invent ";
	$sql .= "LEFT JOIN ";
	$sql .= "   (SELECT ";
	$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       t_contents.tstock_num,";
	$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$last_no' ";
	if($_POST["form_ware"] != NULL){
    	$sql .= "   AND ";
    	//$sql .= "       t_invent.ware_name LIKE '%".$_POST["form_ware"]."%'";
	    $sql .= "       t_invent.ware_id = ".$_POST["form_ware"]." ";
	}
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
	$sql .= "   )AS a_invent ";
	        
	$sql .= "ON b_invent.ware_id = a_invent.ware_id ";
	$sql .= "AND ";
	$sql .= "b_invent.goods_id = a_invent.goods_id ";

	$sql .= "ORDER BY ";
	$sql .= "   b_invent.ware_cd,b_invent.g_goods_cd,b_invent.goods_cd ";

	//倉庫の範囲指定
	if($c==0){
	     //初期表示なら、先頭の行から表示。
	    $r_count = 0;
	}else{
	    //該当する倉庫を行数分表示
		$r_count = 0;
		$num = $c - 1;
	    while($num >= 0){
	        $r_count = $r_count + $row_count[$num];
	        $num--;
	    }
	}
	$sql .= " LIMIT ".$row_count[$c]." OFFSET ".$r_count.";";
//echo $sql."<br><br>";
	$result = Db_Query($db_con, $sql);
	$data_list[$c] = Get_Inv_Data($result);
}

/****************************/
//全倉庫の棚卸一覧データ取得
/****************************/
$sql  = "SELECT ";
//$sql .= "   b_invent.ware_name,";                                      //今回棚卸の倉庫名
$sql .= "   b_invent.g_goods_name,";                                   //今回棚卸のＭ区分名
$sql .= "   b_invent.goods_name,";                                     //今回棚卸の商品名
$sql .= "   SUM(b_invent.tstock_num),";                                //今回棚卸の実棚数
$sql .= "   b_invent.price,";                                          //今回棚卸の単価
$sql .= "   SUM(b_invent.money),";                                     //今回棚卸の棚卸金額
$sql .= "   SUM(a_invent.tstock_num),";                                //前回棚卸の実棚数
$sql .= "   SUM(a_invent.money),";                                     //前回棚卸の棚卸金額
//$sql .= "   (SUM(b_invent.tstock_num) - SUM(a_invent.tstock_num)),";   //前回対比数
//$sql .= "   (SUM(b_invent.money) - SUM(a_invent.money)) ";             //前回対比金額
$sql .= "   (SUM(b_invent.tstock_num) - COALESCE(SUM(a_invent.tstock_num), 0)),";   //前回対比数
$sql .= "   (SUM(b_invent.money) - COALESCE(SUM(a_invent.money), 0)) ";             //前回対比金額
$sql .= "FROM ";
$sql .= "   (SELECT ";
//$sql .= "       t_invent.ware_id,";
$sql .= "       t_contents.goods_id,";
//$sql .= "       t_invent.ware_name,";
//$sql .= "       t_invent.ware_cd,";
$sql .= "       t_contents.g_goods_name,";
$sql .= "       t_contents.g_goods_cd,";
$sql .= "       t_contents.goods_name,";
$sql .= "       t_contents.goods_cd,";
$sql .= "       SUM(t_contents.tstock_num) AS tstock_num,";
//$sql .= "       SUM(t_contents.price) AS price, ";
$sql .= "       CASE ";
$sql .= "           WHEN ";
$sql .= "               SUM(t_contents.tstock_num) != 0 ";
$sql .= "           THEN ROUND(SUM(t_contents.tstock_num * t_contents.price) / SUM(t_contents.tstock_num), 2) ";
$sql .= "           ELSE NULL ";
$sql .= "       END AS price, ";
$sql .= "       SUM(t_contents.tstock_num * t_contents.price) AS money ";
$sql .= "   FROM ";
$sql .= "       t_invent ";
$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
$sql .= "   WHERE ";
$sql .= "       t_invent.invent_no = '$invent_no' ";
$sql .= "   AND ";
$sql .= "       t_invent.shop_id = $shop_id ";
$sql .= "   GROUP BY ";
$sql .= "       t_contents.goods_id, ";
$sql .= "       t_contents.g_goods_name, ";
$sql .= "       t_contents.g_goods_cd, ";
$sql .= "       t_contents.goods_name, ";
$sql .= "       t_contents.goods_cd ";
$sql .= "   )AS b_invent ";
$sql .= "LEFT JOIN ";
$sql .= "   (SELECT ";
//$sql .= "       t_invent.ware_id,";
$sql .= "       t_contents.goods_id,";
$sql .= "       SUM(t_contents.tstock_num) AS tstock_num,";
$sql .= "       SUM(t_contents.tstock_num * t_contents.price) AS money ";
$sql .= "   FROM ";
$sql .= "       t_invent ";
$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
$sql .= "   WHERE ";
$sql .= "       t_invent.invent_no = '$last_no' ";
$sql .= "   AND ";
$sql .= "       t_invent.shop_id = $shop_id ";
$sql .= "   GROUP BY ";
$sql .= "       t_contents.goods_id ";
$sql .= "   )AS a_invent ";

$sql .= "ON ";
//$sql .= "b_invent.ware_id = a_invent.ware_id ";
//$sql .= "AND ";
$sql .= "b_invent.goods_id = a_invent.goods_id ";

//$sql .= "GROUP BY b_invent.ware_cd,b_invent.ware_name,b_invent.g_goods_cd,b_invent.g_goods_name,b_invent.goods_cd,b_invent.goods_name,b_invent.price ";
$sql .= "GROUP BY b_invent.g_goods_cd,b_invent.g_goods_name,b_invent.goods_cd,b_invent.goods_name,b_invent.price ";

$sql .= "ORDER BY ";
//$sql .= "   b_invent.ware_cd,b_invent.g_goods_cd,b_invent.goods_cd;";
$sql .= "   b_invent.g_goods_cd,b_invent.goods_cd;";
//echo $sql;
$total_result = Db_Query($db_con, $sql);
$total_list = Get_Inv_Data2($total_result);



/******************************/
//CSV出力ボタン押下処理
/*****************************/
if($_POST["show_button"] == "表　示" && $_POST["form_output_type"] == "2"){
    /** CSV作成SQL **/
    $sql  = "SELECT ";
	$sql .= "   b_invent.ware_name,";                                      //今回棚卸の倉庫名
	$sql .= "   b_invent.g_goods_name,";                                   //今回棚卸のＭ区分名
	$sql .= "   b_invent.goods_name,";                                     //今回棚卸の商品名
	$sql .= "   b_invent.tstock_num,";                                     //今回棚卸の実棚数
	$sql .= "   b_invent.price,";                                          //今回棚卸の単価
	$sql .= "   b_invent.money,";                                          //今回棚卸の棚卸金額
	$sql .= "   a_invent.tstock_num,";                                     //前回棚卸の実棚数
	$sql .= "   a_invent.money,";                                          //前回棚卸の棚卸金額
//	$sql .= "   (b_invent.tstock_num - a_invent.tstock_num) AS comp_num,"; //前回対比数
//	$sql .= "   (b_invent.money - a_invent.money) AS comp_money ";         //前回対比金額
	$sql .= "   (b_invent.tstock_num - COALESCE(a_invent.tstock_num, 0)) AS comp_num,"; //前回対比数
	$sql .= "   (b_invent.money - COALESCE(a_invent.money, 0)) AS comp_money ";         //前回対比金額
	$sql .= "FROM ";
	$sql .= "   (SELECT ";
	$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       t_invent.ware_name,";
	$sql .= "       t_invent.ware_cd,";
	$sql .= "       t_contents.g_goods_name,";
	$sql .= "       t_contents.g_goods_cd,";
	$sql .= "       t_contents.goods_name,";
	$sql .= "       t_contents.goods_cd,";
	$sql .= "       t_contents.tstock_num,";
	$sql .= "       t_contents.price,";
	$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$invent_no' ";
	if($_POST["form_ware"] != NULL){
    	$sql .= "   AND ";
    	//$sql .= "       t_invent.ware_name LIKE '%".$_POST["form_ware"]."%'";
	    $sql .= "       t_invent.ware_id = ".$_POST["form_ware"]." ";
	}
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
	$sql .= "   )AS b_invent ";
	$sql .= "LEFT JOIN ";
	$sql .= "   (SELECT ";
	$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       t_contents.tstock_num,";
	$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$last_no' ";
	if($_POST["form_ware"] != NULL){
    	$sql .= "   AND ";
    	//$sql .= "       t_invent.ware_name LIKE '%".$_POST["form_ware"]."%'";
	    $sql .= "       t_invent.ware_id = ".$_POST["form_ware"]." ";
	}
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
	$sql .= "   )AS a_invent ";
	        
	$sql .= "ON b_invent.ware_id = a_invent.ware_id ";
	$sql .= "AND ";
	$sql .= "b_invent.goods_id = a_invent.goods_id ";

	$sql .= "ORDER BY ";
	$sql .= "   b_invent.ware_cd,b_invent.g_goods_cd,b_invent.goods_cd;";

    $result = Db_Query($db_con,$sql);

    //CSVデータ取得
	//一行目は棚卸日・調査番号を表示
	$invent_data[0][0]  = $invent_day;
	$invent_data[0][1]  = $invent_no;
	$invent_data[0][2]  = $last_no;
	$invent_data[0][3]  = "　";
	$invent_data[0][4]  = "　";
	$invent_data[0][5]  = "　";
	$invent_data[0][6]  = "　";
	$invent_data[0][7]  = "　";
	$invent_data[0][8]  = "　";
	$invent_data[0][9]  = "　";
	$invent_data[0][10] = "　";
	$invent_data[0][11] = "　";
	$invent_data[0][12] = "　";
	
	//各倉庫データ表示
    $i=1;
    while($data_list = pg_fetch_array($result)){
		$invent_data[$i][0]  = "　";
		$invent_data[$i][1]  = "　";
		$invent_data[$i][2]  = "　";
        //倉庫名
        $invent_data[$i][3] = $data_list[0];
        //Ｍ区分名
        $invent_data[$i][4] = $data_list[1];
        //商品名
        $invent_data[$i][5] = $data_list[2];
        //棚卸数
        $invent_data[$i][6] = $data_list[3];
        //棚卸単価
        $invent_data[$i][7] = $data_list[4];
		//棚卸金額
        $invent_data[$i][8] = $data_list[5];
		//前回在庫数
        $invent_data[$i][9] = $data_list[6];
		//前回在庫金額
        $invent_data[$i][10] = $data_list[7];
		//前回対比数
        $invent_data[$i][11] = $data_list[8];
		//前回対比金額
        $invent_data[$i][12] = $data_list[9];
        $i++;
    }

	$sql  = "SELECT ";
	//$sql .= "   b_invent.ware_name,";                                      //今回棚卸の倉庫名
	$sql .= "   '全倉庫',";                                                //今回棚卸の倉庫名
	$sql .= "   b_invent.g_goods_name,";                                   //今回棚卸のＭ区分名
	$sql .= "   b_invent.goods_name,";                                     //今回棚卸の商品名
	//$sql .= "   SUM(b_invent.tstock_num),";                                //今回棚卸の実棚数
	$sql .= "   b_invent.tstock_num,";                                     //今回棚卸の実棚数
	$sql .= "   b_invent.price,";                                          //今回棚卸の単価
	//$sql .= "   SUM(b_invent.money),";                                     //今回棚卸の棚卸金額
	//$sql .= "   SUM(a_invent.tstock_num),";                                //前回棚卸の実棚数
	//$sql .= "   SUM(a_invent.money),";                                     //前回棚卸の棚卸金額
	$sql .= "   b_invent.money,";                                          //今回棚卸の棚卸金額
	$sql .= "   a_invent.tstock_num,";                                     //前回棚卸の実棚数
	$sql .= "   a_invent.money,";                                          //前回棚卸の棚卸金額
//	$sql .= "   (SUM(b_invent.tstock_num) - SUM(a_invent.tstock_num)),";   //前回対比数
//	$sql .= "   (SUM(b_invent.money) - SUM(a_invent.money)) ";             //前回対比金額
	//$sql .= "   (SUM(b_invent.tstock_num) - COALESCE(SUM(a_invent.tstock_num), 0)),";   //前回対比数
	//$sql .= "   (SUM(b_invent.money) - COALESCE(SUM(a_invent.money), 0)) ";             //前回対比金額
	$sql .= "   (b_invent.tstock_num - COALESCE(a_invent.tstock_num, 0)),";   //前回対比数
	$sql .= "   (b_invent.money - COALESCE(a_invent.money, 0)) ";             //前回対比金額
	$sql .= "FROM ";
	$sql .= "   (SELECT ";
	//$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	//$sql .= "       t_invent.ware_name,";
	//$sql .= "       t_invent.ware_cd,";
	$sql .= "       t_contents.g_goods_name,";
	$sql .= "       t_contents.g_goods_cd,";
	$sql .= "       t_contents.goods_name,";
	$sql .= "       t_contents.goods_cd,";
	//$sql .= "       t_contents.tstock_num,";
	//$sql .= "       t_contents.price,";
	//$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "       SUM(t_contents.tstock_num) AS tstock_num, ";
    $sql .= "       CASE ";
    $sql .= "           WHEN ";
    $sql .= "               SUM(t_contents.tstock_num) != 0 ";
    $sql .= "           THEN ROUND(SUM(t_contents.tstock_num * t_contents.price) / SUM(t_contents.tstock_num), 2) ";
    $sql .= "           ELSE NULL ";
    $sql .= "       END AS price, ";
	$sql .= "       SUM(t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$invent_no' ";
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
    $sql .= "   GROUP BY ";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       t_contents.g_goods_name,";
	$sql .= "       t_contents.g_goods_cd,";
	$sql .= "       t_contents.goods_name,";
	$sql .= "       t_contents.goods_cd";
	$sql .= "   )AS b_invent ";
	$sql .= "LEFT JOIN ";
	$sql .= "   (SELECT ";
	//$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       SUM(t_contents.tstock_num) AS tstock_num, ";
	$sql .= "       SUM(t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$last_no' ";
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
    $sql .= "GROUP BY ";
    $sql .= "       t_contents.goods_id ";
	$sql .= "   )AS a_invent ";

	//$sql .= "ON b_invent.ware_id = a_invent.ware_id ";
	//$sql .= "AND ";
    $sql .= "ON ";
	$sql .= "b_invent.goods_id = a_invent.goods_id ";

	//$sql .= "GROUP BY b_invent.ware_cd,b_invent.ware_name,b_invent.g_goods_cd,b_invent.g_goods_name,b_invent.goods_cd,b_invent.goods_name,b_invent.price ";

	$sql .= "ORDER BY ";
	//$sql .= "   b_invent.ware_cd,b_invent.g_goods_cd,b_invent.goods_cd;";
	$sql .= "   b_invent.g_goods_cd,b_invent.goods_cd;";

	$total_result = Db_Query($db_con, $sql);

	//全倉庫データ表示
	while($csv_list = pg_fetch_array($total_result)){
		$invent_data[$i][0]  = "　";
		$invent_data[$i][1]  = "　";
		$invent_data[$i][2]  = "　";
	    //倉庫名
	    $invent_data[$i][3] = "全倉庫";
	    //Ｍ区分名
	    $invent_data[$i][4] = $csv_list[1];
	    //商品名
	    $invent_data[$i][5] = $csv_list[2];
	    //棚卸数
	    $invent_data[$i][6] = $csv_list[3];
	    //棚卸単価
	    //$invent_data[$i][7] = $csv_list[4];
	    $invent_data[$i][7] = ($csv_list[4] == null) ? "-" : $csv_list[4];
		//棚卸金額
	    $invent_data[$i][8] = $csv_list[5];
		//前回在庫数
	    $invent_data[$i][9] = $csv_list[6];
		//前回在庫金額
	    $invent_data[$i][10] = $csv_list[7];
		//前回対比数
	    $invent_data[$i][11] = $csv_list[8];
		//前回対比金額
	    $invent_data[$i][12] = $csv_list[9];
		$i++;
	}

    //CSVファイル名
    $csv_file_name = "棚卸一覧".date("Ymd").".csv";
    //CSVヘッダ作成
    $csv_header = array(
        "棚卸日", 
        "棚卸調査番号",
        "前回棚卸調査番号",
        "倉庫名",
        "Ｍ区分名", 
        "商品名",
        "棚卸数",
        "棚卸単価",
        "棚卸金額",
        "前回在庫数",
        "前回在庫金額",
        "前回対比数",
        "前回対比金額"
    );
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($invent_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/

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
//$page_menu = Create_Menu_h('stock','2');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

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
    'invent_day'    => "$invent_day",
    'invent_no'     => "$invent_no",
    'last_no'       => "$last_no",
));

$smarty->assign('row',$data_list);      //倉庫データ
$smarty->assign('total',$total_list);   //全倉庫データ
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
