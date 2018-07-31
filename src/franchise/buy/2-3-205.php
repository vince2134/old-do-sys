<?php
/****************************/
//  変更履歴
//      テーブルに存在していないカラムを参照しているためエラーがでているので、修正
//    (2006-07-07 kaji)
//      shop_gidをなくす
/***************************/
/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/11　06-103　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-104　　　　watanabe-k　GETチェック追加
 * 　2006/11/11　06-105　　　　watanabe-k　GETチェック追加
 * 　2009/09/18　              aoyama-n    商品のソート順をlineに修正
 * 　2009/09/18　              aoyama-n    値引商品及び取引区分が値引・返品の場合は赤字で表示
 *
 */




$page_title = "仕入照会";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//外部変数取得
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];
//$shop_gid     = $_SESSION[shop_gid];
$buy_id       = $_GET["buy_id"];             //仕入ID
$group_kind   = $_SESSION[group_kind];
Get_Id_Check3($buy_id);
Get_Id_Check2($buy_id);
$input_flg    = $_GET["input_flg"];          //遷移元識別フラグ


/****************************/
//部品定義
/****************************/
//入荷日
$text="";
$text[] =& $form->createElement("static","y","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","-");
$form->addGroup( $text,"form_arrival_day","form_arrival_day");

//仕入日
$text="";
$text[] =& $form->createElement("static","y","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","-");
$form->addGroup( $text,"form_buy_day","form_buy_day");

//発注番号
$form->addElement("static","form_ord_no","","");
//伝票番号
$form->addElement("static","form_buy_no","","");

//仕入先名
$form_client[] =& $form->createElement("static","cd1","","");
$form_client[] =& $form->createElement("static","",""," ");
$form_client[] =& $form->createElement("static","name","","");
$form->addGroup( $form_client, "form_client", "");

//直送先名
$form->addElement("static","form_direct_name","","");
//仕入倉庫
$form->addElement("static","form_ware_name","","");
//取引区分
$form->addElement("static","form_trade_buy","","");
//担当者
$form->addElement("static","form_oc_staff_name","","");
//担当者
$form->addElement("static","form_c_staff_name","","");
//備考
$form->addElement("static","form_note","","");

//遷移元チェック
if($input_flg == true){
    //仕入入力（オフライン）画面
    //OKボタン
    $form->addElement("button", "ok_button", "Ｏ　Ｋ", "onClick=\"location.href='".Make_Rtn_Page("buy")."'\"");
    if ($_GET[change_ord_flg] != true && $_GET["inst_err"] != true){
        //戻る
        $form->addElement("button","return_button","戻　る","onClick=\"location.href='2-3-201.php?buy_id=$buy_id'\"");
    }
    $freeze_flg = true;    //仕入完了メッセージ表示フラグ
}else{
    //発注照会画面
    //戻る
    $form->addElement("button","return_button","戻　る","onClick=\"javascript:history.back()\"");
}

