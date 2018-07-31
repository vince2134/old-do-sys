<?php
/**
 *
 * 権限一覧
 *
 *
 *
 *
 *
 *
 *
 *   !! 本部・FC画面ともに同じソース内容です !!
 *   !! 変更する場合は片方をいじって他方にコピってください !!
 *
 *
 *
 *
 *
 *
 *
 * ・
 *
 *
 * @author      
 * @version     
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/08/07                  kajioka-h   福田関数（function/permit.inc）を使って書き直した
 *                                          CSV出力のみに変更（画面表示はなし）
 */

$page_title = "権限一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
//DB接続
$db_con = Db_Connect();


//--------------------------//
// 権限関連処理
//--------------------------//
// 権限チェック
//$auth       = Auth_Check($db_con);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;



//--------------------------//
// 外部変数取得
//--------------------------//
$group_kind = $_SESSION["group_kind"];



//--------------------------//
// 外部変数取得
//--------------------------//
$def_data = array(
    "form_del_compe"	=> "1",
    "form_accept_compe"	=> "1",
    "form_compe_invest"	=> "1",
    "form_staff_state"	=> "在職中",
);
$form->setDefaults($def_data);



//--------------------------//
//フォーム作成（固定）
//--------------------------//
//CSV出力ボタン
$form->addElement("submit", "csv_btn", "CSV出力");

//表示
//$form->addElement("submit","show_btn","表　示");

//クリア
$form->addElement("button","clear_btn","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");


//ショップコード
$text[] =& $form->createElement("text","cd1","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_client_cd[cd1]','form_client_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","cd2","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"  ".$g_form_option."\"");
$form->addGroup( $text, "form_client_cd", "form_client_cd");

//担当者コード
$form->addElement("text","form_charge_cd","テキストフォーム","size=\"5\" maxLength=\"4\" style=\"$g_form_style\"  ".$g_form_option."\"");

//削除権限
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "有り","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "無し","3");
$form->addGroup($radio, "form_del_compe", "削除権限");

//承認権限
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "有り","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "無し","3");
$form->addGroup($radio, "form_accept_compe", "承認権限");

//権限付与
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "済","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "未","3");
$form->addGroup($radio, "form_compe_invest", "権限付与");

//在職識別
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "在職中","在職中");
$radio[] =& $form->createElement( "radio",NULL,NULL, "退職","退職");
$radio[] =& $form->createElement( "radio",NULL,NULL, "休業","休業");
$radio[] =& $form->createElement( "radio",NULL,NULL, "全て","全て");
$form->addGroup($radio, "form_staff_state", "在職識別");

//ショップ名
$form->addElement("text","form_client_name","テキストフォーム","size=\"34\" maxLength=\"15\" ".$g_form_option."\"");
//スタッフ名
$form->addElement("text","form_staff_name","テキストフォーム","size=\"22\" maxLength=\"10\" ".$g_form_option."\"");

//中項目？
$select_value="";
$select_value=array(""=>"","中分類"=>"中分類",);
$form->addElement("select","form_select_kind","セレクトボックス",$select_value,$g_form_option_select);




//--------------------------//
// CSV生成
//--------------------------//
if($_POST['csv_btn'] != null){


    if($group_kind == "1"){
    	$csv_data  = Make_Permit_Data($db_con, $group_kind);
    }
	$csv_data .= Make_Permit_Data($db_con, "2");
//print_array($csv_data);


    $csv_file_name = $page_title.date("Ymd").".csv";
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");


    header("Content-disposition: attachment; filename=$csv_file_name");
    header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;

    exit();
}



//--------------------------//
//HTMLヘッダ
//--------------------------//
$html_header = Html_Header($page_title);


//--------------------------//
//HTMLフッタ
//--------------------------//
$html_footer = Html_Footer();


//--------------------------//
//画面ヘッダー作成
//--------------------------//
$page_header = Create_Header($page_title);


// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());
//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",

));
$smarty->assign('ary_data',$ary);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));



/**
 *
 *
 *
 */
