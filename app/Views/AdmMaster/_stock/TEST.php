
select
m_idx, shop_name, goods_name_front, goods_code
, (select code_name from tbl_color as co where co.code_no = goods_color) as goods_color
, IFNULL(SUM(A),0) as A, IFNULL(SUM(B),0) as B, IFNULL(SUM(C),0) as C, IFNULL(SUM(D),0) as D, IFNULL(SUM(E),0) as E
, IFNULL(SUM(F),0) as F, IFNULL(SUM(G),0) as G 
, IFNULL(SUM(H),0) as H, IFNULL(SUM(I),0) as I, IFNULL(SUM(J),0) as J, IFNULL(SUM(K),0) as K, IFNULL(SUM(L),0) as L
, IFNULL(SUM(M),0) as M, IFNULL(SUM(N),0) as N, IFNULL(SUM(O),0) as O
, sum(price_normal) as price_normal, sum(price_margin) as price_margin, sum(price_one) as price_one
  from (
	select a.m_idx, a.shop_name, g.goods_name_front, c.goods_code, c.goods_color, c.price_normal, c.price_margin, c.price_one   
		, CASE WHEN b.goods_size = '72' OR b.goods_size = '79' THEN c.goods_cnt END AS A
		, CASE WHEN b.goods_size = '73' OR b.goods_size = '80' THEN c.goods_cnt END AS B
		, CASE WHEN b.goods_size = '74' OR b.goods_size = '81' THEN c.goods_cnt END AS C
		, CASE WHEN b.goods_size = '75' OR b.goods_size = '82' THEN c.goods_cnt END AS D
		, CASE WHEN b.goods_size = '76' OR b.goods_size = '83' THEN c.goods_cnt END AS E
		, CASE WHEN b.goods_size = '77' OR b.goods_size = '84' OR b.goods_size = '86' THEN c.goods_cnt END AS F
		, CASE WHEN b.goods_size = '78' OR b.goods_size = '85' OR b.goods_size = '87' THEN c.goods_cnt END AS G
		, CASE WHEN b.goods_size = '95' OR b.goods_size = '88' THEN c.goods_cnt END AS H
		, CASE WHEN b.goods_size = '96' OR b.goods_size = '89' THEN c.goods_cnt END AS I
		, CASE WHEN b.goods_size = '90' OR b.goods_size = '97' THEN c.goods_cnt END AS J
		, CASE WHEN b.goods_size = '91' OR b.goods_size = '115' THEN c.goods_cnt END AS K
		, CASE WHEN b.goods_size = '92' OR b.goods_size = '98' THEN c.goods_cnt END AS L
		, CASE WHEN b.goods_size = '93' OR b.goods_size = '99' THEN c.goods_cnt END AS M
		, CASE WHEN b.goods_size = '94' OR b.goods_size = '100' THEN c.goods_cnt END AS N
		, CASE WHEN b.goods_size = '117' OR b.goods_size = '119' THEN c.goods_cnt END AS O 
	from tbl_market as a 
	inner join tbl_goods_agency_option as b 
		on a.m_idx = b.m_idx  
	inner join tbl_goods as g 
		on b.goods_code = g.goods_code 		 	
	inner join tbl_goods_adm_option as c 
		on b.goods_code = b.goods_code and b.goods_color = c.goods_color and b.goods_size = c.goods_size
	left join tbl_size as size on c.goods_size = size.code_no
		where size.type in(6,8,9)
			
) AS T
group by shop_name, goods_code, goods_color order by m_idx ASC, goods_code ASC;
	
	
/*
select * from tbl_goods_agency_option where m_idx= 1  group by goods_code, goods_color, goods_size
*/






-----------------------
옷 상의 사이즈 



