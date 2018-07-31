<?php
/*
 * ÍúÎò¡§
 * ¡¡ÆüÉÕ¡¡¡¡¡¡¡¡BÉ¼No.¡¡¡¡¡¡¡¡Ã´Åö¼Ô¡¡¡¡¡¡ÆâÍÆ¡¡
 *   2016/01/20                amano  Dialogue´Ø¿ô¤Ç¥Ü¥¿¥óÌ¾¤¬Á÷¤é¤ì¤Ê¤¤ IE11 ¥Ð¥°ÂÐ±þ
 */
$page_title = "Ç¼ÉÊ½ñÀßÄê";

//´Ä¶­ÀßÄê¥Õ¥¡¥¤¥ë
require_once("ENV_local.php");

//HTML_QuickForm¤òºîÀ®
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DBÀÜÂ³
$db_con = Db_Connect();

// ¸¢¸Â¥Á¥§¥Ã¥¯
$auth       = Auth_Check($db_con);
// ÆþÎÏ¡¦ÊÑ¹¹¸¢¸ÂÌµ¤·¥á¥Ã¥»¡¼¥¸
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ¥Ü¥¿¥óDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//¥Ç¥Õ¥©¥ë¥ÈÃÍÀßÄê
/****************************/
$sql  = "SELECT ";
$sql .= "d_memo1, ";		//Ç¼ÉÊ½ñ¥³¥á¥ó¥È1
$sql .= "d_memo2, ";		//Ç¼ÉÊ½ñ¥³¥á¥ó¥È2
$sql .= "d_memo3 ";			//Ç¼ÉÊ½ñ¥³¥á¥ó¥È3
$sql .= "FROM ";
$sql .= "t_h_ledger_sheet;";

$result = Db_Query($db_con,$sql);
//DB¤ÎÃÍ¤òÇÛÎó¤ËÊÝÂ¸
$d_memo = Get_Data($result, 2);

//¹Ô¤ÎÂ¸ºßÈ½Äê¥Õ¥é¥°
$id_null_flg=false;
//¥Ç¡¼¥¿¤ÎNULLÈ½Äê¥Õ¥é¥°
$value_flg=false;
//¥Ç¡¼¥¿Â¸ºßÈ½Äê
if(pg_num_rows($result)==null){
	$id_null_flg = true;
}
//¿·µ¬ÅÐÏ¿¡¦¹¹¿·È½Äê
for($c=1;$c<count($d_memo[0]);$c++){
	if($d_memo[0][$c] != null){
		$value_flg = true;
	}
}

$def_fdata = array(
    "d_memo1"     	=> $d_memo[0][0],
    "d_memo2"      	=> $d_memo[0][1],
    "d_memo3"     	=> $d_memo[0][2]
);
$form->setDefaults($def_fdata);

/****************************/
//ÉôÉÊÄêµÁ
/****************************/

//¥³¥á¥ó¥È­¡
$form->addElement("text","d_memo1".$x,"¥Æ¥­¥¹¥È¥Õ¥©¡¼¥à","size=\"50\" maxLength=\"46\" style=\"font-size:12px;\"".$g_form_option."\"");
//¥³¥á¥ó¥È­¢
$form->addElement("text","d_memo2".$x,"¥Æ¥­¥¹¥È¥Õ¥©¡¼¥à","size=\"50\" maxLength=\"46\" style=\"font-size:12px;\"".$g_form_option."\"");
//¥³¥á¥ó¥È­£
//$form->addElement("text","d_memo3".$x,"¥Æ¥­¥¹¥È¥Õ¥©¡¼¥à","size=\"39\" maxLength=\"46\" style=\"font-size:12px;\"".$g_form_option."\"");
$form->addElement("textarea","d_memo3",""," rows=\"3\" cols=\"45\" $g_form_option_area");
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("d_memo3","¥á¥â¤Ï60Ê¸»ú°ÊÆâ¤Ç¤¹¡£","mb_maxlength","60");

