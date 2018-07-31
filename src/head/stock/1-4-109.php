<?php
/********************
 * 商品組立
 *
 *
 * 変更履歴
 *    2006/07/10 (kaji)
 *      ・shop_gidをなくす
 *
 *    2006/07/11 (ふ)
 *      ・製造品マスタに登録されている商品のみ組立可能に修正
 *      ・組立日を当日日付に修正
 *
 *    2006/08/12 (watanabe-k)
 *      ・組立日を指定できるように変更
 *    2006/10/13 (watanabe-k)
 *      ・在庫数抽出SQLでstock_cdに’-’を追加した。
 ********************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/22　008０　　　　 watanabe-k　組立日に2008/2/29と入力するとエラーが表示されるバグの修正
 * 　2006/11/22　0081　　　　  watanabe-k　倉庫名、部品名がサニタイズされていないバグの修正
 * 　2006/11/22　0082　　　　  watanabe-k　完成在庫数に引当倉庫の在庫数を表示しているバグの修正
 *   2006/12/06  ban_0018      suzuki      日付のゼロ埋め追加
 *   2007/02/28                watanabe-k　管理番号の登録を可能にし、登録した履歴を商品組立テーブルへ登録できるように修正
 *   2007/06/20                watanabe-k　商品コード入力ご、自動でカーソルが移動するように修正
 *  2009/10/12                 hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
*  2016/01/22                amano  Button_Submit, Dialogue 関数でボタン名が送られない IE11 バグ対応  
 */

$page_title = "商品組立";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/*******************************/
//外部変数取得
/*******************************/
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];

