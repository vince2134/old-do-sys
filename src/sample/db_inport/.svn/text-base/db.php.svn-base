<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");
require_once("file.fnc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

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
        pg_query("BEGIN;");
        $sql         = "SELECT * from $l_db_tname where false;";
        $result      = pg_query($sql);
        $field_count = pg_num_fields($result);


        //
        $fp = fopen("$l_up_dir"."$l_file_name","r");
        if($field_count == 0 ){
                echo "テーブルの列数が0です";
                exit;
        }

        //固定データ作成
        if($_POST["l_db_tname"] == "t_g_goods" || $_POST["l_db_tname"] == "t_product"){
            $colum  = ",''";
            $colum .= ",'t'";
            $colum .= ",1";
            $field_count = 2;
        }


        //行ループ
            $j=1;
        while($insert_data = fgetcsv($fp, "1000", "$l_ifs") ){
                $sql  = "INSERT INTO $l_db_tname $column_name";
                $sql .= "VALUES ( ".$j.",";

                for ($i=0; $i<$field_count; $i++){
                #for ($i=0; $i<11; $i++){

                    //項目を追加する
                    if($i != 0){
                            $sql .= ",";
                    }
                    
                    //登録データを追加
					if ($insert_data[$i] != ""){
						$insert_data[$i] = pg_escape_string ($insert_data[$i]);
                		$sql .= "'$insert_data[$i]'";

					//データが無い場合はNULLで登録
					}
                   /* else{
						$sql .= "NULL";
					}*/

                }

                $sql .= $colum.");";
                echo "$sql"."<br>";
                $result      = pg_query($sql);

            $j=$j+1;
        }
    pg_query("COMMIT;");
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

$form->display();

?>
