<?php
/************************************/
//変更履歴
//  日時更新後の売上データ抽出SQLを変更（2006/06/16　watanabe-k）
//
//（2006/09/15　kaji）
//  ・回収日を今回締日以降の回収日に
//  ・分割回数は2回以上に
//（2006/10/26 kaji）
//  ・回収日は売上入力で入力された売上計上日を基準に
//
//（2006/11/27 koji）
//  ・基準になる日に+集金日とするように修正
/************************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/10/30      08-058      ふ          確認/完了画面にOKボタンを設置
 *  2006/11/07      08-117      suzuki      ヘッダ情報取得SQLの結合条件変更
 *  2006/11/07      08-094      suzuki      売上IDの存在判定を行う
 *                  08-087
 *                  08-016
 *                  08-017
 *  2006/11/07      08-095      suzuki      売上IDの数値判定を行う
 *                  08-088
 *  2006/11/07      08-096      suzuki      割賦売上以外の伝票はTOPに遷移するように変更
 *                  08-089
 *  2006/11/07      08-119      suzuki      売上照会から遷移した際に、division_flgを変更したらTOPに遷移するように修正
 *  2006/11/13      080155      ふ          割賦設定中に仕入伝票が変更された場合の対処
 *  2006/12/14      kaji-198    kaji        割賦登録直前に元の売上が削除された、または日次更新された場合の処理追加
 *  2007/01/16      仕様変更    watanabe-k  分割回数を２〜６０までに変更
 *  2009/10/13                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *   2016/01/20                amano  Button_Submit 関数でボタン名が送られない IE11 バグ対応
 *
 */
//$page_title = "売上照会";
$page_title = "割賦売上入力";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
//外部変数取得
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];

$sale_id      = $_GET["sale_id"];             //受注ID
Get_Id_Check2($sale_id);
Get_Id_Check3($sale_id);
$division_flg   = $_GET["division_flg"];       // 分割設定済フラグ

$slip_bill_flg  = $_POST["slip_bill_flg"];     //売上入力遷移判定フラグ
$slip_data["slip_bill_flg"] = $slip_bill_flg;
$form->setConstants($slip_data);   
if($division_flg == NULL && $slip_bill_flg == NULL){
	Header("Location: ../top.php");  
}

// 伝票変更日時をセットデフォルト
$sql = "SELECT change_day FROM t_sale_h WHERE sale_id = $sale_id ;";
$res = Db_Query($db_con, $sql);
Get_Id_Check($res);
$set_change_date["hdn_change_date"] = pg_fetch_result($res, 0, 0);
$form->setDefaults($set_change_date);


/****************************/
//契約関数定義
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");
//整合性判定関数
Injustice_check($db_con,"sale_cup",$sale_id,$shop_id);

/****************************/
//部品定義
/****************************/
//売上計上日
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_sale_day","form_sale_day");

//請求日
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_claim_day","form_claim_day");

//伝票番号
$form->addElement("static","form_sale_no","","");
//受注番号
$form->addElement("static","form_ord_no","","");

//得意先名
$form_client[] =& $form->createElement("static","cd1","","");
$form_client[] =& $form->createElement("static","","","-");
$form_client[] =& $form->createElement("static","cd2","","");
$form_client[] =& $form->createElement("static","",""," ");
$form_client[] =& $form->createElement("static","name","","");
$form->addGroup( $form_client, "form_client", "");

//グリーン指定
$form->addElement("static","form_trans_check","","");
//運送業者名
$form->addElement("static","form_trans_name","","");
//直送先名
$form->addElement("static","form_direct_name","","");
//出荷倉庫
$form->addElement("static","form_ware_name","","");
//取引区分
$form->addElement("static","form_trade_sale","","");
//受注担当者
$form->addElement("static","form_staff_name","","");
//売上担当者
$form->addElement("static","form_cstaff_name","","");
//備考
//備考
$form->addElement("static","form_note","","");

//伝票発行
$form->addElement("submit","add_button","分割請求登録","$disabled");

