<?php
/********************************/
//変更履歴
//    ・単価改定時にスタッフ名も登録
//
//    (2006/07/06) shop_gidをなくした(kaji)
//    (2006/10/23) (kaji)
/*********************************/


/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-01-23     仕様変更　　watanabe-k　ボタンの色を変更
 *  2007-01-30     仕様変更　　watanabe-k　レンタル原価を追加
 *  2007-04-11     仕様変更　　watanabe-k　顧客区分単価を必須とする。
 *  2007-04-11     仕様変更　　  morita-d　「ＳＳ」「仕入先」の場合は単価を必須にしない(ハードコーディングにより実装)
 *  2007-08-25     仕様変更　　watanabe-k  商品同期関連の処理を削除
 *  2009/10/13                 hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *
*/



$page_title = "商品マスタ";

//環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //契約関連の関数

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");

//DBに接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//外部変数取得
/****************************/
//$shop_gid = $_SESSION["shop_gid"];
$shop_id = $_SESSION["client_id"];
$staff_id = $_SESSION["staff_id"];
$get_goods_id = $_GET["goods_id"];                          //GETした商品ID

/* GETしたIDの正当性チェック */
$where = " public_flg = 't' AND compose_flg = 'f' ";
if ($_GET["goods_id"] != null && Get_Id_Check_Db($conn, $_GET["goods_id"], "goods_id", "t_goods", "num", $where) != true){
    header("Location: ../top.php");
}

/****************************/
//スタッフ
/****************************/
$sql  = "SELECT";
$sql .= "   staff_name";
$sql .= " FROM";
$sql .= "   t_staff";
$sql .= " WHERE";
$sql .= "   staff_id = $staff_id";
$sql .= ";";

$result = Db_Query($conn, $sql);
$staff_name = pg_fetch_result($result, 0, 0);

/****************************/
//商品名を抽出
/****************************/
if($get_goods_id != null){
    $sql  = " SELECT";
    $sql .= "    t_goods.goods_name,";
    $sql .= "    t_goods.goods_cname,";
    $sql .= "    rental_flg ";
    $sql .= " FROM";
    $sql .= "   t_goods";
    $sql .= " WHERE";
    $sql .= "   goods_id = $get_goods_id";
    $sql .= "   AND";
    $sql .= "   public_flg = 't'";
    $sql .= "   AND\n";
    $sql .= "   compose_flg = 'f'\n";
    $sql .= "   AND\n";
    $sql .= "   shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   no_change_flg = 'f'\n";
    $sql .= ";"; 

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);

    $goods_name  = htmlspecialchars(pg_fetch_result($result,0,0));
    $goods_cname = htmlspecialchars(pg_fetch_result($result,0,1));
    $rental_flg  = pg_fetch_result($result, 0,2);
}else{
    header("Location: ../top.php");
}
////////////////////////////////一覧作成///////////////////////////////////////
if(isset($_POST["f_page1"])){
    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 10 - 10;
}else{
    $offset = 0;
}

$show_sql  = " SELECT";
$show_sql .= "   to_char(t_rprice.price_cday, 'yyyy-mm-dd') AS price_cday,\n";
$show_sql .= "   t_rank.rank_name,";
$show_sql .= "   t_rprice.price,";
$show_sql .= "   t_rprice.rprice,";
$show_sql .= "   t_rprice.staff_name";
$show_sql .= " FROM";
$show_sql .= "   t_rank,";
$show_sql .= "   t_price,";
$show_sql .= "   t_rprice";
$show_sql .= " WHERE";
$show_sql .= "   t_price.price_id = t_rprice.price_id";
$show_sql .= "   AND";
$show_sql .= "   t_price.rank_cd = t_rank.rank_cd";
$show_sql .= "   AND";
$show_sql .= "   t_rprice.rprice_flg = 't'";
$show_sql .= "   AND";
$show_sql .= "   t_price.goods_id = $get_goods_id";
$show_sql .= "   AND";
$show_sql .= "   t_price.rank_cd != '2'";
$show_sql .= "   AND";
$show_sql .= "   t_price.rank_cd != '3'";

//全件数取得用
$num_sql = $show_sql.";";

$num_result = Db_Query($conn, $num_sql);
$total_count = pg_num_rows($num_result);

