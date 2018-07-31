<?php
//環境設定ファイル
require_once("ENV_local.php");

//DB接続
$db_con = Db_Connect();

/****************************/
//テーブル作成
/****************************/
$html_header  =<<<PRINT_HTML_SRC
	--巡回担当者テーブル<br>
	CREATE TABLE t_sale_staff (<br>
		sale_id int8 REFERENCES t_sale_h(sale_id) ON DELETE CASCADE,<br>
		staff_div varchar(1),<br>
		staff_id int4 REFERENCES t_staff(staff_id) ON DELETE RESTRICT ON UPDATE CASCADE,<br>
		sale_rate varchar(3),<br>
		staff_name varchar(10)<br>
	);<br>
	GRANT ALL ON t_sale_staff TO PUBLIC;<br><br>

	--内訳テーブル<br>
	CREATE TABLE t_sale_detail (<br>
		sale_d_id int8 REFERENCES t_sale_d(sale_d_id) ON DELETE CASCADE,<br>
		line int2 NOT NULL,<br>
		goods_id int4 REFERENCES t_goods(goods_id) ON DELETE RESTRICT ON UPDATE CASCADE,<br>
		goods_name varchar(35),<br>
		num int4,<br>
		trade_price numeric(11,2),<br>
		trade_amount int8,<br>
		sale_price numeric(11,2),<br>
		sale_amount int8,<br>
		goods_cd varchar(8),<br>
		PRIMARY KEY (sale_d_id,line)<br>
	);<br>
	GRANT ALL ON t_sale_detail TO PUBLIC;<br><br>

	--出庫品テーブル<br>
	CREATE TABLE t_sale_ship (<br>
		sale_d_id int8 REFERENCES t_sale_d(sale_d_id) ON DELETE CASCADE,<br>
		goods_id int4 REFERENCES t_goods(goods_id) ON DELETE RESTRICT ON UPDATE CASCADE,<br>
		goods_name varchar(35),<br>
		num int4,<br>
		goods_cd varchar(8),<br>
		PRIMARY KEY (sale_d_id,goods_id)<br>
	);<br>
	GRANT ALL ON t_sale_ship TO PUBLIC;<br><br>

PRINT_HTML_SRC;

print $html_header;

/****************************/
//テーブル変更
/****************************/
$html_header  =<<<PRINT_HTML_SRC

	--売上データーテーブル<br>
	ALTER TABLE t_sale_d ADD serv_print_flg boolean DEFAULT false;<br>
	ALTER TABLE t_sale_d ADD set_flg boolean DEFAULT false;<br>
	ALTER TABLE t_sale_d ADD goods_print_flg boolean DEFAULT false;<br>
	ALTER TABLE t_sale_d ADD buy_price numeric(11,2);<br>
	ALTER TABLE t_sale_d ADD buy_amount int8;<br>
	ALTER TABLE t_sale_d ADD egoods_id int4;<br>
	ALTER TABLE t_sale_d ADD egoods_name varchar(35);<br>
	ALTER TABLE t_sale_d ADD egoods_num int4;<br>
	ALTER TABLE t_sale_d ADD contract_id int4;<br><br>

PRINT_HTML_SRC;
print $html_header;

?>