//遷移元チェック
//売上入力画面
//OK
$form->addElement("button", "ok_button", "Ｏ　Ｋ",
    "onClick=javascript:location.href='".Make_Rtn_Page("sale")."'"
);
//戻る
$form->addElement("button","return_button","戻　る","onClick=\"javascript:history.back();\"");

//売上金額合計
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//消費税額(合計)
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//売上金額（税込合計)
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"8\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//分割回数
$select_value[null] = null;
/*
$select_value[2]    = "2回";
$select_value[3]    = "3回";
$select_value[6]    = "6回";
$select_value[12]   = "12回";
$select_value[24]   = "24回";
$select_value[36]   = "36回";
$select_value[48]   = "48回";
$select_value[60]   = "60回";
*/

for($i = 2; $i <= 60; $i++){
    $select_value[$i] = $i."回";
}
$form->addElement(
        "select","form_division_num", "", $select_value, "$g_form_option_select");
// hidden       
$form->addElement("hidden", "hdn_division_submit", "");
$form->addElement("hidden", "hdn_pay_m", "");
$form->addElement("hidden", "hdn_pay_d", "");
$form->addElement("hidden", "hdn_division_num", "");
$form->addElement("hidden","slip_bill_flg");    //売上入力遷移フラグ 
$form->addElement("hidden", "hdn_change_date");
$form->addElement("hidden", "hdn_mst_pay_m");

//請求日
//月
$select_month[null] = null; 
//for($i = 1; $i <= 12; $i++){

for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[0] = "当月"; 
    }elseif($i == 1){

//    if($i == 1){
        $select_month[1] = "翌月"; 
    }else{  
        $select_month[$i] = $i."ヶ月後";
    }
}
$form->addElement("select", "form_pay_m", "セレクトボックス", $select_month, $g_form_option_select);

//日
for($i = 0; $i <= 29; $i++){
    if($i == 29){ 
        $select_day[$i] = '月末'; 
    }elseif($i == 0){
        $select_day[null] = null; 
    }else{  
        $select_day[$i] = $i."日";
    }
}
$freeze_pay_d = $form->addElement("select", "form_pay_d", "セレクトボックス", $select_day, $g_form_option_select);
$freeze_pay_d->freeze();

//分割設定ボタン
$form->addElement(
        "button", "form_conf_button", "分割設定",
        "onClick=\"Button_Submit('hdn_division_submit','#', 't', this);\" $disabled"
);

/****************************/
//売上ヘッダー抽出判定処理
/****************************/
$sql  = "SELECT ";
$sql .= "    aord_id,";
$sql .= "    renew_flg ";
$sql .= "FROM ";
$sql .= "    t_sale_h ";
$sql .= "WHERE ";
$sql .= "    t_sale_h.sale_id = $sale_id ";
$sql .= "    AND ";
$sql .= "    shop_id = $shop_id;";
$result = Db_Query($db_con,$sql);
//GETデータ判定
Get_Id_Check($result);
$stat = Get_Data($result);
$aord_id   = $stat[0][0];            //受注ID
$renew_flg = $stat[0][1];            //日次更新フラグ
$division_flg = ($renew_flg == "t") ? "true" : $division_flg;

//分割設定ボタン押下時に日次更新されていた場合エラー
if($renew_flg == "t" && isset($_POST["add_button"])){
    $renew_msg = "日次更新されているため、割賦売上入力できません。";
}