$show_sql .= " ORDER BY t_rprice.price_cday DESC ,t_rank.rank_cd LIMIT 100 OFFSET $offset";
$show_sql .= ";";

$show_result = Db_Query($conn, $show_sql);
$show_num = pg_num_rows($show_result);
for($i = 0; $i < $show_num; $i++){
    $show_data[$i] = pg_fetch_array($show_result, $i, PGSQL_NUM);

    //スタッフ名をサニタイズ
    $show_data[$i][4] = htmlspecialchars($show_data[$i][4]);

}

///////////////////////////////単価登録/////////////////////////////////////

/****************************/
//Getチェック
/****************************/
Get_Id_Check3($_GET[goods_id]);

//商品マスタで商品として扱われているか？？
$sql  = "SELECT \n";
$sql .= "   goods_id \n";
$sql .= "FROM \n";
$sql .= "   t_goods \n";
$sql .= "WHERE \n";
$sql .= "   t_goods.goods_id = $get_goods_id\n";
$sql .= "   AND\n";
$sql .= "   compose_flg = 'f'\n";
$sql .= "   AND\n";
$sql .= "   shop_id = $shop_id\n";
$sql .= "   AND\n";
$sql .= "   no_change_flg = 'f'\n";
$sql .= ";\n";   

$result = Db_Query($conn, $sql);
Get_Id_Check($result);

/****************************/
//登録データを抽出
/****************************/
$sql  = "SELECT\n";
$sql .= "    t_rank_price.r_price,\n";
$sql .= "    t_rank_price.rprice,\n";
$sql .= "    to_char(t_rank_price.price_cday, 'yyyy-mm-dd') AS price_cday,\n";
$sql .= "    t_rank_data.rank_name,\n";
$sql .= "    t_rank_data.rank_cd\n";
$sql .= " FROM\n";
$sql .= "   (SELECT\n";
$sql .= "        rank_cd,\n";
$sql .= "        rank_name,\n";
$sql .= "        disp_flg\n";
$sql .= "    FROM\n";
$sql .= "        t_rank\n";
$sql .= "    WHERE\n";
$sql .= "        rank_cd != '2'\n";
$sql .= "        AND\n";
$sql .= "        rank_cd != '3'\n";
$sql .= "        AND\n";
$sql .= "        rank_cd != '0000'\n";
$sql .= "   ) AS t_rank_data\n";
$sql .= "   LEFT JOIN\n";
$sql .= "   (SELECT\n";
$sql .= "       t_price.rank_cd,\n";
$sql .= "       t_price.r_price,\n";
$sql .= "       t_rprice_n.rprice,\n";
$sql .= "       t_rprice_n.price_cday\n";
$sql .= "   FROM t_rank,\n";
$sql .= "       t_price\n";
$sql .= "       LEFT JOIN\n";
$sql .= "       (SELECT * FROM t_rprice WHERE rprice_flg = 'f' ) AS t_rprice_n\n";
$sql .= "        ON t_price.price_id = t_rprice_n.price_id\n";
$sql .= "   WHERE\n";
$sql .= "       t_price.shop_id = $shop_id\n";
$sql .= "       AND\n";
$sql .= "       t_price.goods_id = $get_goods_id\n";
$sql .= "       AND\n";
$sql .= "    t_price.rank_cd = t_rank.rank_cd) AS t_rank_price\n";
$sql .= " ON t_rank_data.rank_cd = t_rank_price.rank_cd\n";
$sql .= " ORDER BY t_rank_data.disp_flg, t_rank_data.rank_cd\n";
$sql .= " ; \n";

$result = Db_Query($conn, $sql);
$data_num = pg_num_rows($result);
if( $data_num!= 0){
    for($j = 0; $j < $data_num; $j++){
        $price_data[] = pg_fetch_array($result, $j);
    }
}

