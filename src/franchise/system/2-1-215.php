<?php
/***********************************/
//変更履歴
//  （2006/03/15）
//  ・一覧SQL変更
//　・shop_idをclient_idに変更
//  (2006/05/08)
//  ・検索フォーム表示ボタンを追加
//  (2006/07/06)
//  ・shop_gidをなくす(kaji)
/***********************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-05      ban_0007     suzuki     CSV出力時にサニタイジングを行わないように修正
 *  2007-05-09                   kaku-m     csv出力の項目を追加
 *  2010-05-12      Rev.1.5      hashimoto-y 初期表示に検索項目だけ表示する修正
 *
*/

$page_title = "仕入先マスタ";

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
$shop_id  = $_SESSION[client_id];
//$shop_gid = $_SESSION[shop_gid];

/****************************/
//デフォルト値設定
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
    "form_state_type"     => "1",
    "form_turn"     => "1"
);
$form->setDefaults($def_fdata);

/****************************/
//HTMLイメージ作成用部品
/****************************/
//出力形式
$radio1[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio1, "form_output_type", "出力形式");

//仕入先コード
$form->addElement("text","form_client_cd","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\""." $g_form_option");

//仕入先名
$form->addElement("text","form_client_name","テキストフォーム",'size="34" maxLength="15"'." $g_form_option");

//略称
$form->addElement("text","form_client_cname","テキストフォーム",'size="21" maxLength="10"'." $g_form_option");

//TEL
$form->addElement("text","form_tel","","size=\"15\" maxLength=\"13\" style=\"$g_form_style\""." $g_form_option");

//状態
$radio2[] =& $form->createElement( "radio",NULL,NULL, "取引中","1");
$radio2[] =& $form->createElement( "radio",NULL,NULL, "解約・休止中","2");
//$radio2[] =& $form->createElement( "radio",NULL,NULL, "解約","3");
$radio2[] =& $form->createElement( "radio",NULL,NULL, "全て","4");
$form->addGroup($radio2, "form_state_type", "状態");

//地区
$select_value = Select_Get($conn, "area");
$form->addElement('select', 'form_area_id',"", $select_value);

