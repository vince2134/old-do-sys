<?php
require_once("ENV_local.php");
require_once(FPDF_DIR);
require_once(INCLUDE_DIR."2-2-307.php.inc");

$c_pattern_id = $_POST['pattern_select'];
if($c_pattern_id  == null){
    print "<font color=red><li>�ѥ���������򤷤Ƥ���������</font>";
    exit;
}

$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);


//print_r($_POST);

//sql����
$sql ="SELECT ";
$sql .="    c_memo1,";  //����񥳥���1
$sql .="    c_memo2,";  //����񥳥���2
$sql .="    c_memo3,";  //����񥳥���3
$sql .="    c_memo4,";  //����񥳥���4
$sql .="    c_fsize1,"; //����񥳥���1��ʸ����������
$sql .="    c_fsize2,"; //����񥳥���2��ʸ����������
$sql .="    c_fsize3,"; //����񥳥���3��ʸ����������
$sql .="    c_fsize4,"; //����񥳥���4��ʸ����������
$sql .="    c_memo5,";  //����񥳥���5
$sql .="    c_memo6,";  //����񥳥���6
$sql .="    c_memo7,";  //����񥳥���7
$sql .="    c_memo8,";  //����񥳥���8
$sql .="    c_memo9,";  //����񥳥���9
$sql .="    c_memo10,"; //����񥳥���10
$sql .="    c_memo11,"; //����񥳥���11
$sql .="    c_memo12,"; //����񥳥���12
$sql .="    c_memo13 "; //����񥳥���13
$sql .="FROM ";
$sql .="    t_claim_sheet "; //���������ơ��֥�
$sql .="WHERE ";
$sql .="    c_pattern_id = ".$c_pattern_id;  //�����ѥ�����ID�Ǹ���
$sql .=";";

$rs = Db_Query($db_con,$sql);
$data = pg_fetch_array($rs,0);

//�����
$xx = 10;
//$yy = 3;
$yy = 15;

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


//���ڡ����ιԿ�
$keta = 30;

/*
//��̾��������
$bill = array($deta['c_memo1'],
            $deta['c_memo2'],
            $deta['c_memo3'],
            $deta['c_memo4']
        );

//��̾��Υե���ȥ���������
$c_fsize = array($deta['c_fsize1'],
                $deta['c_fsize2'],
                $deta['c_fsize3'],
                $deta['c_fsize4']
            );

//���̾����å�������������
$bank = array($deta['c_memo5'],
            $deta['c_memo6'],
            $deta['c_memo7'],
            $deta['c_memo8'],
            $deta['c_memo9'],
            $deta['c_memo10'],
            $deta['c_memo11'],
            $deta['c_memo12'],
            $deta['c_memo13']
        );
*/


//�ڡ�������

//PDF����
$page=1;
for($i = 0; $i < 2; $i++){
    $pdf->AddPage();

    if($i == 0){
        $hikae_flg = 't';
    }else{
        $hikae_flg = 'f';
    }

    //�إå���ʬɽ��
    Write_Claim_Header($pdf,$data,$hikae_flg,2,"",$xx,$yy);

    //��׶��ɽ��
    Write_Claim_Total($pdf,$data,$hikae_flg,NULL,NULL,"");

    //���٥ǡ���ɽ��
    Write_Claim_Data_M($pdf,array(null),$hikae_flg);

    //�եå�����ɽ���ʼ�������ʬ��
    Write_Claim_Footer($pdf,$data,$hikae_flg);

}

$pdf->Output();

?>