/******************************/
//データセット
/******************************/
for($i = 0; $i < $data_num; $i++){
    //現在単価
    if($price_data[$i][0] == null){

        //仕入単価、標準単価、顧客区分単価の場合
        if(($i == 0 || $i == 1 || $i > 3)
        //もしくは、
        ||
        //レンタル単価、原価はレンタル商品の場合のみ必須
        ($rental_flg == 't' && ($i == 2 || $i == 3))){

            //※ハードコーディング
            //「ＳＳ」「仕入先」の場合は単価を必須にしない
            //[特殊]も必須としないように修正
            if($price_data[$i][4] != "0005" && $price_data[$i][4] != "0100" && $price_data[$i][4] != "0055"){
                $required_flg[$i] = true;
            }
        }
    }

    $e_price[$i]    = explode(".", $price_data[$i][0]);
    $e_rprice[$i]   = explode(".", $price_data[$i][1]); 
    $e_cday[$i]     = explode("-", $price_data[$i][2]);

    $def_data["form_price"][$i]["i"]    = $e_price[$i][0];
    $def_data["form_price"][$i]["d"]    = $e_price[$i][1];
    $def_data["form_rprice"][$i]["i"]   = $e_rprice[$i][0];
    $def_data["form_rprice"][$i]["d"]   = $e_rprice[$i][1];
    $def_data["form_cost_rate"][$i]     = $price_data[$i]["cost_rate"];
    $def_data["form_cday"][$i]["y"]     = $e_cday[$i][0];
    $def_data["form_cday"][$i]["m"]     = $e_cday[$i][1];
    $def_data["form_cday"][$i]["d"]     = $e_cday[$i][2];
}

$form->setDefaults($def_data);

/******************************/
//新規設定判定
/******************************/
if($price_data[0][0] == null){
    $new_flg = true;
}else{
    $new_flg = false;

    $warning = "※改定日に本日を指定した場合、単価変更を即時行ないます。";
}
/******************************/
//フォーム作成
/******************************/
//単価
for($i = 0; $i < $data_num; $i++){

    //現在単価
    if($price_data[$i][0] == null){
        $price[$i][] =& $form->createElement(
            "text","i","","size=\"11\" maxLength=\"9\"
            onkeyup=\"Default_focus(this.form,this,'form_price[$i][d]',9)\"
            $g_form_option
            style=\"text-align: right; $g_form_style\""
        );
        $price[$i][] =& $form->createElement("static","","","."    );
        $price[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\"
            $g_form_option
            style=\"text-align: left; $g_form_style\""
        );
        $form->addGroup( $price[$i], "form_price[$i]", $price_data[$i][3]);
    }else{
        $dprice[$i][] =& $form->createElement(
            "static","i","",""
        );      
        $dprice[$i][] =& $form->createElement(
            "static","d","",""
        );
        $form->addGroup( $dprice[$i], "form_price[$i]", $price_data[$i][3],".");
            //改定単価
            $rprice[$i][] =& $form->createElement(
                "text","i","","size=\"11\" maxLength=\"9\"
                onkeyup=\"Default_focus(this.form,this,'form_rprice[$i][d]',9);\"
                $g_form_option
                style=\"text-align: right; $g_form_style\""
            );
            $rprice[$i][] =& $form->createElement("static","","","."    );
            $rprice[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\"
                $g_form_option
                style=\"text-align: left; $g_form_style\""
            );
            $form->addGroup( $rprice[$i], "form_rprice[$i]", "");   

        //掛率
        $form->addElement(
                "text","form_cost_rate[$i]","","size=\"3\" maxLength=\"3\" 
                style=\"text-align: right ;$g_form_style\"
                onkeyup=\"cost_rate('$i','".$price_data[1][0]."');\" 
                $g_form_option"
                );

        //改訂日
        $date[$i][] =& $form->createElement(
                "text","y","","size=\"4\" maxLength=\"4\"
                style=\"$g_form_style\"
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onkeyup=\"move_text(this.form,'form_cday[$i]','y','m',1)\" 
                onBlur=\"blurForm(this)\""
            );
        $date[$i][] =& $form->createElement(
                "static","","","-"
            );
        $date[$i][] =& $form->createElement(
                "text","m","","size=\"2\" maxLength=\"2\" 
                style=\"$g_form_style\"
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onkeyup=\"move_text(this.form,'form_cday[$i]','m','d',2)\"
                onBlur=\"blurForm(this)\""
            );
        $date[$i][] =& $form->createElement(
                "static","","","-"
            );
        $date[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\" 
                style=\"$g_form_style\"
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onBlur=\"blurForm(this)\""
            );
        $form->addGroup( $date[$i],"form_cday[$i]","");
    }
}

