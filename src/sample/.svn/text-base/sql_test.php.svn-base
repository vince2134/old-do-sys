<?

function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$sec + (float)$usec);
}



require_once("ENV_local.php");

/*

$sql = "PREPARE claim_data(int, date, int) AS SELECT 
   t_client.client_id, 
   t_client.client_cd1,
   t_client.client_cd2,
   t_client.client_name,
   t_client.client_name2,
   t_client.client_cname,
   t_client.c_tax_div,
   t_client.tax_franct,
   t_client.claim_out,
   t_claim.claim_div,
   t_client.coax,
   t_client.close_day,
   last_claim_data.bill_close_day_last,
   COALESCE(last_claim_data.bill_amount_last,0) AS bill_amount_last,
   COALESCE(last_claim_data.payment_last,0) AS payment_last,
   last_claim_data.payment_extraction_s,
   COALESCE(money_received_data1.pay_amount, 0) AS pay_amount,
   COALESCE(money_received_data2.tune_amount, 0) AS tune_amount, 
   COALESCE(sale_data1.receivable_net_amount, 0) AS receivable_net_amount, 
   COALESCE(sale_data1.receivable_tax_amount, 0) AS receivable_tax_amount,
   COALESCE(sale_data2.taxation_amount, 0) AS taxation_amount,
   COALESCE(sale_data2.notax_amount, 0) AS notax_amount,
   COALESCE(sale_data3.installment_net_amount, 0) AS installment_net_amount, 
   COALESCE(sale_data3.installment_tax_amount, 0) AS installment_tax_amount,
   COALESCE(split_bill_data1.split_bill_amount, 0) AS split_bill_amount, 
   COALESCE(split_bill_data2.installment_receivable_balance, 0) AS installment_receivable_balance, 
   sale_data1.sales_slip_num + sale_data3.sales_slip_num AS sales_slip_num 
FROM
   t_client
        INNER JOIN
    t_claim
   ON t_client.client_id = t_claim.client_id 
   AND t_claim.claim_id = $1 
       LEFT JOIN
   (SELECT 
       MAX(t_bill_d.bill_d_id), 
       t_bill_d.client_id, 
       t_bill_d.bill_close_day_this AS bill_close_day_last, 
       t_bill_d.bill_amount_this AS bill_amount_last,
       t_bill_d.payment_this AS payment_last,
       t_bill_d.payment_extraction_e AS payment_extraction_s
   FROM 
       t_bill_d 
   WHERE 
       t_bill_d.claim_div = (SELECT
                               claim_div
                           FROM
                               t_claim
                           WHERE
                               client_id = t_bill_d.client_id
                               AND
                               claim_id = $1
                           )
   GROUP BY
       t_bill_d.client_id,
       t_bill_d.bill_close_day_this,
       t_bill_d.bill_amount_this,
       t_bill_d.payment_this,
       t_bill_d.payment_extraction_e
   ORDER BY t_bill_d.client_id
   ) AS last_claim_data
   ON t_client.client_id = last_claim_data.client_id
       LEFT JOIN
   (SELECT 
       t_payin_h.client_id,
       COALESCE(SUM(t_payin_d.amount),0) AS pay_amount
   FROM
       t_payin_h
           INNER JOIN
       t_payin_d 
       ON t_payin_h.pay_id = t_payin_d.pay_id
   WHERE
       t_payin_h.pay_day > (SELECT 
                               COALESCE( MAX(t_bill_d.bill_close_day_this) ,'2005-01-01')
                           FROM
                               t_bill
                                   INNER JOIN
                               t_bill_d
                               ON t_bill.bill_id = t_bill_d.bill_id
                           WHERE
                               t_bill_d.client_id = t_payin_h.client_id
                               AND
                               t_bill_d.claim_div = t_payin_h.claim_div
                           )
       AND 
       t_payin_h.pay_day <= $2 
       AND 
       t_payin_h.claim_div = (SELECT
                               claim_div
                            FROM
                                t_claim
                            WHERE
                                client_id = t_payin_h.client_id
                                AND
                                claim_id = $1
                           )
       AND 
       t_payin_h.sale_id IS NULL
       AND 
       t_payin_h.shop_id = $3
   GROUP BY t_payin_h.client_id
   ORDER BY t_payin_h.client_id
   ) AS money_received_data1 
   ON t_client.client_id = money_received_data1.client_id
       LEFT JOIN
   (SELECT 
       t_payin_h.client_id,
       COALESCE(SUM(t_payin_d.amount),0) AS tune_amount
   FROM
       t_payin_h
           INNER JOIN
       t_payin_d 
       ON t_payin_h.pay_id = t_payin_d.pay_id
   WHERE
       t_payin_h.pay_day > (SELECT 
                               COALESCE( MAX(t_bill_d.bill_close_day_this), '2005-01-01')
                           FROM
                               t_bill
                                   INNER JOIN
                               t_bill_d
                               ON t_bill.bill_id = t_bill_d.bill_id
                           WHERE
                               t_bill_d.client_id = t_payin_h.client_id
                               AND
                               t_bill_d.claim_div = t_payin_h.claim_div
                           )
       AND 
       t_payin_h.pay_day <= $2 
       AND 
       t_payin_h.claim_div = (SELECT
                               claim_div
                           FROM
                               t_claim
                           WHERE
                               client_id = t_payin_h.client_id
                               AND
                               claim_id = $1
                           )
       AND 
       t_payin_d.trade_id = 38 
       AND
       t_payin_h.shop_id = $3
   GROUP BY t_payin_h.client_id
   ORDER BY t_payin_h.client_id
   ) AS money_received_data2
   ON t_client.client_id = money_received_data2.client_id
       LEFT JOIN
   (SELECT
       t_sale_h.client_id,
       COALESCE(SUM(t_sale_h.net_amount * CASE WHEN t_sale_h.trade_id=11 THEN 1 ELSE -1 END),0) AS receivable_net_amount, 
       COALESCE(SUM(t_sale_h.tax_amount * CASE WHEN t_sale_h.trade_id=11 THEN 1 ELSE -1 END),0) AS receivable_tax_amount, 
       COALESCE(COUNT(t_sale_h.sale_id),0) AS sales_slip_num 
   FROM
       t_sale_h
   WHERE
       t_sale_h.claim_day > (SELECT 
                               COALESCE( MAX(t_bill_d.bill_close_day_this) , '2005-01-01' )
                           FROM
                               t_bill
                                   INNER JOIN
                               t_bill_d
                               ON t_bill.bill_id = t_bill_d.bill_id
                           WHERE
                               t_bill_d.client_id = t_sale_h.client_id 
                               AND
                               claim_id = t_sale_h.claim_div
                           )
       AND 
       t_sale_h.claim_day <= $2 
       AND 
       t_sale_h.claim_div = (SELECT
                                claim_div
                           FROM
                               t_claim                           WHERE
                               client_id = t_sale_h.client_id
                               AND
                               claim_id = $1
                           )
       AND 
       t_sale_h.trade_id IN (11,13,14) 
       AND 
       t_sale_h.shop_id = $3 
       GROUP BY t_sale_h.client_id 
       ORDER BY t_sale_h.client_id
   ) AS sale_data1 
   ON t_client.client_id = sale_data1.client_id
       LEFT JOIN
   (SELECT
       t_sale_h.client_id,
       COALESCE(
           SUM(
               CASE
                   WHEN t_sale_d.tax_div = '1' THEN t_sale_d.sale_amount * 
                   CASE
                       WHEN t_sale_h.trade_id = 11 THEN 1
                       ELSE -1
                   END
               END
           )
       ,0) AS taxation_amount,
       COALESCE(
           SUM(
               CASE
                   WHEN t_sale_d.tax_div = '3' THEN t_sale_d.sale_amount *
                       CASE
                           WHEN t_sale_h.trade_id = 11 THEN 1 
                           ELSE -1
                       END
                   END
               )
           ,0) AS notax_amount
   FROM
       t_sale_h
           INNER JOIN
       t_sale_d
       ON t_sale_h.sale_id = t_sale_d.sale_id
   WHERE
       t_sale_h.claim_day > (SELECT
                               COALESCE( MAX(t_bill_d.bill_close_day_this) , '2005-01-01' )
                           FROM
                               t_bill
                                   INNER JOIN
                               t_bill_d
                               ON t_bill.bill_id = t_bill_d.bill_id
                           WHERE
                               t_bill_d.client_id = t_sale_h.client_id 
                               AND
                               t_bill_d.claim_div = t_sale_h.claim_div
                           )
       AND
       t_sale_h.claim_day <= $2
       AND
       t_sale_h.claim_div = (SELECT
                               claim_div
                           FROM
                               t_claim
                           WHERE
                               client_id = t_sale_h.client_id
                               AND
                               claim_id = $1
                           )
       AND 
       t_sale_h.trade_id IN (11,13,14) 
       AND 
       t_sale_h.shop_id = $3 
   GROUP BY t_sale_h.client_id 
   ORDER BY t_sale_h.client_id
   ) AS sale_data2
   ON t_client.client_id = sale_data2.client_id
       LEFT JOIN
    (SELECT
       t_sale_h.client_id,
       COALESCE(SUM(t_sale_h.net_amount),0) AS installment_net_amount,
       COALESCE(SUM(t_sale_h.tax_amount),0) AS installment_tax_amount,
       COALESCE(COUNT(t_sale_h.sale_id),0) AS sales_slip_num 
   FROM
       t_sale_h
   WHERE
       t_sale_h.claim_day > (SELECT 
                               COALESCE( MAX(t_bill_d.bill_close_day_this) , '2005-01-01')
                           FROM
                               t_bill
                                   INNER JOIN
                               t_bill_d
                               ON t_bill.bill_id = t_bill_d.bill_id
                           WHERE
                               t_bill_d.client_id = t_sale_h.client_id 
                               AND
                               t_bill_d.claim_div = t_sale_h.claim_div
                           )
       AND
       t_sale_h.claim_day <= $2
       AND 
       t_sale_h.claim_div = (SELECT
                               claim_div
                           FROM
                               t_claim
                           WHERE
                               client_id = t_sale_h.client_id AND claim_id = $1
                           )
       AND
       t_sale_h.trade_id = 15
       AND 
       t_sale_h.shop_id = $3
   GROUP BY t_sale_h.client_id
   ORDER BY t_sale_h.client_id 
   ) AS sale_data3 
   ON t_client.client_id = sale_data3.client_id
       LEFT JOIN
   (SELECT
       t_sale_h.client_id, 
       COALESCE(SUM(t_installment_sales.collect_amount), 0) AS split_bill_amount
   FROM
       t_sale_h
            INNER JOIN
       t_installment_sales
       ON t_sale_h.sale_id = t_installment_sales.sale_id
   WHERE
       t_installment_sales.collect_day > (SELECT
                                           COALESCE( MAX(t_bill_d.bill_close_day_this) , '2005-01-01')
                                       FROM
                                           t_bill
                                               INNER JOIN
                                           t_bill_d
                                           ON t_bill.bill_id = t_bill_d.bill_id
                                       WHERE
                                           t_bill_d.client_id = t_sale_h.client_id
                                           AND
                                           t_bill_d.claim_div = t_sale_h.claim_div
                                       )
       AND
       t_installment_sales.collect_day <= $2
       AND
       t_sale_h.claim_div = (SELECT claim_div FROM t_claim WHERE client_id = t_sale_h.client_id)
       AND
       t_sale_h.trade_id = 15
       AND
       t_sale_h.shop_id = $3
   GROUP BY t_sale_h.client_id
   ORDER BY t_sale_h.client_id
   ) AS  split_bill_data1
   ON t_client.client_id = split_bill_data1.client_id
       LEFT JOIN
   (SELECT
       t_sale_h.client_id,
       COALESCE(SUM(t_installment_sales.collect_amount), 0) AS installment_receivable_balance
   FROM
       t_sale_h
           INNER JOIN
       t_installment_sales
       ON t_sale_h.sale_id = t_installment_sales.sale_id
   WHERE
       t_sale_h.shop_id = $3
       AND
       t_sale_h.trade_id = 15
       AND
       t_sale_h.claim_div = (SELECT
                               claim_div
                           FROM
                               t_claim
                           WHERE
                               client_id = t_sale_h.client_id
                               AND
                               claim_id = $1
                           )
       AND
       t_installment_sales.collect_day > $2
       GROUP BY t_sale_h.client_id
       ORDER BY t_sale_h.client_id
   ) AS split_bill_data2
   ON t_client.client_id = split_bill_data2.client_id 
ORDER BY   t_client.client_cd1, t_client.client_cd2 
;";

*/