//ÅÐÏ¿¥Ü¥¿¥ó
$form->addElement("submit","new_button","ÅÐ¡¡Ï¿","onClick=\"javascript: return Dialogue('ÅÐÏ¿¤·¤Þ¤¹¡£','#', this)\" $disabled");

//Ç¼ÉÊ½ñ½ÐÎÏ¥Ü¥¿¥ó
$form->addElement("button","deli_button","¥×¥ì¥Ó¥å¡¼","onClick=\"javascript:window.open('1-1-317.php','_blank','')\"");

/****************************/
//ÅÐÏ¿¥Ü¥¿¥ó²¡²¼½èÍý
/****************************/
if($_POST["new_button"] == "ÅÐ¡¡Ï¿"){
	$d_memo1 = $_POST["d_memo1"];				//Ç¼ÉÊ½ñ¥³¥á¥ó¥È1
	$d_memo2 = $_POST["d_memo2"];				//Ç¼ÉÊ½ñ¥³¥á¥ó¥È2
	$d_memo3 = $_POST["d_memo3"];				//Ç¼ÉÊ½ñ¥³¥á¥ó¥È3
                                                
	Db_Query($db_con, "BEGIN;");

	//¿·µ¬ÅÐÏ¿¡¦¹¹¿·È½Äê
	if($id_null_flg==true && $from->validate()){
		//ÅÐÏ¿´°Î»¥á¥Ã¥»¡¼¥¸
		$comp_msg = "ÅÐÏ¿¤·¤Þ¤·¤¿¡£";

		$sql  = "INSERT INTO ";
		$sql .= "t_h_ledger_sheet ";
		$sql .= "(d_memo1,";
		$sql .= "d_memo2,";
		$sql .= "d_memo3) ";
		$sql .= "VALUES(";
		$sql .= "'$d_memo1',";
		$sql .= "'$d_memo2',";
		$sql .= "'$d_memo3');";
	}elseif($form->validate()){
		//¹Ô¤ÏÂ¸ºß¤¹¤ë¤¬¡¢Ç¼ÉÊ½ñ¥³¥á¥ó¥È¤¬NULL¤Î¾ì¹ç
		if($value_flg==false){
			//ÅÐÏ¿´°Î»¥á¥Ã¥»¡¼¥¸
			$comp_msg = "ÅÐÏ¿¤·¤Þ¤·¤¿¡£";
		}else{
			//ÊÑ¹¹´°Î»¥á¥Ã¥»¡¼¥¸
			$comp_msg = "ÊÑ¹¹¤·¤Þ¤·¤¿¡£";
		}

		$sql  = "UPDATE ";
		$sql .= "t_h_ledger_sheet ";
		$sql .= "SET ";
		$sql .= "d_memo1 = '$d_memo1', ";
		$sql .= "d_memo2 = '$d_memo2', ";
		$sql .= "d_memo3 = '$d_memo3';";
	}

	$result = Db_Query($db_con,$sql);
	if($result == false){
		Db_Query($db_con,"ROLLBACK;");
		exit;
	}
	Db_Query($db_con, "COMMIT;");
}

/****************************/
//HTML¥Ø¥Ã¥À
/****************************/
//$html_header = Html_Header($page_title);
$html_header = Html_Header($page_title, "amenity.js", "global.css", "slip.css");

/****************************/
//HTML¥Õ¥Ã¥¿
/****************************/
$html_footer = Html_Footer();

/****************************/
//¥á¥Ë¥å¡¼ºîÀ®
/****************************/
$page_menu = Create_Menu_h('system','2');
/****************************/
//²èÌÌ¥Ø¥Ã¥À¡¼ºîÀ®
/****************************/
$page_header = Create_Header($page_title);


// Render´ØÏ¢¤ÎÀßÄê
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form´ØÏ¢¤ÎÊÑ¿ô¤òassign
$smarty->assign('form',$renderer->toArray());

//¤½¤ÎÂ¾¤ÎÊÑ¿ô¤òassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'comp_msg'   	=> "$comp_msg",
    'auth_r_msg'    => "$auth_r_msg",
));

//¥Æ¥ó¥×¥ì¡¼¥È¤ØÃÍ¤òÅÏ¤¹
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