$form->addElement(
    "button","new_button","登録画面",
    "onClick=\"javascript:location.href='1-1-221.php'\""
);
$form->addElement(
    "button","change_button","変更・一覧",
    "onClick=\"javascript:location.href='1-1-220.php'\"");
$form->addElement(
    "button","form_set_price_button","単価設定",
    $g_button_color." 
    onClick='javascript:location.href = \"./1-1-222.php?goods_id=$get_goods_id\"'"
);

//改定単価用エラーフォーム
$form->addElement("text", "rprice_err","");

//改定日用エラーフォーム
$form->addElement("text", "cday_err","");

//改定単価、改定日必須チェックエラーフォーム
$form->addElement("text", "duble_err","");

/*******************************/
//ボタン押下処理
/*******************************/
if($_POST["form_entry_button"] == "登　録"){
    for($i = 0; $i < $data_num; $i++){

        //現在単価
        $price_i[$i] = $_POST["form_price"][$i]["i"];
        $price_d[$i] = $_POST["form_price"][$i]["d"];
        //改定単価
        $rprice_i[$i] = $_POST["form_rprice"][$i]["i"];
        $rprice_d[$i] = $_POST["form_rprice"][$i]["d"];
        //掛け率
        $cost_rate[$i] = $_POST["form_cost_rate"][$i]; 
        //改訂日
        $cday_y[$i] = $_POST["form_cday"][$i]["y"];
        $cday_m[$i] = $_POST["form_cday"][$i]["m"];
        $cday_d[$i] = $_POST["form_cday"][$i]["d"];


        //現在単価
        if($price_data[$i][0] == null){

            //仕入単価、標準単価、顧客区分単価の場合
            if(($i == 0 || $i == 1 || $i > 3)
            //もしくは、
            ||
            //レンタル単価、原価はレンタル商品の場合のみ必須
            ($rental_flg == 't' && ($i == 2 || $i == 3))){
                //●必須チェック

                //※ハードコーディング
                //「ＳＳ」「仕入先」の場合は単価を必須にしない
                if($price_data[$i][4] != "0005" && $price_data[$i][4] != "0100" && $price_data[$i][4] != "0055"){

                    $form->addGroupRule("form_price[$i]", array(
                        'i' => array(
                            array("".$price_data[$i][3]."の現在単価は半角数字のみ必須入力です。", 'required')
                        ),      
                    ));
                }
            }
        }

            //●数字チェック
            $form->addGroupRule("form_price[$i]", array(
                'i' => array(
                        array("".$price_data[$i][3]."の現在単価は半角数字のみ必須入力です。", 'regex', "/^[0-9]+$/")
                ),      
                'd' => array(
                        array("".$price_data[$i][3]."の現在単価は半角数字のみ必須入力です。", 'regex', "/^[0-9]+$/")
                ),      
            ));
//            $form->addGroupRule("form_price[$i]",$price_data[$i][3]."の現在単価は半角数字のみ必須入力です。","regex", "/^[0-9]+$/");

            //■改定単価
            //●数字チェック
            if(($rprice_i[$i] != null && !ereg("^[0-9]+$", $rprice_i[$i]))
                || 
            ($rprice_d[$i] != null && !ereg("^[0-9]+$", $rprice_d[$i]))
            ){
                $form->setElementError("rprice_err","改定単価は半角数字のみです。");
            }

            //■単価改定日
            //●数字チェック
            if(($cday_y[$i] != null  && !ereg("^[0-9]+$", $cday_y[$i]))
                || 
            ($cday_m[$i] != null && !ereg("^[0-9]+$", $cday_m[$i]))
                || 
            ($cday_d[$i] != null && !ereg("^[0-9]+$", $cday_d[$i]))
            ){
                $form->setElementError("cday_err","改定日は半角数字のみです。");
            }

            //●必須チェック
            if(
            (($rprice_i[$i] != null)
                && 
            ($cday_y[$i] == null || $cday_m[$i] == null || $cday_d[$i] == null))
                ||
            (($rprice_i[$i] == null)
                && 
            ($cday_y[$i] != null || $cday_m[$i] != null || $cday_d[$i] != null))
            ){
                $form->setElementError("duble_err","改定単価の変更に、改定単価と改定日は必須入力です。");
            }
    
            //●日付妥当性チェック
            if(($cday_y[$i] != null || $cday_m[$i] != null || $cday_d[$i] != null)
                && 
            (!checkdate((int)$cday_m[$i], (int)$cday_d[$i], (int)$cday_y[$i]))
            ){
                $form->setElementError("cday_err","改定日は半角数字のみです。");
            }

            //●日付チェック（過去の日付はerror）
            if(($cday_y[$i] != null || $cday_m[$i] != null || $cday_d[$i] != null)
            &&
            ($cday_y[$i]."-".$cday_m[$i]."-".$cday_d[$i] < date("Y-m-d"))
            ){
                $form->setElementError("cday_err","改定日は半角数字のみです。");
            } 
    }

    if($form->validate() && $err_flg != true){
    
        /*****************************/
        //登録処理開始
        /*****************************/
        Db_Query($conn, "BEGIN");

        /*****************************/
        //現在単価登録
        /*****************************/
        //単価マスタに登録がない場合
        for($i = 0; $i < $data_num; $i++){
            if($price_i[$i] != null){
                //登録の有無を確認
                $sql  = "SELECT \n";
                $sql .= "   COUNT(price_id) \n";
                $sql .= "FROM \n";
                $sql .= "   t_price \n";
                $sql .= "WHERE \n";
                $sql .= "   shop_id = $shop_id \n";
                $sql .= "   AND \n";
                $sql .= "   goods_id = $get_goods_id \n";
                $sql .= "   AND \n";
                $sql .= "   rank_cd = '".$price_data[$i][4]."' ";
                $sql .= ";";
                $result = Db_Query($conn, $sql);
                $add_num = pg_fetch_result($result, 0,0);

                //既に登録済みの場合
                if($add_num > 0){
                    continue;
                }

                $insert_sql  = " INSERT INTO t_price(";
                $insert_sql .= "    price_id,";
                $insert_sql .= "    goods_id,";
                $insert_sql .= "    rank_cd,";
                $insert_sql .= "    r_price,";
                //$insert_sql .= "    shop_gid";
                $insert_sql .= "    shop_id";
                $insert_sql .= " )VALUES(";
                $insert_sql .= "    (SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),";
                $insert_sql .= "    $get_goods_id,";
                $insert_sql .= "    '".$price_data[$i][4]."',";
                $insert_sql .= "    $price_i[$i].$price_d[$i],";
                //$insert_sql .= "    $shop_gid";
                $insert_sql .= "    $shop_id";
                $insert_sql .= ");";

                $result = Db_Query($conn, $insert_sql);

                if($result === false){
                    Db_Query($conn, "ROLLBACK");
                    exit;
                }
            }
        }

        //入力されたデータ分ループ
        for($i = 0; $i < $data_num; $i++){
            if($price_i[$i] != null && $i > 2){
                /*
                $sql  = "SELECT";
                $sql .= "   shop_gid";
                $sql .= " FROM";
                $sql .= "   t_shop_gr";
                $sql .= " WHERE";
                $sql .= "   rank_cd = '".$price_data[$i][4]."'";
                $sql .= ";";
                */
                //顧客区分が合致する全FCのclient_idを取得
                $sql  = "SELECT \n";
                $sql .= "    t_client.client_id \n";
                $sql .= "FROM \n";
                $sql .= "    t_rank \n";
                $sql .= "    INNER JOIN t_client ON t_rank.rank_cd = t_client.rank_cd \n";
                $sql .= "WHERE \n";
                $sql .= "    t_client.client_div = '3' \n";
                $sql .= "    AND \n";
                $sql .= "    t_client.rank_cd = '".$price_data[$i][4]."'\n";
                $sql .= ";";

                $res = Db_Query($conn, $sql);
                $num = pg_num_rows($res);

                $sql  = "SELECT";
                $sql .= "   group_kind";
                $sql .= " FROM";
                $sql .= "   t_rank";
                $sql .= " WHERE";
                $sql .= "   rank_cd = '".$price_data[$i][4]."'";
                $sql .= ";";

                $result = Db_Query($conn, $sql);
                $group_kind = pg_fetch_result($result , 0);

                //グループ種別を取得
                if($group_kind == '2'){
                    $num = 1;
                }

                //グループ分ループ
                for($k = 0; $k < $num; $k++){
                    $rank_shop_id = pg_fetch_result($res,$k,0);

                    /*****************************/
                    //営業・在庫単価登録
                    /*****************************/
                    for($j = 2; $j < 4; $j++){
                        $insert_sql  = "INSERT INTO t_price (";
                        $insert_sql .= "    price_id,";
                        $insert_sql .= "    goods_id,";
                        $insert_sql .= "    rank_cd,";
                        $insert_sql .= "    r_price,";
                        //$insert_sql .= "    shop_gid";
                        $insert_sql .= "    shop_id";
                        $insert_sql .= ")VALUES(";
                        $insert_sql .= "    (SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),";
                        $insert_sql .= "    $get_goods_id,";
                        $insert_sql .= "    '$j',";
                        $insert_sql .= "    (SELECT";
                        $insert_sql .= "        r_price";
                        $insert_sql .= "     FROM";
                        $insert_sql .= "        t_price";
                        $insert_sql .= "     WHERE";
                        $insert_sql .= "        rank_cd = '".$price_data[$i][4]."'";
                        $insert_sql .= "        AND";
                        //$insert_sql .= "        shop_gid = $shop_gid";
                        $insert_sql .= "        shop_id = $shop_id";
                        $insert_sql .= "        AND";
                        $insert_sql .= "        goods_id = $get_goods_id";
                        $insert_sql .= "    ),";
                        $insert_sql .= "    $rank_shop_id";
                        $insert_sql .= ");";

                        $result = Db_Query($conn, $insert_sql);
                        if($result === false){
                            Db_Query($conn, "ROLLBACK;");
                            exit;
                        }
                    } 
                    //ショップ別商品情報テーブル
                    $insert_sql  = "INSERT INTO t_goods_info (";
                    $insert_sql .= "    goods_id,";
                    $insert_sql .= "    compose_flg,";
                    $insert_sql .= "    head_fc_flg,";
                    //$insert_sql .= "    shop_gid";
                    #2009-10-13 hashimoto-y
                    $insert_sql .= "    stock_manage,";
                    
                    $insert_sql .= "    shop_id";
                    $insert_sql .= ")VALUES(";
                    $insert_sql .= "    $get_goods_id,";
                    $insert_sql .= "    'f',";
                    $insert_sql .= "    'f',";
                    $insert_sql .= "    (SELECT stock_manage FROM t_goods_info WHERE goods_id = $get_goods_id AND shop_id = $shop_id),";
                    $insert_sql .= "    $rank_shop_id";
                    $insert_sql .= ");";

                    $result = Db_Query($conn, $insert_sql);
                    if($result === false){
                        Db_Query($conn, "ROLLBACK");
                        exit;
                    }
                }
            }
        }

        /*******************************/
        //単価改定
        /*******************************/
        if($new_flg === false){
            for($i = 0; $i < $data_num; $i++){

                //単価改定テーブル内の未改定のデータを削除
                $delete_sql  = "DELETE FROM";
                $delete_sql .= "     t_rprice";
                $delete_sql .= " WHERE";
                $delete_sql .= "    price_id = (";
                $delete_sql .= "                SELECT";
                $delete_sql .= "                    price_id";
                $delete_sql .= "                FROM";
                $delete_sql .= "                    t_price";
                $delete_sql .= "                WHERE";
                //$delete_sql .= "                    shop_gid = $shop_gid";
                $delete_sql .= "                    shop_id = $shop_id";
                $delete_sql .= "                    AND";
                $delete_sql .= "                    goods_id = $get_goods_id";
                $delete_sql .= "                    AND";
                $delete_sql .= "                    rank_cd = '".$price_data[$i][4]."'";
                $delete_sql .= "    )";
                $delete_sql .= "    AND";
                $delete_sql .= "    rprice_flg = 'f'";
                $delete_sql .= ";";

                $result = Db_Query($conn, $delete_sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK");
                    exit;
                }
            }

            //単価改定日が今日以前の場合、すぐに反映する
            //今日の日付
            $today = date('Y-m-d');
            //単価改定テーブルに登録
            for($i = 0; $i < $data_num; $i++){
                //改定日を結合
                $cday_m[$i] = str_pad($cday_m[$i], 2, 0, STR_PAD_LEFT);
                $cday_d[$i] = str_pad($cday_d[$i], 2, 0, STR_PAD_LEFT);
                $cday       = $cday_y[$i]."-".$cday_m[$i]."-".$cday_d[$i];

                //改定日が今日以前か判定
                $cday_flg   = ($today >= $cday && $cday != "-00-00")? true : false;
                if($rprice_i[$i] != null){
                    
                    //単価改定テーブルに登録
                    $insert_sql  = " INSERT INTO t_rprice (\n";
                    $insert_sql .= "    price_id,\n";
                    $insert_sql .= "    price,\n";
                    $insert_sql .= "    rprice,\n";
                    $insert_sql .= "    price_cday,\n";
                    $insert_sql .= "    rprice_flg,\n";
                    $insert_sql .= "    staff_name\n";
                    $insert_sql .= " )VALUES(\n";
                    $insert_sql .= "    (SELECT\n";
                    $insert_sql .= "        price_id\n";
                    $insert_sql .= "    FROM\n";
                    $insert_sql .= "        t_price\n";
                    $insert_sql .= "    WHERE\n";
                    //$insert_sql .= "        shop_gid = $shop_gid";
                    $insert_sql .= "        shop_id = $shop_id\n";
                    $insert_sql .= "        AND\n";
                    $insert_sql .= "        goods_id = $get_goods_id\n";
                    $insert_sql .= "        AND\n";
                    $insert_sql .= "        rank_cd = '".$price_data[$i][4]."'\n";
                    $insert_sql .= "    ),\n";
                    $insert_sql .= "    (SELECT\n";
                    $insert_sql .= "        r_price\n";
                    $insert_sql .= "    FROM\n";
                    $insert_sql .= "        t_price\n";   
                    $insert_sql .= "    WHERE\n";
                    //$insert_sql .= "        shop_gid = $shop_gid";
                    $insert_sql .= "        shop_id = $shop_id\n";
                    $insert_sql .= "        AND\n";
                    $insert_sql .= "        goods_id = $get_goods_id\n";
                    $insert_sql .= "        AND\n";
                    $insert_sql .= "        rank_cd = '".$price_data[$i][4]."'\n";
                    $insert_sql .= "    ),\n";
                    $insert_sql .= "    $rprice_i[$i].$rprice_d[$i],\n";
                    if($cday_flg == true){
                        $insert_sql .= "now(),\n";
                    }else{
                        $insert_sql .= "    '$cday',\n";
                    }

                    //改定日に今日以前の日付が登録された場合
                    if($cday_flg == true){
                        $insert_sql .= "    't',\n";
                    //改定日が今日以降の場合
                    }else{
                        $insert_sql .= "    'f',\n";
                    }

                    $insert_sql .= "    '".addslashes($staff_name)."'\n";
                    $insert_sql .= ");\n";

                    $result = Db_Query($conn, $insert_sql);
                    if($result === false){
                        Db_Query($conn, "ROLLBACK");
                        exit;
                    }

                    //単価改定処理
                    if($cday_flg == true){
                        $sql  = "UPDATE";
                        $sql .= "   t_price ";
                        $sql .= "SET";
                        $sql .= "   r_price = $rprice_i[$i].$rprice_d[$i] ";
                        $sql .= "WHERE";
                        $sql .= "   price_id = (SELECT\n";
                        $sql .= "                   price_id\n";
                        $sql .= "               FROM\n";
                        $sql .= "                   t_price\n";
                        $sql .= "               WHERE\n";
                        $sql .= "                   shop_id = $shop_id\n";
                        $sql .= "                   AND\n";
                        $sql .= "                   goods_id = $get_goods_id\n";
                        $sql .= "                   AND\n";
                        $sql .= "                   rank_cd = '".$price_data[$i][4]."'";
                        $sql .= "               )\n";
                        $sql .= ";\n";
                    
                        $result = Db_Query($conn, $sql);
                        if($result === false){
                            Db_Query($conn, "ROLLBACK;");
                            exit;
                        }

/*
                        //単価の変更を契約マスタ、受注データに反映
                        //標準単価の場合のみ
                        if($price_data[$i][4] === '4'){
                            $result = Mst_Sync_Goods($conn,$get_goods_id,"price", "sale");
                            if($result === false){
                                exit;
                            }
                        }
*/
                    }
                } 
            }
        }
        Db_Query($conn, "COMMIT;");
        $freeze_flg = true;
    }
}

