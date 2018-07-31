<?php
/************************* 
 *　変更履歴
 *　　　（20060803）商品名を略称から整式名称に変更<watanabe-k>
 *
 *
 *
**************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/30      scl_項目外  suzuki      総合計数を計算するように修正
 *  2006/12/06      ban_0016    suzuki      日付のゼロ埋め追加
 *  2007/01/24      仕様変更    watanabe-k  ボタンの色変更
 *  2007/05/18      仕様変更    watanabe-k  棚卸入力の差異原因に「調整」を追加したため、受払に登録する調整理由にも追加
*/

$page_title = "在庫調整";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/*******************************/
//外部変数取得
/*******************************/
$shop_id = $_SESSION["client_id"];

/*******************************/
//初期値設定
/*******************************/
//$def_data["form_output_type"] = "1";
//$form->setDefaults($def_data);

$page_num = 0;

/*******************************/
//フォーム作成
/*******************************/
//button
$form->addElement("button","change_button","一　覧",
        $g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","入　力","
        onClick=\"javascript:Referer('1-4-108.php')\"");

//取扱期間
$form_handling_day[] =& $form->createElement(
    "text","sy","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_handling_day[sy]','form_handling_day[sm]',4)\"  
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[sy]','form_handling_day[sm]','form_handling_day[sd]');\""
);
$form_handling_day[] =& $form->createElement("static","","","-");
$form_handling_day[] =& $form->createElement(
    "text","sm","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_handling_day[sm]','form_handling_day[sd]',2)\" 
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[sy]','form_handling_day[sm]','form_handling_day[sd]');\""
);
$form_handling_day[] =& $form->createElement("static","","","-");
$form_handling_day[] =& $form->createElement(
    "text","sd","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[sy]','form_handling_day[sm]','form_handling_day[sd]');\""
);
$form_handling_day[] =& $form->createElement("static","","","　〜　");
$form_handling_day[] =& $form->createElement(
    "text","ey","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_handling_day[ey]','form_handling_day[em]',4)\" 
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[ey]','form_handling_day[em]','form_handling_day[ed]');\""
);
$form_handling_day[] =& $form->createElement("static","","","-");
$form_handling_day[] =& $form->createElement(
    "text","em","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_handling_day[em]','form_handling_day[ed]',2)\" 
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[ey]','form_handling_day[em]','form_handling_day[ed]');\""
);
$form_handling_day[] =& $form->createElement("static","","","-");
$form_handling_day[] =& $form->createElement(
    "text","ed","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[ey]','form_handling_day[em]','form_handling_day[ed]');\""
);
$form->addGroup( $form_handling_day,"form_handling_day","f_date_b1");

//倉庫
$select_value = Select_Get($db_con,'ware');
$form->addElement('select', 'form_ware', '', $select_value,$g_form_option_select);

//商品コード
$form->addElement(
    "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
    $g_form_option" 
);

//商品名
$form->addElement(
    "text","form_goods_cname","","size=\"34\" maxLength=\"30\" 
    $g_form_option"
);

// 調整理由
$item   =   null;   
$item   =   array(  
    null => null,
    "4"  => "発見", 
    "2"  => "破損", 
    "3"  => "紛失", 
    "5"  => "在庫記入ミス",
    "1"  => "システム開始在庫",
    "6"  => "メンブレン製造",
    "7"  => "調整",
);
$form->addElement("select", "form_reason", "", $item, $g_form_option_select);

//表示ボタン
/*
$form->addElement(
    "submit","form_show_button","表　示","
    onClick=\"javascript:Which_Type('form_output_type','1-4-111.php','#');\""
);
*/
$form->addElement(
    "submit","form_show_button","表　示"
);

//クリアボタン
$form->addElement(
    "button","form_clear_button","クリア","
    onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\""
);

/****************************/
//エラーチェック
/****************************/
//■契約年月日
//●半角数字チェック

