<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");
require_once("file.fnc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect("amenity_060315");

extract($_POST);


//■設定***********************************/
$l_up_dir = "tmp/"; //サーバ側での保存先
/******************************************/

if($_POST[submit] == "登　録"){

    // ファイルアップロード
    $File_Upload = File_Upload("l_file", $l_up_dir, "$l_file_name");

	//アップロードされたファイルをEUC-JPへ変換
	File_Mb_Convert("$l_up_dir"."$l_file_name");


    if(!$File_Upload)exit;

    //テーブルのfield数を取得
    $sql         = "SELECT * from $l_db_tname where false;";
    $result      = pg_query($sql);
    $field_count = pg_num_fields($result);


    $fp = fopen("$l_up_dir"."$l_file_name","r");
    if($field_count == 0 ){
        echo "テーブルの列数が0です";
        exit;
    }

    Db_Query($db_con, "BEGIN");

    //行ループ
    $j = 1;
    $k = 1;
    while($insert_data = fgetcsv($fp, "1000", "$l_ifs") ){
        
        for($i = 0; $i < count($insert_data); $i++){
            $insert_data[$i] = trim(pg_escape_string($insert_data[$i]));
        }


        /*******************************/
        //商品マスタ
        /*******************************/

        //商品コード
        $goods_cd = str_pad($insert_data[0], 8, 0, STR_PAD_LEFT);

        //製品区分ＩＤ
        $product_cd = str_pad($insert_data[4], 4, 0, STR_PAD_LEFT);
        $sql  = "SELECT";
        $sql .= "   product_id";
        $sql .= " FROM";
        $sql .= "   t_product";
        $sql .= " WHERE";
        $sql .= "   product_cd = '$product_cd'";
        $sql .= "   AND";
        $sql .= "   public_flg = 't'";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $prodcut_id = pg_fetch_result($result,0,0);

        //Ｍ区分ＩＤ
        $g_goods_cd = str_pad($insert_data[5], 4, 0, STR_PAD_LEFT);
        $sql  = "SELECT";
        $sql .= "   g_goods_id";
        $sql .= " FROM";
        $sql .= "   t_g_goods";
        $sql .= " WHERE";
        $sql .= "   g_goods_cd = '$g_goods_cd'";
        $sql .= "   AND";
        $sql .= "   public_flg = 't'";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $g_goods_id = pg_fetch_result($result, 0,0);

        //課税区分
        if($insert_data[15] == ''){
            $tax_div = '1';
        }elseif($insert_data[15] == '1'){
            $tax_div = '2';
        }elseif($isnert_data[15] == '2'){
            $tax_div = '3';
        }

        //品名変更
        if($insert_data[16] == '2'){
            $name_change = '1';
        }elseif($insert_data[16] == ''){
            $name_change = '2';
        }

        //在庫管理
        if($insert_data[17] == '1'){
            $stock_manage = '1';
        }else{
            $stock_manage = '2';
        }

        //在庫限り品
        if($insert_data[18] == ''){
            $stock_only = '2';
        }elseif($insert_data[18] == '1'){
            $stock_only = '1';
        }

        //登録処理
        $insert_sql  = "INSERT INTO t_goods (";
        $insert_sql .= "    goods_id,";                 //商品ＩＤ
        $insert_sql .= "    goods_cd,";                 //商品コード
        $insert_sql .= "    goods_name,";               //商品名
        $insert_sql .= "    goods_cname,";              //略称
        $insert_sql .= "    attri_div,";                //属性区分
        $insert_sql .= "    product_id,";               //製品区分ＩＤ
        $insert_sql .= "    g_goods_id,";               //Ｍ区分ＩＤ
        $insert_sql .= "    unit,";                     //単位
        $insert_sql .= "    tax_div,";                  //課税区分
        $insert_sql .= "    name_change,";              //品名変更
        $insert_sql .= "    stock_manage,";             //在庫管理
        $insert_sql .= "    stock_only,";               //在庫限り品
        $insert_sql .= "    sale_manage,";              //販売管理
        $insert_sql .= "    royalty,";                  //ロイヤリティ（有・無）
//        $insert_sql .= "    make_goods_flg,";           //製造品フラグ
        $insert_sql .= "    public_flg,";               //共有フラグ
        $insert_sql .= "    shop_gid";                  //ＦＣグループＩＤ
        $insert_sql .= ")VALUES(";
        $insert_sql .= "    $j,";                       //商品ＩＤ
        $insert_sql .= "    '$goods_cd',";              //商品コード
        $insert_sql .= "    '$insert_data[1]',";        //商品名
        $insert_sql .= "    '$insert_data[2]',";        //略称
        $insert_sql .= "    '$insert_data[3]',";        //属性区分
        $insert_sql .= "    $prodcut_id,";              //製品区分ID
        $insert_sql .= "    $g_goods_id,";              //Ｍ区分ID
        $insert_sql .= "    '$insert_data[6]',";        //単位
        $insert_sql .= "    '$tax_div',";               //課税区分
        $insert_sql .= "    '$name_change',";           //品名変更
        $insert_sql .= "    '$stock_manage',";          //在庫管理
        $insert_sql .= "    '$stock_only',";            //在庫限品
        $insert_sql .= "    '1',";                      //販売管理
        $insert_sql .= "    '' ,";                      //ロイヤリティ
//        $insert_sql .= "    '',";
        $insert_sql .= "    't',";
        $insert_sql .= "    1";
        $insert_sql .= ");";

        $result = Db_Query($db_con, $insert_sql);

        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }

        /********************************/
        //ショップ別商品情報テーブル
        /********************************/
        //主な仕入先
        /*
        if($insert_data[8] != null){
            $sql  = "SELECT";
            $sql .= "   client_id";
            $sql .= " FROM";
            $sql .= "   client_cd1 = '$insert_data[8]'";
            $sql .= " WHERE";
            $sql .= "   shop_gid = 1";
            $sql .= "   AND";
            $sql .= "   client_div = '2'";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            $client_id = pg_fetch_result($result, 0,0);
        }else{
            $client_id = null;
        }
        */

        //登録処理
        $insert_sql  = "INSERT INTO t_goods_info (";
        $insert_sql .= "    goods_id,";                 //商品ID
        $insert_sql .= "    in_num,";                   //入数
        $insert_sql .= "    order_point,";              //発注点
        $insert_sql .= "    order_unit,";               //発注単位数
        $insert_sql .= "    lead,";                     //リードタイム
        $insert_sql .= "    note,";                     //備考
        $insert_sql .= "    supplier_id,";              //主な仕入先
        $insert_sql .= "    compose_flg,";              //構成品フラグ
        $insert_sql .= "    head_fc_flg,";              //本部・FCフラグ
        $insert_sql .= "    shop_gid";                  //FCグループID
        $insert_sql .= ")VALUES(";
        $insert_sql .= "    $j,";
        $insert_sql .= "    $insert_data[7],";
        if($insert_data[13] != ''){
            $insert_sql .= "    $insert_data[19],";
        }else{
            $insert_sql .= "    0,";
        } 
        $insert_sql .= "    ".($insert_data[20] != '')? $insert_data[20] : '' ."";
        $insert_sql .= "    ,";
        $insert_sql .= "    '$insert_data[21]',";
        $insert_sql .= "    '$insert_data[21]',";
        $insert_sql .= "    null,";
        $insert_sql .= "    false,";
        $insert_sql .= "    't',";
        $insert_sql .= "    1";
        $insert_sql .= ")";

        $result = Db_Query($db_con, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

        /**************************************/
        //単価テーブル
        /**************************************/
        $price[0] = $insert_data[9];
        $price[1] = $insert_data[10];

        $rprice[0] = $insert_data[11];
        $rprice[1] = $insert_data[12];

        $price_cdsy[0] = $insert_data[13];
        $price_cday[1] = $insert_data[14];

        $rank[0] = '1';
        $rank[1] = '4';

        for($s = 0; $s < 2; $s++){
            $insert_sql  = "INSERT INTO t_price(";
            $insert_sql .= "    price_id,"; 
            $insert_sql .= "    goods_id,";
            $insert_sql .= "    rank_cd,";
            $insert_sql .= "    cost_rate,";
            $insert_sql .= "    cost_price,";
            $insert_sql .= "    r_price,";
            $insert_sql .= "    shop_gid";
            $insert_sql .= " )VALUES(";
            $insert_sql .= "    $k,";
            $insert_sql .= "    $j,";
            $insert_sql .= "    '$rank[$s]',";
            $insert_sql .= "    '100',";
            $insert_sql .= "    $price[$s],";
            $insert_sql .= "    $price[$s],";
            $insert_sql .= "    1";
            $insert_sql .= ");";

            $result = Db_Query($db_con, $insert_sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            if($price_cday[$s] != ""){
                $insert_sql  = "INSERT INTO t_rprice (";
                $insert_sql .= "    price_id,";
                $insert_sql .= "    price,";
                $insert_sql .= "    rprice,";
                $insert_sql .= "    price_cday,";
                $insert_sql .= "    rprice_flg";
                $insert_sql .= " )VALUES(";
                $insert_sql .= "    $k,";
                $insert_sql .= "    $rprice[$s],";
                $insert_sql .= "    $price[$s],";
                $insert_sql .= "    '$price_cday[$s]',";
                $insert_sql .= "    't'";
                $insert_sql .= ");";

                $result = Db_Query($db_con, $insert_sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }
            }
            $k = $k+1;
        }

        $j = $j+1;
    }
    Db_Query($db_con, "COMMIT");

}

//初期値
$def_data = array(
    "l_db_name"   => "amenity",
    "l_db_tname"  => "t_parts",
    "l_file_name" => "test.txt",
    "l_ifs"       => ",",
);
$form->setDefaults($def_data);

//フォーム定義
$sql = "SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY schemaname;";
$result = Db_Query($db_con,$sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $select_a[pg_fetch_result($result, $i,0)] = pg_fetch_result($result, $i , 0);
}
$form->addElement("text","l_file_name","保存ファイル名");
$form->addElement("text","l_db_name","DB名");
$form->addElement("select","l_db_tname","テーブル名",$select_a);
$form->addElement("file","l_file","CSVファイル");
$form->addElement("text","l_ifs","区切り文字");
$form->addElement("submit","submit","登　録");
$form->addElement("link","price_link","","./db_price.php","price");
$form->display();

?>
