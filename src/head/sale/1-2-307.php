<?php

/*
* ����
* �����ա�������BɼNo.��������ô���ԡ��������ơ�
* ��2006/11/29  scl-0030������watanabe-k���ƻҴط�ͭ�ǡ�������������ꤷ�Ƥ���Τˡ���������Τߤ�ɽ�������Х��ν���
* ��2007/04/26          ������morita-d  ���ֿƻҤʤ��פ��ġָ������١פ�2�ڡ����ܰʹߤϹ�׶�ۤ�ɽ�����ʤ��褦�˽���
* ��2007/06/16          ������watanabe-k��������ȯ�Ԥ��Ƥ��ʤ����ϥ��顼ɽ��
*
*/

require_once("ENV_local.php");
require(FPDF_DIR);
require_once(INCLUDE_DIR.(basename($_SERVER[PHP_SELF].".inc")));


//DB��³
$db_con = Db_Connect();

//���¥����å�
$auth       = Auth_Check($db_con);

/*
if ($_POST["claim_issue"]=="") {
	echo "��������ꤷ�Ʋ�������";
	exit;
}
*/

//�����
$xx = 10;
$yy = 15;
//$cellyy = 60; //��׶�ۥ�������Y
//$tabyy  = 83; //�ǡ�����������Y

//�Ľ񤭡�mm��ࡢA4������
$pdf=new MBFPDF('P','mm','A4');

//�ե��������
$pdf->AddMBFont(GOTHIC,'SJIS');
$pdf->AddMBfont(PGOTHIC,'SJIS');
$pdf->AddMBfont(MINCHO,'SJIS');
$pdf->AddMBfont(PMINCHO,'SJIS');
$pdf->Open();

//���ڡ�������
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('MS-Gothic','',7);
//$pdf->SetTitle(mb_convert_encoding("�����", "utf-8", "EUC-JP"));
//$pdf->SetSubject("�����");

//$_POST["claim_issue"] = NULL;
//$_POST["claim_issue"][] = 19; //�̾�
//$_POST["claim_issue"][] = "f"; //�ƻ�
//$_POST["claim_issue"][] = 63; //�ƻ�(���)
//$_POST["claim_issue"][] = 22; //�ƻ�(���)
//$_POST["claim_issue"][] = 72; //�ƻ�(���)
//print_array ($_POST["claim_issue"]);


//��ȯ�ԥܥ��󲡲�
if($_POST["hdn_button"] == "��ȯ��"){
    $claim_issue = $_POST["re_claim_issue"];
}else{
    $claim_issue = $_POST["claim_issue"];
}

//��ȯ�ԥܥ��󲡲�
if($_POST["hdn_button"] == "��ȯ��"){
    $max_j = 1; //�����Τߤ�ȯ�Ԥ��뤿�ᡢ�롼�ײ���򣱲�ˤ��롣
}else{
    $max_j = 2;
}


//�ե����ޥå�
$bill_format = $_POST["format"];

//���򤵤�Ƥ��ʤ����ϤȤꤢ������̣�Τʤ������������
//foreach�ǤΥ��顼���ɤ�����
if(!is_array($claim_issue)){
    $claim_issue[] = 'f';
}

/****************************/
//POST���줿����ID�����
/****************************/
//foreach($_POST["claim_issue"] AS $bill_id){

