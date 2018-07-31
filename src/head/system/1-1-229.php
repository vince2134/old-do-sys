<?php
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-01-23     仕様変更　　watanabe-k　ボタンの色を変更
 *  2007-05-09                 kaku-m      csv出力する項目を追加
 *
 */

$page_title = "構成品マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DBに接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);

/****************************/
//外部変数取得
/****************************/
$shop_id = $_SESSION["client_id"];
/****************************/
//フォーム生成
/****************************/
//出力形式
$radio[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup( $radio, "form_output_type", "出力形式");

//構成品コード
$form->addElement(
        "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        ".$g_form_option."\""
    );

//構成品名
$form->addElement(
        "text","form_goods_name","",'size="34" 
        '." $g_form_option"
    );

//商品コード
$form->addElement(
        "text","form_parts_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        ".$g_form_option."\""
    );

//商品名
$form->addElement(
        "text","form_parts_goods_name","",'size="34" 
        '." $g_form_option"
    );

//ボタン
//登録
$form->addElement("button","new_button","登録画面","onClick=\"javascript:Referer('1-1-230.php')\"");
//変更・一覧
//$form->addElement("button","change_button","変更・一覧","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","change_button","変更・一覧", $g_button_color."  onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addElement(
    "submit","form_show_button","表　示"
    );
