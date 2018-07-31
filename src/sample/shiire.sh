#!/bin/sh
sql="
SELECT
   t_buy_h.client_name AS ������,
   t_buy_h.buy_no AS ��ɼ�ֹ�,
   CASE t_buy_h.trade_id
       WHEN '21' THEN '�ݻ���'
       WHEN '23' THEN '������'
       WHEN '24' THEN '���Ͱ�'
       WHEN '71' THEN '�������'
       WHEN '73' THEN '��������'
       WHEN '74' THEN '�����Ͱ�'
   END AS �����ʬ,
   t_buy_h.buy_day AS ������,
   t_buy_d.goods_name AS ����̾,
   t_buy_d.num AS ������,
   CASE t_buy_h.trade_id
       WHEN '23' THEN t_buy_d.buy_price * (-1)
       WHEN '24' THEN t_buy_d.buy_price * (-1)
       WHEN '73' THEN t_buy_d.buy_price * (-1)
       WHEN '74' THEN t_buy_d.buy_price * (-1)
       ELSE t_buy_d.buy_price
   END AS ����ñ��,
   CASE t_buy_h.trade_id
       WHEN '23' THEN t_buy_d.buy_amount * (-1)
       WHEN '24' THEN t_buy_d.buy_amount * (-1)
       WHEN '73' THEN t_buy_d.buy_amount * (-1)
       WHEN '74' THEN t_buy_d.buy_amount * (-1)
       ELSE t_buy_d.buy_amount
   END AS �������,
   CASE t_buy_d.tax_div
       WHEN '1' THEN '����'
       WHEN '2' THEN '����'
       WHEN '3' THEN '�����'
   END AS ���Ƕ�ʬ,
   t_buy_h.ware_name AS �����Ҹ�,
   t_order_h.ord_no AS ȯ���ֹ�,
   t_buy_h.note AS ����
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











