<?php
/**
 *
 * 棚卸調査表作成・一覧 inventory survey chartt
 *
 *
 *
 *
 *
 *
 *
 *   !! 本部・FC画面ともに同じソース内容です !! same source with HQ and FC
 *   !! 変更する場合は片方をいじって他方にコピってください !! copy paste the change in HQ to FC
 *
 *
 *
 *
 *
 *
 *
 * ・棚卸は各ショップごとに行う（直営でも他のショップの棚卸は実施できない） stocktaking is done per store (even Amenity-toyo (directly managed store)
 * ・棚卸日は最終月次更新より前は指定できない stocktaking date cannot be assigned before the monthly update is done
 * ・棚卸日は前回棚卸日より前は指定できない stocktaking date cannot be assigned before the previous stocktaking date
 *
 * 既知のバグ
 * ・倉庫名にWindowsでファイル名に使えない文字（\/*?:"<>|）があると、
 *   CSVのファイル名がおかしくなる（内容はおｋ）
 *
 * 1.0.0 (2006/04/27) 新規作成
 * 1.0.1 (2006/05/09) 棚卸調査表作成時にstaff_idを登録しないように変更
 * 1.0.2 (2006/05/10) 棚卸調査表作成後に自画面に遷移するように変更
 * 1.0.3 (2006/05/10) 棚卸入力を実施していない場合は差異一覧リンクを表示しないように変更
 * 1.0.4 (2006/05/11) 棚卸調査表作成時に名称とコードを登録するように変更
 * 1.0.5 (2006/07/10) shop_gidをなくす
 * 1.0.6 (2006/08/25) CSVファイル名を変更・実棚数削除
 *                      棚卸日を入力可
 * 1.0.7 (2006/10/13) 棚卸データ取得SQLのstock_cdの'-'をつけた
 * 1.0.8 (2006/10/17) (kaji)
 *   ・棚卸日のフォームからフォーカスが外れたときにフォームを白くする
 *   ・棚卸日を0埋めし、クエリーエラーとなるのを回避
 *   ・棚卸日の妥当性チェックをQuickFormのnumericから正規表現に変更
 *   ・棚卸日は月次更新とシステム開始日より後かチェック追加
 *   ・直営内で他のショップの棚卸データを取消できていたのを修正
 *   ・棚卸データが存在しない場合に、エラーメッセージが表示されなかったのを修正
 *   ・サニタイジング
 *   ・商品分類CD、商品分類名、商品名（略称）を追加
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.8 (2006/10/17)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/06      12-001      kajioka-h   商品の状態が「無効」「有効（直営のみ）」を考慮
 *                  12-002      kajioka-h   ログイン者が所属の倉庫のみ棚卸対象に（直営の管理倉庫を考慮）
 *                  12-003      kajioka-h   倉庫マスタで非表示設定されている倉庫は棚卸対象外にした
 *  2006/12/07      12-005      kajioka-h   同時に調査表作成された場合の排他処理追加
 *                  12-006      kajioka-h   調査表削除時に既に削除されていないかチェック処理追加
 *                  12-007      kajioka-h   調査表削除時に既に更新されていないかチェック処理追加
 *  2006/12/21      xx-xxx      kajioka-h   CSVの表示順を倉庫、商品分類、商品CDにした
 *                  xx-xxx      kajioka-h   実棚数はデフォルト0を登録
 *  2007/01/22      xx-xxx      kajioka-h   調査表一覧で一時登録しているのがわかるように変更
 *  2007/02/13                  watanabe-k  担当倉庫の調査票を作成しないように修正（FC）
 *  2007/02/16      xx-xxx      watanabe-k  管理倉庫カラム削除に伴いSQL修正（本部）
 *  2007/02/20      小松指摘    kajioka-h   実棚数はデフォルト帳簿数に戻りました
 *  2007/03/06      作業項目73  ふ          棚卸一覧と差異明細一覧を１モジュールに集約したため、リンク先名称を変更
 *  2007/05/11      xx-xxx      kajioka-h   棚卸入力で追加入力した商品はCSVに出力しないように変更
 *  2007/05/14      その他92    kajioka-h   棚卸入力が50行ごとに表示・入力可能になったため、棚卸一覧の表示判定、一時登録判定を変更
 *  2009/10/09                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 */


$page_title = "棚卸調査表作成・一覧";

//環境設定ファイル env file
require_once("ENV_local.php");

//HTML_QuickFormを作成 create
//$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続 connect
$db_con = Db_Connect();

// 権限チェック auth check
$auth       = Auth_Check($db_con);

//disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//select作成用部品 select component for creation
//require_once(PATH."include/select_part.php");

/****************************/
//外部変数取得 acquire outside variables
/****************************/
/*
echo "<pre>";
print_r($_SESSION);
print_r($_POST);
echo "</pre>";
*/

$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$rank_cd    = ($group_kind == "1") ? "1" : "3";

if($_GET["err"] == "dup"){
	$err_mess = "既に棚卸調査表が作成されています。";
}elseif($_GET["err"] == "del"){
	$err_mess = "既に棚卸調査表が削除されています。";
}elseif($_GET["err"] == "rnw"){
	$err_mess = "既に棚卸調査表が更新されています。";
}


