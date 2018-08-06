<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/11      ban_0126    suzuki      ���˥������󥰽����ɲ�
*/

$page_title = "���߸˿�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);

$button[] = $form->createElement("button","close","�Ĥ���","onClick=\"javascript:window.close();\"");
$form->addGroup($button, "button", "");
/****************************/
//GET����
/****************************/
$goods_id  = $_GET["select_id"];

Get_Id_Check2($goods_id);

$client_id = $_GET["select_id2"];
/****************************/
//�����ѿ�����
/****************************/
$shop_id     = $_SESSION["client_id"];

//����̾����
$sql  = "SELECT";
$sql .= "   goods_cname";
$sql .= " FROM";
$sql .= "   t_goods";
$sql .= " WHERE";
$sql .= "   goods_id = $goods_id";
$sql .= ";";

$result = Db_Query($conn, $sql);
$goods_name = pg_fetch_result($result ,0,0);
$goods_name = htmlspecialchars($goods_name);

$sql  = "SELECT";
$sql .= "   t_ware.ware_name,";
$sql .= "   t_stock.stock_num,";
$sql .= "   t_stock.rstock_num";
$sql .= " FROM";
$sql .= "   t_ware ";
$sql .= "   INNER JOIN t_stock ON t_stock.ware_id = t_ware.ware_id ";
$sql .= " WHERE";
$sql .= "   t_stock.shop_id = $shop_id";
$sql .= " AND";
$sql .= "   t_stock.goods_id = $goods_id";
$sql .= " AND ";
$sql .= "   t_ware.count_flg = 't';";

$result = Db_Query($conn, $sql);
$data_num = pg_num_rows($result);
for($i = 0; $i < $data_num; $i++){
    $data[] = pg_fetch_array($result, $i, PGSQL_NUM);
}
foreach ($data as $key1 => $value1){
    foreach ($value1 as $key2 => $value2){
        $data[$key1][$key2] = htmlspecialchars($value2);
    }
}

//���߸Ŀ����������ι��
for($i = 0; $i < $data_num; $i++){
    $stock_total  = $stock_total + $data[$i][1];
    $rstock_total = $rstock_total + $data[$i][2];
}
if($stock_total == NULL){
	$stock_total = 0;
}
if($rstock_total == NULL){
	$rstock_total = 0;
}
$sum = array("<b>���</b>",$stock_total,$rstock_total);
/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'html_footer'   => "$html_footer",
    "goods_name"    => "$goods_name",
));
$smarty ->assign("sum",$sum);
$smarty ->assign("data",$data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>