<?php
/*************************
変更履歴
    ・本部の変更履歴を表示しないように変更
    ・スタッフ名を単価改定テーブルに残す

    2006/07/06 shop_gidをなくす (kaji)
************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-06-26     仕様変更　　watanabe-k   単価の変更を契約マスタ、予定データに残すように修正
 *  2007-08-24     仕様変更　　watanabe-k   商品マスタ同期処理を行なわないように修正
 *  2015/05/13                  amano 	  Dialogue関数でボタン名が送られない IE11 バグ対応
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
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//外部変数取得
/****************************/
session_start();
//$shop_gid = $_SESSION["shop_gid"];
$shop_id = $_SESSION["client_id"];
$get_goods_id = $_GET["goods_id"];                          //GETした商品ID
Get_ID_Check2($get_goods_id);
$rank_cd  = $_SESSION["rank_cd"];
$staff_id = $_SESSION["staff_id"];
$group_kind = $_SESSION["group_kind"];

/*
$where  = " (rank_cd = '0003' OR ";
$where .= ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
$where .= " ) ";
if ($_GET["goods_id"] != null && Get_Id_Check_Db($conn, $_GET["goods_id"], "goods_id", "t_price", "num", $where) != true){
//    header("Location: ../top.php");
}
*/
// GETのIDチェック
if ($_GET["goods_id"] != null && ereg("^[0-9]+$", $_GET["goods_id"])){
    // 単価設定済商品の場合
    $sql  = "SELECT * \n";
    $sql .= "FROM   t_price \n";
    $sql .= "WHERE  goods_id = ".$_GET["goods_id"]." \n";
    $sql .= "AND    rank_cd = '0003' \n";
    $sql .= ";";
    $res  = Db_Query($conn, $sql);
    $num1 = pg_num_rows($res);
    // 単価未設定商品の場合
    $sql  = "SELECT * \n";
    $sql .= "FROM   t_goods \n";
    $sql .= "WHERE  goods_id = ".$_GET["goods_id"]." \n";
    $sql .= "AND    shop_id ";
    $sql .= ($_SESSION["group_kind"] == "2") ? "IN (".Rank_Sql().") \n"
                                             : "= ".$_SESSION["client_id"]." \n";
    $sql .= ";";
    $res  = Db_Query($conn, $sql);
    $num2 = pg_num_rows($res);
    // 結果
    if ($num1 == 0 && $num2 == 0){
        header("Location: ../top.php");
    }
}else{
    header("Location: ../top.php");
}

/****************************/
//登録時のスタッフ名を抽出
/****************************/
$sql  = "SELECT";
$sql .= "   staff_name"; 
$sql .= " FROM";
$sql .= "   t_staff";
$sql .= " WHERE";
$sql .= "   t_staff.staff_id = $staff_id";
$sql .= ";";

$result = Db_Query($conn, $sql);
$staff_name = pg_fetch_result($result, 0,0);

/****************************/
//商品名を抽出
/****************************/
/*
if($get_goods_id != null){
    $sql  = " SELECT";
    $sql .= "    t_goods.goods_name,";
    $sql .= "    t_goods.public_flg,";
    $sql .= "    t_goods.goods_cname";
    $sql .= " FROM";
    $sql .= "   t_goods";
    $sql .= " WHERE";
    $sql .= "   goods_id = $get_goods_id";
    $sql .= ";";
    $result = Db_Query($conn, $sql );
    //GetしたIDが不正な場合はmenuへ遷移
    Get_Id_Check($result);

    $goods_name = htmlspecialchars(pg_fetch_result($result,0,0));                 //商品名
    $public_flg = pg_fetch_result($result, 0,1);                                  //本部フラグ
    $goods_cname = htmlspecialchars(pg_fetch_result($result,0,2));                //略記
}else{
    header("location: ../top.php");
}

/****************************/
//商品名を抽出
/****************************/
$sql  = " SELECT";
$sql .= "    t_goods.goods_name,";
$sql .= "    t_goods.goods_cname,";
$sql .= "    t_goods.public_flg";
$sql .= " FROM";
$sql .= "   t_goods";
$sql .= " WHERE";
$sql .= "   goods_id = $get_goods_id";
$sql .= "   AND\n";
$sql .= "   compose_flg = 'f'\n";
$sql .= "   AND\n";
$sql .= "   no_change_flg = 'f'\n";
$sql .= ";"; 
$result = Db_Query($conn, $sql );
Get_ID_Check($result);
$goods_name = htmlspecialchars(pg_fetch_result($result,0,0));                 //商品名
$goods_cname = htmlspecialchars(pg_fetch_result($result,0,1));