$form->addElement(
    "button","form_clear_button","クリア",
    "onClick=\"location.href='$_SERVER[PHP_SELF]'\"
    ");
$form->addElement("submit","form_search_button","検索フォームを表示");

/****************************/
//デフォルト値設定
/****************************/
$def_form= array(
    "form_output_type"   => "1",
    );
$form->setDefaults($def_form);


/****************************/
//POST取得
/****************************/
if($_POST["form_show_button"] == "表　示"){
    $goods_cd           = $_POST["form_goods_cd"];          //親商品コード
    $goods_name         = $_POST["form_goods_name"];        //親商品名
    $parts_goods_cd     = $_POST["form_parts_goods_cd"];    //構成品コード
    $parts_goods_name   = $_POST["form_parts_goods_name"];    //構成品名
    $output_type        = $_POST["form_output_type"];       //表示形式
}
/****************************/
//where_sql 作成
/****************************/
if($goods_cd != null){
    $where_sql  = " AND t_goods.goods_cd LIKE '$goods_cd%'\n";
}

if($goods_name != null){
    $where_sql .= " AND t_goods.goods_name LIKE '%$goods_name%'\n";
}

/*
if($parts_goods_cd != null){
    $where_sql .= " AND t_goods.goods_cd LIKE '$parts_goods_cd%'\n";
}

if($parts_goods_name != null){
    $where_sql .= " AND t_goods.goods_name LIKE '%$parts_goods_name%'\n";
}
*/

if($parts_goods_cd != null || $parts_goods_name != null){
    $where_sql .= " AND t_compose.goods_id IN (SELECT\n";
    $where_sql .= "                                t_compose.goods_id\n";
    $where_sql .= "                            FROM\n";
    $where_sql .= "                                t_compose\n";
    $where_sql .= "                                    INNER JOIN\n";
    $where_sql .= "                                t_goods\n";
    $where_sql .= "                                ON t_compose.parts_goods_id = t_goods.goods_id\n";
    $where_sql .= "                            WHERE\n";
    $where_sql .= "                                public_flg = 't'\n";
    if($parts_goods_cd != null){
        $where_sql .= "                                 AND\n";
        $where_sql .= "                                 goods_cd LIKE '$parts_goods_cd%'\n";
    }
    if($parts_goods_name != null){
        $where_sql .= "                                 AND\n";
        $where_sql .= "                                 goods_name LIKE '%$parts_goods_name%'\n";
    }
    $where_sql .= "                            )\n";
/*
    $where_sql .= " AND t_com_goods.goods_id IN (SELECT\n";
    $where_sql .= "                                 goods_id\n";
    $where_sql .= "                             FROM\n";
    $where_sql .= "                                 t_goods\n";
    $where_sql .= "                             WHERE\n";
    $where_sql .= "                                 public_flg = 't'\n";
    if($parts_goods_cd != null){
        $where_sql .= "                                 AND\n";
        $where_sql .= "                                 goods_cd LIKE '$parts_goods_cd%'\n";
    }
    if($parts_goods_name != null){
        $where_sql .= "                                 AND\n";
        $where_sql .= "                                 goods_name LIKE '%$parts_goods_name%'\n";
    }
    $where_sql .= "                             )\n";
*/
}


/****************************/
//SQL作成
/****************************/
/*
$sql  = "SELECT\n";
$sql .= "    t_com_goods.goods_id,\n";
$sql .= "    t_com_goods.goods_cd,\n";
$sql .= "    t_com_goods.goods_name,\n";
$sql .= "    t_goods.goods_cd,\n";
$sql .= "    t_goods.goods_name,\n";
$sql .= "    t_compose.count,\n";
$sql .= "    CASE t_com_goods.accept_flg \n";
$sql .= "       WHEN '1' THEN '○'\n";
$sql .= "       WHEN '2' THEN '×'\n";
$sql .= "    END\n";
$sql .= " FROM\n";
$sql .= "    t_goods,\n";
$sql .= "    t_goods AS t_com_goods,\n";
$sql .= "    t_compose\n";
$sql .= " WHERE\n";
$sql .= "    t_compose.parts_goods_id = t_goods.goods_id\n";
$sql .= "    AND\n";
$sql .= "    t_compose.goods_id = t_com_goods.goods_id\n";
$sql .= "    AND\n";
$sql .= "    t_com_goods.compose_flg = 't'\n";
$sql .=      $where_sql;
$sql .= " ORDER BY t_com_goods.goods_cd, t_goods.goods_cd\n";
$sql .= ";\n";
*/

$sql  = "SELECT\n";
$sql .= "    t_goods.goods_id,\n";                  //構成品ID 1
$sql .= "    t_goods.goods_cd,\n";                  //構成品コード 2
$sql .= "    t_goods.goods_name,\n";                //構成品名 3
$sql .= "    t_com_goods.goods_cd,\n";              //商品コード 4
$sql .= "    t_com_goods.goods_name,\n";            //商品名 5
$sql .= "    t_compose.count,\n";                   //数量 6
$sql .= "    CASE t_goods.accept_flg \n";           //承認 7
$sql .= "       WHEN '1' THEN '○'\n";
$sql .= "       WHEN '2' THEN '×'\n";
$sql .= "    END \n";
if($output_type != null && $output_type != 1){
$sql .= ", \n";
$sql .= "    t_goods.goods_cname, \n";              //略称 8
$sql .= "    t_goods.unit, \n";                     //単位 9
$sql .= "    CASE t_goods.tax_div \n";              //課税区分 10
$sql .= "       WHEN '1' THEN '課税' \n";
$sql .= "       WHEN '3' THEN '非課税' \n";
$sql .= "    END, \n";
$sql .= "    CASE t_goods.name_change \n";          //品名変更 11
$sql .= "       WHEN '1' THEN '変更可' \n";
$sql .= "       WHEN '2' THEN '変更不可' \n";
$sql .= "    END, \n";
$sql .= "    t_price.r_price, \n";                  //付加 12
$sql .= "    t_price2.r_price AS price, \n";        //標準価格 13
$sql .= "    CASE t_goods.state \n";                //状態 14
$sql .= "       WHEN '1' THEN '有効' \n";
$sql .= "       WHEN '2' THEN '無効' \n";
$sql .= "       WHEN '3' THEN '有効（直営）' \n";
$sql .= "    END \n";
}
$sql .= "FROM\n";
$sql .= "    t_compose\n";
$sql .= "       INNER JOIN\n";
$sql .= "    t_goods\n";
$sql .= "    ON t_compose.goods_id = t_goods.goods_id\n";
$sql .= "       INNER JOIN\n";
$sql .= "    t_goods AS t_com_goods\n";
$sql .= "    ON t_compose.parts_goods_id = t_com_goods.goods_id\n";
if($output_type != null && $output_type != 1){
$sql .= "   LEFT JOIN t_price \n";
$sql .= "   ON t_com_goods.goods_id = t_price.goods_id \n";
$sql .= "   LEFT JOIN t_price AS t_price2 \n";
$sql .= "   ON t_com_goods.goods_id = t_price2.goods_id \n";
}
$sql .= "WHERE\n";
$sql .= "    t_goods.compose_flg = 't'\n";
$sql .=     $where_sql;
if($output_type != null && $output_type != 1){
$sql .= "    AND t_price.rank_cd = '1' \n";
$sql .= "    AND t_price.shop_id = $shop_id \n";
$sql .= "    AND t_price2.rank_cd = '4' \n";
$sql .= "    AND t_price2.shop_id = $shop_id \n";
}
$sql .= "ORDER BY t_goods.goods_cd, t_com_goods.goods_cd\n";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);

