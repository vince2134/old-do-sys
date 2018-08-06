<?php

require_once("ENV_local.php");

$db_con = Db_Connect("demo0705");

//�������
$shop_gid = 1;      //������FC���롼��ID

Db_Query($db_con, "BEGIN;");

//��Ͽ����Ƥ���ܵҶ�ʬ�����
$sql  = "SELECT\n";
$sql .= "   rank_cd\n";
$sql .= " FROM\n";
$sql .= "   t_rank\n";
$sql .= " WHERE\n";
$sql .= "   disp_flg = 't'\n";
$sql .= " ORDER BY rank_cd\n";
$sql .= ";\n";

$rank_res = Db_Query($db_con ,$sql);
$rank_num = pg_num_rows($rank_res);

$aaa = 0;

//�ܵҶ�ʬ���롼��(5��)
for($i = 0; $i < $rank_num; $i++){
    $rank_cd = pg_fetch_result($rank_res, $i,0);

    //�ܵҶ�ʬñ������Ͽ����Ƥ����������ʤξ�������
    $sql  = "SELECT\n";
    $sql .= "   goods_id\n";
    $sql .= " FROM\n";
    $sql .= "   t_price\n";
    $sql .= " WHERE\n";
    $sql .= "   rank_cd = '$rank_cd'\n";
    $sql .= "   AND\n";
    $sql .= "   r_price IS NOT NULL\n";
    $sql .= "   AND\n";
    $sql .= "   shop_gid = $shop_gid\n";
    $sql .= ";\n";

    $goods_res = Db_Query($db_con, $sql);
    $goods_num = pg_num_rows($goods_res);

    //��������쥳����ʬ�롼�ס���1200���
    for($j = 0; $j < $goods_num; $j++){
        $goods_id = pg_fetch_result($goods_res, $j, 0);        

        $sql  = "SELECT\n";
        $sql .= "   shop_gid\n";
        $sql .= " FROM\n";
        $sql .= "   t_shop_gr\n";
        $sql .= " WHERE\n";
        $sql .= "   rank_cd = '$rank_cd'\n";
        $sql .= ";";

        $gr_res = Db_Query($db_con, $sql);
        $gr_num = pg_num_rows($gr_res);

        //FC���롼��ʬ�롼�ס���120���
        for($k = 0; $k < $gr_num; $k++){
            $fc_shop_gid = pg_fetch_result($gr_res, $k, 0);

            //���ۤξ��Ͻ����򎽎����̎�
            if($fc_shop_gid == 43){
                continue;
            }

            for($l = 2; $l < 4; $l++){
                $sql  = "INSERT INTO t_price (";
                $sql .= "   goods_id,";
                $sql .= "   price_id,";
                $sql .= "   rank_cd,";
                $sql .= "   r_price,";
                $sql .= "   shop_gid";
                $sql .= " )VALUES(";
                $sql .= "   $goods_id,";
                $sql .= "   (SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),";
                $sql .= "   '$l',";
                $sql .= "   (SELECT r_price FROM t_price WHERE goods_id = $goods_id AND rank_cd = '4' AND shop_gid = 1),";
                $sql .= "   $fc_shop_gid";
                $sql .= ");";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            $aaa = $aaa+1;
            }



            $sql  = "INSERT INTO t_goods_info(";
            $sql .= "   goods_id,";
            $sql .= "   compose_flg,";
            $sql .= "   head_fc_flg,";
            $sql .= "   shop_gid";
            $sql .= " )VALUES(";
            $sql .= "   $goods_id,";
            $sql .= "   'f',";
            $sql .= "   'f',";
            $sql .= "   $fc_shop_gid";
            $sql .= ");";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }
    }
}
Db_Query($db_con, "COMMIT;");
print $aaa;
?>