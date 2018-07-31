#!/bin/sh
sql="
SELECT
   t_buy_h.client_name AS 仕入先,
   t_buy_h.buy_no AS 伝票番号,
   CASE t_buy_h.trade_id
       WHEN '21' THEN '掛仕入'
       WHEN '23' THEN '掛返品'
       WHEN '24' THEN '掛値引'
       WHEN '71' THEN '現金仕入'
       WHEN '73' THEN '現金返品'
       WHEN '74' THEN '現金値引'
   END AS 取引区分,
   t_buy_h.buy_day AS 仕入日,
   t_buy_d.goods_name AS 商品名,
   t_buy_d.num AS 仕入数,
   CASE t_buy_h.trade_id
       WHEN '23' THEN t_buy_d.buy_price * (-1)
       WHEN '24' THEN t_buy_d.buy_price * (-1)
       WHEN '73' THEN t_buy_d.buy_price * (-1)
       WHEN '74' THEN t_buy_d.buy_price * (-1)
       ELSE t_buy_d.buy_price
   END AS 仕入単価,
   CASE t_buy_h.trade_id
       WHEN '23' THEN t_buy_d.buy_amount * (-1)
       WHEN '24' THEN t_buy_d.buy_amount * (-1)
       WHEN '73' THEN t_buy_d.buy_amount * (-1)
       WHEN '74' THEN t_buy_d.buy_amount * (-1)
       ELSE t_buy_d.buy_amount
   END AS 仕入金額,
   CASE t_buy_d.tax_div
       WHEN '1' THEN '外税'
       WHEN '2' THEN '内税'
       WHEN '3' THEN '非課税'
   END AS 課税区分,
   t_buy_h.ware_name AS 仕入倉庫,
   t_order_h.ord_no AS 発注番号,
   t_buy_h.note AS 備考
 FROM
   t_buy_h LEFT JOIN t_order_h ON t_buy_h.ord_id = t_order_h.ord_id
   LEFT JOIN
   (SELECT
   buy_id,
    goods_name,
   SUM(num) AS num,
   tax_div,
   buy_price,
   SUM(buy_amount) AS buy_amount
   FROM
    t_buy_d 
   GROUP BY buy_id, goods_name, tax_div,buy_price 
   )AS t_buy_d 
   ON t_buy_h.buy_id = t_buy_d.buy_id
 WHERE 
   t_buy_h.shop_id = 93
 ORDER BY buy_no DESC 
;
"
/usr/local/pgsql/bin/psql -d amenity_demo_new -c "$sql" -A -F , 