$form->addGroupRule('form_handling_day', array(
        'sy' => array(
                array('取扱期間の日付は妥当ではありません。','numeric')
        ),
        'sm' => array(
                array('取扱期間の日付は妥当ではありません。','numeric')
        ),
        'sd' => array(
                array('取扱期間の日付は妥当ではありません。','numeric')
        ),
        'ey' => array(
                array('取扱期間の日付は妥当ではありません。','numeric')
        ),
        'em' => array(
                array('取扱期間の日付は妥当ではありません。','numeric')
        ),
        'ed' => array(
                array('取扱期間の日付は妥当ではありません。','numeric')
        ),
));

/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["form_show_button"] == "表　示"){

    $handling_day_sy    = $_POST["form_handling_day"]["sy"];        //取扱期間（開始年）
    $handling_day_sm    = $_POST["form_handling_day"]["sm"];        //取扱期間（開始月）
    $handling_day_sd    = $_POST["form_handling_day"]["sd"];        //取扱期間（開始日）
	$handling_day_sy = str_pad($handling_day_sy,4, 0, STR_PAD_LEFT);  
	$handling_day_sm = str_pad($handling_day_sm,2, 0, STR_PAD_LEFT); 
	$handling_day_sd = str_pad($handling_day_sd,2, 0, STR_PAD_LEFT); 
    if($handling_day_sy != NULL && $handling_day_sm != NULL && $handling_day_sd != NULL){
        $hand_start = $_POST["form_handling_day"]["sy"]."-".$_POST["form_handling_day"]["sm"]."-".$_POST["form_handling_day"]["sd"];
    }

    $handling_day_ey    = $_POST["form_handling_day"]["ey"];        //取扱期間（終了年）
    $handling_day_em    = $_POST["form_handling_day"]["em"];        //取扱期間（終了月）
    $handling_day_ed    = $_POST["form_handling_day"]["ed"];        //取扱期間（終了日）
	$handling_day_ey = str_pad($handling_day_ey,4, 0, STR_PAD_LEFT);  
	$handling_day_em = str_pad($handling_day_em,2, 0, STR_PAD_LEFT); 
	$handling_day_ed = str_pad($handling_day_ed,2, 0, STR_PAD_LEFT); 
    if($handling_day_ey != NULL && $handling_day_em != NULL && $handling_day_ed != NULL){
        $hand_end   = $_POST["form_handling_day"]["ey"]."-".$_POST["form_handling_day"]["em"]."-".$_POST["form_handling_day"]["ed"];
    }

    $ware               = $_POST["form_ware"];                      //倉庫
    $goods_cd           = $_POST["form_goods_cd"];                  //商品コード
    $goods_cname        = $_POST["form_goods_cname"];                //商品名
    $reason             = $_POST["form_reason"];                    // 調整理由


    /****************************/
    //ルール作成
    /****************************/
    // エラーフラグ格納配列作成
    $ary_err_flg = array();

    //契約更新日
    if(!($handling_day_sm == null && $handling_day_sd == null && $handling_day_sy == null)){
        //取扱日（開始）
        if(!checkdate((int)$handling_day_sm, (int)$handling_day_sd, (int)$handling_day_sy)){
            $form->setElementError("form_handling_day","取扱期間の日付は妥当ではありません。");
            $ary_err_flg[] = true;
        }
    }
    if(!($handling_day_em == null && $handling_day_ed == null && $handling_day_ey == null)){
        //取扱日（終了）
        if(!checkdate((int)$handling_day_em, (int)$handling_day_ed, (int)$handling_day_ey)){
            $form->setElementError("form_handling_day","取扱期間の日付は妥当ではありません。");
            $ary_err_flg[] = true;
        }
    }

}