if($freeze_flg == true){
    $form->addElement("button","form_entry_button","Ｏ　Ｋ","onClick=\"location.href='./1-1-221.php'\"");
    $form->addElement("button","form_back_button","戻　る","onClick='javascript:location.href=\"./1-1-222.php?goods_id=$get_goods_id\"'");
    $form->freeze();
}else{
    //ボタン
    $form->addElement("submit","form_entry_button","登　録","onClick=\"javascript:return Dialogue('登録します。','#')\" $disabled");
    $form->addElement("button","form_back_button","戻　る","onClick='javascript:location.href = \"./1-1-221.php?goods_id=$get_goods_id\"'");
}

/****************************/
//javascript作成
/****************************/
$js  = "function cost_rate(num, price){ \n";
$js .= "    //フォーム名定義\n";
$js .= "    var PI = \"form_rprice\"+\"[\"+num+\"][i]\";\n";
$js .= "    var PD = \"form_rprice\"+\"[\"+num+\"][d]\";\n";
$js .= "    var CR = \"form_cost_rate\"+\"[\"+num+\"]\";\n";

$js .= "    //VALUE \n";
$js .= "    var PR  = eval(price);\n";
$js .= "    var CRV = document.dateForm.elements[CR].value;\n";

$js .= "    //それぞれのフォームが入力されていて、しかも整数の場合\n";
$js .= "    if(CRV != null && isNaN(CRV) == false && CRV != 0){\n";
$js .= "        //少数点以下を削除する。\n";
$js .= "        PR100 = eval(PR*100);\n";
$js .= "        CC = eval(CRV / 100); \n";