//������ȯ�Ԥ��Ƥ��ʤ���
$cnt = 0;
foreach($claim_issue AS $key => $bill_id){
	
	//�����ID��f�ξ��Ͻ������ʤ�
	if($bill_id != "f"){

		//�����ν��ϥѥ���������
		$pattern = Chk_Claim_Pattern($db_con,$bill_id, $bill_format[$key]);
		//$pattern = 3;

		//�����ǡ�������
		$bill_data[$bill_id][head] = Get_Claim_Header($db_con,$bill_id);
		$bill_data[$bill_id][data] = Get_Claim_Data($db_con,$bill_id,$pattern);
		//print_array($bill_data,head);
		//print_array($bill[data],data);

		for ($j = 0; $j < $max_j; $j++){
			$bill[head] = $bill_data[$bill_id][head];
			$bill[data] = $bill_data[$bill_id][data];
			if ($j == "0") $hikae_flg = "t";
			if ($j == "1") $hikae_flg = "f";

			/****************************/
			//�ֿƻҴط��ʤ��פ��ġ����١�
			/****************************/
			if ($pattern == "1") {
					
				$page = 1;
				while (count($bill[data][0])) {
					//�ڡ�������
					$pdf->AddPage();

					//�إå���ʬɽ��
					Write_Claim_Header($pdf,$bill[head][0],$hikae_flg,2,$page,$xx,$yy);
		
					//��׶��ɽ��
					Write_Claim_Total($pdf,$bill[head][0],$hikae_flg,NULL,NULL,$page);
		
					//���٥ǡ���ɽ��
					$bill[data][0] = Write_Claim_Data_M($pdf,$bill[data][0],$hikae_flg,"","",$db_con);
		
					//�եå�����ɽ���ʼ�������ʬ��
					Write_Claim_Footer($pdf,$bill[head][0],$hikae_flg);	
					$page++;
				}
			/****************************/
			//�ֿƻҴط��ʤ��פ��ġֹ�ס�
			/****************************/
			} elseif ($pattern == "2") {
				//�ڡ�������
				$pdf->AddPage();
	
				//�إå���ʬɽ��
				Write_Claim_Header($pdf,$bill[head][0],$hikae_flg,0,1,$xx,$yy);
	
				//��׶��ɽ��
				Write_Claim_Total($pdf,$bill[head][0],$hikae_flg);
				
				//�եå�����ɽ���ʼ�������ʬ��
				Write_Claim_Footer($pdf,$bill[head][0],$hikae_flg);	
			/****************************/
			//�ֿƻҴط�����פ��ġ����١�
			/****************************/
			} elseif ($pattern == "3") {
				//�ڡ�������
				$pdf->AddPage();
	
				//�إå���ʬɽ��
				Write_Claim_Header($pdf,$bill[head][0],$hikae_flg,2,1,$xx,$yy);
	
				//��׶��ɽ��
				Write_Claim_Total($pdf,$bill[head][0],$hikae_flg);
	
				//�եå�����ɽ���ʼ�������ʬ��
				Write_Claim_Footer($pdf,$bill[head][0],$hikae_flg);	
	
				if (0) {
					echo "<pre>";
					print_r($bill_data);
					echo "</pre>";
				}
				
				$page = 2;
				//�ֿơܻҡפο�ʬ�η����֤�
                foreach ($bill[head] AS $key => $var) {
				//for ($i=1; $i< count($bill[head]); $i++){

					while (count($bill[data][$key])) {

						//�ڡ�������
						$pdf->AddPage();

						//�إå���ʬɽ��
						Write_Claim_Header($pdf,$bill[head][$key],$hikae_flg,1,$page,$xx,$yy);
						
						//��׶�ۤ�ɽ��
						Write_Claim_Total($pdf,$bill[head][$key],$hikae_flg);
				
						//���٥ǡ���ɽ����ɽ��������ʤ��ä��ǡ���������ͤȤ��Ƽ�����
						$bill[data][$key] = Write_Claim_Data_M($pdf,$bill[data][$key],$hikae_flg, "","", $db_con);

						//�եå�����ɽ���ʼ�������ʬ��
						Write_Claim_Footer($pdf,$bill[head][$key],$hikae_flg);	
						$page++;
					}
				}
			/****************************/
			//�ֿƻҴط�����פ��ġֹ�ס�
			/****************************/
			} elseif ($pattern == "4") {
			
				$bill[data] = $bill[head];  //�����ǡ���
				unset($bill[data][0]);      //���������פ�ɽ�����ʤ��ΤǺ��
				
				$page = 1;
				while (count($bill[data])) {
					//�ڡ�������
					$pdf->AddPage();

					//�إå���ʬɽ��
					Write_Claim_Header($pdf,$bill[head][0],$hikae_flg,0,$page,$xx,$yy);
		
					//��׶��ɽ��
					Write_Claim_Total($pdf,$bill[head][0],$hikae_flg,NULL,NULL,$page);
		
					//��ץǡ���ɽ��
					//Write_Claim_Data_G($pdf,$bill_id,$db_con);
//					$bill[data] = Write_Claim_Data_G($pdf,$bill[data],$hikae_flg);
    				$bill[data] = Write_Claim_Data_G($pdf,$bill[data],$hikae_flg,"","",$bill[head][0]);	

					//�եå�����ɽ���ʼ�������ʬ��
					Write_Claim_Footer($pdf,$bill[head][0],$hikae_flg);	
					$page++;
				}

            /****************************/
            //���������
            /****************************/
            } elseif ($pattern == "5") {

                //ɽ�������˥ǡ�������
                $page_data = Make_Bill_Data($bill, $db_con);

                foreach($page_data AS $page => $var){
                    //�ڡ�������
                    $pdf->AddPage();

                    //�إå���ʬɽ��
                    Write_Claim_Header($pdf,$var["head"],$hikae_flg,2,$page,$xx,$yy);

                    //��׶��ɽ��
                    Write_Claim_Total($pdf,$var["head"],$hikae_flg,NULL,NULL,$page);

                    //�ǡ���ɽ��
                    Write_Claim_Data_MG($pdf,$var,$hikae_flg, "","",$bill[head][0]);

                    //�եå�����ɽ���ʼ�������ʬ��
                    Write_Claim_Footer($pdf,$var["head"],$hikae_flg);
                }
			}
		}
	}else{
        $cnt++;
    }
}

//���������򤷤Ƥ��ʤ����
if(count($claim_issue) == $cnt){
    echo "<b><font color=\"#ff0000\"><li>��������ꤷ�Ʋ�������</li></font></b>";
    exit;
}else{

    //��ȯ�Ԥξ������դ�Ĥ��ʤ�
    if($_POST["hdn_button"] == "��ȯ��"){
    }else{
        //ȯ�ԼԤ���Ͽ
        Update_Claim_Data ($db_con, $_POST["claim_issue"]);	
    }

    //$pdf->Error($pdf);
    //PDF�ν���
    $pdf->Output();
}
?>