//日次更新フラグがtrueか
if($renew_flg == 't'){
    /****************************/
    //売上ヘッダ抽出SQL（日次更新後）
    /****************************/
    $sql  = "SELECT ";                             
    $sql .= "    t_sale_h.sale_no,";
    $sql .= "    t_aorder_h.ord_no,";
    $sql .= "    t_sale_h.sale_day,";
    $sql .= "    t_sale_h.claim_day,";
    $sql .= "    t_sale_h.client_cd1,";
    $sql .= "    t_sale_h.client_cd2,";
    $sql .= "    t_sale_h.client_cname,";
    $sql .= "    t_sale_h.green_flg,";
    $sql .= "    t_sale_h.trans_name,";
    $sql .= "    t_sale_h.direct_name,";
    $sql .= "    t_sale_h.ware_name,";
    $sql .= "    CASE t_sale_h.trade_id";            
    $sql .= "        WHEN '11' THEN '掛売上'";
    $sql .= "        WHEN '13' THEN '掛返品'";
    $sql .= "        WHEN '14' THEN '掛値引'";
    $sql .= "        WHEN '15' THEN '割賦売上'";
    $sql .= "        WHEN '61' THEN '現金売上'";
    $sql .= "        WHEN '63' THEN '現金返品'";
    $sql .= "        WHEN '64' THEN '現金値引'";
    $sql .= "    END,";
    $sql .= "    t_sale_h.c_staff_name,";
    $sql .= "    t_sale_h.note, ";
    $sql .= "    t_sale_h.net_amount, ";
    $sql .= "    t_sale_h.tax_amount, ";
    $sql .= "    t_sale_h.ac_staff_name,";
    $sql .= "    t_sale_h.ware_id, ";
    $sql .= "    t_sale_h.client_id ";
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";

    $sql .= "    LEFT JOIN ";
    $sql .= "    t_aorder_h ";
    $sql .= "    ON t_sale_h.aord_id = t_aorder_h.aord_id ";

    $sql .= "WHERE ";
    $sql .= "    t_sale_h.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "    t_sale_h.sale_id = $sale_id;";
}else{
    /****************************/
    //売上ヘッダー抽出SQL
    /****************************/
    $sql  = "SELECT \n";
    $sql .= "    t_sale_h.sale_no,\n";
    $sql .= "    t_aorder_h.ord_no,\n";
    $sql .= "    t_sale_h.sale_day,\n";
    $sql .= "    t_sale_h.claim_day,\n";
//    $sql .= "    t_client.client_cd1,\n";
//    $sql .= "    t_client.client_cd2,\n";
//    $sql .= "    t_client.client_name,\n";
    $sql .= "    t_sale_h.client_cd1,\n";
    $sql .= "    t_sale_h.client_cd2,\n";
    $sql .= "    t_sale_h.client_cname,\n";
    $sql .= "    t_sale_h.green_flg,\n";
//    $sql .= "    t_trans.trans_cname,\n";
//    $sql .= "    t_direct.direct_cname,\n";
//    $sql .= "    t_ware.ware_name,\n";
    $sql .= "    t_sale_h.trans_cname,\n";
    $sql .= "    t_sale_h.direct_cname,\n";
    $sql .= "    t_sale_h.ware_name,\n";
    $sql .= "    CASE t_sale_h.trade_id\n";
    $sql .= "        WHEN '11' THEN '掛売上'\n";
    $sql .= "        WHEN '13' THEN '掛返品'\n";
    $sql .= "        WHEN '14' THEN '掛値引'\n";
    $sql .= "        WHEN '15' THEN '割賦売上'\n";
    $sql .= "        WHEN '61' THEN '現金売上'\n";
    $sql .= "        WHEN '63' THEN '現金返品'\n";
    $sql .= "        WHEN '64' THEN '現金値引'\n";
    $sql .= "    END,\n";
    $sql .= "    c_staff.staff_name,\n";
    $sql .= "    t_sale_h.note, \n";
    $sql .= "    t_sale_h.net_amount, \n";
    $sql .= "    t_sale_h.tax_amount, \n";
//    $sql .= "    ac_staff.staff_name, \n";
    $sql .= "    t_sale_h.ac_staff_name, \n";
    $sql .= "    t_sale_h.ware_id, \n";
    $sql .= "    t_sale_h.client_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_sale_h \n";

    $sql .= "    LEFT JOIN \n";
    $sql .= "    t_trans \n";
    $sql .= "    ON t_sale_h.trans_id  = t_trans.trans_id \n";

    $sql .= "    LEFT JOIN \n";
    $sql .= "    t_direct \n";
    $sql .= "    ON t_sale_h.direct_id  = t_direct.direct_id \n";

    $sql .= "    LEFT JOIN \n";
    $sql .= "    t_aorder_h \n";
    $sql .= "    ON t_sale_h.aord_id = t_aorder_h.aord_id \n";

    $sql .= "    INNER JOIN t_client ON t_sale_h.client_id  = t_client.client_id \n";
    $sql .= "    INNER JOIN t_ware   ON t_sale_h.ware_id    = t_ware.ware_id \n";
    $sql .= "    INNER JOIN t_staff AS c_staff  ON t_sale_h.c_staff_id = c_staff.staff_id \n";
    $sql .= "    LEFT JOIN t_staff AS ac_staff  ON t_sale_h.ac_staff_id = ac_staff.staff_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_sale_h.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "    t_sale_h.sale_id = $sale_id;\n";
}