function Make_Permit_Data($db_con, $group_kind)
{

	//--------------------------//
	// 出力する文字
	//--------------------------//
	$non = "×";    //権限なし
	$read = "△";   //表示
	$write = "○";  //入力


	//権限の一覧配列
    $menu_array = Permit_Item();
//print_array($menu_array);

    $permit_array = Permit_Col("head");
//print_array($permit_array);


    //--- CSVヘッダ生成 ---//
    //CSVヘッダ1行目
	if($group_kind == "1"){
	    $h_csv1  = array("本部");
	}else{
	    $h_csv1  = array("FC");
	}

    //CSVヘッダ2行目
    $h_csv2  = array(
        "スタッフ情報",
    );

    //CSVヘッダ3行目
    $h_csv3  = array(
        "ショップコード",
        "ショップ名",
        "担当者コード",
        "スタッフ種別",
        "ネットワーク証ID",
        "スタッフ名",
        "在職種別",
        "削除権限",
        "承認権限",
    );

    //CSVヘッダ4行目
    $h_csv4  = array(
    );

    $count2 = count($h_csv2);
    $count3 = count($h_csv3);
    $count4 = count($h_csv4);
    for($i=0; $i<$count3; $i++){
        if($i < ($count3 - $count2)){
            //CSVヘッダ2行目に「""」を追加
            array_push($h_csv2, "");
        }

        if($i < ($count3 - $count4)){
            //CSVヘッダ4行目に「""」を追加
            array_push($h_csv4, "");
        }
    }


	if($group_kind == "1"){
	    $menu_array_data = $menu_array[0];			//メニュー配列
	    $permit_array_data = $permit_array["h"];	//権限配列
	}else{
	    $menu_array_data = $menu_array[1];
	    $permit_array_data = $permit_array["f"];
	}
/*
print_array($menu_array_data);
print_array($permit_array_data);
*/


    //メニュー大区分（2行目）
    $count_menu_array_1 = count($menu_array_data);
    for($i=0; $i < $count_menu_array_1; $i++){

        //メニュー中区分（3行目）
        $count_menu_array_2 = count($menu_array_data[$i][1]);
        for($j=0; $j < $count_menu_array_2; $j++){

            //メニュー小区分（4行目）
            $count_menu_array_3 = count($menu_array_data[$i][1][$j][1]);

            //小区分がない（更新、マスタ・設定）
            if($count_menu_array_3 == 0){

                //CSV2行目
                if($j == 0){
                    array_push($h_csv2, $menu_array_data[$i][0]);
                }else{
                    array_push($h_csv2, "");
                }
                array_push($h_csv3, $menu_array_data[$i][1][$j][0]);	//CSV3行目
                array_push($h_csv4, "");                            	//CSV4行目

            //小区分がある（更新、マスタ・設定以外）
            }else{

                for($k=0; $k < $count_menu_array_3; $k++){

                    //CSV2行目
                    if($j == 0 && $k == 0){
                        array_push($h_csv2, $menu_array_data[$i][0]);
                    }else{
                        array_push($h_csv2, "");
                    }

                    //CSV3行目
                    if($k == 0){
                        array_push($h_csv3, $menu_array_data[$i][1][$j][0]);
                    }else{
                        array_push($h_csv3, "");
                    }

                    array_push($h_csv4, $menu_array_data[$i][1][$j][1][$k]);   //CSV4行目
                }

            }

        }

    }
/*
print_array($h_csv2, "CSV2行目");
print_array($h_csv3, "CSV3行目");
print_array($h_csv4, "CSV4行目");
*/


    //WHERE句生成

    //本部・FC識別
    if($group_kind == "1"){
        $where_sql  = "    t_attach.h_staff_flg = true \n";
    }else{
        $where_sql  = "    t_attach.h_staff_flg = false \n";
    }

    //FC画面のときは自ショップのみ表示
    if($_SESSION["group_kind"] != "1"){
        $where_sql  = "    t_attach.shop_id = ".$_SESSION["client_id"]." \n";
    }

    //ショップコード1
	if($_POST["form_client_cd"]["cd1"] != null){
        $where_sql .= "    AND \n";
	    $where_sql .= "    t_client.client_cd1 = '".$_POST["form_client_cd"]["cd1"]."' \n";
    }
    //ショップコード2
	if($_POST["form_client_cd"]["cd2"] != null){
        $where_sql .= "    AND \n";
	    $where_sql .= "    t_client.client_cd2 = '".$_POST["form_client_cd"]["cd2"]."' \n";
    }
    //ショップ名
	if($_POST["form_client_name"] != null){
        $where_sql .= "    AND \n";
        $where_sql .= "    ( \n";
	    $where_sql .= "        t_client.client_name LIKE '%".$_POST["form_client_name"]."%' \n";
        $where_sql .= "        OR \n";
	    $where_sql .= "        t_client.client_name2 LIKE '%".$_POST["form_client_name"]."%' \n";
        $where_sql .= "        OR \n";
	    $where_sql .= "        t_client.client_cname LIKE '%".$_POST["form_client_name"]."%' \n";
        $where_sql .= "    ) \n";
    }

    //担当者コード
	if($_POST["form_charge_cd"] != null){
        $where_sql .= "    AND \n";
	    $where_sql .= "    t_staff.charge_cd = ".(int)$_POST["form_charge_cd"]." \n";
    }
    //スタッフ名
	if($_POST["form_staff_name"] != null){
        $where_sql .= "    AND \n";
	    $where_sql .= "    t_staff.staff_name LIKE '%".$_POST["form_staff_name"]."%' \n";
    }

    //削除権限
	if($_POST["form_del_compe"] != "1"){
        $where_sql .= "    AND \n";
	    if($_POST["form_del_compe"] == "2"){
    	    $where_sql .= "    t_permit.del_flg = true \n";
        }elseif($_POST["form_del_compe"] == "3"){
    	    $where_sql .= "    t_permit.del_flg = false \n";
        }
    }
    //承認権限
	if($_POST["form_accept_compe"] != "1"){
        $where_sql .= "    AND \n";
	    if($_POST["form_accept_compe"] == "2"){
    	    $where_sql .= "    t_permit.accept_flg = true \n";
        }elseif($_POST["form_accept_compe"] == "3"){
    	    $where_sql .= "    t_permit.accept_flg = false \n";
        }
    }

    //在職識別
	if($_POST["form_staff_state"] != "全て"){
        $where_sql .= "    AND \n";
	    if($_POST["form_staff_state"] == "在職中"){
    	    $where_sql .= "    t_staff.state = '在職中' \n";
	    }elseif($_POST["form_staff_state"] == "退職"){
    	    $where_sql .= "    t_staff.state = '退職' \n";
	    }elseif($_POST["form_staff_state"] == "休業"){
    	    $where_sql .= "    t_staff.state = '休業' \n";
        }
    }

    //権限付与
	if($_POST["form_compe_invest"] != "1"){
        $where_sql .= "    AND \n";
	    if($_POST["form_compe_invest"] == "2"){
    	    $where_sql .= "    t_permit.staff_id IS NOT NULL \n";
        }elseif($_POST["form_compe_invest"] == "3"){
    	    $where_sql .= "    t_permit.staff_id IS NULL \n";
        }
    }



    //SQL生成
    $sql  = "SELECT \n";
    $sql .= "    t_client.client_cd1 || '-' || t_client.client_cd2 AS client_cd, \n";
    $sql .= "    t_client.client_cname, \n";
    $sql .= "    lpad(t_staff.charge_cd, 4, '0') AS charge_cd, \n";
    $sql .= "    CASE t_rank.group_kind \n";
    $sql .= "        WHEN '1' THEN '本部' \n";
    $sql .= "        WHEN '2' THEN '直営' \n";
    $sql .= "        ELSE 'FC' \n";
    $sql .= "    END AS group_kind, \n";
    $sql .= "    CASE t_staff.staff_cd1 \n";
    $sql .= "        WHEN null THEN null \n";
    $sql .= "        ELSE t_staff.staff_cd1 || '-' || t_staff.staff_cd2 \n";
    $sql .= "    END AS staff_cd, \n";
    $sql .= "    t_staff.staff_name, \n";
    $sql .= "    t_staff.state, \n";
    $sql .= "    CASE t_permit.del_flg \n";
    $sql .= "        WHEN true THEN '有' \n";
    $sql .= "        WHEN false THEN '無' \n";
    $sql .= "    END, \n";
    $sql .= "    CASE t_permit.accept_flg \n";
    $sql .= "        WHEN true THEN '有' \n";
    $sql .= "        WHEN false THEN '無' \n";
    $sql .= "    END, \n";

    //権限
    $count_permit_array_1 = count($permit_array_data);
    for($i=1; $i <= $count_permit_array_1; $i++){

        $count_permit_array_2 = count($permit_array_data[$i]);
        for($j=1; $j <= $count_permit_array_2; $j++){

            $count_permit_array_3 = count($permit_array_data[$i][$j]);
            for($k=0; $k < $count_permit_array_3; $k++){

                //0番目がnullだったら次のループに
                if($permit_array_data[$i][$j][$k][0] == null){
                    continue;

                }else{
                    $sql .= "    CASE t_permit.".$permit_array_data[$i][$j][$k][0]." \n";
                    $sql .= "        WHEN 'n' THEN '$non' \n";
                    $sql .= "        WHEN 'r' THEN '$read' \n";
                    $sql .= "        WHEN 'w' THEN '$write' \n";
                    if($i == $count_permit_array_1 && $j == $count_permit_array_2 && $k == ($count_permit_array_3 - 1)){
                        $sql .= "    END \n";
                    }else{
                        $sql .= "    END, \n";
                    }
                }
            }
        }
    }

    $sql .= "FROM \n";
    $sql .= "    t_staff \n";
    $sql .= "    LEFT JOIN t_permit ON t_permit.staff_id = t_staff.staff_id \n";
    $sql .= "    INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id \n";
    $sql .= "    INNER JOIN t_client ON t_client.client_id = t_attach.shop_id \n";
    $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd \n";
    $sql .= "WHERE \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= "    client_cd1, \n";
    $sql .= "    client_cd2, \n";
    $sql .= "    charge_cd \n";
    $sql .= ";";
//print_array($sql);

    $result = Db_Query($db_con, $sql);
    for($i=0, $result_array=array(); $i<pg_num_rows($result); $i++){
        $result_array[] = pg_fetch_array($result, $i, PGSQL_NUM);
    }
//print_array($result_array);


    //CSVデータに4行目から2行目までのヘッダをくっつける（1行目はMake_Csv関数でくっつける）
    array_unshift($result_array, $h_csv4);
    array_unshift($result_array, $h_csv3);
    array_unshift($result_array, $h_csv2);
//print_array($result_array);

    $csv_data  = Make_Csv($result_array, $h_csv1);

    if($group_kind == "1"){
        $csv_data .= "\n\n";
    }

	return $csv_data;
}


?>