$js .= "        CP = eval(eval(PR100) * eval(CRV));\n";
$js .= "        PRICE = eval(CP / 100); \n";
$js .= "        PRICE = Math.floor(PRICE) / 100;\n";
$js .= "        PRICE = String(PRICE);\n";
$js .= "        PRICE_D = PRICE.split(\".\");\n";
$js .= "        if(PRICE_D[1] == undefined){\n";
$js .= "            PRICE_D[1] = \"00\"\n";
$js .= "        }\n"; 

$js .= "        document.dateForm.elements[PI].value = PRICE_D[0];\n";
$js .= "        document.dateForm.elements[PD].value = PRICE_D[1];\n";

$js .= "    }else if(CRV == ''){\n";
$js .= "        document.dateForm.elements[PI].value = \"\";\n";
$js .= "        document.dateForm.elements[PD].value = \"\";\n";
$js .= "    }else if(CRV == '0'){\n";
$js .= "        document.dateForm.elements[PI].value = \"0\";\n";
$js .= "        document.dateForm.elements[PD].value = \"00\"; \n";
$js .= "    }else if(isNaN(CRV) == true){\n";
$js .= "        document.dateForm.elements[PI].value = \"\";\n";
$js .= "        document.dateForm.elements[PD].value = \"\";\n";
$js .= "    }\n";

$js .= "}\n";

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
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
if($get_goods_id != null){
    $page_title .= "　".$form->_elements[$form->_elementIndex[form_set_price_button]]->toHtml();
}
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/
//表示範囲指定
$range = "100";

//ページ数を取得
$page_count = $_POST["f_page1"];

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);

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
    'goods_name'        => "$goods_name",
    'goods_cname'       => "$goods_cname",
    'new_flg'           => "$new_flg",
    'js'                => "$js",
    'auth_r_msg'        => "$auth_r_msg",
    'warning'           => "$warning",
    'rental_flg'        => "$rental_flg"
));
$smarty->assign('input_flg', $input_flg);
$smarty->assign('show_data', $show_data);
$smarty->assign("required_flg", $required_flg);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