//売上金額合計
$form->addElement(
    "text","form_buy_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//消費税額(合計)
$form->addElement(
        "text","form_buy_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//売上金額（税込合計)
$form->addElement(
        "text","form_buy_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);
/****************************/
//仕入ヘッダー抽出判定処理
/****************************/
if($_GET[del_buy_flg] != true && $_GET[del_ord_flg] != true && $_GET[change_ord_flg] != true && $_GET["inst_err"] != true && $_GET[ps_stat] != true){
    $sql  = "SELECT ";
    $sql .= "    renew_flg, ";
    $sql .= "    intro_sale_id, ";
    $sql .= "    act_sale_id ";
    $sql .= "FROM ";
    $sql .= "    t_buy_h ";
    $sql .= "WHERE ";
    $sql .= "    t_buy_h.shop_id = $shop_id";
    $sql .= "    AND";
    $sql .= "    t_buy_h.buy_id = $buy_id;";
    $result = Db_Query($db_con,$sql);
    //GETデータ判定
    Get_Id_Check($result);

    //日次更新フラグ取得
    $renew_flg      = pg_fetch_result($result,0,0);
    $intro_sale_id  = pg_fetch_result($result,0,1);
    $act_id         = pg_fetch_result($result,0,2);


    //日次更新フラグが’ｔ’で登録フラグがtrueの場合トップへ遷移
    if($intro_sale_id != null || $act_id != null){
    }elseif($renew_flg == 't' && $input_flg == 'true'){
        header("Location:../top.php");
        exit;
    }elseif($renew_flg == 'f' && $input_flg != 'true'){
        header("Location:../top.php");
        exit;
    }

}

//日次更新フラグがtrueか
if($renew_flg == 't'){
    /****************************/
    //仕入ヘッダ抽出SQL（日次更新後）
    /****************************/
    $sql  = "SELECT ";                                 
    $sql .= "    t_buy_h.buy_no,";      
    $sql .= "    t_order_h.ord_no,"; 
    $sql .= "    t_buy_h.buy_day,";
    $sql .= "    t_buy_h.arrival_day,";

    if($group_kind == '2'){
        $sql .= "   CASE";
        $sql .= "       WHEN t_buy_h.client_cd2 IS NOT NULL THEN t_buy_h.client_cd1||'-'||t_buy_h.client_cd2";
        $sql .= "       ELSE t_buy_h.client_cd1";
        $sql .= "   END AS client_cd1,";
    }else{
        $sql .= "    t_buy_h.client_cd1,";
    }
    $sql .= "    t_buy_h.client_cname,";
    $sql .= "    t_buy_h.direct_name,";
    $sql .= "    t_buy_h.ware_name,";
    $sql .= "    t_trade.trade_name,";            
    $sql .= "    t_buy_h.c_staff_name,";
    $sql .= "    t_buy_h.note, ";
    $sql .= "    t_buy_h.net_amount, ";
    $sql .= "    t_buy_h.tax_amount, ";
    $sql .= "   t_buy_h.client_id ";
    $sql .= "FROM ";
    $sql .= "    t_buy_h ";

    $sql .= "       LEFT JOIN ";
    $sql .= "    t_order_h ";
    $sql .= "    ON t_buy_h.ord_id = t_order_h.ord_id ";
    $sql .= "       INNER JOIN";
    $sql .= "    t_trade";
    $sql .= "    ON t_buy_h.trade_id = t_trade.trade_id ";

    $sql .= "WHERE ";
    $sql .= "    t_buy_h.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "    t_buy_h.buy_id = $buy_id;";
}else{
    /****************************/
    //仕入ヘッダー抽出SQL
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    t_buy_h.buy_no,";
    $sql .= "    t_order_h.ord_no,";
    $sql .= "    t_buy_h.buy_day,";
    $sql .= "    t_buy_h.arrival_day,";
//    $sql .= "    t_client.client_cd1,";
//    $sql .= "    t_client.client_name,";
//    $sql .= "    t_direct.direct_name,";
//    $sql .= "    t_ware.ware_name,";
//    $sql .= "    t_buy_h.client_cd1,";
    if($group_kind == '2'){
        $sql .= "   CASE";
        $sql .= "       WHEN t_buy_h.client_cd2 IS NOT NULL THEN t_buy_h.client_cd1||'-'||t_buy_h.client_cd2";
        $sql .= "       ELSE t_buy_h.client_cd1";
        $sql .= "   END AS client_cd1,";
    }else{
        $sql .= "    t_buy_h.client_cd1,";
    }
    $sql .= "    t_buy_h.client_cname,";
    $sql .= "    t_buy_h.direct_name,";
    $sql .= "    t_buy_h.ware_name,";
    $sql .= "    t_trade.trade_name,"; 
//    $sql .= "    t_staff.staff_name,";
    $sql .= "    t_buy_h.c_staff_name,";
    $sql .= "    t_buy_h.note, ";
    $sql .= "    t_buy_h.net_amount, ";
    $sql .= "    t_buy_h.tax_amount, ";
    $sql .= "    t_buy_h.trade_id, ";
    $sql .= "   t_buy_h.client_id ";
    $sql .= "FROM ";
    $sql .= "    t_buy_h ";

	$sql .= "       INNER JOIN";
    $sql .= "    t_trade";
    $sql .= "    ON t_buy_h.trade_id = t_trade.trade_id ";

    $sql .= "       LEFT JOIN ";
    $sql .= "    t_direct ";
    $sql .= "    ON t_buy_h.direct_id  = t_direct.direct_id ";

    $sql .= "       LEFT JOIN ";
    $sql .= "    t_order_h ";
    $sql .= "    ON t_buy_h.ord_id = t_order_h.ord_id ";

    $sql .= "       INNER JOIN";
    $sql .= "    t_client ON t_buy_h.client_id  = t_client.client_id ";
/*
    $sql .= "    LEFT JOIN t_ware   ON t_buy_h.ware_id    = t_ware.ware_id ";
    $sql .= "    INNER JOIN t_staff  ON t_buy_h.c_staff_id = t_staff.staff_id ";
    $sql .= "    INNER JOIN t_trade  ON t_buy_h.trade_id   = t_trade.trade_id ";
  */
	  $sql .= "WHERE ";
    $sql .= "    t_buy_h.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "    t_buy_h.buy_id = $buy_id;";
}

$result = Db_Query($db_con,$sql);
$h_data_list = Get_Data($result);

$sql  = "SELECT ";
//$sql .= "    t_staff.staff_name ";
$sql .= "    t_buy_h.oc_staff_name ";
$sql .= "FROM ";
$sql .= "    t_buy_h ";
$sql .= "    INNER JOIN t_staff ON t_buy_h.oc_staff_id = t_staff.staff_id ";
$sql .= "WHERE ";
$sql .= "    t_buy_h.shop_id = $shop_id ";
$sql .= "AND ";
$sql .= "    t_buy_h.buy_id = $buy_id;";
$result = Db_Query($db_con,$sql);   
$oc_staff = Get_Data($result);

/****************************/
//仕入データ抽出SQL（日次更新後）
/****************************/
$data_sql  = "SELECT ";
//日次更新フラグがtrueか
if($renew_flg == 't'){
    $data_sql .= "    t_buy_d.goods_cd,";
}else{
//    $data_sql .= "    t_goods.goods_cd,";
    $data_sql .= "    t_buy_d.goods_cd,";
}
$data_sql .= "    t_buy_d.goods_name,";
$data_sql .= "    t_buy_d.num,"; 
$data_sql .= "    t_buy_d.buy_price,";
//aoyama-n 2009-09-18
#$data_sql .= "    t_buy_d.buy_amount ";
$data_sql .= "    t_buy_d.buy_amount, ";
$data_sql .= "    t_goods.discount_flg ";
$data_sql .= "FROM ";
$data_sql .= "    t_buy_d ";
$data_sql .= "    INNER JOIN t_buy_h ON t_buy_d.buy_id = t_buy_h.buy_id ";
//日次更新フラグがtrueか
//aoyama-n 2009-09-18
#if($renew_flg != 't'){
#    $data_sql .= "    INNER JOIN t_goods ON t_buy_d.goods_id = t_goods.goods_id ";
#}
$data_sql .= "    INNER JOIN t_goods ON t_buy_d.goods_id = t_goods.goods_id ";
$data_sql .= "WHERE ";
$data_sql .= "    t_buy_d.buy_id = $buy_id ";
$data_sql .= "AND ";
$data_sql .= "    t_buy_h.shop_id = $shop_id ";
$data_sql .= "ORDER BY ";
//日次更新フラグがtrueか
if($renew_flg == 't'){
    //aoyama-n 2009-09-18
    #$data_sql .= "    t_buy_d.goods_cd;";
    $data_sql .= "    t_buy_d.line;";
}else{
//    $data_sql .= "    t_goods.goods_cd;";
    //aoyama-n 2009-09-18
    #$data_sql .= "    t_buy_d.goods_cd;";
    $data_sql .= "    t_buy_d.line;";
}

$result = Db_Query($db_con,$data_sql);

/****************************/
//仕入データー表示
/****************************/
//行データ部品を作成
$row_data = Get_Data($result);
for($i=0;$i<count($row_data);$i++){
    for($j=0;$j<count($row_data[$i]);$j++){
        if($j==2 || $j==4){
            $row_data[$i][$j] = number_format($row_data[$i][$j]);
        }else if($j==3){
            $row_data[$i][$j] = number_format($row_data[$i][$j],2);
        }
    }
}

/****************************/
//仕入ヘッダー表示
/****************************/
$def_fdata["form_buy_no"]                       =   $h_data_list[0][0];                        //伝票番号
$def_fdata["form_ord_no"]                       =   $h_data_list[0][1];                        //発注番号

//日付生成
$form_buy_day                                   =   explode('-',$h_data_list[0][2]);
$form_arrival_day                               =   explode('-',$h_data_list[0][3]);

$def_fdata["form_buy_day"]["y"]                 =   $form_buy_day[0];                          //仕入日(年)
$def_fdata["form_buy_day"]["m"]                 =   $form_buy_day[1];                          //仕入日(月)
$def_fdata["form_buy_day"]["d"]                 =   $form_buy_day[2];                          //仕入日(日)

$def_fdata["form_arrival_day"]["y"]             =   $form_arrival_day[0];                      //入荷日(年)
$def_fdata["form_arrival_day"]["m"]             =   $form_arrival_day[1];                      //入荷日(月)
$def_fdata["form_arrival_day"]["d"]             =   $form_arrival_day[2];                      //入荷日(日)

$def_fdata["form_client"]["cd1"]                =   $h_data_list[0][4];                        //仕入先    
//$def_fdata["form_client"]["cd2"]                =   $h_data_list[0][5];                          
$def_fdata["form_client"]["name"]               =   $h_data_list[0][5];                          

$def_fdata["form_direct_name"]                  =   $h_data_list[0][6];                        //直送先
$def_fdata["form_ware_name"]                    =   $h_data_list[0][7];                        //倉庫
$def_fdata["form_trade_buy"]                    =   $h_data_list[0][8];                        //取引区分
$def_fdata["form_c_staff_name"]                 =   $h_data_list[0][9];                       //担当者
$def_fdata["form_note"]                         =   $h_data_list[0][10];

$def_fdata["form_buy_total"]                    =   number_format($h_data_list[0][11]);        //税抜金額
$def_fdata["form_buy_tax"]                      =   number_format($h_data_list[0][12]);        //消費税
$total_money                                    =   $h_data_list[0][11] + $h_data_list[0][12]; //税込金額
$def_fdata["form_buy_money"]                    =   number_format($total_money);                         
$def_fdata["form_oc_staff_name"]                =   $oc_staff[0][0];                           //発注担当者

$client_id                                      =   $h_data_list[0][13];                        // 仕入先ID

$form->setDefaults($def_fdata);


//取引区分が割賦の場合、割賦入力ボタン作成
if($h_data_list[0][13] == '25' && $input_flg == "true"){
    $form->addElement("button", "form_split_button", "割賦仕入", "onClick=\"location.href='2-3-206.php?buy_id=".$buy_id."'\" $disabled");
}


/****************************/
// 仕入先の状態取得
/****************************/
if ($_POST == null && $_GET["input_flg"] == "true"){
}else{
    $client_state_print = Get_Client_State($db_con, $client_id);
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
$page_menu = Create_Menu_f('buy','2');

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
    'input_flg'     => "$input_flg",
    'freeze_flg'    => "$freeze_flg",
    "client_state_print"    => "$client_state_print",
));
$smarty->assign('row',$row_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
