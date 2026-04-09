<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	
	$total_sql = " SELECT m.*
						, p.nowPoint
						, o.nowPrice
						, ( left(curdate(),4) - left(m.birthday,4) + 1) as olds
				     FROM tbl_member m
				     LEFT OUTER JOIN (select sum(point) as nowPoint, user_id from tbl_point group by user_id) p
					   ON m.user_id = p.user_id
				     LEFT OUTER JOIN (select sum(total_price) as nowPrice, user_id from tbl_order where status = 'M' group by user_id )o
					   ON m.user_id = o.user_id
					WHERE 1=1 $strSql ";
	$result = mysqli_query($connect, $total_sql) or die (mysql_error());
	$nTotalCount = mysqli_num_rows($result);
	$num = $nTotalCount;

	$sql    = $total_sql . " order by m.m_idx desc ";
	$result = mysqli_query($connect, $sql) or die (mysqli_error($connect));

?>

				
						<table cellpadding="0" cellspacing="0" summary="" class="listTable">
						<caption></caption>
						<colgroup>
						<col width="" />
						<col width="" />
						<col width="" />
						<col width="" />
						</colgroup>
						<thead>
							<tr>
								<th><button type="button">전체</button></th>
								<th>번호</th>
								<th>등급</th>
								<th>아이디</th>
								<th>성명</th>
								<th>성별</th>
								<th>연령</th>
								<th>접속수</th>
								<th>최근접속일</th>
								<th>가입일</th>
								<th>이메일</th>
								<th>이메일수신</th>				
							</tr>
						</thead>	
						<tbody>
						<?
						while($row = mysqli_fetch_array($result)){
							$row_num = $num--;
						?>
							<tr>
								<td><input type="checkbox"></td>
								<td><?=$row_num?></td>
								<td>USER</td>
								<td><?=$row['user_id']?></td>
								<td><?=$row['user_name']?></td>
								<td>여</td>
								<td>41</td>
								<td>3</td>
								<td>2018-04-26 17:23:16</td>
								<td>2018-04-26</td>
								<td>bally23@hanmail.net</td>
								<td>동의</td>
							</tr>
						<?}?>
							
						</tbody>
						</table>
					