//ボタン
$button[] = $form->createElement("submit","show_button","表　示");
$button[] = $form->createElement("button","clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addGroup($button, "form_button", "ボタン");
$form->addElement("button","change_button","変更・一覧",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","登録画面","onClick=\"location.href='2-1-216.php'\"");
$form->addElement("submit","form_search_button","検索フォームを表示");

#2010-05-13 hashimoto-y
/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["form_button"]["show_button"] == "表　示"){
    $output_type    = $_POST["form_output_type"];           //出力形式
    $client_cd      = trim($_POST["form_client_cd"]);       //仕入先コード1
    $client_name    = trim($_POST["form_client_name"]);     //仕入先名
    $area_id       = $_POST["form_area_id"];               //地区
    $tel            = $_POST["form_tel"];                   //TEL
    $state          = $_POST["form_state_type"];            //状態


    /****************************/
    //データ件数取得
    /****************************/
    $client_sql  = "SELECT";
    $client_sql .= " t_client.client_id,";          // 0 仕入先ID
    $client_sql .= " t_client.client_cd1,";         // 1 仕入先コード１
    $client_sql .= " t_client.client_name,";        // 2 仕入先名
    $client_sql .= " t_area.area_name,";            // 3 地区
    $client_sql .= " t_client.tel,";                // 4 TEL
    $client_sql .= " t_client.state";               // 5 状態
    //下のcsv判定用に、output_type取得
    if($_POST["form_button"]["show_button"] == "表　示"){
    $output_type    = $_POST["form_output_type"];
    }
    //csv出力時
    if($output_type == 2){
    $client_sql .= ", ";
    $client_sql .= "    t_sbtype.sbtype_name,";     // 6 業種名
    $client_sql .= "    t_inst.inst_name,";         // 7 施設名
    $client_sql .= "    t_bstruct.bstruct_name,";   // 8 業態名
    $client_sql .= "    t_client.client_read,";     // 9 仕入先名１フリガナ
    $client_sql .= "    t_client.client_name2,";    // 10 仕入先名２
    $client_sql .= "    t_client.client_read2,";    // 11 仕入先名２フリガナ
    $client_sql .= "    t_client.client_cname,";    // 12 略称
    $client_sql .= "    t_client.client_cread,";    // 13 略称フリガナ
    $client_sql .= "    t_client.post_no1 || '-' || t_client.post_no2 ,";        // 14 郵便番号
    $client_sql .= "    t_client.address1,";        // 15 住所１
    $client_sql .= "    t_client.address2,";        // 16 住所２
    $client_sql .= "    t_client.address3,";        // 17 住所３
    $client_sql .= "    t_client.address_read,";    // 18 住所２フリガナ
    $client_sql .= "    t_client.capital,";         // 19 資本金
    $client_sql .= "    t_client.fax,";             // 20 FAX
    $client_sql .= "    t_client.email,";           // 21 Email
    $client_sql .= "    t_client.url,";             // 22 URL
    $client_sql .= "    t_client.rep_name,";        // 23 代表者氏名
    $client_sql .= "    t_client.represe,";         // 24 代表者役職
    $client_sql .= "    t_client.rep_htel,";        // 25 代表者携帯
    $client_sql .= "    t_client.direct_tel,";      // 26 直通TEL
    $client_sql .= "    t_client.charger1,";        // 27 窓口担当
    $client_sql .= "    t_staff.staff_name,";       // 28 契約担当
    $client_sql .= "    t_client.c_part_name,";     // 29 仕入先部署
    $client_sql .= "    t_trade.trade_name,";       // 30 仕入先区分
    $client_sql .= "    CASE t_client.close_day ";  // 31 締日
    $client_sql .= "        WHEN '29' THEN '月末' ";
    $client_sql .= "        ELSE t_client.close_day || '日' ";
    $client_sql .= "    END AS close_day,";
    $client_sql .= "    CASE t_client.payout_m ";   // 32 支払日（月）
    $client_sql .= "        WHEN '0' THEN '当月' ";
    $client_sql .= "        WHEN '1' THEN '翌月' ";
    $client_sql .= "        ELSE t_client.payout_m || 'ヵ月後' ";
    $client_sql .= "    END AS payout_m,";
    $client_sql .= "    CASE t_client.payout_d ";   // 33 支払日（日）
    $client_sql .= "        WHEN '29' THEN '月末' ";
    $client_sql .= "        ELSE t_client.payout_d || '日' ";
    $client_sql .= "    END AS payout_d,";
    $client_sql .= "    t_client.col_terms,";       // 34 支払条件
    $client_sql .= "    t_client.bank_name,";       // 35 振込口座
    $client_sql .= "    t_client.b_bank_name,";     // 36 振込口座略称
    $client_sql .= "    t_client.holiday,";         // 37 休日
    $client_sql .= "    t_client.establish_day,";   // 38 創業日
    $client_sql .= "    t_client.cont_sday,";       // 39 取引開始日
    $client_sql .= "    CASE t_client.coax ";       // 40 金額：丸め区分
    $client_sql .= "        WHEN '1' THEN '切捨' ";
    $client_sql .= "        WHEN '2' THEN '四捨五入' ";
    $client_sql .= "        WHEN '3' THEN '切上' ";
    $client_sql .= "    END AS coax, ";
    $client_sql .= "    CASE t_client.tax_div ";    // 41 消費税:課税単位
    $client_sql .= "        WHEN '1' THEN '締日単位' ";
    $client_sql .= "        WHEN '2' THEN '伝票単位' ";
    $client_sql .= "    END AS tax_div,";
    $client_sql .= "    CASE t_client.tax_franct "; // 42 消費税:端数区分
    $client_sql .= "        WHEN '1' THEN '切捨' ";
    $client_sql .= "        WHEN '2' THEN '四捨五入' ";
    $client_sql .= "        WHEN '3' THEN '切上' ";
    $client_sql .= "    END AS tax_franct,";
    $client_sql .= "    CASE t_client.c_tax_div ";  // 43 消費税:課税区分
    $client_sql .= "        WHEN '1' THEN '外税' ";
    $client_sql .= "        WHEN '2' THEN '内税' ";
    $client_sql .= "    END AS c_tax_div,";
    $client_sql .= "    t_branch.branch_name,";     // 44 担当支店
    $client_sql .= "    t_client.deal_history,";    // 45 取引履歴
    $client_sql .= "    t_client.importance, ";     // 46 重要事項
    $client_sql .= "    t_client.note ";            // 47 備考
    }

    $client_sql .= " FROM";
    $client_sql .= " t_client";
    $client_sql .= "  LEFT JOIN";
    $client_sql .= " t_area ";
    $client_sql .= " ON t_client.area_id = t_area.area_id ";
    //csv出力時
    if($output_type == 2){
    $client_sql .= " LEFT JOIN t_sbtype ";
    $client_sql .= "    ON t_sbtype.sbtype_id = t_client.sbtype_id ";
    $client_sql .= " LEFT JOIN t_inst ";
    $client_sql .= "    ON t_inst.inst_id = t_client.inst_id ";
    $client_sql .= " LEFT JOIN t_bstruct ";
    $client_sql .= "    ON t_bstruct.bstruct_id = t_client.b_struct ";
    $client_sql .= " LEFT JOIN t_staff ";
    $client_sql .= "    ON t_staff.staff_id = t_client.c_staff_id1 ";
    $client_sql .= " LEFT JOIN t_trade ";
    $client_sql .= "    ON t_trade.trade_id = t_client.trade_id ";
    $client_sql .= " LEFT JOIN t_branch ";
    $client_sql .= "    ON t_branch.branch_id = t_client.charge_branch_id ";
    }
    $client_sql .= " WHERE";
    //$client_sql .= "     t_client.shop_gid = $shop_gid";
    if($_SESSION[group_kind] == "2"){
        $client_sql .= "   t_client.shop_id IN (".Rank_Sql().") ";
    }else{
        $client_sql .= "   t_client.shop_id = $shop_id";
    }

    $client_sql .= "     AND";
    $client_sql .= "     t_client.client_div = 2 ";

    //データに表示させる全件数
    $total_count_sql = $client_sql;
    $count_res = Db_Query($conn, $total_count_sql." ORDER BY t_client.client_cd1;");
    $page_data = Get_Data($count_res);

    /****************************/
    //全件数取得
    /****************************/
    $count_sql  = " SELECT";
    $count_sql .= "     COUNT(client_id)";
    $count_sql .= " FROM";
    $count_sql .= "     t_client";
    $count_sql .= " WHERE";
    //$count_sql .= "     t_client.shop_gid = $shop_gid";
    if($_SESSION[group_kind] == "2"){
        $count_sql .= "   t_client.shop_id IN (".Rank_Sql().") ";
    }else{
        $count_sql .= "   t_client.shop_id = $shop_id";
    }

    $count_sql .= "     AND";
    $count_sql .= "     t_client.client_div = '2'";
    $count_sql .= ";";

    //ヘッダーに表示させる全件数
    $count_res = Db_Query($conn, $count_sql);
    $total_count = pg_fetch_result($count_res,0,0);


    /****************************/
    //where_sql作成
    /****************************/
        //仕入先コード1
        if($client_cd != null){
            $client_cd_sql  = " AND t_client.client_cd1 LIKE '$client_cd%'";
        }
       
        //仕入先名
        if($client_name != null){
            $client_name_sql  = " AND t_client.client_name LIKE '%$client_name%'";
        }
        
        //略称
        if($client_cname != null){
            $client_cname_sql  = " AND t_client.client_cname LIKE '%$client_cname%'";
        }
        
        //地区
        if($area_id != 0){
            $area_id_sql = " AND t_area.area_id = $area_id";
        }

        //TEL
        if($tel != null){
            $tel_sql  = " AND t_client.tel LIKE '$tel%'";
        }

        //状態
        if($state != 4){
            $state_sql = " AND t_client.state = $state";
        }

        $where_sql  = $client_cd_sql;
        $where_sql .= $client_name_sql;
        $where_sql .= $client_cname_sql;
        $where_sql .= $area_id_sql;
        $where_sql .= $tel_sql;
        $where_sql .= $state_sql;
    /****************************/
    //表示データ作成
    /****************************/
    //画面選択時
    if($output_type != 2){
        //該当件数
        $client_sql .= $where_sql;
        $total_count_sql = $client_sql;
        $count_res = Db_Query($conn, $total_count_sql." ORDER BY t_client.client_cd1;");
        $match_count = pg_num_rows($count_res);
        
        $page_data = Get_Data($count_res, $output_type);
    }else if($output_type == 2){

		//該当件数
        $client_sql .= $where_sql;
        $total_count_sql = $client_sql;
        $count_res = Db_Query($conn, $total_count_sql." ORDER BY t_client.client_cd1;");
        $match_count = pg_num_rows($count_res);
        
        $page_data = Get_Data($count_res, $output_type);

        //CSV作成
        for($i = 0; $i < $match_count; $i++){
            if($page_data[$i][5] == 1){
                $page_data[$i][5] = "取引中";
            }else{
                $page_data[$i][5] = "解約・休止中";
            }
            $csv_page_data[$i][0] = $page_data[$i][5];          //状態
            $csv_page_data[$i][1] = $page_data[$i][3];          //地区
            $csv_page_data[$i][2] = $page_data[$i][6];          //業種
            $csv_page_data[$i][3] = $page_data[$i][7];          //施設
            $csv_page_data[$i][4] = $page_data[$i][8];          //業態
            $csv_page_data[$i][5] = $page_data[$i][1];          //仕入先コード
            $csv_page_data[$i][6] = $page_data[$i][2];          //仕入先名１
            $csv_page_data[$i][7] = $page_data[$i][9];          //仕入先名１フリガナ
            $csv_page_data[$i][8] = $page_data[$i][10];         //仕入先名２
            $csv_page_data[$i][9] = $page_data[$i][11];         //仕入先名２フリガナ
            $csv_page_data[$i][10] = $page_data[$i][12];        //略称
            $csv_page_data[$i][11] = $page_data[$i][13];        //略称フリガナ
            $csv_page_data[$i][12] = $page_data[$i][14];        //郵便番号
            $csv_page_data[$i][13] = $page_data[$i][15];        //住所１
            $csv_page_data[$i][14] = $page_data[$i][16];        //住所２
            $csv_page_data[$i][15] = $page_data[$i][17];        //住所３
            $csv_page_data[$i][16] = $page_data[$i][18];        //住所２フリガナ
            $csv_page_data[$i][17] = $page_data[$i][19];        //資本金
            $csv_page_data[$i][18] = $page_data[$i][4];         //TEL
            $csv_page_data[$i][19] = $page_data[$i][20];        //FAX
            $csv_page_data[$i][20] = $page_data[$i][21];        //Email
            $csv_page_data[$i][21] = $page_data[$i][22];        //URL
            $csv_page_data[$i][22] = $page_data[$i][23];        //代表者氏名
            $csv_page_data[$i][23] = $page_data[$i][24];        //代表者役職
            $csv_page_data[$i][24] = $page_data[$i][25];        //代表者携帯
            $csv_page_data[$i][25] = $page_data[$i][26];        //直通TEL
            $csv_page_data[$i][26] = $page_data[$i][27];        //窓口ご担当
            $csv_page_data[$i][27] = $page_data[$i][28];        //契約担当
            $csv_page_data[$i][28] = $page_data[$i][29];        //仕入先部署
            $csv_page_data[$i][29] = $page_data[$i][30];        //取引区分
            $csv_page_data[$i][30] = $page_data[$i][31];        //締日
            $csv_page_data[$i][31] = $page_data[$i][32]."の".$page_data[$i][33];  //支払日
            $csv_page_data[$i][32] = $page_data[$i][34];        //支払条件
            $csv_page_data[$i][33] = $page_data[$i][36];        //振込口座
            $csv_page_data[$i][34] = $page_data[$i][37];        //振込口座略称
            $csv_page_data[$i][35] = $page_data[$i][38];        //休日
            $csv_page_data[$i][36] = $page_data[$i][39];        //創業日
            $csv_page_data[$i][37] = $page_data[$i][40];        //金額：丸め区分
            $csv_page_data[$i][38] = $page_data[$i][41];        //消費税：課税単位
            $csv_page_data[$i][39] = $page_data[$i][42];        //消費税：端数区分
            $csv_page_data[$i][40] = $page_data[$i][43];        //消費税：課税区分
            $csv_page_data[$i][41] = $page_data[$i][44];        //担当支店
            $csv_page_data[$i][42] = $page_data[$i][45];        //取引履歴
            $csv_page_data[$i][43] = $page_data[$i][46];        //重要事項
            $csv_page_data[$i][44] = $page_data[$i][47];        //備考
        }

        $csv_file_name = "仕入先マスタ".date("Ymd").".csv";
        $csv_header = array(
            "状態",
            "地区",
            "業種",
            "施設",
            "業態",
            "仕入先コード",
            "仕入先名１",
            "仕入先名１（フリガナ）",
            "仕入先名２",
            "仕入先名２（フリガナ）",
            "略称",
            "略称（フリガナ）",
            "郵便番号",
            "住所１",
            "住所２",
            "住所３",
            "住所２（フリガナ）",
            "資本金",
            "TEL",
            "FAX",
            "Email",
            "URL",
            "代表者氏名",
            "代表者役職",
            "代表者携帯",
            "直通TEL",
            "窓口ご担当",
            "契約担当",
            "仕入先部署",
            "取引区分",
            "締日",
            "支払日",
            "支払条件",
            "振込口座",
            "振込口座略称",
            "休日",
            "創業日",
            "金額：丸め区分",
            "消費税：課税単位",
            "消費税：端数区分",
            "消費税：課税区分",
            "担当支店",
            "取引履歴",
            "重要事項",
            "備考",
          );

        $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
        $csv_data = Make_Csv($csv_page_data, $csv_header);
        Header("Content-disposition: attachment; filename=$csv_file_name");
        Header("Content-type: application/octet-stream; name=$csv_file_name");
        print $csv_data;
        exit;
    }

#2010-05-12 hashimoto-y
$display_flg = true;
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
$page_menu = Create_Menu_f('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
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
    'match_count'   => "$match_count",
    'display_flg'    => "$display_flg",
));
$smarty->assign('row',$page_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