/*******************************/
//フォーム作成
/*******************************/
//組立日
$form_create_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_create_day[y]','form_create_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_create_day[y]','form_create_day[m]','form_create_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_create_day[] = $form->createElement("static","","","-");
$form_create_day[] = $form->createElement(
    "text","m","","size=\"1\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_create_day[m]','form_create_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_create_day[y]','form_create_day[m]','form_create_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_create_day[] = $form->createElement("static","","","-");
$form_create_day[] = $form->createElement(
    "text","d","",
    "size=\"1\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onFocus=\"onForm_today(this,this.form,'form_create_day[y]','form_create_day[m]','form_create_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$freeze[] = $form->addGroup( $form_create_day,"form_create_day","");

//商品コード
$freeze[] = $form->addElement(
    "text","form_goods_cd","",
    "size=\"10\" maxLength=\"8\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_goods_cd','form_goods_name',8)\" 
    onChange=\"javascrip:Button_Submit('input_goods_flg','#','t', this)\""
);
$freeze[] = $form->addElement(
    "text","form_goods_name","","size=\"34\" maxLength=\"30\" 
    readonly"
);

//組立数
$freeze[] = $form->addElement("text","form_create_num",""," size=\"11\" maxLength=\"9\" 
        style=\"$g_form_style text-align: right;\" $g_form_option");

//引落倉庫
$select_value = Select_Get($db_con, "ware");
$freeze[] = $form->addElement('select', 'form_output_ware',"", $select_value);

//入庫倉庫
$freeze[] = $form->addElement('select', 'form_input_ware',"", $select_value);

//表示
$form->addElement("submit","form_show_button","表　示");

//クリア
$form->addElement("button","form_clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//組立
$form->addElement("submit","form_create_button","組　立","onClick=\"javascript:return Dialogue('組立ます。','#', this)\"".$disabled);

//組立管理番号
$form->addElement("text","form_build_no",""," size=\"10\" maxLength=\"8\" 
        style=\"$g_form_style text-align: left;\" $g_form_option");

//hidden
$form->addElement("hidden","hdn_goods_id","","");       // 抽出した商品ID
$form->addElement("hidden","hdn_create_num","","");     // POSTで取得した組立数
$form->addElement("hidden","hdn_output_ware","","");    // POSTで取得した入庫倉庫ID
$form->addElement("hidden","hdn_input_ware","","");     // POSTで取得した出庫倉庫ID
$form->addElement("hidden","hdn_validate_flg","","");   // 表示OKフラグ
$form->addElement("hidden","hdn_create_day","","");     // 組立数

$form->addElement("hidden","first_set_flg", "1","");    // 初期表示フラグ

$form->addElement("hidden","input_goods_flg","","");    //商品入力フラグ

//ヘッダボタン
$form->addElement("button", "list_button", "一　覧","onClick=\"location.href='./1-4-115.php'\"");
$form->addElement("button", "new_button", "登　録",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");


/*****************************/
//イベント判別
/*****************************/
$first_set_flg      = ($_POST["first_set_flg"] != 1)? true : false;
$show_button_flg    = ($_POST["form_show_button"] == "表　示")? true : false;
$add_button_flg     = ($_POST["form_create_button"] == "組　立")? true : false;
$input_goods_flg    = ($_POST["input_goods_flg"] == 't')? true : false;
$input_goods_flg    = ($first_set_flg == false && $show_button_flg == false && $add_button_flg == false && count($_POST) > 0 )? true : false;

/*****************************/
//初期表示処理
/*****************************/
if($first_set_flg == true){
    $def_build_no = New_Number($db_con);
    $def_data["form_build_no"] = $def_build_no;
    $form->setDefaults($def_data);
/****************************/
//商品コード入力
/****************************/
}elseif($input_goods_flg == true){
    $goods_cd = $_POST["form_goods_cd"];

    $sql  = "SELECT ";
    $sql .= "   t_goods.goods_name ";
    $sql .= "FROM ";
    $sql .= "   t_goods ";
    $sql .= "WHERE ";
    $sql .= "   goods_cd = '$goods_cd'";
    $sql .= "   AND ";
    $sql .= "   public_flg = 't' ";
    $sql .= "   AND ";
    $sql .= "   make_goods_flg = 't' ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 

    $count = pg_num_rows($result);
    if($count > 0){
        $goods_name = pg_fetch_result($result, 0,0);

        $set_data["form_goods_name"] = $goods_name;

        $sql  = "SELECT ";
        $sql .= "   t_make_goods.denominator, ";
        $sql .= "   t_make_goods.numerator ";
        $sql .= "FROM ";
        $sql .= "   t_make_goods ";
        $sql .= "WHERE ";
        $sql .= "   t_make_goods.goods_id = ";
        $sql .= "       (SELECT";
        $sql .= "           t_goods.goods_id ";
        $sql .= "       FROM ";
        $sql .= "           t_goods ";
        $sql .= "       WHERE ";
        $sql .= "           goods_cd = '$goods_cd'";
        $sql .= "           AND ";
        $sql .= "           public_flg = 't' ";
        $sql .= "           AND ";
        $sql .= "           make_goods_flg = 't' ";
        $sql .= "       )";            
        $sql .= ";";

        $result = Db_Query($db_con, $sql);     
        $goods_data = pg_fetch_all($result);

        $count = count($goods_data);

        //最小公倍数を求めるために配列を分ける
        for($i = 0; $i < $count; $i++){
            $ary_denomirator[$i] = $goods_data[$i]["denominator"];
            $ary_numerator[$i]   = $goods_data[$i]["numerator"];
        }

        //分母の最小公倍数を求める
        $common_denomirator = Get_Common_Num($ary_denomirator);    

        //組立数をセット
        $set_data["form_create_num"] = $common_denomirator;
    }

    //初期化
    $set_data["input_goods_flg"] = "";

/****************************/
//エラーチェック
/****************************/
}elseif($show_button_flg == true || $add_button_flg == true){

    /*********************************/
    //POST取得
    /*********************************/
    $goods_cd       = $_POST["form_goods_cd"];          //商品コード
    $goods_name     = $_POST["form_goods_name"];          //商品コード
    $create_num     = $_POST["form_create_num"];        //組立数
    $output_ware    = $_POST["form_output_ware"];       //引落倉庫
    $input_ware     = $_POST["form_input_ware"];        //入庫倉庫
    $create_day_y   = $_POST["form_create_day"]["y"];   //組立日（年）
    $create_day_m   = $_POST["form_create_day"]["m"];   //組立日（月）
    $create_day_d   = $_POST["form_create_day"]["d"];   //組立日（日）
	$create_day_y   = str_pad($create_day_y,4, 0, STR_PAD_LEFT);  
	$create_day_m   = str_pad($create_day_m,2, 0, STR_PAD_LEFT); 
	$create_day_d   = str_pad($create_day_d,2, 0, STR_PAD_LEFT); 
    $build_id       = (int)$_POST["form_build_no"];
    $build_no       = $_POST["form_build_no"];

    /******************************/
    //ルール作成
    /******************************/
    //■商品名
    //必須チェック
    $form->addRule("form_goods_name","正しい商品コードを入力して下さい。","required");

    //■組立数
    //必須チェック
    $form->addRule("form_create_num","組立数は半角数字のみ入力可能です。","required");
    //半角チェック
    $form->addRule("form_create_num","組立数は半角数字のみ入力可能です。", "regex", "/^[0-9]+$/");

    //■引落倉庫
    //必須チェック
    $form->addRule("form_output_ware","引落倉庫を選択して下さい。","required");

    //■入庫倉庫
    //必須チェック
    $form->addRule("form_input_ware","入庫倉庫を選択して下さい。","required");

    //■組立日
    //必須、半角チェック
    $form->addGroupRule('form_create_day', array(
        'y' => array(
            array('組立日の日付は妥当ではありません。', 'required'),
            array('組立日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")
        ),      
        'm' => array(
            array('組立日の日付は妥当ではありません。','required'),
            array('組立日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),      
        'd' => array(
            array('組立日の日付は妥当ではありません。','required'),
            array('組立日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        )         
    ));

    //日付妥当性チェック
    if(!checkdate((int)$create_day_m, (int)$create_day_d, (int)$create_day_y)){
        $form->setElementError('form_create_day',"組立日の日付は妥当ではありません。");
        $date_err = true;
    }else{
        //日付を結合
        $create_day_y = str_pad($create_day_y, 4, 0, STR_PAD_LEFT);
        $create_day_m = str_pad($create_day_m, 2, 0, STR_PAD_LEFT);
        $create_day_d = str_pad($create_day_d, 2, 0, STR_PAD_LEFT);
        $create_day = $create_day_y."-".$create_day_m."-".$create_day_d;

        $date_err = false;        
    }

    // 前回の月次更新日以前は駄目
    if($date_err == false){
        //前回の月次更新日を取得
        $sql  = "SELECT \n";
        $sql .= "    COALESCE(MAX(close_day), '".START_DAY."') \n";
        $sql .= "FROM \n";
        $sql .= "    t_sys_renew \n";
        $sql .= "WHERE \n";
        $sql .= "    shop_id = ".$shop_id." \n";
        $sql .= "    AND \n";
        $sql .= "    renew_div = '2' \n";
        $sql .= ";\n";

        $result = Db_Query($db_con, $sql);
        $renew_date = pg_fetch_result($result, 0, 0);
        $renew_date = ($renew_date == null) ? START_DAY : $renew_date;

        if ($renew_date >= $create_day){
            $form->setElementError("form_create_day", "組立日に月次更新日以前の日付は登録できません。");
        }
    }

    //■管理番号
    //必須チェック
    if($build_no == null){
        $form->setElementError("form_build_no","組立管理番号は半角数字のみ入力可能です。");
        $new_no = New_Number($db_con);
        $set_data["form_build_no"] = $new_no;
    //半角チェック
    }elseif(!ereg("^[0-9]+$", $build_no)){
        $form->setElementError("form_build_no","組立管理番号は半角数字のみ入力可能です。");
        $new_no = New_Number($db_con);
        $set_data["form_build_no"] = $new_no;
    //管理番号の重複チェック
    }else{
        $sql  = "SELECT" ;
        $sql .= "   COUNT(*) ";
        $sql .= "FROM ";
        $sql .= "   t_build ";
        $sql .= "WHERE ";
        $sql .= "   build_id = $build_id ";
        $sql .= ";";

        $result  = Db_Query($db_con, $sql);
        $add_num = pg_fetch_result($result, 0,0); 

        if($add_num > 0){
            $form->setElementError("form_build_no","".$build_no."は既に使用されています。");
            $new_no = New_Number($db_con);
            $set_data["form_build_no"] = $new_no;
        }
    }

    //商品情報チェック
    $sql  = "SELECT";
    $sql .= "   COUNT(goods_id) ";
    $sql .= "FROM ";
    $sql .= "   t_goods ";
    $sql .= "WHERE ";
    $sql .= "   goods_cd = '$goods_cd' ";
    $sql .= "   AND ";
    $sql .= "   goods_name = '$goods_name' ";
    $sql .= "   AND ";
    $sql .= "   shop_id = $shop_id ";
    $sql .= ";";
    $result = Db_Query($db_con ,$sql);
    $goods_num = pg_fetch_result($result,0,0);

    if($goods_num == 0){
        $form->setElementError("form_goods_name", "商品情報取得前に表示ボタンが押されました。操作をやり直してください。");
    }
}

/****************************/
//組立
/****************************/
if($add_button_flg == true && $form->validate()){

    $validate_flg   = $_POST["hdn_validate_flg"];

    $goods_id       = $_POST["hdn_goods_id"];
    $create_num     = $_POST["hdn_create_num"];
    $output_ware    = $_POST["hdn_output_ware"];
    $input_ware     = $_POST["hdn_input_ware"];
    for($i = 0; $i < count($_POST["hdn_parts_goods_id"]); $i++){
        $parts_goods_id[] = $_POST["hdn_parts_goods_id"][$i];
        $make_goods_num[] = $_POST["hdn_make_goods_num"][$i];
    }
    $create_day     = $_POST["hdn_create_day"];

    $build_no       = $_POST["form_build_no"];          //組立番号
    $build_id       = (int)$_POST["form_build_no"];     //組立ID

    Db_Query($db_con, "BEGIN");

    //組立履歴テーブルへ登録
    $sql  = "INSERT INTO t_build (";
    $sql .= "   build_id ,";
    $sql .= "   goods_id, ";
    $sql .= "   build_num, ";
    $sql .= "   build_day, ";
    $sql .= "   output_ware_id, ";
    $sql .= "   input_ware_id";
    $sql .= ")VALUES(";
    $sql .= "   $build_id, ";
    $sql .= "   $goods_id, ";
    $sql .= "   $create_num, ";
    $sql .= "   '$create_day', ";
    $sql .= "   $output_ware, ";
    $sql .= "   $input_ware ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){

        $sql_err   = pg_last_error();
        $rule_name = "t_build_pkey";

        Db_Query($db_con, "ROLLBACK;");

        if(strstr($sql_err, $rule_name)){
            $form->setElementError("form_build_no","".$build_no."は既に使用されています。");
            $duplicate_flg = true;
            $validate_flg = false;

            //番号を振りなおす
            $new_no = New_Number($db_con);

            $set_data["form_build_no"] = $new_no;
        }else{
            exit;
        }
    }

    //重複エラーが無い場合
    if($duplicate_flg != true){
        //在庫受払テーブルの更新（入庫）
        $sql  = "INSERT INTO t_stock_hand (";
        $sql .= "   goods_id,";
        $sql .= "   enter_day,";
        $sql .= "   work_day,";
        $sql .= "   work_div,";
        $sql .= "   ware_id,";
        $sql .= "   io_div,";
        $sql .= "   num,";
        $sql .= "   staff_id,";
        $sql .= "   shop_id,";
        $sql .= "   slip_no,";
        $sql .= "   build_id ";
        $sql .= ")VALUES(";
        $sql .= "   $goods_id,";
        $sql .= "   NOW(),";
        $sql .= "   '$create_day',";
        $sql .= "   '7',";
        $sql .= "   $input_ware,";
        $sql .= "   '1',";
        $sql .= "   $create_num,";
        $sql .= "   $staff_id,";
        $sql .= "   $shop_id,";
        $sql .= "   '$build_no',";
        $sql .= "   $build_id";
        $sql .= ");";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }

        //部品の現在個数を抽出
        for($i = 0; $i < count($parts_goods_id); $i++){
            //在庫受払テーブルの更新（入庫）
            $sql  = "INSERT INTO t_stock_hand (";
            $sql .= "   goods_id,";
            $sql .= "   enter_day,";
            $sql .= "   work_day,";
            $sql .= "   work_div,";
            $sql .= "   ware_id,";
            $sql .= "   io_div,";
            $sql .= "   num,";
            $sql .= "   staff_id,";
            $sql .= "   shop_id,";
            $sql .= "   slip_no,";
            $sql .= "   build_id ";
            $sql .= ")VALUES(";
            $sql .= "   $parts_goods_id[$i],";
            $sql .= "   NOW(),";
            $sql .= "   '$create_day',";
            $sql .= "   '7',";
            $sql .= "   $output_ware,";
            $sql .= "   '2',";
            $sql .= "   $make_goods_num[$i],";
            $sql .= "   $staff_id,";
            $sql .= "   $shop_id,";
            $sql .= "   '$build_no',";
            $sql .= "   $build_id";
            $sql .= ");";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }
        }
        Db_Query($db_con, "COMMIT");
//        Header("Location: $_SERVER[PHP_SELF]");
        Header("Location: ./1-4-116.php?build_id=$build_id&new_flg=true");
    }
}

/******************************/
//表示データ抽出
/******************************/
if(($form->validate() && $show_button_flg == true) || $add_button_flg == true){

    //商品IDをhiddenにセットするため商品マスタから以下の情報を抽出
    $sql  = "SELECT";
    $sql .= "   goods_id";
    $sql .= " FROM";
    $sql .= "   t_goods";
    $sql .= " WHERE";
    $sql .= "   shop_id = $shop_id";
    $sql .= "   AND";
    $sql .= "   goods_cd = '$goods_cd'";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $goods_id = pg_fetch_result($result,0,0);

    //出庫倉庫名を抽出
    $sql  = "SELECT";
    $sql .= "   ware_name";
    $sql .= " FROM";
    $sql .= "   t_ware";
    $sql .= " WHERE";
    $sql .= "   ware_id = $output_ware";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $output_ware_name = htmlspecialchars(pg_fetch_result($result, 0, 0));

    //入庫倉庫名を抽出
    $sql  = "SELECT";
    $sql .= "   ware_name";
    $sql .= " FROM";
    $sql .= "   t_ware";
    $sql .= " WHERE";
    $sql .= "   ware_id = $input_ware";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $input_ware_name = htmlspecialchars(pg_fetch_result($result, 0, 0));

    //完成品在庫数抽出
    $sql  = "SELECT\n";
    $sql .= "   COALESCE(t_stock.stock_num,0),\n";
    $sql .= "   COALESCE(t_stock.rstock_num,0)\n";
    $sql .= " FROM\n";
    $sql .= "   t_goods\n";
    $sql .= "       LEFT JOIN\n";
    //在庫受払テーブルより在庫数、引当数を抽出
    $sql .= "   (SELECT\n";
    $sql .= "       CASE\n";
    $sql .= "           WHEN t_stock.goods_id IS NOT NULL THEN t_stock.goods_id\n";
    $sql .= "           WHEN t_stock.goods_id IS NULL     THEN t_allowance.goods_id\n";
    $sql .= "       END AS goods_id,\n";
    $sql .= "       COALESCE(t_stock.stock_num,0)AS stock_num,\n";
    $sql .= "       COALESCE(t_allowance.allowance_num,0) AS rstock_num\n";
    $sql .= "   FROM\n";
    //在庫数を計算
    $sql .= "       (SELECT\n";
    $sql .= "           goods_id,\n";
    $sql .= "           ware_id,\n";
    $sql .= "           SUM(t_stock_hand.num * \n";
    $sql .= "                   CASE t_stock_hand.io_div\n";
    $sql .= "                       WHEN 1 THEN 1\n";
    $sql .= "                       WHEN 2 THEN -1\n";
    $sql .= "                   END\n";
    $sql .= "           ) AS stock_num,\n";
    $sql .= "           shop_id,\n";
    $sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd\n";
    $sql .= "       FROM\n";
    $sql .= "           t_stock_hand\n";
    $sql .= "       WHERE\n";
    $sql .= "           work_div NOT IN (1,3) \n";
    $sql .= "           AND\n";
    $sql .= "           work_day <= '$create_day'\n";
    $sql .= "           AND\n";
    $sql .= "           goods_id = $goods_id\n";
    $sql .= "           AND\n";
    $sql .= "           ware_id = $input_ware\n";
    $sql .= "           AND\n";
    $sql .= "           shop_id = $shop_id\n";
    $sql .= "       GROUP BY goods_id, ware_id, shop_id\n";
    $sql .= "       ) AS t_stock\n";
    $sql .= "   FULL OUTER JOIN\n";
    $sql .= "       (SELECT\n";
    $sql .= "           goods_id,\n";
    $sql .= "           ware_id,\n";
    $sql .= "           SUM(t_stock_hand.num * \n";
    $sql .= "                   CASE t_stock_hand.io_div\n";
    $sql .= "                       WHEN 1 THEN -1\n";
    $sql .= "                       WHEN 2 THEN 1\n";
    $sql .= "                   END\n";
    $sql .= "           ) AS allowance_num,\n";
    $sql .= "           shop_id,\n";
    $sql .= "           goods_id || '-' || ware_id || '-' || shop_id AS stock_cd\n";
    $sql .= "       FROM\n";
    $sql .= "           t_stock_hand\n";
    $sql .= "       WHERE\n";
    $sql .= "           work_div = '1'\n";
    $sql .= "           AND\n";
    $sql .= "           goods_id = $goods_id\n";
    $sql .= "           AND\n";
    $sql .= "           work_day <= '$create_day'\n";
    $sql .= "           AND\n";
    $sql .= "           ware_id = $input_ware\n";
    $sql .= "           AND\n";
    $sql .= "           shop_id = $shop_id\n";
    $sql .= "       GROUP BY goods_id, ware_id, shop_id\n";
    $sql .= "       )AS t_allowance\n";
    $sql .= "       ON t_stock.stock_cd = t_allowance.stock_cd\n";
    $sql .= "    )AS t_stock\n";
    $sql .= "    ON t_goods.goods_id = t_stock.goods_id \n";
    $sql .= "WHERE\n";
    $sql .= "   t_goods.goods_id = $goods_id";
    $sql .= ";\n";

    $result     = Db_Query($db_con, $sql);
    $stock_num  = @pg_fetch_result($result, 0,0);
    $rstock_num = @pg_fetch_result($result, 0,1);
    $stock_num  = ($stock_num != NULL)? $stock_num : 0;
    $rstock_num = ($rstock_num != NULL)? $rstock_num : 0;

    //部品在庫数を抽出
    $sql  = "SELECT\n";
    $sql .= "   make_goods.goods_id,\n";
    $sql .= "   make_goods.goods_cd,\n";
    $sql .= "   make_goods.goods_name,\n";
    $sql .= "   make_goods.denominator,\n";
    $sql .= "   make_goods.numerator,\n";
    $sql .= "   CASE make_goods.stock_manage\n";
    $sql .= "       WHEN '1' THEN ware_goods.stock_num\n";
    $sql .= "       WHEN '2' THEN null\n";
    $sql .= "   END\n";
    $sql .= " FROM\n";
    $sql .= "   (SELECT\n";
    $sql .= "       t_goods.goods_id,\n";
    $sql .= "       t_goods.goods_cd,\n";
    $sql .= "       t_goods.goods_name,\n";
    #2009-10-12 hashimoto-y
    #$sql .= "       t_goods.stock_manage,\n";
    $sql .= "       t_goods_info.stock_manage,\n";

    $sql .= "       t_make_goods.denominator,\n";
    $sql .= "       t_make_goods.numerator\n";
    $sql .= "   FROM\n";
    $sql .= "       t_goods\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_make_goods\n";
    $sql .= "       ON t_goods.goods_id = t_make_goods.parts_goods_id\n";
    #2009-10-12 hashimoto-y
    $sql .= "       INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

    $sql .= "   WHERE\n";
    $sql .= "       t_make_goods.goods_id = $goods_id\n";
    #2009-10-12 hashimoto-y
    $sql .= "   AND \n";
    $sql .= "   t_goods_info.shop_id = $shop_id ";

    $sql .= "   ) AS  make_goods\n";
    $sql .= "       LEFT JOIN\n";

    $sql .= "   (SELECT\n";
    $sql .= "       goods_id,\n";
    $sql .= "       SUM(t_stock_hand.num * \n";
    $sql .= "               CASE t_stock_hand.io_div\n";
    $sql .= "                   WHEN 1 THEN 1\n";
    $sql .= "                   WHEN 2 THEN -1\n";
    $sql .= "               END\n";
    $sql .= "       ) AS stock_num,\n";
    $sql .= "       shop_id,\n";
    $sql .= "       goods_id || '-' || ware_id || '-' || shop_id AS stock_cd\n";
    $sql .= "   FROM\n";
    $sql .= "       t_stock_hand\n";
    $sql .= "   WHERE\n";
    $sql .= "       work_div NOT IN (1,3) \n";
    $sql .= "       AND\n";
    $sql .= "       work_day <= '$create_day'\n";
    $sql .= "       AND\n";
    $sql .= "       ware_id = $output_ware\n";
    $sql .= "       AND\n";
    $sql .= "       shop_id = $shop_id\n";
    $sql .= "   GROUP BY goods_id, ware_id, shop_id\n";
    $sql .= "   ) AS ware_goods\n";
    $sql .= "   ON make_goods.goods_id = ware_goods.goods_id\n";
    $sql .= "   ORDER BY goods_cd ";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);
    $page_data = Get_Data($result, 1);

    //使用数を求める
    for($i = 0; $i < $data_num; $i++){
        $make_goods_num = $page_data[$i][4]/$page_data[$i][3]*$create_num;

        //チェック
        if($make_goods_num != ceil($make_goods_num)){
            $error = "使用数が割り切れません。もう一度組立数を入力してください。";
            $err_flg = true;
            break;
        }
        $page_data[$i][6] = $make_goods_num;
    }

    //使用数が正当な値の場合
    if($err_flg != true){
        $validate_flg = true;

        //データセット
        $set_data["hdn_goods_id"]       = $goods_id;            //抽出した商品ID
        $set_data["hdn_create_num"]     = $create_num;          //POSTで取得した組立数
        $set_data["hdn_output_ware"]    = $output_ware;         //POSTで取得した入庫倉庫ID
        $set_data["hdn_input_ware"]     = $input_ware;          //POSTで取得した出庫倉庫ID
        $set_data["hdn_create_day"]     = $create_day;          //POSTで取得した組立日  
 
        for($i = 0; $i < $data_num; $i++){
            $form->addElement("hidden","hdn_parts_goods_id[$i]","",""); 
            $form->addElement("hidden","hdn_make_goods_num[$i]","",""); 
 
            $set_data["hdn_parts_goods_id"][$i] = $page_data[$i][0];  //抽出した部品ID 
            $set_data["hdn_make_goods_num"][$i] = $page_data[$i][6];  //使用数
        }

        $set_data["hdn_validate_flg"] = $validate_flg;

        //画面をフリーズ
        for($i = 0; $i < count($freeze); $i++){
            $freeze[$i]->freeze();
        }

        $freeze_flg = true;
    }
}

$form->setConstants($set_data);
/****************************/
//関数
/****************************/
function New_Number($db_con){
    //組立管理番号を抽出
    $sql  = "SELECT";
    $sql .= "   CASE ";
    $sql .= "       WHEN COALESCE(MAX(build_id), 0)+1 > 99999999 THEN null ";
    $sql .= "       ELSE COALESCE(MAX(build_id), 0)+1 ";
    $sql .= "   END ";
    $sql .= "FROM ";
    $sql .= "   t_build ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $build_no = pg_fetch_result($result, 0,0);

    $build_no = str_pad($build_no, 8, 0, STR_PAD_LEFT);

    return $build_no;
}

function Get_Common_Num($ary){
    $count = count($ary);

    //一つの部品によって構成されていル場合
    if($count == 1){
        return $ary[0];
    }

    //$fstに基準
    $first = $ary[0];
    for($i = 1; $i < $count; $i++){
        //比べる対象
        $second = $ary[$i];

        //$fstと$sndの値の最大公約数を求める
        $res   = Get_Common_Num2($first, $second);
        $first = ($first * $second) / $res;
    }
    return $first;
}

//最大公約数を求める関数
function Get_Common_Num2($first, $second){
    //割り切れるまでループ
    while($res = $first % $second){
        $first = $second;
        $second = $res;
    }

    return $second;
}

/****************************/
//HTMLヘッダ
/****************************/
//$html_header = Html_Header($page_title);
$html_header = Html_Header($page_title,"amenity.js", "global.css", "", "ie8");

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
$page_title .= "　".$form->_elements[$form->_elementIndex[list_button]]->toHtml();
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
    'code_value'        => "$code_value",
    'input_ware_name'   => $input_ware_name,
    'output_ware_name'  => $output_ware_name,
    'create_num'        => $create_num,
    'stock_num'         => $stock_num,
    'rstock_num'        => $rstock_num,
    'error'             => "$error",
    'validate_flg'      => "$validate_flg",
    'auth_r_msg'        => "$auth_r_msg",
    'today'             => date("Y")." - ".date("m")." - ".date("d"),
    'freeze_flg'        => "$freeze_flg",
    'duplicate_err'     => "$duplicate_err",
));

$smarty->assign("page_data",$page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