select
m_idx, shop_name, goods_name_front, goods_code
, (select code_name from tbl_color as co where co.code_no = goods_color) as goods_color
, IFNULL(SUM(A),0) as A, IFNULL(SUM(B),0) as B, IFNULL(SUM(C),0) as C, IFNULL(SUM(D),0) as D, IFNULL(SUM(E),0) as E
, IFNULL(SUM(F),0) as F, IFNULL(SUM(G),0) as G 
, IFNULL(SUM(H),0) as H, IFNULL(SUM(I),0) as I, IFNULL(SUM(J),0) as J, IFNULL(SUM(K),0) as K, IFNULL(SUM(L),0) as L
, IFNULL(SUM(M),0) as M, IFNULL(SUM(N),0) as N, IFNULL(SUM(O),0) as O
, sum(price_normal) as price_normal, sum(price_margin) as price_margin, sum(price_one) as price_one
  from (
	select a.m_idx, a.shop_name, g.goods_name_front, c.goods_code, c.goods_color, c.price_normal, c.price_margin, c.price_one   
		, CASE WHEN b.goods_size = '-1' OR b.goods_size = '-1' THEN c.goods_cnt END AS A  /*85*/
		, CASE WHEN b.goods_size = '105' OR b.goods_size = '112' THEN c.goods_cnt END AS B /*90*/
		, CASE WHEN b.goods_size = '101' OR b.goods_size = '113' THEN c.goods_cnt END AS C /*95*/
		, CASE WHEN b.goods_size = '102' OR b.goods_size = '114' THEN c.goods_cnt END AS D /*100*/
		, CASE WHEN b.goods_size = '103' THEN c.goods_cnt END AS E /*105*/
		, CASE WHEN b.goods_size = '104' THEN c.goods_cnt END AS F /*110*/
		
		, CASE WHEN b.goods_size = '78' OR b.goods_size = '85' OR b.goods_size = '87' THEN c.goods_cnt END AS G /*S*/
		, CASE WHEN b.goods_size = '95' OR b.goods_size = '88' THEN c.goods_cnt END AS H /*M*/
		, CASE WHEN b.goods_size = '96' OR b.goods_size = '89' THEN c.goods_cnt END AS I /*L*/
		, CASE WHEN b.goods_size = '90' OR b.goods_size = '97' THEN c.goods_cnt END AS J /*XL*/
		, CASE WHEN b.goods_size = '91' OR b.goods_size = '115' THEN c.goods_cnt END AS K /*XXL*/
		, CASE WHEN b.goods_size = '92' OR b.goods_size = '98' THEN c.goods_cnt END AS L
		, CASE WHEN b.goods_size = '93' OR b.goods_size = '99' THEN c.goods_cnt END AS M
		, CASE WHEN b.goods_size = '94' OR b.goods_size = '100' THEN c.goods_cnt END AS N
		, CASE WHEN b.goods_size = '117' OR b.goods_size = '119' THEN c.goods_cnt END AS O 
	from tbl_market as a 
	inner join tbl_goods_agency_option as b 
		on a.m_idx = b.m_idx  
	inner join tbl_goods as g 
		on b.goods_code = g.goods_code 		 	
	inner join tbl_goods_adm_option as c 
		on b.goods_code = b.goods_code and b.goods_color = c.goods_color and b.goods_size = c.goods_size
	left join tbl_size as size on c.goods_size = size.code_no
		where size.type in(7,12,10)
) AS T
group by shop_name, goods_code, goods_color order by m_idx ASC, goods_code ASC;
	
	
/*
select * from tbl_goods_agency_option where m_idx= 1  group by goods_code, goods_color, goods_size
*/






		
	select * from tbl_goods_agency_option where m_idx=1 and  goods_code='1011691' and goods_color='10046'
	
		select * from tbl_goods_adm_option where goods_code='1011691' and goods_color='10046';	
		
select * from tbl_size where type in(6,8,9) order by type asc, code_name asc;			
		
select * from tbl_market

select * from tbl_goods_agency_option

select * from tbl_code
select * from tbl_size_type; 
select * from tbl_size where type in(6,8,9)  order by type asc, code_name asc;
select * from tbl_size where type in(7,12,10)  order by type asc, code_name asc;


select * from tbl_goods_adm_option where goods_size in (112,113,114)
select * from tbl_goods_agency_option where goods_size in (112,113,114)
select code_name from tbl_color as co where co.code_no = 

select * from tbl_size where type in(7,12,10) and code_name='85'  order by type asc, code_name asc;
select * from tbl_size where type in(7,12,10) and code_name='110'  order by type asc, code_name asc;


225 :72,79 
230 :73,80 