/****************************/
//本部商品判定
/****************************/
$public_flg = pg_fetch_result($result,0,2);
if($public_flg == "t"){
    $head_flg = true;
}else{
    $head_flg = false;
}
///////////////////////////////一覧作成////////////////////////////////////////

if(isset($_POST["f_page1"])){
    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;
}else{
    $offset = 0;
}

//本部商品の場合
if($head_flg == true){
    $sql  = "SELECT\n";
    $sql .= "   to_char(t_rprice.price_cday, 'yyyy-mm-dd') AS price_cday,\n";
    $sql .= "   t_rank.rank_name,\n";
    $sql .= "   t_rprice.price,\n";
    $sql .= "   t_rprice.rprice,\n";
    $sql .= "   t_rprice.staff_name\n";
    $sql .= " FROM\n";
    $sql .= "    t_goods\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_price\n";
    $sql .= "    ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_rank\n";
    $sql .= "    ON t_price.rank_cd = t_rank.rank_cd\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_rprice\n";
    $sql .= "    ON t_price.price_id = t_rprice.price_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_goods.goods_id = $get_goods_id\n";
    $sql .= "   AND\n";
    $sql .= "   (t_price.rank_cd = '2'\n";
    $sql .= "   OR\n";
    $sql .= "   t_price.rank_cd = '3'\n";
    $sql .= "    )\n";
    $sql .= "   AND\n";
    //$sql .= "   t_price.shop_gid = $shop_gid\n";
//    $sql .= "   t_price.shop_id = $shop_id\n";
    $sql .= ($group_kind == '2')? "t_price.shop_id IN (".Rank_Sql().") " : "t_price.shop_id = $shop_id ";
    $sql .= "   AND\n";
    $sql .= "   t_rprice.rprice_flg = 't'\n";

//FC商品の場合
}else{

    $sql  = " SELECT\n";
    $sql .= "   to_char(t_rprice.price_cday, 'yyyy-mm-dd') AS price_cday,\n";
    $sql .= "   t_rank.rank_name,\n";
    $sql .= "   t_rprice.price,\n";
    $sql .= "   t_rprice.rprice,\n";
    $sql .= "   t_rprice.staff_name\n";
    $sql .= " FROM\n";
    $sql .= "    t_goods\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_price\n";
    $sql .= "    ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_rank\n";
    $sql .= "    ON t_price.rank_cd = t_rank.rank_cd\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_rprice\n";
    $sql .= "    ON t_price.price_id = t_rprice.price_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_goods.goods_id = $get_goods_id\n";
    $sql .= "   AND\n";
    $sql .= "   (t_price.rank_cd = '1'\n";
    $sql .= "   OR\n";
    $sql .= "   t_price.rank_cd = '2'\n";
    $sql .= "   OR\n";
    $sql .= "   t_price.rank_cd = '3'\n";
    $sql .= "   OR\n";
    $sql .= "   t_price.rank_cd = '4'\n";
    $sql .= "   )\n";
    $sql .= "   AND\n";
    //$sql .= "   t_price.shop_gid = $shop_gid\n";
//    $sql .= "   t_price.shop_id = $shop_id\n";
    $sql .= ($group_kind == 2)? " t_price.shop_id IN (".Rank_Sql().")" : " t_price.shop_id = ".$shop_id."";
    $sql .= "   AND\n";
    $sql .= "   t_rprice.rprice_flg = 't'\n";
    
}

//全件数取得用
$num_sql = $sql.";";