$result = Db_Query($db_con,$sql);
$h_data_list = Get_Data($result);

/****************************/
//売上データ抽出SQL
/****************************/
$data_sql  = "SELECT ";
//日次更新フラグがtrueか
if($renew_flg == 't'){
    $data_sql .= "    t_sale_d.goods_cd,";
}else{
//    $data_sql .= "    t_goods.goods_cd,";
    $data_sql .= "    t_sale_d.goods_cd,";
}
$data_sql .= "    t_sale_d.goods_name,";
$data_sql .= "    t_sale_d.num,"; 
$data_sql .= "    t_sale_d.cost_price,";
$data_sql .= "    t_sale_d.sale_price,";
$data_sql .= "    t_sale_d.cost_amount, ";
$data_sql .= "    t_sale_d.sale_amount, ";

//受注IDがある場合は、受注数を表示
if($aord_id != NULL){
    $data_sql .= "    t_aorder_d.num, ";
}
#2009-10-13 hashimoto-y
#$data_sql .= "    CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num ";
$data_sql .= "    CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num ";

$data_sql .= "FROM ";
$data_sql .= "    t_sale_d ";
$data_sql .= "    INNER JOIN t_sale_h ON t_sale_d.sale_id = t_sale_h.sale_id ";

//受注IDがある場合は、受注データテーブルと結合
if($aord_id != NULL){
    $data_sql .= "    INNER JOIN t_aorder_d ON t_sale_d.aord_d_id = t_aorder_d.aord_d_id ";
}

//日次更新フラグがtrueか
$data_sql .= "    INNER JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id ";
$data_sql .= "   LEFT JOIN ";
$data_sql .= "   (SELECT";
$data_sql .= "       goods_id,";
$data_sql .= "       SUM(stock_num)AS stock_num";
$data_sql .= "   FROM";
$data_sql .= "       t_stock";
$data_sql .= "   WHERE";
$data_sql .= "       shop_id = $shop_id";
$data_sql .= "       AND";
$data_sql .= "       ware_id = ".$h_data_list[0][17];
$data_sql .= "       GROUP BY t_stock.goods_id";
$data_sql .= "   )AS t_stock";
$data_sql .= "   ON t_sale_d.goods_id = t_stock.goods_id ";
#2009-10-13 hashimoto-y
$data_sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id ";

$data_sql .= "WHERE ";
$data_sql .= "    t_sale_d.sale_id = $sale_id ";
$data_sql .= "AND ";
$data_sql .= "    t_sale_h.shop_id = $shop_id ";
#2009-10-13 hashimoto-y
$data_sql .= "AND ";
$data_sql .= "    t_goods_info.shop_id = $shop_id ";

$data_sql .= "ORDER BY ";
//日次更新フラグがtrueか
if($renew_flg == 't'){
    $data_sql .= "    t_sale_d.goods_cd;";
}else{
//    $data_sql .= "    t_goods.goods_cd;";
    $data_sql .= "    t_sale_d.goods_cd;";
}

$result = Db_Query($db_con,$data_sql);

