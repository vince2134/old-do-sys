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

    $m = 0;
    while($insert_data = fgetcsv($fp, "1000", "$l_ifs") ){
        
        for($i = 0; $i < count($insert_data); $i++){
            $insert_data[$i] = trim(pg_escape_string($insert_data[$i]));
        }

        /**************************************/
        //単価テーブル
        /**************************************/

        //商品ID
        $goods_cd = str_pad($insert_data[0], 8, 0, STR_PAD_LEFT);

        $sql  = "SELECT";
        $sql .= "   goods_id";
        $sql .= " FROM";
        $sql .= "   t_goods";
        $sql .= " WHERE";
        $sql .= "   goods_cd = '$goods_cd'";
        $sql .= "   AND";
        $sql .= "   public_flg = 't'";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        $goods_id = pg_fetch_result($result ,0,0);


        //顧客区分コード
        if($insert_data[1] == '1'){
            $rank_cd = "0001";
        }elseif($insert_data[1] == '2'){
            $rank_cd = "0002";
        }elseif($insert_data[1] == '3'){
            $rank_cd = "0003";
        }elseif($insert_data[1] == '4'){
            $rank_cd = "0004";
        }

        //FCグループID
        $sql  = "SELECT";
        $sql .= "   shop_gid";
        $sql .= " FROM";
        $sql .= "   t_shop_gr";
        $sql .= " WHERE";
        $sql .= "   rank_cd = '$rank_cd'";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);

        $num = pg_num_rows($result);
        if($num != 0){
            for($i = 0; $i < $num; $i++){
                $shop_gid[$i] = pg_fetch_result($result,$i,0);
            }
        }
        $insert_sql  = "INSERT INTO t_price(";
        $insert_sql .= "    price_id,";
        $insert_sql .= "    goods_id,";
        $insert_sql .= "    rank_cd,";
        $insert_sql .= "    cost_price,";
        $insert_sql .= "    cost_rate,";
        $insert_sql .= "    r_price,";
        $insert_sql .= "    shop_gid";
        $insert_sql .= ")VALUES(";
        $insert_sql .= "    (SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),";
        $insert_sql .= "    $goods_id,";
        $insert_sql .= "    '$rank_cd',";
        $insert_sql .= "    $insert_data[2],";
        $insert_sql .= "    '100',";
        $insert_sql .= "    $insert_data[2],";
        $insert_sql .= "    1";
        $insert_sql .= ")";

        $result = Db_Query($db_con, $insert_sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }

        /************************************/
        //単価改定テーブル
        /************************************/
        if($insert_data[4] != ''){
            $insert_sql  = "INSERT INTO t_rprice (";
            $insert_sql .= "    price_id,";
            $insert_sql .= "    price,";
            $insert_sql .= "    rprice,";
            $insert_sql .= "    price_cday,";
            $insert_sql .= "    rprice_flg";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT MAX(price_id) FROM t_price),";
            $insert_sql .= "    $insert_data[3],";
            $insert_sql .= "    $insert_data[2],";
            $insert_sql .= "    '$insert_data[4]',";
            $insert_sql .= "    't'";
            $insert_sql .= ");";

            $result = Db_Query($db_con, $insert_sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }
        }

        //営業単価・在庫単価登録
        for($s = 0; $s < count($shop_gid); $s++){
            for($r = 2; $r < 4; $r++){
                $insert_sql  = "INSERT INTO t_price (";
                $insert_sql .= "    price_id,";
                $insert_sql .= "    goods_id,";
                $insert_sql .= "    rank_cd,";
                $insert_sql .= "    cost_rate,";
                $insert_sql .= "    cost_price,";
                $insert_sql .= "    r_price,";
                $insert_sql .= "    shop_gid";
                $insert_sql .= ")VALUES(";
                $insert_sql .= "    (SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),";
                $insert_sql .= "    $goods_id,";
                $insert_sql .= "    '$r',";
                $insert_sql .= "    '100',";
                $insert_sql .= "    (SELECT";
                $insert_sql .= "        r_price";
                $insert_sql .= "    FROM";
                $insert_sql .= "        t_price";
                $insert_sql .= "    WHERE";
                $insert_sql .= "        goods_id = $goods_id";
                $insert_sql .= "        AND";
                $insert_sql .= "        rank_cd = '4'";
                $insert_sql .= "        AND";
                $insert_sql .= "        shop_gid = 1";
                $insert_sql .= "    ),";
                $insert_sql .= "    (SELECT";
                $insert_sql .= "        r_price";
                $insert_sql .= "    FROM";
                $insert_sql .= "        t_price";
                $insert_sql .= "    WHERE";
                $insert_sql .= "        goods_id = $goods_id";
                $insert_sql .= "        AND";
                $insert_sql .= "        rank_cd = '4'";
                $insert_sql .= "        AND";
                $insert_sql .= "        shop_gid = 1";
                $insert_sql .= "    ),";
                $insert_sql .= "    $shop_gid[$s]";
                $insert_sql .= ");";

                $result = Db_Query($db_con, $insert_sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }
            }
        }

        /********************************/
        //ショップ別商品情報テーブル
        /********************************/
        if($m % 4 == 0){
            for($s = 0; $s < count($shop_gid); $s++){
                $insert_sql  = "INSERT INTO t_goods_info(";
                $insert_sql .= "    goods_id,"; 
                $insert_sql .= "    compose_flg,";
                $insert_sql .= "    head_fc_flg,";
                $insert_sql .= "    shop_gid";
                $insert_sql .= " )VALUES(";
                $insert_sql .= "    $goods_id,";
                $insert_sql .= "    'f',";
                $insert_sql .= "    'f',";
                $insert_sql .= "    $shop_gid[$s]";
                $insert_sql .= ");";

                $result = Db_Query($db_con, $insert_sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }
            }
        }

        $m=$m+1;
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
$form->addElement("link","price_link","","./db_goods.php","goods");
$form->display();

?>