$result = Db_Query($conn, $num_sql);
$total_count = pg_num_rows($result);

$sql .= " ORDER BY t_rprice.price_cday DESC, t_price.rank_cd";
$sql .= " LIMIT 100 OFFSET $offset";
$sql .= ";"; 

$result = Db_Query($conn, $sql);
$show_num = pg_num_rows($result);
for($i = 0; $i < $show_num; $i++){
    $page_data[$i] = pg_fetch_array($result, $i, PGSQL_NUM);
    $page_data[$i][4] = htmlspecialchars($page_data[$i][4]);
}

/****************************/
//ページ作成
/****************************/

//表示範囲指定
$range = "100";

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);


/////////////////////////////単価登録/////////////////////////////////////////

/****************************/
//登録情報を抽出（表示用）
/****************************/
$sql  = " SELECT\n";
$sql .= "   t_price.r_price,\n";
$sql .= "   t_rprice_n.rprice,\n";
$sql .= "   to_char(t_rprice_n.price_cday, 'yyyy-mm-dd') AS price_cday,\n";
$sql .= "   t_price.rank_cd\n";
$sql .= " FROM\n";
$sql .= "   t_price\n";
$sql .= "   LEFT JOIN\n";
$sql .= "   (SELECT\n";
$sql .= "        *\n";
$sql .= "    FROM\n";
$sql .= "        t_rprice\n";
$sql .= "    WHERE\n";
$sql .= "        rprice_flg = 'f'\n";
$sql .= "   ) AS t_rprice_n\n";
$sql .= " ON t_price.price_id = t_rprice_n.price_id\n";
$sql .= " WHERE\n";
$sql .= "   t_price.goods_id = $get_goods_id\n";
$sql .= "   AND\n";

//FC商品の場合
if($head_flg === false){
    $sql .= "   (t_price.rank_cd = 1\n";
}else{
    $sql .= "   (t_price.rank_cd = '$rank_cd'\n";
}

$sql .= "   OR\n";
$sql .= "   t_price.rank_cd = 4\n";
$sql .= "   OR\n";
//$sql .= "   t_price.shop_gid = $shop_gid)";
//$sql .= "   t_price.shop_id = $shop_id)";
$sql .= ($group_kind == 2)? " t_price.shop_id IN (".Rank_Sql().") )\n" : " t_price.shop_id = ".$shop_id.")\n";
$sql .= " ORDER BY t_price.rank_cd\n";
$sql .= ";\n";

$result = Db_Query($conn, $sql);
$data_num = pg_num_rows($result);
if($data_num != 0){
    for($j = 0; $j < $data_num; $j++){
        $price_data[] = pg_fetch_array($result, $j, PGSQL_NUM);
    }
    $warning = "※改定日に本日を指定した場合、単価変更を即時行ないます。";
}
/****************************/
//データセット
/****************************/
for($i = 0; $i < pg_num_rows($result); $i++){

    //顧客区分単価を配列のキー0にセット
    if(strlen($price_data[$i][3]) == 4){
        //抽出したデータを表示形式に整形
        $show_price[0]  = explode(".", $price_data[$i][0]);
        $show_rprice[0] = explode(".", $price_data[$i][1]);
        $show_cday[0]   = explode("-", $price_data[$i][2]);

        //フォーム配列に表示データをセット
        $def_data["form_price"][0]["i"]  = $show_price[0][0];
        $def_data["form_price"][0]["d"]  = $show_price[0][1];
        $def_data["form_rprice"][0]["i"] = $show_rprice[0][0];
        $def_data["form_rprice"][0]["d"] = $show_rprice[0][1];
        $def_data["form_cday"][0]["y"]   = $show_cday[0][0];
        $def_data["form_cday"][0]["m"]   = $show_cday[0][1];
        $def_data["form_cday"][0]["d"]   = $show_cday[0][2];
    }else{

        $key = $price_data[$i][3]-1;

        //抽出したデータを表示形式に整形
        $show_price[$key]  = explode(".", $price_data[$i][0]);
        $show_rprice[$key] = explode(".", $price_data[$i][1]);
        $show_cday[$key]   = explode("-", $price_data[$i][2]);

        //フォーム配列に表示データをセット

        $def_data["form_price"][$key]["i"]  = $show_price[$key][0];
        $def_data["form_price"][$key]["d"]  = $show_price[$key][1];
        $def_data["form_rprice"][$key]["i"] = $show_rprice[$key][0];
        $def_data["form_rprice"][$key]["d"] = $show_rprice[$key][1];
        $def_data["form_cday"][$key]["y"]   = $show_cday[$key][0];
        $def_data["form_cday"][$key]["m"]   = $show_cday[$key][1];
        $def_data["form_cday"][$key]["d"]   = $show_cday[$key][2];
    }
}