/****************************/
//デフォルト値設定 set the default value
/****************************/

$def_fdata = array(
    "form_target_goods" => "1"
);

$form->setDefaults($def_fdata);

/****************************/
//部品定義 define component
/****************************/

//対象商品ラジオボタン coresponding product radio button 
$radio = "";
$radio[] =& $form->createElement("radio", NULL, NULL, "全商品", "1");
$radio[] =& $form->createElement("radio", NULL, NULL, "在庫数0以外", "2");
$radio[] =& $form->createElement("radio", NULL, NULL, "在庫数0", "3");
$form->addGroup($radio, "form_target_goods", "対象商品");

//棚卸日 stocktaking date
$form_create_day[] =& $form->createElement(
    "text","y","テキストフォーム",
    "style=\"ime-mode:disabled;\" size=\"4\" maxLength=\"4\"
     onkeyup=\"changeText(this.form,'form_create_day[y]','form_create_day[m]',4)\"
     onFocus=\"onForm_today(this,this.form,'form_create_day[y]','form_create_day[m]','form_create_day[d]');\"
     onBlur=\"blurForm(this)\" onKeyDown=\"chgKeycode();\"
    ");
$form_create_day[] =& $form->createElement(
    "text","m","テキストフォーム","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\"
     onkeyup=\"changeText(this.form,'form_create_day[m]','form_create_day[d]',2)\"
     onFocus=\"onForm_today(this,this.form,'form_create_day[y]','form_create_day[m]','form_create_day[d]');\"
     onBlur=\"blurForm(this)\" onKeyDown=\"chgKeycode();\"
    ");
$form_create_day[] =& $form->createElement(
    "text","d","テキストフォーム","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\"
     onFocus=\"onForm_today(this,this.form,'form_create_day[y]','form_create_day[m]','form_create_day[d]');\"
     onBlur=\"blurForm(this)\" onKeyDown=\"chgKeycode();\"
    ");
$form->addGroup( $form_create_day,"form_create_day","form_create_day","-");

//調査表作成ボタン create survey chart button
$form->addElement("submit", "create_button", "調査表作成", $disabled);

//クリアボタン clear button
$form->addElement("submit", "clear_button", "クリア", "");

//調査取消ボタン cancel survey button
//$form->addElement("submit", "delete_button", "調査取消", $disabled);
$form->addElement("button", "form_delete_button", "調査取消", "onClick=\"javascript:Dialogue_2('削除します。', '#', '調査取消', 'delete_button')\" $disabled");
$form->addElement("hidden", "delete_button");

// 棚卸調査表リンクボタン stocktaking surver chart lin button
$form->addElement("button", "4_201_button", "棚卸調査表", "$g_button_color onClick=\"location.href('".$_SERVER["PHP_SELF"]."');\"");

// 棚卸実績一覧リンクボタン stocktaking result list link button
if($group_kind == "1"){
    $form->addElement("button", "4_205_button", "棚卸実績一覧", "onClick=\"location.href('./1-4-205.php');\"");
}else{
    $form->addElement("button", "4_205_button", "棚卸実績一覧", "onClick=\"location.href('./2-4-205.php');\"");
}

//棚卸調査表番号hidden stocktaking survey table number hidden
$form->addElement("hidden", "invent_cd", "", "");

/****************************/
//
/****************************/

/***「調査表作成」ボタンが押された if the create stocksurvey button is pressed***/ 
if($_POST["create_button"] == "調査表作成") {

    $create_day_y           = $_POST["form_create_day"]["y"];     //棚卸日 stocktaking date
    $create_day_m           = $_POST["form_create_day"]["m"];        
    $create_day_d           = $_POST["form_create_day"]["d"];

    if($create_day_y != null || $create_day_m != null || $create_day_d != null){
        $create_day = $create_day_y."-".$create_day_m."-".$create_day_d;
    }

    /****************************/
    //エラーチェック(addRule) error check
    /****************************/
    //棚卸日 stocktaking date
    //●必須チェック required field 
    //●半角数字チェック half width number check
    $form->addGroupRule('form_create_day', array(
            'y' => array(
                    array('棚卸日 の日付は妥当ではありません。', 'required'),
                    //array('棚卸日 の日付は妥当ではありません。', 'numeric')
                    array('棚卸日 の日付は妥当ではありません。', "regex", '/^[0-9]+$/')
            ),      
            'm' => array(
                    array('棚卸日 の日付は妥当ではありません。','required'),
                    //array('棚卸日 の日付は妥当ではありません。', 'numeric')
                    array('棚卸日 の日付は妥当ではありません。', "regex", '/^[0-9]+$/')
            ),      
            'd' => array(
                    array('棚卸日 の日付は妥当ではありません。','required'),
                    //array('棚卸日 の日付は妥当ではありません。', 'numeric')
                    array('棚卸日 の日付は妥当ではありません。', "regex", '/^[0-9]+$/')
            ),      
    ));

    /****************************/
    //エラーチェック(PHP) error check (PHP)
    /****************************/
    $error_flg = false;            //エラー判定フラグ error determining flag

    //棚卸日 stocktaking date
    //・妥当性チェック check validity
    if($create_day_y != null || $create_day_m != null || $create_day_d != null){
        $create_day_y = (int)$create_day_y;
        $create_day_m = (int)$create_day_m;
        $create_day_d = (int)$create_day_d;
        if(!checkdate($create_day_m,$create_day_d,$create_day_y)){
            $form->setElementError("form_create_day","棚卸日 の日付は妥当ではありません。");
            $error_flg = true;
        }
    }
    //・月次更新より後かチェック check if its after monthly update
    if($error_flg == false && !Check_Monthly_Renew($db_con, $shop_id, "0", $create_day_y, $create_day_m, $create_day_d)){
        $form->setElementError("form_create_day","棚卸日 に前回の月次更新以前の日付が入力されています。");
        $error_flg = true;
    }
    //・システム開始より後かチェック check if its after the system commence date
    if($error_flg == false){
        $sys_start_msg = Sys_Start_Date_Chk($create_day_y, $create_day_m, $create_day_d, "棚卸日");
        if($sys_start_msg != null){
            $form->setElementError("form_create_day", $sys_start_msg);
            $error_flg = true;
        }else{
            //$create_day = $create_day_y."-".$create_day_m."-".$create_day_d;
            $create_day  = str_pad($create_day_y, 4, 0, STR_PAD_LEFT);
            $create_day .= str_pad($create_day_m, 2, 0, STR_PAD_LEFT);
            $create_day .= str_pad($create_day_d, 2, 0, STR_PAD_LEFT);
        }
    }

    //直前に他のユーザに調査表を作成されていないかチェック（12-005）check if other users havent created the survey chart
    $sql = "SELECT COUNT(invent_id) FROM t_invent WHERE shop_id = $shop_id AND renew_flg = false;";
    $result = Db_Query($db_con, $sql);
    if(pg_fetch_result($result, 0, 0) != 0){
        header("Location: $_SERVER[PHP_SELF]?err=dup");
        exit();
    }

    //エラーの場合はこれ以降の表示処理を行なわない dont proceed with the process if its an error 
    if($form->validate() && $error_flg == false){

        //調査表を作成するため、ショップ内の倉庫、商品等を取得 acquire data such as warehouse, product of the store to create a survey chart
        $sql  = "SELECT \n";
        $sql .= "    t_stock.ware_id, \n";
        $sql .= "    t_stock.goods_id, \n";
        $sql .= "    t_stock.stock_num AS book_physical, \n";
        $sql .= "    t_price.r_price, \n";
        $sql .= "    t_ware.ware_cd, \n";
        $sql .= "    t_ware.ware_name, \n";
        $sql .= "    t_goods.goods_cd, \n";
        $sql .= "    t_goods.goods_name, \n";
        $sql .= "    t_g_goods.g_goods_cd, \n";
        $sql .= "    t_g_goods.g_goods_name, \n";
        $sql .= "    t_product.product_cd, \n";
        $sql .= "    t_product.product_name, \n";
        $sql .= "    t_g_product.g_product_cd, \n";
        $sql .= "    t_g_product.g_product_name, \n";
        $sql .= "    t_goods.goods_cname \n";

        $sql .= "FROM \n";

        //在庫受払テーブルより在庫数、引当数を抽出 extract the reserved number of units and the current number of units from the stock balance table.
//        $sql .= "   (SELECT \n";
//        $sql .= "       CASE \n";
//        $sql .= "           WHEN t_stock.goods_id IS NOT NULL THEN t_stock.goods_id \n";
//        $sql .= "           WHEN t_stock.goods_id IS NULL     THEN t_allowance.goods_id \n";
//        $sql .= "       END AS goods_id, \n";
//        $sql .= "       t_stock.ware_id, \n";
//        $sql .= "       COALESCE(t_stock.stock_num,0)AS stock_num \n";
//        $sql .= "   FROM \n";
        //在庫数を計算 compute the current number of units
        $sql .= "       (SELECT \n";
        $sql .= "           goods_id, \n";
        $sql .= "           ware_id, \n";
        $sql .= "           SUM(t_stock_hand.num * \n";
        $sql .= "               CASE t_stock_hand.io_div \n";
        $sql .= "                       WHEN 1 THEN 1 \n";
        $sql .= "                       WHEN 2 THEN -1 \n";
        $sql .= "                   END \n"; 
        $sql .= "           ) AS stock_num, \n"; 
//        $sql .= "           shop_id, \n";
        //$sql .= "           goods_id || '-' || ware_id || shop_id AS stock_cd\n";
        //$sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd \n";
        $sql .= "           goods_id || '-' || ware_id AS stock_cd \n";
        $sql .= "       FROM \n";
        $sql .= "           t_stock_hand \n";
        $sql .= "       WHERE \n";
        $sql .= "           work_div NOT IN (1,3) \n";
        $sql .= "           AND \n";
        $sql .= "           work_day <= '$create_day' \n";
        $sql .= "           AND \n";
        if($_SESSION[group_kind] == '2'){
            $sql .= "           shop_id IN (".Rank_Sql().")\n";
        }else{  
            $sql .= "           shop_id = $shop_id \n";
        }       
        //$sql .= "       GROUP BY goods_id, ware_id, shop_id \n";
        $sql .= "       GROUP BY goods_id, ware_id \n";
        $sql .= "       ) AS t_stock \n";
//        $sql .= "   FULL OUTER JOIN \n";
//        //引当数を計算 compute the no of units reserved for order
//        $sql .= "       (SELECT \n";
//        $sql .= "           goods_id, \n";
//        $sql .= "           ware_id, \n";
//        $sql .= "           SUM(t_stock_hand.num * \n";
//        $sql .= "                   CASE t_stock_hand.io_div \n";
//        $sql .= "                       WHEN 1 THEN -1 \n";
//        $sql .= "                       WHEN 2 THEN 1 \n";
//        $sql .= "                   END \n";
//        $sql .= "           ) AS allowance_num, \n";
//        $sql .= "           shop_id, \n";
//        //$sql .= "           goods_id || '-' || ware_id || shop_id AS stock_cd\n";
//        $sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd \n";
//        $sql .= "       FROM \n";
//        $sql .= "           t_stock_hand \n";
//        $sql .= "       WHERE \n";
//        $sql .= "           work_div = '3' \n";
//        $sql .= "           AND \n";
//        $sql .= "           work_day <= '$create_day' \n";
//        $sql .= "           AND \n";
//        if($_SESSION[group_kind] == '2'){
//            $sql .= "           shop_id IN (".Rank_Sql().")\n";
//        }else{
//            $sql .= "           shop_id = $shop_id \n";
//        }
//        $sql .= "       GROUP BY goods_id, ware_id, shop_id \n";
//        $sql .= "       )AS t_allowance \n";
//        $sql .= "       ON t_stock.stock_cd = t_allowance.stock_cd \n";
//        $sql .= "    ) AS t_stock \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_goods \n";
        $sql .= "    ON t_goods.goods_id = t_stock.goods_id \n ";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_price \n";
        $sql .= "    ON t_price.goods_id = t_stock.goods_id \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_ware \n";
        $sql .= "    ON t_ware.ware_id = t_stock.ware_id \n";
//        $sql .= "       AND t_ware.own_shop_id = $shop_id \n";
        if($group_kind == 1){
            $sql .= "       AND t_ware.shop_id = $shop_id \n";
        }else{
            $sql .= "       AND t_ware.staff_ware_flg = false \n";
        }
        $sql .= "       AND t_ware.nondisp_flg = false \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_g_goods \n";
        $sql .= "    ON t_g_goods.g_goods_id = t_goods.g_goods_id \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_product \n";
        $sql .= "    ON t_product.product_id = t_goods.product_id \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "    t_g_product \n";
        $sql .= "    ON t_g_product.g_product_id = t_goods.g_product_id \n";

        #2009-10-09 hashimoto-y
        $sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

        $sql .= "WHERE \n";
//    $sql .= "    t_stock.shop_id = $_SESSION[client_id] ";

        #2009-10-09 hashimoto-y
        #$sql .= "    t_goods.stock_manage = '1' \n";
        $sql .= "    t_goods_info.stock_manage = '1' \n";
        $sql .= "     AND";
        $sql .= "     t_goods_info.shop_id = $shop_id ";

        $sql .= "AND \n";
        $sql .= "    t_goods.accept_flg = '1' \n";
        $sql .= "AND \n";
        //FC以外（本部または直営）は有効商品と直営のみ有効商品 If its either other than FC (HQ and directly managed store) is valid product or if its directly store which is a valid product
        if($_SESSION["group_kind"] != '3'){
            $sql .= "    t_goods.state IN ('1', '3') \n";
        //FCは有効商品のみ if FC is the only valid product
        }else{
            $sql .= "    t_goods.state = '1' \n";
        }
        $sql .= "AND \n";
    //$sql .= "    t_price.shop_gid = $_SESSION[shop_gid] ";
        $sql .= ($group_kind == "2") ? " t_price.shop_id IN (".Rank_Sql().") \n " : " t_price.shop_id = $shop_id \n";
        //$sql .= " t_price.shop_id = $shop_id \n";
        $sql .= "AND \n";
        $sql .= "    t_price.rank_cd = $rank_cd \n";

        //対象商品の「在庫数0以外」が選択された場合 if the `other than current number of units which are 0` for the corresponding product is selected
        if($_POST["form_target_goods"] == "2") {
            $sql .= "    AND t_stock.stock_num <> 0 \n";
        //対象商品の「在庫数0」が選択された場合
        } else if ($_POST["form_target_goods"] == "3") {
            $sql .= "    AND t_stock.stock_num = 0 \n";
        }

        $sql .= "ORDER BY \n";
        $sql .= "    t_stock.ware_id, \n";
        $sql .= "    t_stock.goods_id \n";
        $sql .= ";\n";
//print_array($sql, "棚卸データ取得");

        $result = Db_Query($db_con, $sql);

        //棚卸調査表のデータが0件だった場合、自画面に戻る return to the self screen(???) if the stocktaking survey chart had 0 data
        if(pg_num_rows($result) == 0) {
            header("Location: $_SERVER[PHP_SELF]?invent_data=0");
            exit();
        }

        //新規棚卸調査表番号取得 acquire the new stocktaking survey chart number
        $sql2  = "SELECT ";
        $sql2 .= "    COALESCE(MAX(to_number(invent_no, '0000000000')), 0)+1 ";
        $sql2 .= "FROM ";
        $sql2 .= "    t_invent ";
        $sql2 .= "WHERE ";
        $sql2 .= "    shop_id = $_SESSION[client_id]";
//        $sql2 .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
        $sql2 .= ";";

        $result2 = Db_Query($db_con, $sql2);
        $invent_no = pg_fetch_result($result2, 0, 0);
        $invent_no = str_pad($invent_no, 10, "0", STR_PAD_LEFT);


        /*** 棚卸ヘッダ、棚卸データ登録トランザクション開始 stocktaking header, start registration of sotcktaking  data transaction ***/
        Db_Query($db_con, "BEGIN;");

        $pre_ware_id = "";

        /*** 棚卸ヘッダテーブルに倉庫分のデータを登録 register the warehouse data in the stocktaking header table ***/
        while($array = pg_fetch_array($result)) {

            if($pre_ware_id != $array['ware_id']) {

                //棚卸ヘッダテーブルに登録 register in the stocktaking header table
                $sql2  = "INSERT INTO t_invent \n";

                // 1.0.1(06-05-09) kajioka-h：棚卸調査表作成時はstaff_idは登録しな do not register the staff_id when the stocktaking survey chart is created
                //$sql2 .= "   (invent_id, invent_no, expected_day, ware_id, target_goods, staff_id, shop_id) ";
                $sql2 .= "   (invent_id, invent_no, expected_day, ware_id, ware_name, ware_cd, target_goods, shop_id) \n";

                $sql2 .= "VALUES ( \n";
                $sql2 .= "    (SELECT COALESCE(MAX(invent_id), 0)+1 FROM t_invent), \n";
                $sql2 .= "    '$invent_no',\n ";
                $sql2 .= "    '$create_day',\n ";
                $sql2 .= "    ".$array['ware_id'].",\n ";
                //$sql2 .= "    '$array[ware_name]', \n";
                $sql2 .= "    '".addslashes($array[ware_name])."', \n";
                $sql2 .= "    '$array[ware_cd]', \n";
                $sql2 .= "    ".$_POST['form_target_goods'].",\n ";

                // 1.0.1(06-05-09) kajioka-h：棚卸調査表作成時はstaff_idは登録しない do not register the staff_id when the stocktaking survey chart is created
                //$sql2 .= "    ".$_SESSION['staff_id'].", ";
                $sql2 .= "    ".$shop_id." \n";
                $sql2 .= ") \n";
                $sql2 .= "; \n";

                $result2 = Db_Query($db_con, $sql2);
                if($result2 == false) {
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

                //棚卸ヘッダテーブルに登録した棚卸調査IDを取得 acqyure the stocktaking sruvey ID that was registed in the stocktaking header table 
                $sql2  = "SELECT invent_id FROM t_invent ";
                $sql2 .= "WHERE ";
                $sql2 .= "    shop_id = ".$_SESSION['client_id']." ";
                //$sql2 .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
                $sql2 .= "AND ";
                $sql2 .= "    ware_id = ".$array['ware_id']." ";
                $sql2 .= "AND ";
                $sql2 .= "    invent_no = '$invent_no'";
                $sql2 .= ";";

                $result2 = Db_Query($db_con, $sql2);
                $invent_id = pg_fetch_result($result2, 0, 0);       //棚卸調査ID stocktaking survey ID
            }

            //棚卸データテーブルに倉庫に対する商品分のデータを登録 register the product data for the warehouse in the stocktaking data table 
            $sql2  = "INSERT INTO t_contents ";
            //$sql2 .= "    (invent_id, goods_id, stock_num, tstock_num, goods_cd, goods_name, g_goods_cd, g_goods_name, price) ";
            $sql2 .= "    ( ";
            $sql2 .= "        invent_id, ";
            $sql2 .= "        goods_id, ";
            $sql2 .= "        stock_num, ";
            $sql2 .= "        tstock_num, ";
            $sql2 .= "        goods_cd, ";
            $sql2 .= "        goods_name, ";
            $sql2 .= "        g_goods_cd, ";
            $sql2 .= "        g_goods_name, ";
            $sql2 .= "        price, ";
            $sql2 .= "        product_cd, ";
            $sql2 .= "        product_name, ";
            $sql2 .= "        g_product_cd, ";
            $sql2 .= "        g_product_name, ";
            $sql2 .= "        goods_cname ";
            $sql2 .= "    ) ";
            $sql2 .= "VALUES ( ";
            $sql2 .= "    $invent_id, ";
            $sql2 .= "    ".$array['goods_id'].", ";
            $sql2 .= "    ".$array['book_physical'].", ";
            $sql2 .= "    ".$array['book_physical'].", ";   //実棚数はデフォルト帳簿数に戻りました the actual inventory has returned in the default number stated in accounts
            //$sql2 .= "    0, ";         //実棚数はデフォルト0に make the actual inventory by default 0
            $sql2 .= "    '$array[goods_cd]', ";
            //$sql2 .= "    '$array[goods_name]', ";
            $sql2 .= "    '".addslashes($array[goods_name])."', ";
            $sql2 .= "    '$array[g_goods_cd]', ";
            //$sql2 .= "    '$array[g_goods_name]', ";
            $sql2 .= "    '".addslashes($array[g_goods_name])."', ";
            $sql2 .= "    ".$array['r_price'].", ";
            $sql2 .= "    '$array[product_cd]', ";
            $sql2 .= "    '".addslashes($array[product_name])."', ";
            $sql2 .= "    '$array[g_product_cd]', ";
            $sql2 .= "    '".addslashes($array[g_product_name])."', ";
            $sql2 .= "    '".addslashes($array[goods_cname])."' ";
            $sql2 .= ")";
            $sql2 .= ";";

            $result2 = Db_Query($db_con, $sql2);
            if($result2 == false) {
                Db_Query($db_con, "ROLLBACK;");
                exit();
            }

            $pre_ware_id = $array['ware_id'];
/*
            //トランザクション完了 finish transaction
            Db_Query($db_con, "COMMIT;");

            //1.0.2(06-05-10) watanabe-k：棚卸調査表作成後は自画面に遷移 transition to the self screen(???) after the stocktaking survey char is created
            header("Location: ./2-4-201.php");
*/ 
       }

        //トランザクション完了 complete transaction
        Db_Query($db_con, "COMMIT;");

        //1.0.2(06-05-10) watanabe-k：棚卸調査表作成後は自画面に遷移 transition to the self screen(???) after the stocktaking survey char is created
        header("Location: $_SERVER[PHP_SELF]");
        exit();

        /*** 作成した棚卸調査表の情報・一覧を表示 display the info/list of stocktaking survey chart that was created ***/
/*
        $array = Make_Utable($db_con, $_SESSION['client_id']);
        $row1 = $array[0];
        $row2 = $array[1];

        $disp_flg = "l";

        $form->setConstants(array("invent_cd" => "$row1[1]"));
*/
    }elseif($duplicate_err_mess != null){
        $disp_flg = 'l';
    }else{
        $disp_flg = 'u';

    }
//「クリア」ボタンが押された when theclear button is pressed
} else if($_POST["clear_button"] == "クリア") {

    //自画面へ遷移 transition to the self-screen
    header("Location: $_SERVER[PHP_SELF]");

//「調査取消」ボタンが押された if the survey cancel button is pressed
} else if($_POST["delete_button"] == "調査取消") {

    //既に削除、または更新されていないかチェック（12-006、12-007） check if its already deleted or updated (renewd)
    $sql  = "SELECT \n";
    $sql .= "    DISTINCT(renew_flg) \n";
    $sql .= "FROM \n";
    $sql .= "    t_invent \n";
    $sql .= "WHERE \n";
    $sql .= "    invent_no = '$_POST[invent_cd]' \n";
    $sql .= "    AND \n";
    $sql .= "    shop_id = $shop_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    if(pg_num_rows($result) == 0){
        header("Location: $_SERVER[PHP_SELF]?err=del");
        exit();
    }elseif(pg_fetch_result($result, 0, 0) == "t"){
        header("Location: $_SERVER[PHP_SELF]?err=rnw");
        exit();
    }

    //棚卸ヘッダテーブルからデータを削除 delete the data from the stocktaking header table
    $sql  = "DELETE FROM t_invent ";
    $sql .= "WHERE ";
    $sql .= "    invent_no = '$_POST[invent_cd]' ";
    $sql .= "AND ";
    $sql .= "    shop_id = $shop_id ";
    //$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

        //棚卸調査表の作成フォームを表示 display the create form of stocktaking inventory chart
    $row1 = array($g_today);

    //
    $form->setConstants(array("form_target_goods" => "1"));

    $disp_flg = "u";

//初期表示 initial display
} else {

    //棚卸更新していない調査表がある場合、棚卸調査表の情報・一覧を表示 if there is a stocktaking chart that has not been udated(renew) yet, display the info/list of the stocktaking survery chart
    if(pg_num_rows(Get_Invent_Data($db_con, $_SESSION['client_id'])) != 0) {
        $array = Make_Utable($db_con, $_SESSION['client_id']);
        $row1 = $array[0];
        $row2 = $array[1];

        $disp_flg = "l";

        $form->setConstants(array("invent_cd" => "$row1[1]"));

    //棚卸更新していない調査表がない場合、棚卸調査表の作成フォームを表示 display the create form for stocktaking survey chart if there is no stocktaking survey chart that is not updated (renewed)
    } else {
        $row1 = array($g_today);

        if($_GET["invent_data"] == "0") {
            $row2 = array("棚卸商品データがありません");
        } else {
            $row2 = null;
        }

        $disp_flg = "u";
    }
}

if($_GET["ware_id"]!=null){
	$ware_id = (int)$_GET["ware_id"];

    /** CSV作成SQL **/
    $sql  = "SELECT ";
    $sql .= "t_contents.goods_cd,";      //商品コード product code
    $sql .= "t_contents.goods_name,";    //商品名 product name
    $sql .= "t_contents.stock_num,";     //帳簿数 stock number in the book of accounts
    //$sql .= "t_contents.tstock_num,";    //実棚数 actual inventory number
    $sql .= "t_invent.ware_name";        //倉庫名 warehouse name
    $sql .= " FROM ";
    $sql .= "t_invent, ";
    $sql .= "t_contents ";
    $sql .= "WHERE ";
    $sql .= "t_invent.invent_id = t_contents.invent_id ";
    $sql .= "AND ";
    $sql .= "t_invent.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "t_invent.invent_no = '$_GET[invent_no]' ";
    $sql .= "AND ";
    $sql .= "t_contents.add_flg = false ";

    /** 条件指定 assign condition**/
    //直送先コード指定の有無 to assign or not the direct destination code
    if($ware_id != null && $ware_id != all){
        $sql .= "AND t_invent.ware_id = '$ware_id' ";
    }
    $sql .= "ORDER BY ";
    //$sql .= "t_invent.ware_id,t_contents.goods_cd;";
    $sql .= "t_invent.ware_cd, ";
    $sql .= "t_contents.g_product_cd, ";
    $sql .= "t_contents.goods_cd ";
    $sql .= ";";

    $result = Db_Query($db_con,$sql);

    //CSVデータ取得 acquire csv data
    $i=0;
    while($data_list = pg_fetch_array($result)){
        //倉庫名 warehouse name
        $direct_data[$i][0] = $data_list[3];
        //商品コード product code
        $direct_data[$i][1] = $data_list[0];
        //商品名 product name
        $direct_data[$i][2] = $data_list[1];
        //帳簿数 number of units in the book
        $direct_data[$i][3] = $data_list[2];
        $i++;
    }

	//CSVファイル名 csv file name
	//倉庫リンク判定  determine warehouse link
	if($ware_id == "all"){
		//全倉庫 all warehouse
		$csv_file_name = "棚卸調査票".date("Ymd")."全倉庫.csv";
	}else{
		//各倉庫 each warehouse
		$csv_file_name = "棚卸調査票".date("Ymd").$direct_data[0][0].".csv";
	}
    //CSVヘッダ作成 create CSV header
    $csv_header = array(
        "倉庫名", 
        "商品コード", 
        "商品名",
        "帳簿数",
    );
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($direct_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}


//倉庫一覧のテーブルを表示 display the table of warehouse list
$sql2  = "SELECT ";
$sql2 .= "    t_invent.invent_no ";
$sql2 .= "FROM ";
$sql2 .= "    t_invent ";
$sql2 .= "WHERE ";
$sql2 .= "    t_invent.renew_flg = 'f' ";
$sql2 .= "AND ";
$sql2 .= "    t_invent.shop_id = $shop_id ";
$sql2 .= ";";

$result2 = Db_Query($db_con, $sql2);
$invent_no = @pg_fetch_result($result2, 0, 0);


/****************************/
//HTMLヘッダ HTML header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成 create menu
/****************************/
//$page_menu = Create_Menu_f('stock','2');

/****************************/
//画面ヘッダー作成 create screen header
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex["4_201_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["4_205_button"]]->toHtml();
$page_header = Create_Header($page_title);





// Render関連の設定 render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign form related variable
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign assign other variables
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'err_mess'      => "$err_mess",
    'invent_no'     => "$invent_no",
    'group_kind'    => "$group_kind",
));

//変数をassign assign variblaes
$smarty->assign("data1", $row1);
$smarty->assign("data2", $row2);
$smarty->assign("disp", $disp_flg);


//テンプレートへ値を渡す pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


/**
 *
 * 棚卸調査表に出力する商品取得SQL SQL that will acquire the product that will be outputted in the stocktaking survey chart
 *
 * @param       resource    $db_con     DBコネクション DB connection
 * @param       int         $client_id  取引先ID trade partner ID
 *
 * @return      resource    結果リソース result resource
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/04/27)
 *
 */
function Get_Invent_Data($db_con, $client_id) {

    //棚卸調査表番号、棚卸日、対象商品取得 stocktaking survery chart number, stocktaking date, acquire corresponding product
    $sql  = "SELECT ";
    $sql .= "    distinct ";
    $sql .= "    invent_no, ";
    $sql .= "    expected_day, ";
    $sql .= "    target_goods ";
    $sql .= "FROM ";
    $sql .= "    t_invent ";
    $sql .= "WHERE ";
    $sql .= "    shop_id = $client_id ";
    //$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $client_id ";
    $sql .= "AND ";
    $sql .= "    renew_flg = 'f' ";
    $sql .= ";";

    return Db_Query($db_con, $sql);

}


/**
 *
 * 棚卸調査表作成後に表示するテーブルのデータ作成 create data that for the table that will be display after the stocktaking survey chart is created
 *
 * @param       resource    $db_con     DBコネクション connection
 * @param       int         $client_id  取引先ID trade partner ID
 *
 * @return      array       テーブルのデータ table's data
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/04/27)
 *
 */
function Make_Utable($db_con, $client_id) {

    $result = Get_Invent_Data($db_con, $client_id);

    //対象商品をコードから文字列に turn the corresponding product from code to string
    if(pg_fetch_result($result, 0, "target_goods") == 1) {
        $str = "全商品";
    } elseif (pg_fetch_result($result, 0, "target_goods") == 2) {
        $str = "在庫数0以外";
    } else if (pg_fetch_result($result, 0, "target_goods") == 3) {
        $str = "在庫数0";
    }

    $row1 = array(
        pg_fetch_result($result, 0, "expected_day"), 
        pg_fetch_result($result, 0, "invent_no"), 
        $str
    );


    //倉庫一覧のテーブルを表示 display the table of warehouse list 
    $sql2  = "SELECT ";
    $sql2 .= "    t_invent.invent_no, ";
    $sql2 .= "    t_invent.ware_id, ";
    $sql2 .= "    t_invent.ware_name, ";

    //1.0.3(06-05-10) watanabe-k：棚卸入力をしていない場合は差異一覧リンクを表示しない。do not display the difference link if thre is no stocktakin input
/*
    $sql2 .= "    CASE";
    $sql2 .= "       WHEN exec_day IS NULL THEN 'f'";
    $sql2 .= "       ELSE 't'";
    $sql2 .= "    END AS input_flg, ";
*/
    $sql2 .= "    CASE contents1.all_num ";
    $sql2 .= "       WHEN contents2.input_num THEN true ";  //全件数と棚卸実施者が入力されてるレコード数が同じだと入力完了 complete input if all items and the number of records inputted by the user doing the stocktaking is the same
    $sql2 .= "       ELSE false ";                          //それ以外はまだ if not then not yet done
    $sql2 .= "    END AS input_flg, ";

    $sql2 .= "    CASE ";
    $sql2 .= "        WHEN contents2.input_num = contents1.all_num THEN false ";    //全件数と棚卸実施者入力レコード数が同じ（全部入力）は完了 complete input if all items and the number of records inputted by the user doing the stocktaking is the same
    $sql2 .= "        WHEN contents2.input_num IS NULL THEN false ";                //棚卸実施者入力レコード数がnull（全部未入力）は未 if the number of reocrd inputted by the stocktaker is null (no input) then not yet done
    $sql2 .= "        ELSE true ";                                                  //それ以外（全件数と棚卸実施者入力レコード数が異なる）は一時入力 other than that (if all items and the inputted number of records by the stocktaker is different)
    $sql2 .= "    END AS temp_flg ";    //一時入力フラグ temporary input flag

    $sql2 .= "FROM ";
    $sql2 .= "    t_invent ";
    $sql2 .= "    INNER JOIN ";
    $sql2 .= "    ( ";
    $sql2 .= "        SELECT ";
    $sql2 .= "            invent_id, ";
    $sql2 .= "            COUNT(goods_id) AS all_num ";
    $sql2 .= "        FROM ";
    $sql2 .= "            t_contents ";
    $sql2 .= "        GROUP BY ";
    $sql2 .= "            invent_id ";
    $sql2 .= "    ) AS contents1 ON t_invent.invent_id = contents1.invent_id ";
    $sql2 .= "    LEFT JOIN ";
    $sql2 .= "    ( ";
    $sql2 .= "        SELECT ";
    $sql2 .= "            invent_id, ";
    $sql2 .= "            COUNT(goods_id) AS input_num ";
    $sql2 .= "        FROM ";
    $sql2 .= "            t_contents ";
    $sql2 .= "        WHERE ";
    $sql2 .= "            staff_id IS NOT NULL ";
    $sql2 .= "        GROUP BY ";
    $sql2 .= "            invent_id ";
    $sql2 .= "    ) AS contents2 ON t_invent.invent_id = contents2.invent_id ";

    $sql2 .= "WHERE ";
    $sql2 .= "    t_invent.renew_flg = 'f' ";
    $sql2 .= "AND ";
    $sql2 .= "    t_invent.shop_id = $client_id ";
//    $sql2 .= ($group_kind == "2") ? " t_invent.shop_id IN (".Rank_Sql().") " : " t_invent.shop_id = $client_id ";
    $sql2 .= "ORDER BY t_invent.ware_cd ";
    $sql2 .= ";";

    $result2 = Db_Query($db_con, $sql2);

/*
    while($array = pg_fetch_array($result2)) {
        $row2[] = array($array["invent_no"], $array["ware_id"], $array["ware_name"], $array["input_flg"]);
    }
*/
    $row2 = Get_Data($result2);

    return array($row1, $row2);

}


?>
