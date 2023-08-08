<?php

//issue_book_details.php

include 'database_connection.php';

include 'function.php';

if(!is_user_login())
{
	header('location:user_login.php');
}

$query = "
	SELECT * FROM lms_issue_book 
	INNER JOIN lms_book 
	ON lms_book.book_isbn_number = lms_issue_book.book_id 
	WHERE lms_issue_book.user_id = '".$_SESSION['user_id']."' 
	ORDER BY lms_issue_book.issue_book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

include 'header.php';

?>
<div style="min-height: 700px;">
	<h1>Issue Book Detail</h1>
	<div>
		<div>
			<div>
				<div>
					<i></i> Issue Book Detail
				</div>
				<div align="right">
				</div>
			</div>
		</div>
		<div>
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Book ISBN No.</th>
						<th>Book Name</th>
						<th>Issue Date</th>
						<th>Return Date</th>
						<th>Fines</th>
						<th>Status</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Book ISBN No.</th>
						<th>Book Name</th>
						<th>Issue Date</th>
						<th>Return Date</th>
						<th>Fines</th>
						<th>Status</th>
					</tr>
				</tfoot>
				<tbody>
				<?php 
				if($statement->rowCount() > 0)
				{
					foreach($statement->fetchAll() as $row)
					{
						$status = $row["book_issue_status"];
						if($status == 'Issue')
						{
							$status = '<span>Issue</span>';
						}

						if($status == 'Not Return')
						{
							$status = '<span>Not Return</span>';
						}

						if($status == 'Return')
						{
							$status = '<span>Return</span>';
						}

						echo '
						<tr>
							<td>'.$row["book_isbn_number"].'</td>
							<td>'.$row["book_name"].'</td>
							<td>'.$row["issue_date_time"].'</td>
							<td>'.$row["return_date_time"].'</td>
							<td>'.get_currency_symbol($connect).$row["book_fines"].'</td>
							<td>'.$status.'</td>
						</tr>
						';
					}
				}
				?>
				</tbody>
			</table>
		</div>
	</div>

</div>