$conn = Db_Connect("watanabe-k");


$sql = "UPDATE t_shop2 SET shop_name = '¹ÀÆó' WHERE shop_id= 2;";

$result = Db_Query($conn, $sql);


print "pg_last_erorr:".print pg_last_error($result)."<br>";
print_array(pg_fetch_all($result));
print "pg_result_status:".pg_result_status($result)."<br>";
print "pg_get_result:".pg_get_result($result)."<br>";


/*

Db_Query($conn, $sql);

$a = getmicrotime();

for($i = 0; $i < 1; $i++){

$res =Db_Query($conn, "EXECUTE claim_data(6029 , '2006-08-28', 93); ");

}

$b = getmicrotime() - $a;
print $b;

$res =Db_Query($conn, "EXPLAIN EXECUTE claim_data(6029 , '2006-08-28', 93); ");


print "<pre style=\"font: 10px; font-family: '£Í£Ó ¥´¥·¥Ã¥¯'; \>";

for($i = 0; $i < pg_num_rows($res); $i++){

    $a =  pg_fetch_result($res, $i ,0);

    $a = str_replace("Index Scan", "<font color=blue>Index Scan</font>", $a);
    $a = str_replace("Seq Scan", "<font color=red>Seq Scan</font>", $a);

    print $a."<br>";
}

print "</pre>";
*/
?>