/****************************/
//表示処理判定
/****************************/
if($output_type == 1 || $output_type == null){

    $show_data = Get_Data($result, 1);
    /****************************/
    //表示データ整形
    /****************************/
    for($i = 0; $i < $total_count; $i++){
        for($j = 0; $j < $total_count; $j++){
            if($i != $j && $show_data[$i][0] == $show_data[$j][0]){
                $show_data[$j][0] = null;
                $show_data[$j][1] = null;
                $show_data[$j][2] = null;
                $show_data[$j][6] = null;
            }
        }
    }

    $search_num = 0;
    for($i = 0; $i < $total_count; $i++){
        if($i == 0){
            $tr[$i] = "Result1";
            $search_num++;
        }elseif($show_data[$i][0] == null){
            $tr[$i] = $tr[$i-1];
        }else{
            if($tr[$i-1] == "Result1"){
                $tr[$i] = "Result2";
                $search_num++;
            }else{
                $tr[$i] = "Result1";
                $search_num++;
            }
        }
    }
}else{
    $show_data = Get_Data($result, 2);
    $k = 999;
    $cnt = 0;
    $huka = 0;
    $kakaku = 0;
    for($i = 0; $i < count($show_data); $i++){
        if($i < (count($show_data)-1) && $show_data[$i][0] == $show_data[$i+1][0]&&$cnt < 1){
            $huka = bcmul($show_data[$i][11],$show_data[$i][5],2);
            $kakaku = bcmul($show_data[$i][12],$show_data[$i][5],2);
            $cnt = 0;
            for($k=$i+1;$show_data[$i][0] == $show_data[$k][0];$k++){
                $huka = bcadd(bcmul($show_data[$k][11],$show_data[$k][5],2),$huka,2);
                $kakaku = bcadd(bcmul($show_data[$k][12],$show_data[$k][5],2),$kakaku,2);
                $cnt++;
            }
        }
        $csv_list[$i][0] = $show_data[$i][13];  //状態
        $csv_list[$i][1] = $show_data[$i][1];   //構成品コード
        $csv_list[$i][2] = $show_data[$i][2];   //構成品名
        $csv_list[$i][3] = $show_data[$i][7];   //略称
        $csv_list[$i][4] = $show_data[$i][8];   //単位
        $csv_list[$i][5] = $show_data[$i][9];   //課税区分
        $csv_list[$i][6] = $show_data[$i][10];  //品名変更
        $csv_list[$i][7] = ($show_data[$i][6]=='○')?'承認済み':'未承認';   //承認
        $csv_list[$i][8] = $huka;               //付加
        $csv_list[$i][9] = $kakaku;             //標準価格
        $csv_list[$i][10] = $show_data[$i][3];  //部品商品コード
        $csv_list[$i][11] = $show_data[$i][4];  //部品商品名
        $csv_list[$i][12] = $show_data[$i][11]; //単価
        $csv_list[$i][13] = $show_data[$i][5];  //構成数
        $csv_list[$i][14] = bcmul($show_data[$i][11],$show_data[$i][5],2);//仕入金額
        $cnt--;
    }

    $result = Db_Query($conn, $sql);
    $total_count = pg_num_rows($result);
    $show_data = Get_Data($result, 2);

    $csv_file_name = "構成品マスタ".date("Ymd").".csv";
    $csv_header = array(
        "状態",
        "構成品コード", 
        "構成品名",
        "略称",
        "単位",
        "課税区分",
        "品名変更",
        "承認",
        "付加",
        "標準価格",
        "部品商品コード",
        "部品商品名",
        "仕入単価",
        "構成数",
        "仕入金額",
    );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_list, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;

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
//メニュー作成
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
$sql  = "SELECT";   
$sql .= "   count(t_compose.goods_id)";
$sql .= " FROM";
$sql .= "   (select goods_id from t_compose GROUP BY goods_id) AS t_compose";
$sql .= ";";

$result = Db_Query($conn, $sql.";");
$total_count = pg_fetch_result($result,0,0);

$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
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
	"total_count" => "$total_count", 
	"search_num" => "$search_num", 
));

$smarty->assign('show_data', $show_data);
$smarty->assign('tr', $tr);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