/****************************/
//売上ヘッダー表示
/****************************/
$def_fdata["form_sale_no"]                      =   $h_data_list[0][0];                          //伝票番号
$def_fdata["form_ord_no"]                       =   $h_data_list[0][1];                          //受注番号

//日付生成
$form_sale_day                                  =   explode('-',$h_data_list[0][2]);
$form_claim_day                                 =   explode('-',$h_data_list[0][3]);

$def_fdata["form_sale_day"]["y"]                =   $form_sale_day[0];                           //売上日(年)
$def_fdata["form_sale_day"]["m"]                =   $form_sale_day[1];                           //売上日(月)
$def_fdata["form_sale_day"]["d"]                =   $form_sale_day[2];                           //売上日(日)

$def_fdata["form_claim_day"]["y"]               =   $form_claim_day[0];                          //請求日(年)
$def_fdata["form_claim_day"]["m"]               =   $form_claim_day[1];                          //請求日(月)
$def_fdata["form_claim_day"]["d"]               =   $form_claim_day[2];                          //請求日(日)

$def_fdata["form_client"]["cd1"]                =   $h_data_list[0][4];                          //得意先cd1
$def_fdata["form_client"]["cd2"]                =   $h_data_list[0][5];                          //得意先cd2
$def_fdata["form_client"]["name"]               =   $h_data_list[0][6];                          //得意先名

//グリーン指定判定
if($h_data_list[0][7] == 't'){
    $def_fdata["form_trans_check"]              = "グリーン指定あり　";
}
$def_fdata["form_trans_name"]                   =   $h_data_list[0][8];                         //運送業者
$def_fdata["form_direct_name"]                  =   $h_data_list[0][9];                         //直送先
$def_fdata["form_ware_name"]                    =   $h_data_list[0][10];                         //倉庫
$def_fdata["form_trade_sale"]                   =   $h_data_list[0][11];                         //取引区分
$def_fdata["form_cstaff_name"]                  =   $h_data_list[0][12];                         //売上担当者
$def_fdata["form_note"]                         =   $h_data_list[0][13];

$def_fdata["form_sale_total"]                   =   number_format($h_data_list[0][14]);          //税抜金額
$def_fdata["form_sale_tax"]                     =   number_format($h_data_list[0][15]);          //消費税
$total_money                                    =   $h_data_list[0][14] + $h_data_list[0][15];   //税込金額

$def_fdata["form_sale_money"]                   =   number_format($total_money);                         
$def_fdata["form_split_bill_amount"][0]         =   number_format($total_money);

$def_fdata["form_staff_name"]                   =   $h_data_list[0][16];                         //受注担当者                         

//回収日（毎月）
$sql = "SELECT pay_m, pay_d FROM t_client WHERE client_id = ".$h_data_list[0][18].";";
$result = Db_Query($db_con,$sql);
$pay_m = (int)pg_fetch_result($result, 0, "pay_m");
$pay_d = (int)pg_fetch_result($result, 0, "pay_d");
$form->setConstants(array("form_pay_d"=>$pay_d));
$form->setConstants(array("hdn_mst_pay_m"=>$pay_m));

$form->setDefaults($def_fdata);

//分割回数をセット
$division_num = 1;
/*
$yy = date('Y');
$mm = date('m');
*/
//入力された請求日を基準にする
$yy = (int)$form_claim_day[0];
$mm = (int)$form_claim_day[1];

if($_POST["hdn_division_select"] == 't'){

    if($_POST["form_division_num"] != Null 
    && $_POST["form_pay_m"] != null
    && $_POST["form_pay_d"] != null){

        $division_num = $_POST["form_division_num"];        //分割回数

        $total_money = $_POST["form_sale_money"];        //税込金額
        $total_money = str_replace(",","",$total_money);

        $pay_m = $_POST["form_pay_m"];                  //請求日（月）
        $pay_d = $_POST["form_pay_d"];                  //請求日（日）
    }

    $set_data[hdn_division_select] == 't';

}

