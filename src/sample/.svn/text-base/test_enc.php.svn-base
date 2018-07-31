<?php
//タイトル
$page_title = "DB登録";

//環境設定ファイル
require_once("ENV_local.php");
require_once("file.fnc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続


//■設定***********************************/
/******************************************/

        $log_file_name = "./tmp/test.txt";

        $log_file = @fopen($log_file_name,"r");
        //行ループ
        $j = 1;
        while($log_data = fgets($log_file, "1000") ){
            for($i = 0; $i < count($log_data); $i++){
                print $log_data[$i]."<br>";
//                print cp51932_to_eucjpwin($log_data[0]);
//                print mb_convert_encoding($log_data[0], "EUC-jp", "SJIS");
            }
            print_r($log_data); 
        }
/*
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
        while($claim_data = fgetcsv($fp, "1000", "$l_ifs") ){

            $client_id = $client_data[$claim_data[0]];
            $claim_id = $client_data[$claim_data[7]];
        
            $insert_sql  = "INSERT INTO t_client_info (";
            $insert_sql .= "    client_id,";    
            $insert_sql .= "    claim_id";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    $client_id,";
            $insert_sql .= "    $claim_id";
            $insert_sql .= ")";
            
            $result = Db_Query($db_con, $insert_sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }


    print "終わりました。";
    Db_Query($db_con, "COMMIT;");
*/

$form->display();

?>