$form->setDefaults($def_data);

/****************************/
//フォーム作成
/****************************/
//単価
$price_name = array("仕入原価", "営業原価", "在庫原価", "標準価格");

for($i = 0; $i < 4; $i++){
    //現在単価
    if(($head_flg == true && ($i == 0 || $i == 3)) || $show_price[$i][0] != null){
        $dprice[$i][] =& $form->createElement(
            "text","i","",'size="11" maxLength="9" 
            style="color : #525552; 
            border : #ffffff 1px
            solid; background-color: #ffffff;
            text-align: right"
            readonly'
        );
        $dprice[$i][] =& $form->createElement(
            "text","d","",'size="2" maxLength="2"
            style="color : #525552; 
            border : #ffffff 1px solid;
             background-color: #ffffff;
            text-align: left"
            readonly'
        );
        $form->addGroup( $dprice[$i], "form_price[$i]", $price_name[$i],".");
    }else{
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
        $form->addGroup( $price[$i], "form_price[$i]", $price_name[$i]);
    }    

    //改訂単価
    if(($head_flg == true && $i != 0 && $i != 3) || ($head_flg == false && $show_price[$i][0] != null)){

        $rprice[$i][] =& $form->createElement(
            "text","i","","size=\"11\" maxLength=\"9\"
            onkeyup=\"Default_focus(this.form,this,'form_rprice[$i][d]',9)\"
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
		        "text","form_cost_rate[$i]","",
                "size=\"3\" maxLength=\"3\" 
                style=\"text-align: right; $g_form_style\"
                onkeyup=\"cost_rate('$i','".$price_data[3][0]."');\"
		        $g_form_option"
		        );

    //改訂日
        $date[$i][] =& $form->createElement(
                "text","y","","size=\"4\" maxLength=\"4\" 
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onkeyup=\"move_text(this.form,'form_cday[$i]','y','m',1)\"
                onBlur=\"blurForm(this)\"
                style=\"$g_form_style\""
            );
        $date[$i][] =& $form->createElement(
                "static","","","-"
            );
        $date[$i][] =& $form->createElement(
                "text","m","","size=\"2\" maxLength=\"2\" 
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onkeyup=\"move_text(this.form,'form_cday[$i]','m','d',2)\"
                onBlur=\"blurForm(this)\"
                style=\"$g_form_style\""
            );
        $date[$i][] =& $form->createElement(
                "static","","","-"
            );
        $date[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\" 
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onBlur=\"blurForm(this)\"
                style=\"$g_form_style\""
            );
        $form->addGroup( $date[$i],"form_cday[$i]","");
    }
}

//ボタン
$form->addElement(
    "button","new_button","登録画面",
    "onClick=\"javascript:location.href='2-1-221.php'\"");
$form->addElement(
    "button","change_button","変更・一覧",
    "onClick=\"javascript:location.href='2-1-220.php'\"");