/****************************/
// 分割設定確認のみの場合
/****************************/
if ($division_flg == "true"){
    // 該当仕入IDの分割データを取得
    $sql = "SELECT collect_day, collect_amount FROM t_installment_sales WHERE sale_id = $sale_id ORDER BY collect_day;";
    $res = Db_Query($db_con, $sql);

    $i = 0;
     while ($ary_res = @pg_fetch_array($res, $i)){
        $ary_division_data[$i]["pay_day"] = $ary_res["collect_day"];
        $ary_division_data[$i]["split_pay_amount"] = $ary_res["collect_amount"];
        $i++;
    }

    for ($i=0; $i<count($ary_division_data); $i++){
        $form->addElement("static", "form_pay_date[$i]", "");
        $form->addElement("static", "form_pay_amount[$i]", "");
        $division_data["form_pay_date[$i]"]     = $ary_division_data[$i]["pay_day"];
        $division_data["form_pay_amount[$i]"]   = number_format($ary_division_data[$i]["split_pay_amount"]);
        $form->setConstants($division_data);
    }

/****************************/
// 分割設定を行う・未設定の場合
/****************************/
}else{
    /****************************/
    // 分割設定ボタン押下時　前処理
    /****************************/
    if ($_POST["hdn_division_submit"] == "t"){

        /*** 分割設定エラーチェック ***/
        // エラーフラグ格納先作成
        $ary_division_err_flg = array();

        // 回収日
        if ($_POST["form_pay_m"] == null || $_POST["form_pay_d"] == null){
        //if ($_POST["form_pay_m"] == null){
            $ary_division_err_flg[] = true;
            $ary_division_err_msg[] = "回収日は必須です。";
        }

        // 分割回数
        if ($_POST["form_division_num"] == null){
            $ary_division_err_flg[] = true;
            $ary_division_err_msg[] = "分割回数は必須です。";
        }

        // エラーチェック結果集計
        $division_err_flg = (in_array(true, $ary_division_err_flg)) ? true : false;

        // 分割設定フラグ格納
        $division_set_flg = ($division_err_flg === false) ? true : false;

        // 分割設定内容をhiddenにSET
        if ($division_set_flg == true){
            $hdn_set["hdn_pay_m"]           = $_POST["form_pay_m"];
            $hdn_set["hdn_pay_d"]           = $_POST["form_pay_d"];
            $hdn_set["hdn_division_num"]    = $_POST["form_division_num"];
            $form->setConstants($hdn_set);
        }

        // hiddenにSETされた分割設定ボタン押下情報を削除
        $hdn_del["hdn_division_submit"] = "";
        $form->setConstants($hdn_del);

    }

    /****************************/
    // 分割回収登録ボタン押下時　前処理
    /****************************/
    if (isset($_POST["add_button"])){

        // （分割回収登録ボタンが表示されている＝分割設定内容に問題なしなので）分割設定フラグONを格納
        $division_set_flg = true;

        // （分割設定ボタン押下時に）hiddenにSETした分割設定内容を変数へ代入
        $hdn_pay_m           = $_POST["hdn_pay_m"];
        $hdn_pay_d           = $_POST["hdn_pay_d"];
        $hdn_division_num    = $_POST["hdn_division_num"];

        // さらにフォームへSET（表示用）
        $division_set["form_pay_m"]         = $_POST["hdn_pay_m"];
        $division_set["form_pay_d"]         = $_POST["hdn_pay_d"];
        $division_set["form_division_num"]  = $_POST["hdn_division_num"];
        $form->setConstants($division_set);

    }

    /****************************/
    // 分割設定処理
    /****************************/
    // 分割設定フラグが真の場合
    if ($division_set_flg === true){

        // 分割設定前処理
        $pay_m          = isset($_POST["add_button"]) ? $hdn_pay_m : $_POST["form_pay_m"];                  // 回収日（月）

//        $pay_m          = $pay_m + $_POST["hdn_mst_pay_m"];                  // 回収日（月）
        $pay_d          = isset($_POST["add_button"]) ? $hdn_pay_d : $_POST["form_pay_d"];                  // 回収日（日）
        $division_num   = isset($_POST["add_button"]) ? $hdn_division_num : $_POST["form_division_num"];    // 分割回数
        $total_money    = str_replace(",", "", $total_money);   // 税込金額（カンマ抜き）
//        $total_money    = str_replace(",", "", $_POST["form_sale_money"]);   // 税込金額（カンマ抜き）
        //$yy             = date("Y");
        //$mm             = date("m");

        // 税込金額÷分割回数の商
        $division_quotient_price    = bcdiv($total_money, $division_num);
        // 税込金額÷分割回数の余り
        $division_franct_price      = bcmod($total_money, $division_num);
        // 2回目以降の回収金額
        $second_over_price          = str_pad(substr($division_quotient_price, 0, 3), strlen($division_quotient_price), 0);
        // 1回目の回収金額
        $first_price                = ($division_quotient_price - $second_over_price) * $division_num + $division_franct_price + $second_over_price;
        // 金額が分割回数で割り切れる場合
        if ($division_franct_price == "0"){
            $first_price = $second_over_price = $division_quotient_price;
        }

        // 分割回数分ループ
        for ($i=0; $i<$division_num; $i++){

            // 分割回収日作成
            $date_y     = date("Y", mktime(0, 0, 0, $mm + $pay_m + $i, 1, $yy));
            $date_m     = date("m", mktime(0, 0, 0, $mm + $pay_m + $i, 1, $yy));
            $mktime_m   = ($pay_d == "29") ? $mm + $pay_m + $i + 1 : $mm + $pay_m + $i;
            $mktime_d   = ($pay_d == "29") ? 0 : $pay_d;
            $date_d     = date("d", mktime(0, 0, 0, $mktime_m, $mktime_d, $yy));

            // 分割回収日を配列にSET
            $division_date[]    = "$date_y-$date_m-$date_d";

            // 分割回収金額を配列にSET
            $division_price[]   = ($i == 0) ? $first_price : $second_over_price;

            // 分割回収日フォーム作成
            $form_pay_date = null;
            $form_pay_date[] = &$form->createElement("static", "y", "", "");
            $form_pay_date[] = &$form->createElement("static", "m", "", "");
            $form_pay_date[] = &$form->createElement("static", "d", "", "");
            $form->addGroup($form_pay_date, "form_pay_date[$i]", "", "-");

            // 分割回収金額フォーム作成
            $form->addElement("text", "form_split_pay_amount[$i]", "", "class=\"money\" size=\"11\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

            // 分割回収金額をセット
            $set_data["form_split_pay_amount"][$i] = ($i == 0) ? $first_price : $second_over_price;

            // 分割回収日をセット
            $set_data["form_pay_date"][$i]["y"] = $date_y;
            $set_data["form_pay_date"][$i]["m"] = $date_m;
            $set_data["form_pay_date"][$i]["d"] = $date_d;

            // 分割回収金額、分割回収日データをSET（分割回収登録ボタン押下時はフォームデータを引き継ぐ）
            isset($_POST["add_button"]) ? $form->setDefaults($set_data) : $form->setConstants($set_data);

        }

    }

    /****************************/
    // 分割回収登録ボタン押下処理
    /****************************/
    if (isset($_POST["add_button"])){

        /****************************/
        // エラーチェック
        /****************************/
        /* 分割設定時に、仕入伝票が変更されていないか調べる */
        $sql = "SELECT * FROM t_sale_h WHERE sale_id = $sale_id AND change_day = '".$_POST["hdn_change_date"]."';";
        $res = Db_Query($db_con, $sql);
        if (pg_num_rows($res) == 0){
            // 正当なデータでない場合は仕入完了画面へ遷移
            header("Location:1-2-205.php?inst_err=true&sale_id=0&input_flg=true");
            exit;
        }

        /* 合計金額チェック */
        // 分割回収金額
        $sum_err_flg = ($total_money != array_sum($_POST["form_split_pay_amount"])) ? true : false;
        if ($sum_err_flg == true){
            $form->setElementError("form_split_pay_amount[0]", "分割請求金額の合計が不正です。");
        }

        /* 半角数字チェック */
        // 分割回収金額
        for ($i=0; $i<$division_num; $i++){
            $ary_numeric_err_flg[] = (ereg("^[0-9]+$", $_POST["form_split_pay_amount"][$i])) ? false : true;
        }
        if (in_array(true, $ary_numeric_err_flg)){
            $form->setElementError("form_split_pay_amount[0]", "分割請求金額は半角数字のみです。");
        }

        /* 必須項目チェック */
        // 分割回収金額
        $required_err_flg = (in_array(null, $_POST["form_split_pay_amount"])) ? true : false;
        if ($required_err_flg == true){
            $form->setElementError("form_split_pay_amount[0]", "分割請求金額は必須です。");
        }

        // エラーチェック結果集計
        $err_flg = ($sum_err_flg == true || in_array(true, $ary_numeric_err_flg) || $required_err_flg == true) ? true : false;

        // バリデーーート
        $form->validate();
        /****************************/
        // DB処理
        /****************************/
        // エラーが無ければ
        if ($err_flg == false){

            // フリーザ
            $form->freeze();

            // トランザクション開始
            Db_Query($db_con, "BEGIN;");

            // 更新状況フラグの定義
            $db_err_flg = array();

            /* 仕入ヘッダテーブル更新処理(UPDATE) */
            $sql = "UPDATE t_sale_h SET total_split_num = $division_num WHERE sale_id = $sale_id;";
            $res  = Db_Query($db_con, $sql);

            // 更新失敗時ロールバック
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                $db_err_flg[] = true;
                exit;
            }

            /* 割賦回収テーブル更新処理(DELETE) */
            $sql = "DELETE from t_installment_sales WHERE sale_id = $sale_id;";
            $res  = Db_Query($db_con, $sql);

            // 更新失敗時ロールバック
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                $db_err_flg[] = true;
                exit;
            }

            /* 割賦回収テーブル更新処理(INSERT) */
            for ($i=0; $i<$division_num; $i++){
                $sql  = "INSERT INTO \n";
                $sql .= "    t_installment_sales \n";
                $sql .= "( \n";
                $sql .= "    installment_sales_id, \n";
                $sql .= "    sale_id, \n";
                $sql .= "    collect_day, \n";
                $sql .= "    collect_amount \n";
                $sql .= ") VALUES ( \n";
                $sql .= "    (SELECT COALESCE(MAX(installment_sales_id), 0)+1 FROM t_installment_sales), \n";
                $sql .= "    $sale_id, \n";
                $sql .= "    '$division_date[$i]', \n";
                $sql .= "    ".$_POST["form_split_pay_amount"][$i]." \n";
                $sql .= ");\n";

                $res  = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }

            // SQLエラーが無い場合
            if (!in_array(true, $db_err_flg)){

                // コメットさん
                Db_Query($db_con, "COMMIT;");

                // 分割回収登録フラグにTRUEをSET
                $division_comp_flg = true;

                // 画面表示用にナンバーフォーマットした分割回収金額をセット
                if (isset($_POST["add_button"])){
                    for ($i=0; $i<count($_POST["form_split_pay_amount"]); $i++){
                        $number_format_data["form_split_pay_amount"][$i] = number_format($_POST["form_split_pay_amount"][$i]);
                    }
                }
                $form->setConstants($number_format_data);
            }

        }

    }

}


//print_array($_POST);

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
//$page_menu = Create_Menu_h('sale','2');
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
    'html_header'           => "$html_header",
    'page_menu'             => "$page_menu",
    'page_header'           => "$page_header",
    'html_footer'           => "$html_footer",
    "division_set_flg"      => $division_set_flg,
    "division_err_flg"      => $division_err_flg,
    "ary_division_err_msg"  => $ary_division_err_msg,
    "division_comp_flg"     => $division_comp_flg,
    "division_flg"          => $division_flg,
    'renew_msg'             => "$renew_msg",
    "freeze_flg"            => $freeze_flg,
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