if($_POST["form_show_button"] == "表　示" && $form->validate() && !(in_array(true, $ary_err_flg))){

    $show_flg = true;

    //取扱期間（開始）
    $handling_sday = $handling_day_sy."-".$handling_day_sm."-".$handling_day_sd;

    //取扱期間（終了）
    $handling_eday = $handling_day_ey."-".$handling_day_em."-".$handling_day_ed;

    /****************************/
    //WHERE_SQL作成
    /****************************/
    //商品コードが指定された場合
    $where_sql  = ($goods_cd != null) ? " AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
    //商品名が指定された場合
    $where_sql .= ($goods_cname != null) ? " AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;
    //倉庫が指定された場合
    $where_sql .= ($ware != null) ? " AND t_ware.ware_id = $ware \n" : null;
    //取扱期間（開始）が指定された場合
    $where_sql .= ($handling_sday != "--") ? " AND '$handling_sday' <= t_stock_hand.work_day \n" : null;
    //取扱期間（終了）が指定された場合
    $where_sql .= ($handling_eday != "--") ? " AND t_stock_hand.work_day <= '$handling_eday' \n" : null;
    // 調整理由
    $where_sql .= ($reason != null) ? "AND t_stock_hand.adjust_reason = '$reason' \n" : null;

    /****************************/
    //SQL作成
    /****************************/
    $sql  = "SELECT\n";
    $sql .= "   t_ware.ware_name,\n";                       // 倉庫名
    $sql .= "   t_stock_hand.work_day,\n";                  // 調整日
    $sql .= "   t_goods.goods_name,\n";                    // 商品名（略称）
    $sql .= "   (t_stock_hand.num *\n";
    $sql .= "   CASE t_stock_hand.io_div\n";
    $sql .= "       WHEN '1' THEN 1\n";
    $sql .= "       WHEN '2' THEN -1\n";
    $sql .= "   END\n";
    $sql .= "   ) AS num,\n";                               // 超整数
    $sql .= "   (t_stock_hand.num * t_stock_hand.adjust_price *\n";
    $sql .= "   CASE t_stock_hand.io_div\n";
    $sql .= "       WHEN '1' THEN 1\n";
    $sql .= "       WHEN '2' THEN -1\n";
    $sql .= "   END\n";
    $sql .= "   ) AS price,\n";                             // 調整額
    $sql .= "   t_goods.goods_cd,\n";                       // 商品コード
    $sql .= "   t_stock_hand.adjust_reason ";               // 調整理由
    $sql .= " FROM\n";
    $sql .= "   t_stock_hand,\n";
    $sql .= "   t_goods,\n";
    $sql .= "   t_ware\n";
    $sql .= " WHERE\n";
    $sql .= "   t_stock_hand.work_div ='6'\n";                  // 作業区分＝移動
    $sql .= "   AND\n";
    $sql .= "   t_stock_hand.shop_id = $shop_id\n";             // ショップID
    $sql .= "   AND\n";
    $sql .= "   t_ware.ware_id = t_stock_hand.ware_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.goods_id = t_stock_hand.goods_id\n";
    $sql .=     $where_sql;
    $sql .= "   ORDER BY t_ware.ware_cd, t_stock_hand.work_day, t_goods.goods_cd\n";
    $sql .= ";\n";

    /****************************/
    //表示データ作成
    /****************************/
    $result     = Db_Query($db_con, $sql);
    $page_data  = Get_Data($result);
    $page_num   = pg_num_rows($result);

    $j              = 0;
    $row_color      = null;
    $data_color     = null;

    // データ件数分ループ
    for ($i=0; $i<$page_num; $i++){

        /******************************
        //  各調整の表示用データ作成
        ******************************/
        // No.を加算
        $j++;

        // 行色設定
        $row_color      = ($row_color != "Result1") ? "Result1" : "Result2";

        // 調整数の正負判断
        $data_color     = ($page_data[$i][3] >= 0) ? "plus" : "minus";

        // 調整理由を復元
        $adjust_reason  = null;
        $adjust_reason  = ($page_data[$i][6] == "1") ? "システム開始在庫" : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "2") ? "破損"             : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "3") ? "紛失"             : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "4") ? "発見"             : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "5") ? "在庫記入ミス"     : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "6") ? "メンブレン製造"   : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "7") ? "調整"             : $adjust_reason;

        // 表示用データ作成
        $row_data[] = array(
            $row_color,                         // 行色css
            $j,                                 // No.
            $page_data[$i][0],                  // 倉庫名
            $page_data[$i][1],                  // 調整日
            $page_data[$i][5],                  // 商品コード
            $page_data[$i][2],                  // 商品名
            $data_color,                        // 調整数、調整額の色
            number_format($page_data[$i][3]),   // 調整数
            number_format($page_data[$i][4]),   // 調整額
            $adjust_reason,                     // 調整理由
        );

        // 倉庫計表示用に、調整数を加算（正数）
        $ware_plus_num      = ($page_data[$i][3] >= 0) ? bcadd($ware_plus_num,    $page_data[$i][3]) : $ware_plus_num;
        // 倉庫計表示用に、調整数を加算（負数）
        $ware_minus_num     = ($page_data[$i][3] <  0) ? bcadd($ware_minus_num,   $page_data[$i][3]) : $ware_minus_num;
         // 倉庫計表示用に、調整額を加算（正数）
        $ware_plus_price    = ($page_data[$i][4] >= 0) ? bcadd($ware_plus_price,  $page_data[$i][4]) : $ware_plus_price;
        // 倉庫計表示用に、調整額を加算（負数）
        $ware_minus_price   = ($page_data[$i][4] <  0) ? bcadd($ware_minus_price, $page_data[$i][4]) : $ware_minus_price;

        /******************************
        //  倉庫計の表示用データ作成
        ******************************/
        // 倉庫が変わる場合
        if ($page_data[$i][0] != $page_data[$i+1][0]){

            // 表示用データ作成
            $row_data[] = array(
                "Result3",
                null,
                null,
                "<span align=\"center\"><b>倉庫計　入庫<br>　　　　出庫</b></span>",
                null,
                null,
                null,
                number_format($ware_plus_num)."<br><span style=\"color: #ff0000;\">".number_format($ware_minus_num)."</span>",
                number_format($ware_plus_price)."<br><span style=\"color: #ff0000;\">".number_format($ware_minus_price)."</span>",
                null,
            );

            // 総合計表示用に、調整数の倉庫計を加算（正数）
            $total_plus_num     = ($ware_plus_num >=   0) ? bcadd($total_plus_num,    $ware_plus_num)  : $total_plus_num;
            // 総合計表示用に、調整数の倉庫計を加算（負数）
            $total_minus_num    = ($ware_minus_num <   0) ? bcadd($total_minus_num,   $ware_minus_num) : $total_minus_num;

            // 総合計表示用に、調整額の倉庫計を加算（正数）
            $total_plus_price   = ($ware_plus_price >= 0) ? bcadd($total_plus_price,  $ware_plus_price)  : $total_plus_price;
            // 総合計表示用に、調整額の倉庫計を加算（負数）
            $total_minus_price  = ($ware_minus_price < 0) ? bcadd($total_minus_price, $ware_minus_price) : $total_minus_price;

            // 行色をリセットする
            $row_color          = null;

            // 倉庫計をリセットする
            $ware_plus_num      = 0;
            $ware_minus_num     = 0;
            $ware_plus_price    = 0;
            $ware_minus_price   = 0;

        }

    }

    /******************************
    //  総合計の表示用データ作成
    ******************************/
    // 調整数の総合計を取得（正数）
    $row_data[] = array(
        "Result4",
        null,
        "<span align=\"center\"><b>総合計　入庫<br>　　　　出庫</b></span>",
        null,
        null,
        null,
        null,
        number_format($total_plus_num)."<br><span style=\"color: #ff0000;\">".number_format($total_minus_num)."</span>",
        number_format($total_plus_price)."<br><span style=\"color: #ff0000;\">".number_format($total_minus_price)."</span>",
        null,
    );

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
$page_menu = Create_Menu_h('stock','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'       => "$html_header",
    'page_menu'         => "$page_menu",
    'page_header'       => "$page_header",
    'html_footer'       => "$html_footer",
    'html_page'         => "$html_page",
    'html_page2'        => "$html_page2",
    'match_count'       => "$page_num",
    'total_minus_num'   => "$total_minus_num",
    'total_plus_num'    => "$total_plus_num",
    'total_minus_price' => "$total_minus_price",
    'total_plus_price'  => "$total_plus_price",
    'hand_start'        => "$hand_start",
    'hand_end'          => "$hand_end",
    'show_flg'          => "$show_flg",
));

$smarty->assign("ware_total", $ware_total);
$smarty->assign("row_data", $row_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