$form->addElement(
    "button","form_set_price_button","単価設定",
    $g_button_color."
     onClick='javascript:location.href = \"./2-1-222.php?goods_id=$get_goods_id\"'");


/****************************/
//ボタン押下処理
/****************************/
if($_POST["form_entry_button"] == "登　録"){

    /****************************/
    //POST取得
    /****************************/
    for($i = 0; $i < 4; $i++){
        $price_i[$i]  = $_POST["form_price"][$i]["i"];
        $price_d[$i]  = $_POST["form_price"][$i]["d"];
        $rprice_i[$i] = $_POST["form_rprice"][$i]["i"];
        $rprice_d[$i] = $_POST["form_rprice"][$i]["d"];
        $cday_y[$i]   = $_POST["form_cday"][$i]["y"];
        $cday_m[$i]   = $_POST["form_cday"][$i]["m"];
        $cday_d[$i]   = $_POST["form_cday"][$i]["d"];
    }

    /***************************/
    //ルール作成
    /***************************/
    for($i = 0; $i < 4; $i++){
        //■現在単価
        //●半角チェック
/*
        if(($price_i[$i] != null && !ereg("^[0-9]+$", $price_i[$i]))
            ||
           ($price_d[$i] != null && (!ereg("^[0-9]+$", $price_d[$i]) && $price_i[$i] != null))
        ){
            $price_err = "現在単価は半角数字のみです。";  
            $err_flg = true; 
            break;
        }
*/

        //●必須チェック
        $form->addGroupRule("form_price[$i]", array(
            'i' => array(
                    array("".$price_name[$i]."の現在単価は半角数字のみ必須入力です。", 'required'),
                    array("".$price_name[$i]."の現在単価は半角数字のみ必須入力です。", "regex", "/^[0-9]+$/")
            ),
            'd' => array(
                    array("".$price_name[$i]."の現在単価は半角数字のみ必須入力です。", "regex", "/^[0-9]+$/")
            ),
        ));
/*
        if($price_i[$i] != null && !ereg("^[0-9]+$", $price_i[$i])){
            $price_err = "現在単価は半角数字のみです。";  
            $err_flg = true; 
            break;
        }
*/
/*
        if($price_d[$i] != null){
            if(!ereg("^[0-9]+$", $price_d[$i]) || $price_i[$i] == null){
                $price_err = "現在単価は半角数字のみです。";  
                $err_flg = true; 
                break;
            }
        }
*/
        //●入力チェック
        if($price_i[$i] != null){
            $price_input_flg = true;
        }

        //■改訂単価
        //●半角チェック
        if(($rprice_i[$i] != null && !ereg("^[0-9]+$", $rprice_i[$i]))
            ||
           ($rprice_d[$i] != null && !ereg("^[0-9]+$", $rprice_d[$i]))
        ){
            $rprice_err = "改訂単価は半角数字のみです。";  
            $err_flg = true;
            break;
        }

        //●入力チェック
        if(($cday_y[$i] != null || $cday_m[$i] != null || $cday_d[$i]) && $rprice_i[$i] == null){
            $rprice_err = "改訂単価の変更に、改訂単価と改訂日は必須入力です。";
            $err_flg = true;
            break;
        }

        //■改訂日
        //●半角チェック
        if(($cday_y[$i] != null && !ereg("^[0-9]+$", $cday_y[$i]))
            ||
          ($cday_m[$i] != null && !ereg("^[0-9]+$", $cday_m[$i]))
            ||
          ($cday_d[$i] != null && !ereg("^[0-9]+$", $cday_m[$i]))
        ){
            $cday_err = "改訂日は半角数字のみです。";
            $err_flg = true;
            break;
        }

        //●入力チェック
        if($rprice_i[$i] != null && ($cday_y[$i] == null || $cday_m[$i] == null || $cday_d[$i] == null)){
            $cday_err = "改訂単価の変更に、改訂単価と改定日は必須入力です。";
            $err_flg = true;
            break;
        }elseif($cday_y[$i] != null || $cday_m[$i] != null || $cday_d[$i] != null){
            $input_flg[$i] = true;
        }

        //●日付妥当性チェック
        if(!checkdate((int)$cday_m[$i], (int)$cday_d[$i], (int)$cday_y[$i]) && $input_flg[$i] == true){
            $cday_err = "改訂日の日付は妥当ではありません。";
            $err_flg = true;
            break;
        }
 
        //●単価設定可能日付チェック
        if($cday_y[$i]."-".$cday_m[$i]."-".$cday_d[$i] < date("Y-m-d") && $input_flg[$i] == true){
            $cday_err = "改訂日の日付は妥当ではありません。";
            $err_flg = true;
            break;
        }

    }
    /****************************/
    //正常処理
    /****************************/
    if($err_flg != true && $form->validate()){


        Db_query($conn, "BEGIN;");

        /*******************************/
        //現在単価登録
        /*******************************/
        for($i = 0; $i < 4; $i++){

            $rank_cd = $i+1;        //FC区分コード
            //本部商品でない＆単価未登録＆現在単価に入力がある
            if($head_flg == false && $show_price[$i][0] == null && $price_i[$i] != null){
                $insert_sql  = " INSERT INTO t_price (";
                $insert_sql .= "    price_id,";
                $insert_sql .= "    goods_id,";
                $insert_sql .= "    rank_cd,";
                $insert_sql .= "    r_price,";
                //$insert_sql .= "    shop_gid";
                $insert_sql .= "    shop_id";
                $insert_sql .= " )VALUES(";
                $insert_sql .= "    (SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),";
                $insert_sql .= "    $get_goods_id,";
                $insert_sql .= "    '$rank_cd',";
                $insert_sql .= "    '$price_i[$i].$price_d[$i]',";
                //$insert_sql .= "    $shop_gid";
                $insert_sql .= "    $shop_id";
                $insert_sql .= ");";

                $result = Db_Query($conn, $insert_sql);
                
                //失敗した場合はロールバック
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }
            }
        }

        /*******************************/
        //改定単価
        /*******************************/
        for($i = 0; $i < 4; $i++){
//            if($input_flg[$i] == true){
                $rank_cd = $i+1;        //FC区分コード

                //単価改定テーブルの未改定のデータを削除
                $delete_sql  = " DELETE FROM ";
                $delete_sql .= "    t_rprice";
                $delete_sql .= " WHERE";
                $delete_sql .= "    price_id = (";
                $delete_sql .= "                SELECT";
                $delete_sql .= "                    price_id";
                $delete_sql .= "                FROM";
                $delete_sql .= "                    t_price";
                $delete_sql .= "                WHERE";
                //$delete_sql .= "                    shop_gid = $shop_gid";
//                $delete_sql .= "                    shop_id = $shop_id";
                $delete_sql .= ($group_kind == 2)? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
                $delete_sql .= "                    AND";
                $delete_sql .= "                    goods_id = $get_goods_id";
                $delete_sql .= "                    AND";
                $delete_sql .= "                    rank_cd = '$rank_cd'";
                $delete_sql .= "    )";
                $delete_sql .= "    AND";
                $delete_sql .= "    rprice_flg = 'f'";
                $delete_sql .= ";";

                $result = Db_Query($conn, $delete_sql);

                //失敗した場合はロールバック
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }
//            }
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
            $cday_flg   = ($today >= $cday && $cday != '-00-00')? true : false;

            if($input_flg[$i] == true){
                $rank_cd = $i+1;        //FC区分コード

                //本部商品である＆改定単価に入力がある
                //     OR
                //FC商品である＆改定単価に入力がある
                if(($head_flg == true && ($i != 0 || $i != 3) && $rprice_i[$i] != null) 
                    ||
                ($head_flg == false && $rprice_i[$i] != null)){
                    $insert_sql  = " INSERT INTO t_rprice (";
                    $insert_sql .= "    price_id,";
                    $insert_sql .= "    price,";
                    $insert_sql .= "    rprice,";
                    $insert_sql .= "    price_cday,";
                    $insert_sql .= "    rprice_flg,";
                    $insert_sql .= "    staff_name";
                    $insert_sql .= " )VALUES(";
                    $insert_sql .= "    (SELECT";
                    $insert_sql .= "        price_id";
                    $insert_sql .= "    FROM";
                    $insert_sql .= "        t_price";
                    $insert_sql .= "    WHERE";
                    //$insert_sql .= "        shop_gid = $shop_gid";
                    //$insert_sql .= "        shop_id = $shop_id";
                    $insert_sql .= ($group_kind == 2)? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
                    $insert_sql .= "        AND";
                    $insert_sql .= "        goods_id = $get_goods_id";
                    $insert_sql .= "        AND";
                    $insert_sql .= "        rank_cd = '$rank_cd'";
                    $insert_sql .= "    ),";
                    $insert_sql .= "    (SELECT";
                    $insert_sql .= "        r_price";
                    $insert_sql .= "    FROM";
                    $insert_sql .= "        t_price";
                    $insert_sql .= "    WHERE";
                    //$insert_sql .= "        shop_gid = $shop_gid";
//                    $insert_sql .= "        shop_id = $shop_id";
                    $insert_sql .= ($group_kind == 2)? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
                    $insert_sql .= "        AND";
                    $insert_sql .= "        goods_id = $get_goods_id";
                    $insert_sql .= "        AND";
                    $insert_sql .= "        rank_cd = '$rank_cd'";
                    $insert_sql .= "    ),";
                    $insert_sql .= "    $rprice_i[$i].$rprice_d[$i],";
                    if($cday_flg === true){
                        $insert_sql .= "    now(),";
                    }else{
                        $insert_sql .= "    '$cday',";
                    }
                    if($cday_flg === true){    
                        $insert_sql .= "    't',";
                    }else{
                        $insert_sql .= "    'f',";
                    }
                    $insert_sql .= "    '".addslashes($staff_name)."'";
                    $insert_sql .= ");";

                    $result = Db_Query($conn, $insert_sql);
                
                    //失敗した場合はロールバック
                    if($result === false){
                        Db_Query($conn, "ROLLBACK;");
                        exit;
                    }
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
                    $sql .= ($group_kind == 2)? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
//                    $sql .= "                   shop_id = $shop_id\n";
                    $sql .= "                   AND\n";
                    $sql .= "                   goods_id = $get_goods_id\n";
                    $sql .= "                   AND\n";
                    $sql .= "                   rank_cd = '".$rank_cd."'";
                    $sql .= "               )\n";
                    $sql .= ";\n";

                    $result = Db_Query($conn, $sql);
                    if($result === false){
                        Db_Query($conn, "ROLLBACK;");
                        exit;
                    }

/*
                    //単価の変更を契約マスタ、予定データに反映する。
                    //営業単価
                    if($rank_cd == '2'){
                        $result = Mst_Sync_Goods($conn,$get_goods_id,"price","buy");
                        if($result === false){
                            exit;
                        }
                    //標準売価の場合
                    }elseif($rank_cd == '4'){
                        $result = Mst_Sync_Goods($conn,$get_goods_id,"price","sale");
                        if($result === false){
                            exit;
                        }
                    }
*/
                }
            }
        }    
        Db_Query($conn, "COMMIT;");
        $freeze_flg = true;
    }
}

if($freeze_flg == true){
    $form->addElement("button","form_entry_button","Ｏ　Ｋ","onClick=\"location.href='./2-1-221.php'\"");
    $form->addElement("button","form_back_button","戻　る","onClick=\"javascript:history.back()\"");
    $form->freeze();

}else{
    //ボタン
    $form->addElement("submit","form_entry_button","登　録","onClick=\"javascript:return Dialogue('登録します。','#', this)\" $disabled");
    $form->addElement("button","form_back_button","戻　る","onClick='javascript:location.href = \"./2-1-221.php?goods_id=$get_goods_id\"'");
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
/****************************/$page_menu = Create_Menu_f('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
if($get_goods_id != null){
    $page_title .= "　".$form->_elements[$form->_elementIndex[form_set_price_button]]->toHtml();
}$page_header = Create_Header($page_title);

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
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
    'goods_name'    => "$goods_name",
    'goods_cname'   => "$goods_cname",
    'price_err'     => "$price_err",
    'rprice_err'    => "$rprice_err",
    'cday_err'      => "$cday_err",
    'js'            => "$js",
    'warning'       => "$warning",
));

$smarty->assign('page_data', $page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
